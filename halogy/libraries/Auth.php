<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Halogy
 *
 * A user friendly, modular content management system for PHP 5.0
 * Built on CodeIgniter - http://codeigniter.com
 *
 * @package		Halogy
 * @author		Haloweb Ltd
 * @copyright	Copyright (c) 2012, Haloweb Ltd
 * @license		http://halogy.com/license
 * @link		http://halogy.com/
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

#[\AllowDynamicProperties]
class Auth {

	// set defaults
	var $CI;								// CI instance
	var $table = 'users';					// default table
	var $base_path = '';					// default base path
	var $redirect = '';						// default redirect
	var $sessionName = 'logged_in';			// name of session
	var $error = '';						// error message
	
	function __construct()
	{
		$this->CI =& get_instance();

		// get siteID, if available
		if (defined('SITEID'))
		{
			$this->siteID = SITEID;
		}		
	}
	
	function login($username = '', $password = '', $sessionName = '', $redirect = FALSE, $remember = FALSE)
	{	
		// set default session
		if (!$sessionName)
		{
			$sessionName = $this->sessionName;
		}

		// set default redirect
		if (!$redirect && $this->redirect)
		{
			$redirect = $this->redirect;
		}

		// check if already logged in
		if ($this->CI->session->userdata($sessionName) == $sessionName)
		{
			return ($redirect) ? redirect($redirect) : TRUE;
		}

		// create account
		if ($this->do_login($username, $password, $sessionName)) 
		{
			// check if remember is set
			if ($remember)
			{
				$this->set_remember_cookie($sessionName);
			}
			
			return ($redirect) ? redirect($redirect) : TRUE;
		}
	}

	// hash a password for storage
	function hash_password($password)
	{
		return password_hash((string)$password, PASSWORD_DEFAULT);
	}

	// check a password against a stored hash (supports legacy unsalted md5)
	function verify_password($password, $hash)
	{
		if (!is_scalar($password))
		{
			return FALSE;
		}

		$password = (string)$password;
		$hash = (string)$hash;

		if ($hash === '')
		{
			return FALSE;
		}

		if (strpos($hash, '$') === 0)
		{
			return password_verify($password, $hash);
		}

		return hash_equals($hash, md5($password));
	}

	// is the stored hash legacy or weaker than the current default?
	function needs_rehash($hash)
	{
		return (strpos((string)$hash, '$') !== 0 || password_needs_rehash((string)$hash, PASSWORD_DEFAULT));
	}

	function do_login($username, $password, $sessionName, $cookie = FALSE)
	{			
		// login with something other than username, and check against siteID
		if (is_array($username))
		{
			// based on siteID
			$this->CI->db->where('siteID', $this->siteID);
			
			$this->CI->db->where($username['field'], $username['value']);
		}

		// login with username
		else
		{
			$this->CI->db->where('username', $username);
		}

		// grab from db
		$query = $this->CI->db->get_where($this->table);
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array(); 
			
			// check against password
			if (!$this->verify_password($password, $row['password'])) 
			{
				$this->error = 'The login details used did not match our records. Please try again.';

				return FALSE;
			}

			// upgrade legacy or outdated hashes
			if ($this->needs_rehash($row['password']))
			{
				$row['password'] = $this->hash_password($password);

				$this->CI->db->where('userID', $row['userID']);
				$this->CI->db->set('password', $row['password']);
				$this->CI->db->update($this->table);
			}

			return $this->start_session($row, $sessionName);
		}
		else
		{
			$this->error = 'The login details used did not match our records. Please try again.';
			
			// no database result found
			return FALSE;
		}
	}

	// post-authentication steps shared by password and cookie login
	function start_session($row, $sessionName)
	{
		// check they have permission to access this site
		if ($row['groupID'] > 0 && $row['siteID'] != $this->siteID)
		{
			$this->error = 'You do not have permission to edit this site.';

			return FALSE;
		}

		// remember who and what for the remember me cookie
		$this->passwordHash = $row['password'];

		// remove the password field
		unset($row['password']);

		// check if they are active or not
		if (!$row['active'])
		{
			$this->error = 'Your account is not yet active. Please bear with us until your account is activated.';

			return FALSE;
		}
		
		// new session ID on privilege change, prevents session fixation
		$this->CI->session->sess_regenerate();

		// rotate the CSRF token too (password and remember me logins)
		$this->CI->security->csrf_regenerate();

		// set session data
		$this->CI->session->set_userdata($row);
		
		// set logged_in to true
		$this->CI->session->set_userdata(array($sessionName => true));

		// update last login
		$this->CI->db->where('userID', $row['userID']);
		$this->CI->db->set('lastLogin', date("Y-m-d H:i:s"));
		$this->CI->db->update('users');

		// login was successful			
		return TRUE;
	}

	// session names that may be restored from the remember me cookie
	function _remember_sessions()
	{
		return array('logged_in', 'session_user', 'session_admin');
	}

	// site a remember me cookie is valid for (superusers are cross-site, so 0)
	function _remember_scope($groupID)
	{
		return ($groupID < 0) ? 0 : (int)$this->siteID;
	}

	function _remember_signature($userID, $expiry, $sessionName, $passwordHash, $scope)
	{
		return hash_hmac('sha256', $userID.'|'.$expiry.'|'.$sessionName.'|'.$scope.'|'.$passwordHash, (string)$this->CI->config->item('encryption_key'));
	}

	// set the signed remember me cookie for the user who just logged in
	function set_remember_cookie($sessionName)
	{
		$userID = $this->CI->session->userdata('userID');

		if (!$userID || !in_array($sessionName, $this->_remember_sessions(), TRUE) || !isset($this->passwordHash))
		{
			return FALSE;
		}

		$expiry = time() + 604800;
		$value = $userID.'|'.$expiry.'|'.$sessionName.'|'.$this->_remember_signature($userID, $expiry, $sessionName, $this->passwordHash, $this->_remember_scope($this->CI->session->userdata('groupID')));

		return setcookie($this->CI->config->item('cookie_prefix').'halogy', $value, array(
			'expires'  => $expiry,
			'path'     => ($this->CI->config->item('cookie_path')) ? $this->CI->config->item('cookie_path') : '/',
			'domain'   => (string)$this->CI->config->item('cookie_domain'),
			'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $this->CI->config->item('cookie_secure') === TRUE,
			'httponly' => TRUE,
			'samesite' => 'Lax',
		));
	}

	// log in from the remember me cookie, no password involved
	function login_from_cookie($cookie)
	{
		$parts = explode('|', (string)$cookie);

		if (count($parts) !== 4 || !ctype_digit($parts[0]) || !ctype_digit($parts[1]) || $parts[1] <= time() || !in_array($parts[2], $this->_remember_sessions(), TRUE))
		{
			return $this->_forget_cookie();
		}

		list($userID, $expiry, $sessionName, $signature) = $parts;

		// only this site's users, apart from superusers who are cross-site
		$this->CI->db->where('userID', $userID);
		$this->CI->db->where('(groupID < 0 OR siteID = '.(int)$this->siteID.')', NULL, FALSE);
		$query = $this->CI->db->get($this->table);

		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();

			if ($row['password'] && hash_equals($this->_remember_signature($userID, $expiry, $sessionName, $row['password'], $this->_remember_scope($row['groupID'])), $signature))
			{
				return $this->start_session($row, $sessionName);
			}
		}

		return $this->_forget_cookie();
	}

	function _forget_cookie()
	{
		delete_cookie('halogy');

		return FALSE;
	}

	function logout($redirect = '')
	{
		// set default redirect
		if (!$redirect)
		{
			$redirect = $this->base_path;
		}

		// destroy any cookies
		delete_cookie('halogy');
		
		// destroy session
		$this->CI->session->sess_destroy();

		// the next visitor of this browser gets a fresh CSRF token
		$this->CI->security->csrf_regenerate();

		// redirect
		redirect($redirect);
	}

}