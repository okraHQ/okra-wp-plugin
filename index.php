<?php
/*
 * Plugin Name: Okra
 * Description: The simplest way to connect your Nigerian bank account to an app. The Wordpress way.
 * Version: 1.0
 * Author:
 * Author URI:
 * Text Domain: okra
 * License:
 * License URI:
 */

if(!function_exists("add_action")){
	echo "Not allowed";
	exit();
}

//Setup
define ("OKRA_PLUGIN_URL", __FILE__);
$arr = explode(DIRECTORY_SEPARATOR, dirname(OKRA_PLUGIN_URL));
define ("PLUGIN_URI", $arr[sizeof($arr)-1]);

//Includes
include ("includes/hooks.php");
include ("includes/shortcodes.php");

//Hooks
register_activation_hook(__FILE__, "okra_activate_plugin");
//register_deactivation_hook(__FILE__, "okra_deactivate_plugin");
register_uninstall_hook(__FILE__, "okra_deactivate_plugin");
add_action("admin_init", "okra_admin_init");
add_action("admin_menu", "okra_admin_menu");
add_action("admin_enqueue_scripts", "okra_enqueue_scripts");
add_action("admin_post_okra_form_single_save", "okra_form_single_save");
add_action("admin_post_okra_form_single_create", "okra_form_single_create");

//Shortcodes
add_shortcode("okra_modal", "okra_modal_shortcode");
