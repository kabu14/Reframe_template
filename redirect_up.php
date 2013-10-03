<?php

/*
 * Template Name: Redirect Up
 */
 
 //Redirect the user up one level in the tree
 
 //Removes the last directory from the URL
 //$URL = rtrim($_SERVER['Request_URI'], ' /');
 //find the string that stripped away 
?>
<?php
// redirect the user up one level in the tree
$URI = rtrim($_SERVER['REQUEST_URI'], ' /');

$URI = substr($URI, 0, strrpos($URI, '/') + 1);

if ( ! in_array($URI, array('', '/'))) {
	header('Location: '.$URI);
}
?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>



