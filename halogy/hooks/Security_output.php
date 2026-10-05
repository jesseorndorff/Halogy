<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Security output hooks
 *
 * - send_headers (pre_system): basic hardening response headers
 * - check_get_csrf (post_controller_constructor): requires the token on
 *   state-changing GET links, decided by the routed controller method
 * - inject_csrf (post_controller): adds the CSRF token to raw POST forms
 *   (Halogy views and DB templates use <form> tags, not form_open()), appends
 *   it to same-origin links to state-changing methods and adds a csrf-token
 *   meta tag read by the jQuery ajax prefilter in the static JS
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
	 * Host and port of the current request (missing port = scheme default)
	 */
	protected function _origin()
	{
		$https = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
		$host = isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : '';

		return $this->_host_port($host, $https ? 'https' : 'http');
	}

	/**
	 * Normalise "host[:port]" to "host:port"
	 */
	protected function _host_port($host, $scheme, $port = NULL)
	{
		if ($port === NULL && preg_match('/^(.*):(\d+)$/', $host, $m))
		{
			$host = $m[1];
			$port = (int) $m[2];
		}

		if ($port === NULL)
		{
			$port = (strtolower($scheme) === 'https') ? 443 : 80;
		}

		return strtolower($host).':'.$port;
	}

	/**
	 * Resolve a URL attribute the way a browser does before parsing it: decode
	 * HTML entities, drop tab/CR/LF anywhere, trim, turn backslashes into
	 * slashes (so "/\\evil.com" is seen as the protocol relative "//evil.com").
	 */
	protected function _normalise_url($url)
	{
		$url = html_entity_decode((string) $url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$url = preg_replace('/[\t\r\n]+/', '', $url);
		$url = str_replace('\\', '/', $url);

		// leading C0 controls and spaces are stripped too
		return trim($url, "\x00..\x20");
	}

	/**
	 * Is this URL relative, or absolute to the very same host and port?
	 */
	protected function _same_origin($url, $origin)
	{
		$url = $this->_normalise_url($url);

		if ( ! preg_match('#^(?:[a-z][a-z0-9+.-]*:|//)#i', $url))
		{
			return TRUE;
		}

		$https = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
		$parts = parse_url(strpos($url, '//') === 0 ? ($https ? 'https:' : 'http:').$url : $url);
		if ($parts === FALSE OR ! isset($parts['scheme']) OR ! in_array(strtolower($parts['scheme']), array('http', 'https')) OR ! isset($parts['host']))
		{
			return FALSE;
		}

		return $this->_host_port($parts['host'], $parts['scheme'], isset($parts['port']) ? $parts['port'] : NULL) === $origin;
	}

	/**
	 * Does this link point to a state-changing controller method?
	 * The method is one of the first path segments after the base path
	 * (module/method, admin/module/method, ...).
	 */
	protected function _is_action_link($url, $security)
	{
		$url = $this->_normalise_url($url);

		$path = parse_url(strpos($url, '//') === 0 ? 'http:'.$url : $url, PHP_URL_PATH);
		if ( ! is_string($path) OR $path === '')
		{
			return FALSE;
		}

		$base = parse_url(config_item('base_url'), PHP_URL_PATH);
		$base = is_string($base) ? trim($base, '/') : '';
		$path = trim($path, '/');
		if ($base !== '' && strpos($path.'/', $base.'/') === 0)
		{
			$path = ltrim(substr($path, strlen($base)), '/');
		}

		$segments = explode('/', $path);
		if (isset($segments[0]) && $segments[0] === 'index.php')
		{
			array_shift($segments);
		}

		// which segments can be the routed method: "method" or "controller/method"
		// (index 0 and 1), "admin/module/method" (1 and 2) and the full
		// "module/controller/method" when that controller really exists
		// ("shop/cart/remove" is cart() with an argument, not a remove() call)
		$segments = array_map('rawurldecode', $segments);
		if (count($segments) == 0)
		{
			return FALSE;
		}

		if ($segments[0] === 'admin')
		{
			$candidates = array_slice($segments, 1, 2);
		}
		else
		{
			$candidates = array_slice($segments, 0, 2);
			if (isset($segments[2]) && preg_match('/^[a-z0-9_]+$/i', $segments[0]) && isset($segments[1]) && preg_match('/^[a-z0-9_]+$/i', $segments[1])
				&& is_file(APPPATH.'modules/'.$segments[0].'/controllers/'.$segments[1].EXT))
			{
				$candidates[] = $segments[2];
			}
		}

		foreach ($candidates as $segment)
		{
			if ($security->csrf_get_method_protected($segment))
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

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
		$origin = $this->_origin();

		// Content that is not live markup must be left untouched, otherwise a
		// token ends up inside the text of an editor and is saved with it:
		// textareas, scripts, styles and comments are masked while rewriting
		$masked = array();
		$salt = bin2hex(random_bytes(8));
		$result = preg_replace_callback('~<textarea\b.*?</textarea\s*>|<script\b.*?</script\s*>|<style\b.*?</style\s*>|<!--.*?-->~is', function($m) use (&$masked, $salt)
		{
			$key = 'csrfmask'.$salt.'x'.count($masked).'x';
			$masked[$key] = $m[0];

			return $key;
		}, $output);
		if ( ! is_string($result))
		{
			// regex failure (backtrack limit): leave the page as it is
			log_message('error', 'Security_output: could not mask page content');
			return;
		}
		$output = $result;

		// forms
		if (stripos($output, '<form') !== FALSE)
		{
			$output = preg_replace_callback('/<form\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>/i', function($m) use ($output, $name, $input, $origin)
			{
				// POST forms only
				if ( ! preg_match('/\bmethod\s*=\s*["\']?\s*post\b/i', $m[1][0]))
				{
					return $m[0][0];
				}

				// relative or same host actions only
				if (preg_match('/\baction\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|([^\s>]+))/i', $m[1][0], $a))
				{
					if ( ! $this->_same_origin(end($a), $origin))
					{
						return $m[0][0];
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

		// links to state-changing methods get the token in the query string
		if (stripos($output, '<a') !== FALSE)
		{
			$security = $CI->security;
			$query = $name.'='.$hash;
			$output = preg_replace_callback('/(<a\b(?:[^>"\']|"[^"]*"|\'[^\']*\')*?\bhref\s*=\s*)(?:"([^"]*)"|\'([^\']*)\'|([^\s"\'>]+))/i', function($m) use ($security, $name, $query, $origin)
			{
				$value = (isset($m[4]) && $m[4] !== '') ? $m[4] : ((isset($m[3]) && $m[3] !== '') ? $m[3] : $m[2]);
				$url = $this->_normalise_url($value);

				if ($url === '' OR $url[0] === '#' OR strpos($url, $name.'=') !== FALSE
					OR ! $this->_same_origin($value, $origin)
					OR ! $this->_is_action_link($value, $security))
				{
					return $m[0];
				}

				// keep the fragment last
				$fragment = '';
				if (($pos = strpos($value, '#')) !== FALSE)
				{
					$fragment = substr($value, $pos);
					$value = substr($value, 0, $pos);
				}
				$value .= ((strpos($value, '?') === FALSE) ? '?' : '&amp;').$query.$fragment;

				if (isset($m[4]) && $m[4] !== '')
				{
					return $m[1].'"'.$value.'"';
				}

				$quote = (isset($m[3]) && $m[3] !== '') ? "'" : '"';

				return $m[1].$quote.$value.$quote;
			}, $output);
		}

		// put the masked content back
		if (count($masked) > 0)
		{
			$output = strtr($output, $masked);
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
