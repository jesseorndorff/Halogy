<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* CodeIgniter BBCode Helpers
*
* @package  CodeIgniter
* @subpackage Helpers
* @category Helpers
* @author  Philip Sturgeon
* @changes  MpaK http://mrak7.com
* @link  http://codeigniter.com/wiki/BBCode_Helper/
*/

// ------------------------------------------------------------------------

/**
* parse_bbcode
*
* Converts BBCode style tags into basic HTML
*
* @access public
* @param string unparsed string
* @param int max image width
* @return string
*/

function bbcode($str = '', $max_images = 0)
{
	// the marker used for finished links and images is stripped from the
	// input, so it can only come from this function
	$str = str_replace("\x1a", '', (string)$str);

	// convert to html entities: from here on nothing the author typed can
	// start a tag or break out of an attribute
	$str = htmlentities($str, ENT_QUOTES, 'UTF-8');

	// links and images are built (and checked) first and set aside, so the
	// rest of the formatting cannot reach into their attributes
	$parts = array();

	$set_aside = function ($html) use (&$parts)
	{
		$parts[] = $html;
		return "\x1a".(count($parts) - 1)."\x1a";
	};

	// [img]url[/img]
	$str = preg_replace_callback("'\[img\](.*?)\[/img\]'i", function ($m) use ($set_aside)
	{
		if (($url = _bbcode_url($m[1], FALSE)) === FALSE)
		{
			return $m[0];
		}
		return $set_aside('<img src="'.$url.'" alt="" />');
	}, $str);

	// [url]url[/url], [link]url[/link]
	$str = preg_replace_callback("'\[(url|link)\](.*?)\[/\\1\]'i", function ($m) use ($set_aside)
	{
		if (($url = _bbcode_url($m[2])) === FALSE)
		{
			return $m[0];
		}
		return $set_aside('<a href="'.$url.'" rel="nofollow noopener">'.$m[2].'</a>');
	}, $str);

	// [url=url]text[/url], [link=url]text[/link]
	$str = preg_replace_callback("'\[(url|link)=(.*?)\](.*?)\[/\\1\]'i", function ($m) use ($set_aside)
	{
		if (($url = _bbcode_url($m[2])) === FALSE)
		{
			// not a safe target: the text is kept, the link is dropped
			return $m[3];
		}
		return $set_aside('<a href="'.$url.'" rel="nofollow noopener">'.$m[3].'</a>');
	}, $str);

	// bare addresses become links
	$str = preg_replace_callback('#(^|\s|\(|\])((?:https?://|www\.)[^\s<>()\[\]\x1a]+)#i', function ($m) use ($set_aside)
	{
		$link = $m[2];
		$trail = '';
		if (preg_match('/^(.*?)((?:[.,;:!?]|&quot;|&\#0?39;)+)$/s', $link, $t))
		{
			$link = $t[1];
			$trail = $t[2];
		}
		if (($url = _bbcode_url($link)) === FALSE)
		{
			return $m[0];
		}
		return $m[1].$set_aside('<a href="'.$url.'" rel="nofollow noopener">'.$link.'</a>').$trail;
	}, $str);

	$str = preg_replace_callback('/([a-zA-Z0-9_.+\-]+@[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)+)/', function ($m) use ($set_aside)
	{
		return $set_aside('<a href="mailto:'.$m[1].'">'.$m[1].'</a>');
	}, $str);

	$find = array(
	"'\n'i",
	"'\[b\](.*?)\[/b\]'is",
	"'\[i\](.*?)\[/i\]'is",
	"'\[u\](.*?)\[/u\]'is",
	"'\[s\](.*?)\[/s\]'is",
	"'\[size=small\](.*?)\[/size\]'is",	
	"'\[size=normal\](.*?)\[/size\]'is",
	"'\[size=medium\](.*?)\[/size\]'is",
	"'\[size=big\](.*?)\[/size\]'is",
	"'\[quote\](.*?)\[/quote\]'is",
	"'\[code\](.*?)\[/code\]'is"	
	);
	
	$replace = array(
	'<br />',
	'<strong>\\1</strong>',
	'<em>\\1</em>',
	'<u>\\1</u>',
	'<s>\\1</s>',
	'<span style="font-size:0.9em;">\\1</span>',	
	'<span style="font-size:1em;">\\1</span>',
	'<span style="font-size:1.2em;">\\1</span>',
	'<span style="font-size:1.4em;">\\1</span>',
	'</p><blockquote>\\1</blockquote><p>',	
	'<pre><code>\\1</code></pre>'				
	);
	
	$str = preg_replace($find, $replace, $str);

	// put the finished links and images back
	$str = preg_replace_callback("/\x1a(\d+)\x1a/", function ($m) use (&$parts)
	{
		return (isset($parts[$m[1]])) ? $parts[$m[1]] : '';
	}, $str);

	return '<p>'.$str.'</p>';

}

// ------------------------------------------------------------------------

/**
* _bbcode_url
*
* Checks a link target taken from bbcode (already converted to html
* entities). Only http, https, mailto (links only) and site-relative
* targets are accepted; anything else, javascript: and data: included,
* gives FALSE and is shown as plain text.
*
* @access private
* @param string target, as it appears in the escaped text
* @param bool allow mailto: (links, not images)
* @return mixed safe target ready for a double quoted attribute, or FALSE
*/

function _bbcode_url($url, $mailto = TRUE)
{
	// [url="..."] and [url='...']
	$url = trim((string)$url);
	if (preg_match('/^(?:&quot;|&\#0?39;)(.*)(?:&quot;|&\#0?39;)$/s', $url, $m))
	{
		$url = $m[1];
	}

	// what the browser will read: no whitespace or control characters
	$plain = html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	if ($plain === '' || preg_match('/[\x00-\x20\x7f-\x9f\\\\<>"\']|\p{Z}|[\x{200b}-\x{200f}\x{2028}\x{2029}\x{feff}]/u', $plain))
	{
		return FALSE;
	}

	// bare www. addresses
	if (preg_match('/^www\./i', $plain))
	{
		$url = 'http://'.$url;
		$plain = 'http://'.$plain;
	}

	$allowed = '#^(?:https?://[^/?\#]+|/(?!/)|\#)#i';
	if ($mailto)
	{
		$allowed = '#^(?:https?://[^/?\#]+|mailto:[^/?\#]+|/(?!/)|\#)#i';
	}

	return (preg_match($allowed, $plain)) ? $url : FALSE;
}

?>