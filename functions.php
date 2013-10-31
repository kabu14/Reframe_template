<?php
require('reframe_home.php');
require('reframe_default.php');

//Initialize the update checker.
require 'theme-updates/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'inspiration_test',
    'http://wpupdate.reframemarketing.com/info.json'
);

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}
add_action('wp_print_scripts ', 'my_jquery_enqueue');

/**
 * sticky form input
 * @param  string $key
 * @return $_REQUEST or ''
 */
function old($key)
{
	if ( !empty($_REQUEST[$key]) ) {
		return htmlspecialchars($_REQUEST[$key]);
	}
	return '';
}



/**
 * sticky radio button
 * @param  string $key   the name field
 * @param  string $value the value field
 * @return string        returns the checked="checked" depending on users last input value
 */
function old_radio($key, $value)
{
	if ( !empty($_REQUEST[$key]) && ($_REQUEST[$key] == $value) ) {
		return 'checked="checked"';
	}
	return '';
}



/**
 * uses trim() and htmlspecialchars() for non empty inputs
 * keeps line breaks for textareas
 * @param  string $input
 * @return string
 */
function safe_input($input)
{
	if ( !empty($input) ) {
		return trim(nl2br(htmlspecialchars($input)));
	}
	return '';
}



/**
 * gathers an optional input and returns a label with an input
 * if not empty
 * @param  string $input
 * @param  string $label
 * @return string
 */
function optional($label, $input)
{
	if ( !empty($input) && empty($label) ) {
		return $input;
	}
	elseif ( !empty($input) ) {
		return "<p>$label $input</p>";
	}
	return '';
}



/**
 * sets wp_mail() content type
 */
function set_html_content_type() {

	return 'text/html';
}
?>