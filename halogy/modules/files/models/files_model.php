<?php
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

class Files_model extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
		
		// get siteID, if available
		if (defined('SITEID'))
		{
			$this->siteID = SITEID;
		}
	}

	function search_files($query, $limit = '')
	{
		if (!$query)
		{
			return FALSE;
		}	
		
		$this->db->where(array('siteID' => $this->siteID, 'deleted' => 0));
		
		$this->db->where('(fileRef LIKE "%'.$this->db->escape_like_str($query).'%")');
				
		$this->db->order_by('fileRef', 'asc');
		
        if ($limit != '')
            $query = $this->db->get('files', $limit);
		else
            $query = $this->db->get('files');
		    
		if ($query->num_rows())
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	function get_folders($folderID = '')
	{
		// default where
		$this->db->where(array('siteID' => $this->siteID, 'deleted' => 0));
		$this->db->order_by('folderOrder');
		
		// get based on folder ID
		if ($folderID)
		{
			$query = $this->db->get_where('file_folders', array('folderID' => $folderID), 1);
			
			if ($query->num_rows())
			{
				return $query->row_array();
			}
			else
			{
				return false;
			}	
		}
		// or just get all of em
		else
		{
			// template type
			$query = $this->db->get('file_folders');
			
			if ($query->num_rows())
			{
				return $query->result_array();
			}
			else
			{
				return false;
			}
		}
	}	

	function update_children($folderID)
	{
		// update page draft
		$this->db->set('folderID', 0);
		$this->db->where('siteID', $this->siteID);
		$this->db->where('folderID', $folderID);
		$this->db->update('files');

		return TRUE;
	}
}