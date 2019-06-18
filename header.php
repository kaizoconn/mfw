<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">

	<title><?php echo gmfw_return_page_title() . " | " . get_bloginfo('name'); ?></title>

	<!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end of wordpress head functions -->

	<style type="text/css">
		/* To encourage you to write as little CSS as possible, there's no separate CSS file */

		/* @import url(https://fonts.googleapis.com/css?family=Rubik:300,500); */
		@import url(https://fonts.googleapis.com/css?family=Roboto:300,500);

		body { margin: 1em auto 5em auto; max-width: 900px; line-height: 1.6em; font-size: 16px; color: #444; padding: 0 10px; }
		hr { border: 0; color: #808080; background-color: #808080; height: 1px; }
		hr.pagebottom { height: 5px; margin-top: 3em; }

		/* link colors from http://clrs.cc/ */

		a { color: #0074D9; }
		a:visited { color: #B10DC9; }
		a:hover { text-decoration: underline; }

		/* img.full { width: 100%; } */

		h1, h2, h3, h4, h5 { text-transform: uppercase; font-weight: normal; margin-top: 2em; }

		#header-contents { padding: 1em 0;}
		#navmenu ul { padding: 0; margin: 0; float: right; }
		#navmenu li { list-style-type: none; float: left; margin: 0 1em 0 0; }
		#navmenu li:last-of-type { margin-right: 0; }
		#navmenu .current-menu-item a { font-weight: 500; }
		#navmenu a { text-transform: uppercase; text-decoration: none; color: #444444; }

		h1, h2, h3, h4, p, li, dt, dd, th, td { font-family: 'Roboto', sans-serif; font-weight: 300; }

		h1, h2, h3 { line-height: 1.2em; }

		h1 { font-size: 32px; margin-bottom: 2em; }
		h2 { font-size: 25px; }
		h3 { font-size: 22px; }

		li { margin-bottom: 1em; }

		pre { border: 2px dashed #CCCCCC; padding: 1em; font-family: monospace; font-size: 14px; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word; }

		dt { font-weight: 500; }
		dt, dd { margin-bottom: 1em; }

		body article { margin-bottom: 2em; border-bottom: 1px solid #CCCCCC; }
		body article:last-of-type { border-bottom: 0; }

		/*
		h1, h2, h3, h4 { font-family: serif; }
		p, li, body { font-family: sans-serif; }
		*/

		.caps { text-transform: uppercase; }
		.clear { clear: both; }
		.mt0 { margin-top: 0 !important; }
		.mb0 { margin-bottom: 0 !important; }

	</style>

</head>

<body <?php body_class(); ?>>

	<header>

		<div id="header-contents">

			<div style="width: 33%; display: inline; float: left;" class="caps">
				<p class="mb0 mt0"><?php echo get_bloginfo('name'); ?></p>
			</div>

			<div id="navmenu" style="width: 67%; display: inline; float: left;">
				<nav>
					<?php wp_nav_menu( array('menu' => 'Main' )); ?>
				</nav>
			</div>

			<div class="clear"></div>

		</div>

		<hr>

	</header>
