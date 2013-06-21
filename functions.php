<?php
require('reframe_home.php');
require('reframe_default.php');

//Initialize the update checker.
require 'theme-updates/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'inspiration_test',
    'http://wpupdate.reframemarketing.com/info.json'
);
?>