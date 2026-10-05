<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Security output hooks
 *
 * - send_headers (pre_system): basic hardening response headers
 * - inject_csrf (post_controller): adds the CSRF token to raw POST forms
 *   (Halogy views and DB templates use <form> tags, not form_open()) and a
 *   csrf-token meta tag read by the jQuery ajax prefilter in the static JS
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

	function inject_csrf()
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

		$name = $CI->security->get_csrf_token_name();
		$hash = $CI->security->get_csrf_hash();
		$input = '<input type="hidden" name="'.$name.'" value="'.$hash.'" />';
		$host = isset($_SERVER['HTTP_HOST']) ? strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'])) : '';

		// forms
		if (stripos($output, '<form') !== FALSE)
		{
			$output = preg_replace_callback('/<form\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>/i', function($m) use ($output, $name, $input, $host)
			{
				// POST forms only
				if ( ! preg_match('/\bmethod\s*=\s*["\']?\s*post\b/i', $m[1][0]))
				{
					return $m[0][0];
				}

				// relative or same host actions only
				if (preg_match('/\baction\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/i', $m[1][0], $a))
				{
					$action = trim(html_entity_decode(end($a)));
					if (preg_match('#^(?:[a-z][a-z0-9+.-]*:|//)#i', $action))
					{
						$url = parse_url(strpos($action, '//') === 0 ? 'http:'.$action : $action);
						if ( ! isset($url['scheme']) OR ! in_array(strtolower($url['scheme']), array('http', 'https')) OR ! isset($url['host']) OR strtolower($url['host']) !== $host)
						{
							return $m[0][0];
						}
					}
				}

				// form_open() may have added the token already
				$start = $m[0][1] + strlen($m[0][0]);
				$end = stripos($output, '</form', $start);
				$body = substr($output, $start, ($end === FALSE) ? 2000 : $end - $start);
				if (strpos($body, 'name="'.$name.'"') !== FALSE)
				{
					return $m[0][0];
				}

				return $m[0][0].$input;
			}, $output, -1, $count, PREG_OFFSET_CAPTURE);
		}

		// meta tag
		if (($pos = stripos($output, '</head>')) !== FALSE)
		{
			$output = substr_replace($output, '<meta name="csrf-token" content="'.$hash.'" />'."\n", $pos, 0);
		}

		$CI->output->set_output($output);
	}
}

/* End of file Security_output.php */
/* Location: ./application/hooks/Security_output.php */
