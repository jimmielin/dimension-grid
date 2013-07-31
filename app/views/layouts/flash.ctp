<?php
/**
 * Dimension.Grid
 * @author    Jimmie Lin <jimmie.lin@gmail.com>
 * @since     1.0.600.7
 * @license   Dimension.Grid Developer Non-Disclosure Agreement
 * @copyright (c) 2010 Jimmie Lin
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title; ?></title>
		<?php if (Configure::read() == 0) { ?>
			<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
		<?php } ?>

		<style type="text/css" media="screen">
			body {
				background: #F7F7F7;
				font-family: sans-serif;
				font-size: 20px;
			}
			p {
				text-align: center;
				font-weight: bold;

				text-shadow: 1px 1px 0 white;
			}
			a { color:#444; text-decoration:none }
			a:hover { text-decoration: underline; color:#44E }
		</style>
	</head>
	<body>
		<p><a href="<?php echo $url; ?>"><?php echo $message; ?></a></p>
		<div style='font-size:11px;margin:auto auto;width:50%;text-align:center'>
			<strong><?php echo Configure::read("Appl.Name"); ?></strong> Version <strong><?php echo Configure::read("Appl.Version"); ?></strong> &copy; 2010 Jimmie Lin
		</div>
	</body>
</html>