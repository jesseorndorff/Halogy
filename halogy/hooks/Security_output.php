<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Security output hooks
 *
 * - send_headers (pre_system): basic hardening response headers
 * - check_get_csrf (post_controller_constructor): state-changing GET links
 *   (decided by the routed controller method) must come from this site
 * - csrf_meta (post_controller): adds the csrf-token meta tag right after the
 *   opening <head> tag, read by the jQuery ajax prefilter in the static JS
 *
 * Nothing else in the page is touched: request origin is verified from the
 * Sec-Fetch-Site / Origin / Referer headers (see CI_Security::_request_allowed),
 * so forms and links do not need a token any more.
 */
#[\AllowDynamicProperties]
class Security_output {

	function send_headers()
	{
		if (headers_sent())
		{
			return;
		}

		header('X-Content-Type-Options: nosniff');
		header('X-Frame-Options: SAMEORIGIN');
		header('Referrer-Policy: strict-origin-when-cross-origin');
	}

	function check_get_csrf()
	{
		$CI =& get_instance();

		if ($CI->config->item('csrf_protection') !== TRUE)
		{
			return;
		}

		$CI->security->csrf_verify_get($CI->router->fetch_method());
	}

	// --------------------------------------------------------------------

	/**
	 * Add <meta name="csrf-token"> to HTML pages
	 *
	 * Inserted once, straight after the first <head> opening tag found in the
	 * first 4 KB of the output. Pages without one are left alone: AJAX then
	 * relies on the Sec-Fetch-Site / Origin headers the browser sends anyway.
	 */
	function csrf_meta()
	{
		$CI =& get_instance();

		if ($CI->config->item('csrf_protection') !== TRUE)
		{
			return;
		}

		// html responses only
		$headers = headers_list();
		foreach ((function() { return $this->headers; })->call($CI->output) as $header)
		{
			$headers[] = $header[0];
		}
		foreach ($headers as $header)
		{
			if (stripos($header, 'content-type:') === 0 && stripos($header, 'text/html') === FALSE)
			{
				return;
			}
		}

		$output = $CI->output->get_output();
		if ( ! is_string($output) OR $output === '')
		{
			return;
		}

		if ( ! preg_match('/<head\b[^>]*>/i', substr($output, 0, 4096), $m, PREG_OFFSET_CAPTURE))
		{
			return;
		}

		$pos = $m[0][1] + strlen($m[0][0]);
		$meta = "\n".'<meta name="csrf-token" content="'.$CI->security->get_csrf_hash().'" />';

		$CI->output->set_output(substr_replace($output, $meta, $pos, 0));
	}
}

/* End of file Security_output.php */
/* Location: ./application/hooks/Security_output.php */
