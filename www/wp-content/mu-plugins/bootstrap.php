<?php
/*
Plugin Name: eLearning Industry
Text Domain: eli-theme
 */
$poedit = __('Yes, please.', 'eli-theme');

// Bail if at the cli and instructed to skip plugins.
if (defined('WP_CLI') && WP_CLI && WP_CLI::get_runner()->config['skip-plugins'])
{
    return;
}


if (wp_installing())
{
    return;
}

// Get Composer autoloader up and running.
require __DIR__ . "/../vendor/autoload.php";

return;
