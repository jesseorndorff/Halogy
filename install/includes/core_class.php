<?php
/**
 * @author  Halogy Dev Team
 * @package Halogy\Installer
 *
 */
class Core {

	/**
	 * Function to validate post data, hostname, database name and username. Password is optional.
	 *
	 * @return bool
	 */
	function validate_post($data)
	{
		return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']);
	}

	/**
	 * Function to show an error message.
	 *
	 * @return string
	 */
	function show_message($type,$message) {
		return $message;
	}

	/**
	 * Function to write the database configuration file (database.php)
	 *
	 * @return bool
	 */
	function write_db_config($data) {

		/** @var string The template path */
		$template_path 	= 'config/database.php';
                
		/** @var string The destination path in CodeIgniter */
		$output_path 	= '../halogy/config/database.php';

		/** @var string Open the file */
		$database_file = file_get_contents($template_path);

       		/** @var string The content to write */
		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);

		/** @var object Write fopen handle */
		$handle = fopen($output_path,'w+');

		/** make certain the filepath is writable */
		@chmod($output_path,0777);

		/** verify permissions one last time*/
		if(is_writable($output_path)) {

			/** write the file */
                        if(fwrite($handle,$new)) {
                            
                               /** reverse the file permissions */
                                @chmod($output_path,0755);

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
        
        /**
	 * Function to write the config.php file
	 *
	 * @return bool
	 */
	function write_config($data) {

		/** @var string The template path */
		$template_path 	= 'config/config.php';
                
                /** @var string The config destination path in CodeIgniter */
		$output_path 	= '../halogy/config/config.php';

		/** open the file */
		$database_file = file_get_contents($template_path);
                
                /** @var string Build the URL string for the config file BASE_URL setting */
                $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
                $url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $url = str_replace('install/', '', $url);
                $url = str_replace('index.php', '', $url);
                
		/** @var string Replace the BASE URL setting */
                $new  = str_replace("%BASEURL%",$url,$database_file);
		
		/** @var null Write the database file */
		$handle = fopen($output_path,'w+');

		/** make certain the filepath is writable */
		@chmod($output_path,0777);

		/** verify file permissions */
		if(is_writable($output_path)) {

			/** write the file */
			if(fwrite($handle,$new)) {
                                
                                /** reverse the file permissions */
                                @chmod($output_path,0755);

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}  
}