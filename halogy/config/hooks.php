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

// state-changing actions (by routed method) only run on a verified POST;
// a GET to one renders the confirmation page instead
$hook['post_controller_constructor'][] = array(
	'class'		=> 'Security_output',
	'function'	=> 'check_action_csrf',
	'filename'	=> 'Security_output.php',
	'filepath'	=> 'hooks'
);

// add the csrf-token meta tag (read by the AJAX prefilter in the static JS)
$hook['post_controller'][] = array(
	'class'		=> 'Security_output',
	'function'	=> 'csrf_meta',
	'filename'	=> 'Security_output.php',
	'filepath'	=> 'hooks'
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */