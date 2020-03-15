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
				`onClose` TEXT NOT NULL DEFAULT '',
				`onOpen`  TEXT NOT NULL DEFAULT '',
				`beforeOpen` TEXT NOT NULL DEFAULT '',
				`beforeClose` TEXT NOT NULL DEFAULT '',
				`onSuccess`  TEXT NOT NULL DEFAULT '',
				`onFailure` TEXT NOT NULL DEFAULT ''
			)
		";

	$wpdb->query($query);

	$query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "okra_products` (
				`id` BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
				`product` VARCHAR(255) DEFAULT ''
			);
		";

	$wpdb->query($query);

	$query = "
			INSERT INTO `" . $wpdb->prefix . "okra_products` (product) VALUES
			('auth'), ('transactions'), ('balance'), ('identity'), ('income')
		";

	$wpdb->query($query);

	$query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "okra_product_form` (
				`pid` BIGINT(20), FOREIGN KEY (pid) REFERENCES `" . $wpdb->prefix . "okra_products`(id) ON UPDATE CASCADE ON DELETE CASCADE,
				`fid` BIGINT(20), FOREIGN KEY (fid) REFERENCES `" . $wpdb->prefix . "okra_all_forms`(id) ON UPDATE CASCADE ON DELETE CASCADE,
				PRIMARY KEY(pid, fid)
			)
		";

	$wpdb->query($query);

	$query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "okra_settings` (
				`id` BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
				`clientName` VARCHAR(255) NOT NULL DEFAULT '',
				`env` VARCHAR(255) NOT NULL DEFAULT '',
				`key` VARCHAR(255) NOT NULL DEFAULT '',
				`token` VARCHAR(255) NOT NULL DEFAULT '',
				`callback_url` VARCHAR(255) NOT NULL DEFAULT '',
				`corporate` VARCHAR(255) NOT NULL DEFAULT ''
			)
		";
	$wpdb->query($query);

	$query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "okra_styles` (
				`id` BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
				`styles` TEXT NOT NULL DEFAULT ''
			);
		";

	$wpdb->query($query);

	$query = "
			CREATE TABLE IF NOT EXISTS `". $wpdb->prefix ."okra_integrations` (
				`id` BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
				`company` VARCHAR(255) NOT NULL UNIQUE,
				`dev_api_key` VARCHAR(255) NOT NULL DEFAULT '',
				`live_api_key` VARCHAR(255) NOT NULL DEFAULT '',
				`env` VARCHAR(255) NOT NULL DEFAULT '',
				`status` TINYINT(1) NOT NULL DEFAULT 0
			); 
	";	

	$wpdb->query($query);

}

function okra_deactivate_plugin() {

	global $wpdb;
	$query = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "okra_styles`";
	$wpdb->query($query);

	$query = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "okra_settings`";
	$wpdb->query($query);

	$query = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "okra_product_form`";
	$wpdb->query($query);

	$query = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "okra_products`";
	$wpdb->query($query);

	$query = "DROP TABLE IF EXISTS `" . $wpdb->prefix . "okra_all_forms`";
	$wpdb->query($query);

	$query = "DROP TABLE IF EXISTS `". $wpdb->prefix ."okra_integrations`";
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
		$products = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_products`");
		$pages = get_pages();

		$product_checked = okra_display_checkbox(
			$products,
			"products",
			"form-check-label",
			"product",
			"id",
			null
		);

		include plugin_dir_path(dirname(__FILE__)) . "front/full_form_single_create.php";
	} else {
		if (isset($_GET["id"])) {
			$products = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_products`");
			$pages = get_pages();
			$form = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_all_forms` WHERE id={$_GET['id']}");
			$form = array_shift($form);
			$form_products = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_product_form` WHERE fid={$_GET['id']}");
			$checked_values_array = array();

			foreach ($form_products as $row) {
				array_push($checked_values_array, $row->pid);
			}

			$product_checked = okra_display_checkbox(
				$products,
				"products",
				"form-check-label",
				"product",
				"id",
				$checked_values_array
			);

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

function okra_settings_page() {
	global $wpdb;

	$output = "";

	if(isset($_GET["settings_add"])){

		$output = okra_display_alert_msg("Settings updated successfully", "alert-success");

	}

	$navbar = okra_get_navbar(array("", "active-nav", "", ""));
	$env = array(
		array(
			"property" => "Sandbox",
			"value" => "production-sandbox",
		),
		array(
			"property" => "Production",
			"value" => "production",
		),
	);

	$clientName = '';
	$env_ = '';
	$key = '';
	$token = '';
	$callback_url = '';
	$corporate = '';

	$setting = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_settings`");
	if (sizeof($setting) > 0) {
		$setting = array_shift($setting);
		$clientName = $setting->clientName;
		$env_ = $setting->env;
		$key = $setting->key;
		$token = $setting->token;
		$callback_url = $setting->callback_url;
		$corporate = $setting->corporate;
	}

	include plugin_dir_path(dirname(__FILE__)) . "front/settings.php";
}

function okra_styles_page() {
	$navbar = okra_get_navbar(array("", "", "active-nav", ""));
	$output = '';

	if (isset($_GET["save"]) && $_GET["save"] === "true") {
		$output = okra_display_alert_msg("Styles saved successfully", "alert-success");
	} else if (isset($_GET["save"])) {
		$output = okra_display_alert_msg("Styles not saved", "alert-danger");
	}

	global $wpdb;
	$styles = $wpdb->get_results("SELECT styles from `" . $wpdb->prefix . "okra_styles`");
	$styles = array_shift($styles);
	include plugin_dir_path(dirname(__FILE__)) . "front/styles.php";
}

function okra_integration_page() {
	
	$navbar = okra_get_navbar(array("", "", "", "active-nav"));
	global $wpdb;

	if(isset($_GET["add"]) && $_GET["add"] === "true"){
		include plugin_dir_path(dirname(__FILE__)) . "front/integration_create.php";
	}else if(isset($_GET["status"])){

		$wpdb->query("UPDATE `". $wpdb->prefix ."okra_integrations` SET status = 1-status WHERE id = {$_GET['status']}");
		$integrations = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix ."okra_integrations`");
		
		$integrations_enabled = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix ."okra_integrations` WHERE status = 1");

		$code = okra_generate_integration_json($integrations_enabled);

		include plugin_dir_path(dirname(__FILE__)) . "front/integration.php";


	}else if(isset($_GET["delete"])){

		$wpdb->delete($wpdb->prefix . "okra_integrations", array("id"	=>	$_GET["delete"]));
		$integrations = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix ."okra_integrations`");

		$integrations_enabled = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix ."okra_integrations` WHERE status = 1");

		$code = okra_generate_integration_json($integrations_enabled);

		include plugin_dir_path(dirname(__FILE__)) . "front/integration.php";

	}else{

		$output = "";

		if(isset($_GET["insert"]) && $_GET["insert"] === "true"){
			$output = okra_display_alert_msg("Integration saved successfully", "alert-success");
		}



		$integrations = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix ."okra_integrations`");

		$integrations_enabled = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix ."okra_integrations` WHERE status = 1");

		$code = okra_generate_integration_json($integrations_enabled);

		include plugin_dir_path(dirname(__FILE__)) . "front/integration.php";
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

	add_submenu_page(
		"okra_wordpress_plugin",
		"Okra Settings",
		"Settings",
		"manage_options",
		"okra_settings",
		"okra_settings_page"
	);

	add_submenu_page(
		"okra_wordpress_plugin",
		"Okra Styles",
		"Styles",
		"manage_options",
		"okra_styles",
		"okra_styles_page"
	);

	add_submenu_page(
		"okra_wordpress_plugin",
		"Okra Integration",
		"Payment Integration",
		"manage_options",
		"okra_integration",
		"okra_integration_page"
	);
}

function okra_settings_save() {
	// Settings data will come here

	check_admin_referer("okra_settings_save");
	global $wpdb;
	$array = array(
		"clientName" => sanitize_text_field($_POST["name"]),
		"env" => sanitize_text_field($_POST["env"]),
		"key" => sanitize_text_field($_POST["key"]),
		"token" => sanitize_text_field($_POST["token"]),
		"callback_url" => sanitize_text_field($_POST["callback_url"]),
		"corporate" => sanitize_text_field($_POST["corporate"])
	);

	$count = sizeof($wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_settings`"));

	if ($count > 0) {
		$wpdb->update($wpdb->prefix . "okra_settings", $array, array("id" => 1));
	} else {
		$wpdb->insert($wpdb->prefix . "okra_settings", $array);
	}
	wp_redirect(admin_url() . "admin.php?page=okra_settings&&settings_add=true");
}

function okra_styles_save() {
	// Styles data will come here

	global $wpdb;
	$css = esc_html($_POST["styles"]);
	$count = sizeof($wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "okra_styles`"));
	if ($count === 0) {
		$wpdb->insert($wpdb->prefix . "okra_styles", array("styles" => $css));
	} else {
		$wpdb->update($wpdb->prefix . "okra_styles", array("styles" => $css), array("id" => 1));
	}

	file_put_contents(plugin_dir_path(dirname(__FILE__)) . "assets/css/theme.css", $css);
	wp_redirect(admin_url() . 'admin.php?page=okra_styles&&save=true');

}

function okra_form_single_save() {
	// Single form settings here

	if ($_POST["action"] === "okra_form_single_save") {

		global $wpdb;
		$id = $_POST["id"];
		//echo $id;
		$name = sanitize_text_field($_POST["name"]);
		$page = sanitize_text_field($_POST["page"]);
		$products = $_POST["products"];
		$onClose = okra_quote_pattern('"', "'", sanitize_text_field($_POST["onClose"]));
		$onOpen = okra_quote_pattern(sanitize_text_field($_POST["onOpen"]));
		$beforeOpen = okra_quote_pattern(sanitize_text_field($_POST["beforeOpen"]));
		$beforeClose = okra_quote_pattern(sanitize_text_field($_POST["beforeClose"]));
		$onSuccess = okra_quote_pattern(sanitize_text_field($_POST["onSuccess"]));
		$onFailure = okra_quote_pattern(sanitize_text_field($_POST["onFailure"]));

		$array = array(
			"name" => $name,
			"page" => $page,
			"onClose" => $onClose,
			"onOpen" => $onOpen,
			"beforeOpen" => $beforeOpen,
			"beforeClose" => $beforeClose,
			"onSuccess" => $onSuccess,
			"onFailure" => $onFailure,
		);

		$wpdb->query("DELETE FROM `" . $wpdb->prefix . "okra_product_form` WHERE fid={$id}");

		if (sizeof($products) > 0) {
			$query = "INSERT INTO `" . $wpdb->prefix . "okra_product_form` (pid, fid) VALUES ";
			for ($i = 0; $i < sizeof($products); $i++) {
				$query .= "({$products[$i]}, {$id}),";
			}
			$query = substr($query, 0, strlen($query) - 1);
			$wpdb->query($query);
		}

		$wpdb->update($wpdb->prefix . "okra_all_forms", $array, array("id" => $id));
		wp_redirect(admin_url() . "?page=okra_wordpress_plugin&&update=true");

	}
}

function okra_form_single_create() {

	if ($_POST["action"] === "okra_form_single_create") {
		global $wpdb;
		$name = sanitize_text_field($_POST["name"]);
		$page = sanitize_text_field($_POST["page"]);
		$products = $_POST["products"];
		$onClose = okra_quote_pattern(sanitize_text_field($_POST["onClose"]));
		$onOpen = okra_quote_pattern(sanitize_text_field($_POST["onOpen"]));
		$beforeOpen = okra_quote_pattern(sanitize_text_field($_POST["beforeOpen"]));
		$beforeClose = okra_quote_pattern(sanitize_text_field($_POST["beforeClose"]));
		$onSuccess = okra_quote_pattern(sanitize_text_field($_POST["onSuccess"]));
		$onFailure = okra_quote_pattern(sanitize_text_field($_POST["onFailure"]));

		$array = array(
			"name" => $name,
			"page" => $page,
			"onClose" => $onClose,
			"onOpen" => $onOpen,
			"beforeOpen" => $beforeOpen,
			"beforeClose" => $beforeClose,
			"onSuccess" => $onSuccess,
			"onFailure" => $onFailure,
		);

		$wpdb->insert($wpdb->prefix . "okra_all_forms", $array);
		$id = $wpdb->insert_id;
		if (sizeof($products) > 0) {
			$query = "INSERT INTO `" . $wpdb->prefix . "okra_product_form` (pid, fid) VALUES ";
			for ($i = 0; $i < sizeof($products); $i++) {
				$query .= "({$products[$i]}, {$id}),";
			}
			$query = substr($query, 0, strlen($query) - 1);
			$wpdb->query($query);
		}

		wp_redirect(admin_url() . "?page=okra_wordpress_plugin&&insert=true");

	}
}

function okra_settings_update() {

	check_admin_referer("okra_settings_update");
	global $wpdb;
	$array = array(
		"clientName" => sanitize_text_field($_POST["name"]),
		"env" => sanitize_text_field($_POST["env"]),
		"key" => sanitize_text_field($_POST["key"]),
		"token" => sanitize_text_field($_POST["token"]),
		"callback_url" => sanitize_text_field($_POST["callback_url"]),
		"corporate" => sanitize_text_field($_POST["corporate"])
	);

	$wpdb->update($wpdb->prefix . "okra_settings", $array, array($id = $_POST["id"]));
	wp_redirect(admin_url() . "?page=okra_wordpress_plugin&&setting_update=true");

}

function okra_integration_create(){

	check_admin_referer("okra_integration_create");
	global $wpdb;

	$array = array(
		"company" => sanitize_text_field($_POST["company"]),
		"dev_api_key" => sanitize_text_field($_POST["dev_key"]),
		"live_api_key" => sanitize_text_field($_POST["live_key"]),
		"env" => sanitize_text_field($_POST["env"]),
	);

	$wpdb->insert($wpdb->prefix . "okra_integrations", $array);
	wp_redirect(admin_url() . "admin.php?page=okra_integration&&insert=true");
	
}