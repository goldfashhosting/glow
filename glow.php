<?php

/**
 * @package glow
 * @version v2.2.1
 */
/*
Plugin Name: GLOW
Plugin URL: http://goldfash.com?plugins
Description: GLOW provides various functions for GMWP+. GLOW is also the heartbeat of using GMWP+.
Version: v2.2.1
Author: GOD1ST.Cloud Developers
Author URI:        http://GOD1st.Cloud
Contributors:      raceanf
Domain Path:       /languages
Text Domain:       glow
GitHub Plugin URI: https://github.com/goldfashhosting/glow
GitHub Branch:     master
*/


function glow_init()
{
 require ('inc/gfunctions/functions.php');
 require ('inc/webapps/shortcodes.php');
}
add_action('init', 'glow_init');

