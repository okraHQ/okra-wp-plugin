<?php

include "functions.php";

function okra_activate_plugin() {
	if (version_compare(get_bloginfo("version"), "4.2", "<")) {
		wp_die(__("You must update the wordpress before using this plugin", "fifth_insight"));
	}

	global $wpdb;

	$query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "okra_all_forms`  (
				`id` BIGINT (20) PRIMARY KEY AUTO_INCREMENT,
				`created` DATETIME DEFAULT CURRENT_TIMESTAMP,
				`name` VARCHAR(255) NOT NULL DEFAULT '',
				`page` VARCHAR(255) NOT NULL DEFAULT '',
				`short_code` VARCHAR(50) NOT NULL DEFAULT ''
			)
		";

	$wpdb->query($query);

}

function okra_deactivate_plugin() {

	global $wpdb;

	$query = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "okra_all_forms`";
	$wpdb->query($query);

}

function okra_admin_init() {
	global $submenu;
	$submenu_list = $submenu["okra_wordpress_plugin"];
	return $submenu_list;
}

function okra_full_forms_page() {
	
	$navbar = okra_get_navbar(array("active-nav", "", "", ""));
	global $wpdb;

	if (isset($_GET["add"])) {
		$pages = get_pages();
		include plugin_dir_path(dirname(__FILE__)) . "front/full_form_single_create.php";
	} else {
		if (isset($_GET["id"])) {
			$pages = get_pages();
			$form = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_all_forms` WHERE id={$_GET['id']}");
			$form = array_shift($form);

			$page_selected = okra_display_option(
				$pages,
				"post_title",
				"post_title",
				$form->page
			);

			include plugin_dir_path(dirname(__FILE__)) . "front/full_form_single.php";
		}else if(isset($_GET["delId"])){

			$wpdb->delete($wpdb->prefix . "okra_all_forms", array("id"	=>	$_GET["delId"]));
			$forms = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_all_forms`");
			include plugin_dir_path(dirname(__FILE__)) . "front/full_forms.php";

		}else {

			$output = "";
			if (isset($_GET["update"])) {
				if ($_GET["update"] === "true") {
					$output = okra_display_alert_msg("Changes updated successfully", "alert-success");
				} else {
					$output = okra_display_alert_msg("Changes didn't updated", "alert-danger");
				}
			}

			if (isset($_GET["insert"])) {
				if ($_GET["insert"] === "true") {
					$output = okra_display_alert_msg("Changes updated successfully", "alert-success");
				} else {
					$output = okra_display_alert_msg("Changes didn't updated", "alert-danger");
				}
			}

			if(isset($_GET["delete"]) && $_GET["delete"] === "true"){
				$output = okra_display_alert_msg("Form deleted successfully", "alert-danger");
			}

			$forms = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_all_forms`");

			include plugin_dir_path(dirname(__FILE__)) . "front/full_forms.php";
		}
	}

}

function okra_enqueue_scripts() {
	wp_register_style("okra_bootstrap", plugins_url("/" . PLUGIN_URI . "/assets/css/bootstrap.min.css"), OKRA_PLUGIN_URL);
	wp_register_style("okra_font", plugins_url("/" . PLUGIN_URI . "/assets/css/font-awesome.min.css"), OKRA_PLUGIN_URL);
	wp_register_style("okra_theme_style", plugins_url("/" . PLUGIN_URI . "/assets/css/style.css"), OKRA_PLUGIN_URL);
	wp_register_style("okra_codemirror_style", plugins_url("/" . PLUGIN_URI . "/assets/css/codemirror.css"), OKRA_PLUGIN_URL);
	wp_register_style("okra_eclipse_style", plugins_url("/" . PLUGIN_URI . "/assets/css/eclipse.css"), OKRA_PLUGIN_URL);

	wp_enqueue_style("okra_bootstrap");
	wp_enqueue_style("okra_font");
	wp_enqueue_style("okra_theme_style");
	wp_enqueue_style("okra_codemirror_style");
	wp_enqueue_style("okra_eclipse_style");

	wp_register_script("okra_bootstrap_script", plugins_url("/" . PLUGIN_URI . "/assets/js/bootstrap.min.js"), OKRA_PLUGIN_URL);
	wp_register_script("okra_popper_script", plugins_url("/" . PLUGIN_URI . "/assets/js/popper.min.js"), OKRA_PLUGIN_URL);
	wp_register_script("okra_theme_js", plugins_url("/" . PLUGIN_URI . "/assets/js/main.js"), OKRA_PLUGIN_URL);
	wp_register_script("okra_codemirror_script", plugins_url("/" . PLUGIN_URI . "/assets/js/codemirror.js"), OKRA_PLUGIN_URL);
	wp_register_script("okra_htmlmirror_script", plugins_url("/" . PLUGIN_URI . "/assets/js/htmlmixed.js"), OKRA_PLUGIN_URL);

	wp_enqueue_script("jquery");
	wp_enqueue_script("okra_popper_script");
	wp_enqueue_script("okra_bootstrap_script");
	wp_enqueue_script("okra_theme_js");
	wp_enqueue_script("okra_codemirror_script");
	wp_enqueue_script("okra_htmlmirror_script");
}

function okra_admin_menu() {
	add_menu_page(
		"Okra Plugin",
		"Okra",
		"manage_options",
		"okra_wordpress_plugin",
		"okra_full_forms_page",
		"",
		60
	);
}


function okra_form_single_save() {
	// Single form settings here

	if ($_POST["action"] === "okra_form_single_save") {

		global $wpdb;
		$id = $_POST["id"];
		//echo $id;
		$name = sanitize_text_field($_POST["name"]);
		$page = sanitize_text_field($_POST["page"]);
		$short_code = sanitize_text_field($_POST["short_code"]);

		$array = array(
			"name" => $name,
			"page" => $page,
			"short_code" => $short_code
		);

		$wpdb->update($wpdb->prefix . "okra_all_forms", $array, array("id" => $id));
		wp_redirect(admin_url() . "?page=okra_wordpress_plugin&&update=true");

	}
}

function okra_form_single_create() {

	if ($_POST["action"] === "okra_form_single_create") {
		global $wpdb;
		$name = sanitize_text_field($_POST["name"]);
		$page = sanitize_text_field($_POST["page"]);
		$short_code = sanitize_text_field($_POST["short_code"]);
		$array = array(
			"name" => $name,
			"page" => $page,
			"short_code" => $short_code
		);

		$wpdb->insert($wpdb->prefix . "okra_all_forms", $array);

		wp_redirect(admin_url() . "?page=okra_wordpress_plugin&&insert=true");

	}
}

