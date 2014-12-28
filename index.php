<?php 
/*
 * A Design by W3layouts
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
 *
 */
include "app/config.php";
include "app/detect.php";

if (empty($page_name)) {
	include $browser_t.'/index.php';
	}
elseif (!empty($page_name)) {
	include $browser_t.'/index.php';
	}
elseif ($page_name=='contact-post.php') {
	include $browser_t.'/contact.php';
	include 'app/contact.php';
	}
else
	{
		include $browser_t.'/404.php';
	}

?>
