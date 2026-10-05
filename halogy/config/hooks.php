<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// send security headers as early as possible (also covers error pages)
$hook['pre_system'][] = array(
	'class'		=> 'Security_output',
	'function'	=> 'send_headers',
	'filename'	=> 'Security_output.php',
	'filepath'	=> 'hooks'
);

// inject the CSRF token into raw <form> tags and the csrf-token meta tag
$hook['post_controller'][] = array(
	'class'		=> 'Security_output',
	'function'	=> 'inject_csrf',
	'filename'	=> 'Security_output.php',
	'filepath'	=> 'hooks'
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */