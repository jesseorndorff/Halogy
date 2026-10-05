<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<title><?php echo html_escape($heading); ?></title>
	<style type="text/css">
		body { font-size: 76%; font-family: "Lucida Grande", arial, sans-serif; margin: 50px 0 0; color: #171717; background: #fff; }
		div.content { width: 600px; max-width: 90%; margin: 0 auto; padding: 40px 0 20px; }
		div.content h1 { font-size: 3em; font-weight: normal; color: #171717; margin: 0 0 30px; }
		div.content p { font-size: 1.2em; color: #555; margin: 0 0 20px; line-height: 1.4em; }
		div.content code { display: block; font-size: 1.1em; padding: 8px 10px; background: #f4f4f4; border: 1px solid #ddd; word-break: break-all; }
		div.content input { font-size: 1.2em; padding: 6px 14px; margin: 0 16px 0 0; cursor: pointer; }
		div.content a { font-size: 1.2em; color: #2194CD; text-decoration: none; }
		div.content a:hover { color: #bbb; }
	</style>
</head>
<body>

<div class="content">

	<h1><?php echo html_escape($heading); ?></h1>

	<p>You followed a link to an action that changes data on this site:</p>

	<code><?php echo html_escape($action); ?></code>

	<p>Links can be planted in pages, messages and e-mails, so this action only runs after you confirm it.</p>

	<form method="post" action="<?php echo html_escape($action); ?>">
		<input type="hidden" name="<?php echo html_escape($token_name); ?>" value="<?php echo html_escape($token); ?>" />
		<input type="submit" value="Confirm" />
		<a href="<?php echo html_escape($cancel); ?>">Cancel</a>
	</form>

</div>

</body>
</html>
