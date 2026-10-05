<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Security Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Security
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/security.html
 */
#[\AllowDynamicProperties]
class CI_Security {

	/**
	 * Random Hash for protecting URLs
	 *
	 * @var string
	 * @access protected
	 */
	protected $_xss_hash			= '';
	/**
	 * Random Hash for Cross Site Request Forgery Protection Cookie
	 *
	 * @var string
	 * @access protected
	 */
	protected $_csrf_hash			= '';
	/**
	 * Expiration time for Cross Site Request Forgery Protection Cookie
	 * Defaults to two hours (in seconds)
	 *
	 * @var int
	 * @access protected
	 */
	protected $_csrf_expire			= 7200;
	/**
	 * Token name for Cross Site Request Forgery Protection Cookie
	 *
	 * @var string
	 * @access protected
	 */
	protected $_csrf_token_name		= 'ci_csrf_token';
	/**
	 * Cookie name for Cross Site Request Forgery Protection Cookie
	 *
	 * @var string
	 * @access protected
	 */
	protected $_csrf_cookie_name	= 'ci_csrf_token';
	/**
	 * List of never allowed strings
	 *
	 * @var array
	 * @access protected
	 */
	protected $_never_allowed_str = array(
					'document.cookie'	=> '[removed]',
					'document.write'	=> '[removed]',
					'.parentNode'		=> '[removed]',
					'.innerHTML'		=> '[removed]',
					'window.location'	=> '[removed]',
					'-moz-binding'		=> '[removed]',
					'<!--'				=> '&lt;!--',
					'-->'				=> '--&gt;',
					'<![CDATA['			=> '&lt;![CDATA[',
					'<comment>'			=> '&lt;comment&gt;'
	);

	/* never allowed, regex replacement */
	/**
	 * List of never allowed regex replacement
	 *
	 * @var array
	 * @access protected
	 */
	protected $_never_allowed_regex = array(
					"javascript\s*:"			=> '[removed]',
					"expression\s*(\(|&\#40;)"	=> '[removed]', // CSS and IE
					"vbscript\s*:"				=> '[removed]', // IE, surprise!
					"Redirect\s+302"			=> '[removed]'
	);

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// CSRF config
		foreach(array('csrf_expire', 'csrf_token_name', 'csrf_cookie_name') as $key)
		{
			if (FALSE !== ($val = config_item($key)))
			{
				$this->{'_'.$key} = $val;
			}
		}

		// Append application specific cookie prefix
		if (config_item('cookie_prefix'))
		{
			$this->_csrf_cookie_name = config_item('cookie_prefix').$this->_csrf_cookie_name;
		}

		// Over HTTPS the cookie gets the __Host- prefix: the browser then only
		// accepts it from this exact host (no sibling subdomain, no plain http
		// response can plant one), Secure, Path=/ and without Domain.
		if ($this->_is_https())
		{
			$this->_csrf_cookie_name = '__Host-'.$this->_csrf_cookie_name;
		}

		// Set the CSRF hash
		$this->_csrf_set_hash();

		log_message('debug', "Security Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Verify Cross Site Request Forgery Protection
	 *
	 * Runs before routing, for every request:
	 *
	 *  - GET and HEAD only refresh the cookie (state-changing GET links are
	 *    dealt with by csrf_verify_action() once the method is known)
	 *  - POST must prove that it was made by this site: see _request_allowed()
	 *  - any other verb (OPTIONS, PUT, DELETE, PATCH, ...) is answered with
	 *    405: nothing in this application is meant to be reached that way, and
	 *    the router would otherwise run the controller method regardless of
	 *    the verb.
	 *
	 * @return	object
	 */
	public function csrf_verify()
	{
		$method = $this->_request_method();

		if ($method === 'GET' OR $method === 'HEAD')
		{
			// the cookie is re-sent with every page view, always carrying the
			// same hash (sliding expiry, so forms left open stay valid); the
			// token is only rotated explicitly (login, logout) by csrf_regenerate()
			$this->csrf_set_cookie();

			return $this;
		}

		if ($method !== 'POST')
		{
			$this->csrf_show_method_not_allowed('GET, HEAD, POST');
		}

		// Endpoints that are legitimately POSTed to by external servers
		if ($this->_csrf_uri_excluded())
		{
			return $this;
		}

		if ( ! $this->_request_allowed())
		{
			$this->csrf_show_error();
		}

		// We kill this since we're done and we don't want to
		// polute the _POST array. The token itself is deliberately kept
		// for its lifetime so multiple tabs and AJAX calls keep working.
		unset($_POST[$this->_csrf_token_name]);

		log_message('debug', "CSRF request verified");

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Guard a state-changing action that is linked to (delete, publish, ...)
	 *
	 * Called once the router has resolved the controller method. A method
	 * matching $config['csrf_protect_get_methods'] only ever runs on a POST,
	 * which csrf_verify() has already checked. A GET to it does not run the
	 * action: it renders a confirmation page whose form POSTs to the same
	 * URL with the token, so a link planted in user content, in a mail or
	 * behind a login redirect can never change anything by being followed.
	 * The only exception is $config['csrf_get_passthrough_methods'] (logout),
	 * which a GET may run when the browser says the request is same-origin.
	 * HEAD (and any other verb) to such a method is answered with 405.
	 *
	 * @param	string	the routed controller method
	 * @return	void
	 */
	public function csrf_verify_action($method)
	{
		if ( ! $this->csrf_get_method_protected($method) OR $this->_csrf_uri_excluded())
		{
			return;
		}

		$request = $this->_request_method();

		if ($request === 'POST')
		{
			return;
		}

		if ($request !== 'GET')
		{
			$this->csrf_show_method_not_allowed('GET, POST');
		}

		if ($this->csrf_get_method_passthrough($method) && $this->_browser_says_same_origin())
		{
			return;
		}

		$this->csrf_show_confirm();
	}

	// --------------------------------------------------------------------

	/**
	 * Was this POST made by this site?
	 *
	 * The browser's own statement about the request comes first, so a token
	 * planted by a sibling subdomain or a plain http man in the middle does
	 * not help a cross-site request:
	 *
	 *  1. Sec-Fetch-Site present and not "same-origin" -> refused
	 *  2. Origin present and "null" or another scheme/host/port -> refused
	 *
	 * Then the request passes when any of these holds:
	 *
	 *  3. a valid token: POST field or X-CSRF-Token header (form_open()
	 *     forms, the confirmation page, AJAX, scripts)
	 *  4. Sec-Fetch-Site: same-origin (every current browser sends it)
	 *  5. Origin names this exact scheme, host and port
	 *  6. neither header is present and Referer names this exact scheme,
	 *     host and port
	 *
	 * Anything else fails: requests without any of these headers and without a
	 * token can be forged, so they are refused.
	 *
	 * @return	bool
	 */
	protected function _request_allowed()
	{
		$site = isset($_SERVER['HTTP_SEC_FETCH_SITE']) ? strtolower(trim((string) $_SERVER['HTTP_SEC_FETCH_SITE'])) : NULL;
		if ($site !== NULL && $site !== 'same-origin')
		{
			return FALSE;
		}

		$origin = isset($_SERVER['HTTP_ORIGIN']) ? $this->_header_is_same_origin($_SERVER['HTTP_ORIGIN']) : NULL;
		if ($origin === FALSE)
		{
			return FALSE;
		}

		if ($this->_token_valid() OR $site === 'same-origin' OR $origin === TRUE)
		{
			return TRUE;
		}

		if ($site === NULL && $origin === NULL && isset($_SERVER['HTTP_REFERER']))
		{
			return $this->_header_is_same_origin($_SERVER['HTTP_REFERER']);
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Does the browser itself say this request is same-origin?
	 *
	 * Sec-Fetch-Site when present (so "none", a navigation from outside the
	 * browser, is not enough), otherwise Origin, otherwise Referer. Tokens
	 * do not count. Used for the GET passthrough (logout).
	 *
	 * @return	bool
	 */
	protected function _browser_says_same_origin()
	{
		if (isset($_SERVER['HTTP_SEC_FETCH_SITE']))
		{
			return (strtolower(trim((string) $_SERVER['HTTP_SEC_FETCH_SITE'])) === 'same-origin');
		}

		if (isset($_SERVER['HTTP_ORIGIN']))
		{
			return $this->_header_is_same_origin($_SERVER['HTTP_ORIGIN']);
		}

		if (isset($_SERVER['HTTP_REFERER']))
		{
			return $this->_header_is_same_origin($_SERVER['HTTP_REFERER']);
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Does the request carry a token matching the CSRF cookie?
	 *
	 * The token is read from the POST field or the X-CSRF-Token header; a
	 * query string parameter never counts.
	 *
	 * @return	bool
	 */
	protected function _token_valid()
	{
		$token = '';

		if (isset($_POST[$this->_csrf_token_name]) && is_string($_POST[$this->_csrf_token_name]))
		{
			$token = $_POST[$this->_csrf_token_name];
		}
		elseif (isset($_SERVER['HTTP_X_CSRF_TOKEN']))
		{
			$token = (string) $_SERVER['HTTP_X_CSRF_TOKEN'];
		}

		if ($token === '' OR ! isset($_COOKIE[$this->_csrf_cookie_name]) OR ! is_string($_COOKIE[$this->_csrf_cookie_name]))
		{
			return FALSE;
		}

		return hash_equals($_COOKIE[$this->_csrf_cookie_name], $token);
	}

	// --------------------------------------------------------------------

	/**
	 * The request method, upper case
	 *
	 * @return	string
	 */
	protected function _request_method()
	{
		return isset($_SERVER['REQUEST_METHOD']) ? strtoupper(trim((string) $_SERVER['REQUEST_METHOD'])) : 'GET';
	}

	/**
	 * Was this request made over HTTPS?
	 *
	 * Behind a TLS-terminating proxy the deployer sets $_SERVER['HTTPS'] = 'on'
	 * (see the CSRF notes in config.php): the cookie prefix and the Origin
	 * comparison depend on it.
	 *
	 * @return	bool
	 */
	protected function _is_https()
	{
		return (( ! empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off')
			|| (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443));
	}

	// --------------------------------------------------------------------

	/**
	 * Does an Origin or Referer header value name this site?
	 *
	 * Only scheme, host and port count. The value comes straight from the
	 * browser, so it is parsed as is: anything parse_url() rejects, a value
	 * with user information, a non http(s) scheme or a missing host fails.
	 *
	 * @param	string	the header value
	 * @return	bool
	 */
	protected function _header_is_same_origin($value)
	{
		$value = trim((string) $value);
		if ($value === '' OR strtolower($value) === 'null')
		{
			return FALSE;
		}

		$theirs = $this->_origin_parts($value);
		$ours = $this->_request_origin();

		return ($theirs !== FALSE && $ours !== FALSE && $theirs === $ours);
	}

	/**
	 * Scheme, host and port of the current request
	 *
	 * @return	array|FALSE
	 */
	protected function _request_origin()
	{
		if ( ! isset($_SERVER['HTTP_HOST']) OR trim((string) $_SERVER['HTTP_HOST']) === '')
		{
			return FALSE;
		}

		return $this->_origin_parts(($this->_is_https() ? 'https' : 'http').'://'.trim((string) $_SERVER['HTTP_HOST']));
	}

	/**
	 * Normalised scheme, host and port of a URL
	 *
	 * @param	string
	 * @return	array|FALSE	array('scheme', 'host', 'port') or FALSE if unusable
	 */
	protected function _origin_parts($url)
	{
		$parts = @parse_url($url);

		if ( ! is_array($parts) OR ! isset($parts['scheme'], $parts['host']) OR isset($parts['user']) OR isset($parts['pass']))
		{
			return FALSE;
		}

		$scheme = strtolower($parts['scheme']);
		if ($scheme !== 'http' && $scheme !== 'https')
		{
			return FALSE;
		}

		$host = strtolower($parts['host']);
		if ($host === '' OR preg_match('/^[a-z0-9\-._\[\]:]+$/', $host) !== 1)
		{
			return FALSE;
		}

		$port = isset($parts['port']) ? (int) $parts['port'] : (($scheme === 'https') ? 443 : 80);

		return array($scheme, $host, $port);
	}

	// --------------------------------------------------------------------

	/**
	 * Does this controller method name change state when requested by GET?
	 *
	 * @param	string
	 * @return	bool
	 */
	public function csrf_get_method_protected($method)
	{
		$pattern = config_item('csrf_protect_get_methods');

		return (is_string($pattern) && $pattern !== '' && $method !== '' && preg_match('#'.str_replace('#', '\\#', $pattern).'#i', (string) $method) === 1);
	}

	/**
	 * May this protected method still run on a GET the browser calls same-origin?
	 *
	 * @param	string
	 * @return	bool
	 */
	public function csrf_get_method_passthrough($method)
	{
		$pattern = config_item('csrf_get_passthrough_methods');

		return (is_string($pattern) && $pattern !== '' && $method !== '' && preg_match('#'.str_replace('#', '\\#', $pattern).'#i', (string) $method) === 1);
	}

	// --------------------------------------------------------------------

	/**
	 * Is the current URI exempt from CSRF verification?
	 *
	 * Entries of $config['csrf_exclude_uris'] are matched exactly against
	 * the URI string or as a regular expression.
	 *
	 * @return	bool
	 */
	protected function _csrf_uri_excluded()
	{
		$list = config_item('csrf_exclude_uris');
		if ( ! is_array($list) OR count($list) == 0)
		{
			return FALSE;
		}

		$uri = trim(load_class('URI', 'core')->uri_string(), '/');

		foreach ($list as $pattern)
		{
			if ($uri === trim($pattern, '/') OR @preg_match('#^'.str_replace('#', '\\#', $pattern).'$#i', $uri) === 1)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cross Site Request Forgery Protection Cookie
	 *
	 * @return	object
	 */
	public function csrf_set_cookie()
	{
		$https = $this->_is_https();
		$secure_cookie = ($https OR config_item('cookie_secure') === TRUE);

		if ($secure_cookie && ! $https)
		{
			return FALSE;
		}

		if (headers_sent())
		{
			return FALSE;
		}

		// Only one Set-Cookie for this cookie per response: the sliding refresh
		// at the start of the request may already have queued one when the
		// token is rotated (login, logout). Other cookies (session, remember
		// me) queued so far are kept.
		$others = array();
		foreach (headers_list() as $header)
		{
			if (stripos($header, 'Set-Cookie:') !== 0)
			{
				continue;
			}

			if (stripos(ltrim(substr($header, 11)), $this->_csrf_cookie_name.'=') !== 0)
			{
				$others[] = $header;
			}
		}
		header_remove('Set-Cookie');
		foreach ($others as $header)
		{
			header($header, FALSE);
		}

		// a __Host- cookie (HTTPS) is only accepted by the browser when it is
		// Secure, has Path=/ and no Domain attribute
		$host_prefixed = (strncmp($this->_csrf_cookie_name, '__Host-', 7) === 0);

		setcookie($this->_csrf_cookie_name, $this->_csrf_hash, array(
			'expires'	=> time() + $this->_csrf_expire,
			'path'		=> $host_prefixed ? '/' : config_item('cookie_path'),
			'domain'	=> $host_prefixed ? '' : config_item('cookie_domain'),
			'secure'	=> $secure_cookie,
			'httponly'	=> TRUE,
			'samesite'	=> 'Lax'
		));

		log_message('debug', "CRSF cookie Set");

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Rotate the CSRF token
	 *
	 * Called when the privilege level changes (login, logout). The new token
	 * is used for everything rendered from now on, including pages shown
	 * after a redirect, because the cookie is issued with this response.
	 *
	 * @return	object
	 */
	public function csrf_regenerate()
	{
		$previous = $this->_csrf_hash;
		$this->_csrf_hash = bin2hex(random_bytes(16));

		if ($this->csrf_set_cookie() === FALSE)
		{
			// the browser never got the new token, so keep the old one
			$this->_csrf_hash = $previous;

			return $this;
		}

		$_COOKIE[$this->_csrf_cookie_name] = $this->_csrf_hash;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Show CSRF Error
	 *
	 * @return	void
	 */
	public function csrf_show_error()
	{
		// the error template forces a 404 header, so set the status afterwards
		$html = load_class('Exceptions', 'core')->show_error('An Error Was Encountered', 'The action you have requested is not allowed.', 'error_general', 403);
		set_status_header(403);
		echo $html;
		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * Refuse the request method
	 *
	 * @param	string	the Allow header value
	 * @return	void
	 */
	public function csrf_show_method_not_allowed($allow)
	{
		$html = load_class('Exceptions', 'core')->show_error('An Error Was Encountered', 'The request method is not allowed for this address.', 'error_general', 405);
		set_status_header(405);
		header('Allow: '.$allow);
		header('Cache-Control: no-store');
		echo $html;
		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * Show the confirmation page for a state-changing action reached by GET
	 *
	 * A standalone page (halogy/errors/csrf_confirm.php) with one form that
	 * POSTs the token to the very same URL, so the action runs through
	 * csrf_verify() with the same URI segments, and a Cancel link back to
	 * the page the user came from (same-origin Referer) or the site.
	 *
	 * @return	void
	 */
	public function csrf_show_confirm()
	{
		// the action URL: this request's path and query string without a token
		$request_uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
		$path = (string) parse_url($request_uri, PHP_URL_PATH);
		if ($path === '' OR $path[0] !== '/')
		{
			$path = '/'.ltrim(load_class('URI', 'core')->uri_string(), '/');
		}

		$query = array();
		parse_str(isset($_SERVER['QUERY_STRING']) ? (string) $_SERVER['QUERY_STRING'] : '', $query);
		unset($query[$this->_csrf_token_name]);
		$action = $path.((count($query) > 0) ? '?'.http_build_query($query) : '');

		// back to where the user came from, when that was this site
		$cancel = (strncmp($path, '/admin', 6) === 0) ? '/admin' : '/';
		if (isset($_SERVER['HTTP_REFERER']) && $this->_header_is_same_origin($_SERVER['HTTP_REFERER']))
		{
			$referer = @parse_url((string) $_SERVER['HTTP_REFERER']);
			if (is_array($referer) && isset($referer['path']) && $referer['path'] !== '' && $referer['path'][0] === '/')
			{
				$cancel = $referer['path'].(isset($referer['query']) ? '?'.$referer['query'] : '');
			}
		}

		$token_name = $this->_csrf_token_name;
		$token = $this->_csrf_hash;
		$heading = 'Confirm action';

		// the token in the form must match the cookie the browser holds
		$this->csrf_set_cookie();

		while (ob_get_level() > 0)
		{
			ob_end_clean();
		}
		ob_start();
		include(APPPATH.'errors/csrf_confirm.php');
		$html = ob_get_contents();
		ob_end_clean();

		set_status_header(200);
		header('Content-Type: text/html; charset='.config_item('charset'));
		header('Cache-Control: no-store');
		echo $html;
		exit;
	}

	// --------------------------------------------------------------------

	/**
	 * Get CSRF Hash
	 *
	 * Getter Method
	 *
	 * @return 	string 	self::_csrf_hash
	 */
	public function get_csrf_hash()
	{
		return $this->_csrf_hash;
	}

	// --------------------------------------------------------------------

	/**
	 * Get CSRF Token Name
	 *
	 * Getter Method
	 *
	 * @return 	string 	self::csrf_token_name
	 */
	public function get_csrf_token_name()
	{
		return $this->_csrf_token_name;
	}

	// --------------------------------------------------------------------

	/**
	 * XSS Clean
	 *
	 * Sanitizes data so that Cross Site Scripting Hacks can be
	 * prevented.  This function does a fair amount of work but
	 * it is extremely thorough, designed to prevent even the
	 * most obscure XSS attempts.  Nothing is ever 100% foolproof,
	 * of course, but I haven't been able to get anything passed
	 * the filter.
	 *
	 * Note: This function should only be used to deal with data
	 * upon submission.  It's not something that should
	 * be used for general runtime processing.
	 *
	 * This function was based in part on some code and ideas I
	 * got from Bitflux: http://channel.bitflux.ch/wiki/XSS_Prevention
	 *
	 * To help develop this script I used this great list of
	 * vulnerabilities along with a few other hacks I've
	 * harvested from examining vulnerabilities in other programs:
	 * http://ha.ckers.org/xss.html
	 *
	 * @param	mixed	string or array
	 * @param 	bool
	 * @return	string
	 */
	public function xss_clean($str, $is_image = FALSE)
	{
		/*
		 * Is the string an array?
		 *
		 */
		if (is_array($str))
		{
			while (list($key) = each($str))
			{
				$str[$key] = $this->xss_clean($str[$key]);
			}

			return $str;
		}

		/*
		 * Remove Invisible Characters
		 */
		$str = remove_invisible_characters($str);

		// Validate Entities in URLs
		$str = $this->_validate_entities($str);

		/*
		 * URL Decode
		 *
		 * Just in case stuff like this is submitted:
		 *
		 * <a href="http://%77%77%77%2E%67%6F%6F%67%6C%65%2E%63%6F%6D">Google</a>
		 *
		 * Note: Use rawurldecode() so it does not remove plus signs
		 *
		 */
		$str = rawurldecode($str);

		/*
		 * Convert character entities to ASCII
		 *
		 * This permits our tests below to work reliably.
		 * We only convert entities that are within tags since
		 * these are the ones that will pose security problems.
		 *
		 */

		$str = preg_replace_callback("/[a-z]+=([\'\"]).*?\\1/si", array($this, '_convert_attribute'), $str);

		$str = preg_replace_callback("/<\w+.*?(?=>|<|$)/si", array($this, '_decode_entity'), $str);

		/*
		 * Remove Invisible Characters Again!
		 */
		$str = remove_invisible_characters($str);

		/*
		 * Convert all tabs to spaces
		 *
		 * This prevents strings like this: ja	vascript
		 * NOTE: we deal with spaces between characters later.
		 * NOTE: preg_replace was found to be amazingly slow here on
		 * large blocks of data, so we use str_replace.
		 */

		if (strpos($str, "\t") !== FALSE)
		{
			$str = str_replace("\t", ' ', $str);
		}

		/*
		 * Capture converted string for later comparison
		 */
		$converted_string = $str;

		// Remove Strings that are never allowed
		$str = $this->_do_never_allowed($str);

		/*
		 * Makes PHP tags safe
		 *
		 * Note: XML tags are inadvertently replaced too:
		 *
		 * <?xml
		 *
		 * But it doesn't seem to pose a problem.
		 */
		if ($is_image === TRUE)
		{
			// Images have a tendency to have the PHP short opening and
			// closing tags every so often so we skip those and only
			// do the long opening tags.
			$str = preg_replace('/<\?(php)/i', "&lt;?\\1", $str);
		}
		else
		{
			$str = str_replace(array('<?', '?'.'>'),  array('&lt;?', '?&gt;'), $str);
		}

		/*
		 * Compact any exploded words
		 *
		 * This corrects words like:  j a v a s c r i p t
		 * These words are compacted back to their correct state.
		 */
		$words = array(
				'javascript', 'expression', 'vbscript', 'script',
				'applet', 'alert', 'document', 'write', 'cookie', 'window'
			);

		foreach ($words as $word)
		{
			$temp = '';

			for ($i = 0, $wordlen = strlen($word); $i < $wordlen; $i++)
			{
				$temp .= substr($word, $i, 1)."\s*";
			}

			// We only want to do this when it is followed by a non-word character
			// That way valid stuff like "dealer to" does not become "dealerto"
			$str = preg_replace_callback('#('.substr($temp, 0, -3).')(\W)#is', array($this, '_compact_exploded_words'), $str);
		}

		/*
		 * Remove disallowed Javascript in links or img tags
		 * We used to do some version comparisons and use of stripos for PHP5,
		 * but it is dog slow compared to these simplified non-capturing
		 * preg_match(), especially if the pattern exists in the string
		 */
		do
		{
			$original = $str;

			if (preg_match("/<a/i", $str))
			{
				$str = preg_replace_callback("#<a\s+([^>]*?)(>|$)#si", array($this, '_js_link_removal'), $str);
			}

			if (preg_match("/<img/i", $str))
			{
				$str = preg_replace_callback("#<img\s+([^>]*?)(\s?/?>|$)#si", array($this, '_js_img_removal'), $str);
			}

			if (preg_match("/script/i", $str) OR preg_match("/xss/i", $str))
			{
				$str = preg_replace("#<(/*)(script|xss)(.*?)\>#si", '[removed]', $str);
			}
		}
		while($original != $str);

		unset($original);

		// Remove evil attributes such as style, onclick and xmlns
		$str = $this->_remove_evil_attributes($str, $is_image);

		/*
		 * Sanitize naughty HTML elements
		 *
		 * If a tag containing any of the words in the list
		 * below is found, the tag gets converted to entities.
		 *
		 * So this: <blink>
		 * Becomes: &lt;blink&gt;
		 */
		$naughty = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
		$str = preg_replace_callback('#<(/*\s*)('.$naughty.')([^><]*)([><]*)#is', array($this, '_sanitize_naughty_html'), $str);

		/*
		 * Sanitize naughty scripting elements
		 *
		 * Similar to above, only instead of looking for
		 * tags it looks for PHP and JavaScript commands
		 * that are disallowed.  Rather than removing the
		 * code, it simply converts the parenthesis to entities
		 * rendering the code un-executable.
		 *
		 * For example:	eval('some code')
		 * Becomes:		eval&#40;'some code'&#41;
		 */
		$str = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $str);


		// Final clean up
		// This adds a bit of extra precaution in case
		// something got through the above filters
		$str = $this->_do_never_allowed($str);

		/*
		 * Images are Handled in a Special Way
		 * - Essentially, we want to know that after all of the character
		 * conversion is done whether any unwanted, likely XSS, code was found.
		 * If not, we return TRUE, as the image is clean.
		 * However, if the string post-conversion does not matched the
		 * string post-removal of XSS, then it fails, as there was unwanted XSS
		 * code found and removed/changed during processing.
		 */

		if ($is_image === TRUE)
		{
			return ($str == $converted_string) ? TRUE: FALSE;
		}

		log_message('debug', "XSS Filtering completed");
		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * Random Hash for protecting URLs
	 *
	 * @return	string
	 */
	public function xss_hash()
	{
		if ($this->_xss_hash == '')
		{
			mt_srand();
			$this->_xss_hash = md5(time() + mt_rand(0, 1999999999));
		}

		return $this->_xss_hash;
	}

	// --------------------------------------------------------------------

	/**
	 * HTML Entities Decode
	 *
	 * This function is a replacement for html_entity_decode()
	 *
	 * The reason we are not using html_entity_decode() by itself is because
	 * while it is not technically correct to leave out the semicolon
	 * at the end of an entity most browsers will still interpret the entity
	 * correctly.  html_entity_decode() does not convert entities without
	 * semicolons, so we are left with our own little solution here. Bummer.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function entity_decode($str, $charset='UTF-8')
	{
		if (stristr($str, '&') === FALSE)
		{
			return $str;
		}

		$str = html_entity_decode($str, ENT_COMPAT, $charset);
		$str = preg_replace('~&#x(0*[0-9a-f]{2,5})~ei', 'chr(hexdec("\\1"))', $str);
		return preg_replace('~&#([0-9]{2,4})~e', 'chr(\\1)', $str);
	}

	// --------------------------------------------------------------------

	/**
	 * Filename Security
	 *
	 * @param	string
	 * @param 	bool
	 * @return	string
	 */
	public function sanitize_filename($str, $relative_path = FALSE)
	{
		$bad = array(
						"../",
						"<!--",
						"-->",
						"<",
						">",
						"'",
						'"',
						'&',
						'$',
						'#',
						'{',
						'}',
						'[',
						']',
						'=',
						';',
						'?',
						"%20",
						"%22",
						"%3c",		// <
						"%253c",	// <
						"%3e",		// >
						"%0e",		// >
						"%28",		// (
						"%29",		// )
						"%2528",	// (
						"%26",		// &
						"%24",		// $
						"%3f",		// ?
						"%3b",		// ;
						"%3d"		// =
					);

		if ( ! $relative_path)
		{
			$bad[] = './';
			$bad[] = '/';
		}

		$str = remove_invisible_characters($str, FALSE);
		return stripslashes(str_replace($bad, '', $str));
	}

	// ----------------------------------------------------------------

	/**
	 * Compact Exploded Words
	 *
	 * Callback function for xss_clean() to remove whitespace from
	 * things like j a v a s c r i p t
	 *
	 * @param	type
	 * @return	type
	 */
	protected function _compact_exploded_words($matches)
	{
		return preg_replace('/\s+/s', '', $matches[1]).$matches[2];
	}

	// --------------------------------------------------------------------

	/*
	 * Remove Evil HTML Attributes (like evenhandlers and style)
	 *
	 * It removes the evil attribute and either:
	 * 	- Everything up until a space
	 *		For example, everything between the pipes:
	 *		<a |style=document.write('hello');alert('world');| class=link>
	 * 	- Everything inside the quotes
	 *		For example, everything between the pipes:
	 *		<a |style="document.write('hello'); alert('world');"| class="link">
	 *
	 * @param string $str The string to check
	 * @param boolean $is_image TRUE if this is an image
	 * @return string The string with the evil attributes removed
	 */
	protected function _remove_evil_attributes($str, $is_image)
	{
		// All javascript event handlers (e.g. onload, onclick, onmouseover), style, and xmlns
		$evil_attributes = array('on\w*', 'style', 'xmlns', 'formaction');

		if ($is_image === TRUE)
		{
			/*
			 * Adobe Photoshop puts XML metadata into JFIF images, 
			 * including namespacing, so we have to allow this for images.
			 */
			unset($evil_attributes[array_search('xmlns', $evil_attributes)]);
		}
		
		do {
			$count = 0;
			$attribs = array();
			
			// find occurrences of illegal attribute strings without quotes
			preg_match_all("/(".implode('|', $evil_attributes).")\s*=\s*([^\s]*)/is",  $str, $matches, PREG_SET_ORDER);
			
			foreach ($matches as $attr)
			{
				$attribs[] = preg_quote($attr[0], '/');
			}
			
			// find occurrences of illegal attribute strings with quotes (042 and 047 are octal quotes)
			preg_match_all("/(".implode('|', $evil_attributes).")\s*=\s*(\042|\047)([^\\2]*?)(\\2)/is",  $str, $matches, PREG_SET_ORDER);

			foreach ($matches as $attr)
			{
				$attribs[] = preg_quote($attr[0], '/');
			}

			// replace illegal attribute strings that are inside an html tag
			if (count($attribs) > 0)
			{
				$str = preg_replace("/<(\/?[^><]+?)([^A-Za-z\-])(".implode('|', $attribs).")([\s><])([><]*)/i", '<$1$2$4$5', $str, -1, $count);
			}
			
		} while ($count);
		
		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * Sanitize Naughty HTML
	 *
	 * Callback function for xss_clean() to remove naughty HTML elements
	 *
	 * @param	array
	 * @return	string
	 */
	protected function _sanitize_naughty_html($matches)
	{
		// encode opening brace
		$str = '&lt;'.$matches[1].$matches[2].$matches[3];

		// encode captured opening or closing brace to prevent recursive vectors
		$str .= str_replace(array('>', '<'), array('&gt;', '&lt;'),
							$matches[4]);

		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * JS Link Removal
	 *
	 * Callback function for xss_clean() to sanitize links
	 * This limits the PCRE backtracks, making it more performance friendly
	 * and prevents PREG_BACKTRACK_LIMIT_ERROR from being triggered in
	 * PHP 5.2+ on link-heavy strings
	 *
	 * @param	array
	 * @return	string
	 */
	protected function _js_link_removal($match)
	{
		$attributes = $this->_filter_attributes(str_replace(array('<', '>'), '', $match[1]));

		return str_replace($match[1], preg_replace("#href=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|base64\s*,)#si", "", $attributes), $match[0]);
	}

	// --------------------------------------------------------------------

	/**
	 * JS Image Removal
	 *
	 * Callback function for xss_clean() to sanitize image tags
	 * This limits the PCRE backtracks, making it more performance friendly
	 * and prevents PREG_BACKTRACK_LIMIT_ERROR from being triggered in
	 * PHP 5.2+ on image tag heavy strings
	 *
	 * @param	array
	 * @return	string
	 */
	protected function _js_img_removal($match)
	{
		$attributes = $this->_filter_attributes(str_replace(array('<', '>'), '', $match[1]));

		return str_replace($match[1], preg_replace("#src=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|base64\s*,)#si", "", $attributes), $match[0]);
	}

	// --------------------------------------------------------------------

	/**
	 * Attribute Conversion
	 *
	 * Used as a callback for XSS Clean
	 *
	 * @param	array
	 * @return	string
	 */
	protected function _convert_attribute($match)
	{
		return str_replace(array('>', '<', '\\'), array('&gt;', '&lt;', '\\\\'), $match[0]);
	}

	// --------------------------------------------------------------------

	/**
	 * Filter Attributes
	 *
	 * Filters tag attributes for consistency and safety
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _filter_attributes($str)
	{
		$out = '';

		if (preg_match_all('#\s*[a-z\-]+\s*=\s*(\042|\047)([^\\1]*?)\\1#is', $str, $matches))
		{
			foreach ($matches[0] as $match)
			{
				$out .= preg_replace("#/\*.*?\*/#s", '', $match);
			}
		}

		return $out;
	}

	// --------------------------------------------------------------------

	/**
	 * HTML Entity Decode Callback
	 *
	 * Used as a callback for XSS Clean
	 *
	 * @param	array
	 * @return	string
	 */
	protected function _decode_entity($match)
	{
		return $this->entity_decode($match[0], strtoupper(config_item('charset')));
	}

	// --------------------------------------------------------------------

	/**
	 * Validate URL entities
	 *
	 * Called by xss_clean()
	 *
	 * @param 	string
	 * @return 	string
	 */
	protected function _validate_entities($str)
	{
		/*
		 * Protect GET variables in URLs
		 */

		 // 901119URL5918AMP18930PROTECT8198

		$str = preg_replace('|\&([a-z\_0-9\-]+)\=([a-z\_0-9\-]+)|i', $this->xss_hash()."\\1=\\2", $str);

		/*
		 * Validate standard character entities
		 *
		 * Add a semicolon if missing.  We do this to enable
		 * the conversion of entities to ASCII later.
		 *
		 */
		$str = preg_replace('#(&\#?[0-9a-z]{2,})([\x00-\x20])*;?#i', "\\1;\\2", $str);

		/*
		 * Validate UTF16 two byte encoding (x00)
		 *
		 * Just as above, adds a semicolon if missing.
		 *
		 */
		$str = preg_replace('#(&\#x?)([0-9A-F]+);?#i',"\\1\\2;",$str);

		/*
		 * Un-Protect GET variables in URLs
		 */
		$str = str_replace($this->xss_hash(), '&', $str);

		return $str;
	}

	// ----------------------------------------------------------------------

	/**
	 * Do Never Allowed
	 *
	 * A utility function for xss_clean()
	 *
	 * @param 	string
	 * @return 	string
	 */
	protected function _do_never_allowed($str)
	{
		foreach ($this->_never_allowed_str as $key => $val)
		{
			$str = str_replace($key, $val, $str);
		}

		foreach ($this->_never_allowed_regex as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cross Site Request Forgery Protection Cookie
	 *
	 * @return	string
	 */
	protected function _csrf_set_hash()
	{
		if ($this->_csrf_hash == '')
		{
			// If the cookie exists we will use it's value.
			// We don't necessarily want to regenerate it with
			// each page load since a page could contain embedded
			// sub-pages causing this feature to fail
			if (isset($_COOKIE[$this->_csrf_cookie_name]) &&
				is_string($_COOKIE[$this->_csrf_cookie_name]) &&
				preg_match('/^[a-f0-9]{32}$/', $_COOKIE[$this->_csrf_cookie_name]))
			{
				return $this->_csrf_hash = $_COOKIE[$this->_csrf_cookie_name];
			}

			return $this->_csrf_hash = bin2hex(random_bytes(16));
		}

		return $this->_csrf_hash;
	}

}
// END Security Class

/* End of file Security.php */
/* Location: ./system/libraries/Security.php */
