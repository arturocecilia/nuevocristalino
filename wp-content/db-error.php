<?php // custom WordPress database error page tutorial @ digwp.com

	header('HTTP/1.1 503 Service Temporarily Unavailable');
	header('Status: 503 Service Temporarily Unavailable');
	header('Retry-After: 3600'); // 1 hour = 3600 seconds
	mail("spamless@domain.tld", "Database Error", "There is a problem with teh database!", "From: Montgomery Scott");

?>
<!DOCTYPE HTML>
<html dir="ltr" lang="en-US">
	<head>
		<title>This site is no longer active</title>
		<style type="text/css">
			h1, p {
				font-family: Helvetica, sans-serif;
				font-size: 24px;
				color: #333;
				text-align: center;
				}
			p {
				font-size: 14px;
				}
		</style>
	</head>
	<body><br /><br /><br /><br />
		<h1>La red de sites de Nuevocristalino ya no está activo</h1>
		<h1>Newlens, Mylifestylelens and Neuelinsen are no longer available</h1>
		<p>info@nuevocristalino.es</p>
	</body>
</html>