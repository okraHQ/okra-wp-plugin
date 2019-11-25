<?php

	function okra_modal_shortcode( $attr ){

		if(!empty($attr['id'])){

			global $wpdb;
			$modal = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."okra_all_forms` WHERE id={$attr['id']}");
			$products = $wpdb->get_results("SELECT product from `". $wpdb->prefix ."okra_products` WHERE id in (SELECT pid FROM `". $wpdb->prefix ."okra_product_form` WHERE fid={$attr['id']})");
			$settings = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."okra_settings`");

			$products_array = array();

			if(sizeof($modal) === 0){
				return "No modal created";
			}

			if(sizeof($settings) === 0){
				return "No settings saved";
			}

			foreach ($products as $row){
				array_push($products_array, $row->product);
			}

			$modal = array_shift($modal);
			$settings = array_shift($settings);

			$modal->onClose = str_replace('<quote>', "'", stripcslashes($modal->onClose));
			$modal->onOpen = str_replace('<quote>', "'", stripcslashes($modal->onOpen));
			$modal->beforeOpen = str_replace('<quote>', "'", stripcslashes($modal->beforeOpen));
			$modal->beforeClose = str_replace('<quote>', "'", stripcslashes($modal->beforeClose));
			$modal->onSuccess = str_replace('<quote>', "'", stripcslashes($modal->onSuccess));
			$modal->onFailure = str_replace('<quote>', "'", stripcslashes($modal->onFailure));

			$theme_css = substr(plugins_url(dirname(PLUGIN_URI)), 0, strlen(plugins_url(dirname(PLUGIN_URI)))-1);

			$output = "
				
				<div id='okra-enabled'>
					<head>
						<script src='https://dev-cdn.okra.ng/okra.min.js'></script>
 						<link rel='stylesheet' href='https://dev-cdn.okra.ng/okra.min.css' media='all' />

					</head> 
					<button class='okra'>". $attr["btn-text"] ."</button>
 					
 					<script type='text/javascript'>

					    /**
					    * SIMPLE OKRA MODAL
						*/
						
						var options = {
					        env: '". $settings->env ."', 
					        clientName: '". $settings->clientName ."', //TODO use this somehow with the button
					        key: '". $settings->key ."',
					        token: '". $settings->token ."',
					        user: {
					            first_name: 'Bayo',
					            last_name: 'Thomas',
					            middle_name: 'Peter', // optional
					            email: 'bayo@okra.ng',
					            bvn: '00123456789', //optional
					            bank: 'okra-plc', //optional
					            accounts: ['0123456789'] 
					        },
					        products: ". json_encode($products_array) .",
					        onClose: function() {
					            ". $modal->onClose ."
					        },
					        onOpen: function() {
					      		". $modal->onOpen ."
					        },
					        beforeOpen: function() {
					           	". $modal->beforeOpen ."
					        },
					        beforeClose: function() {
					            ". $modal->beforeClose ."
					        },
					        onSuccess: function() {
					            ". $modal->onSuccess ."
					        },
					        onFailure: function (error) {
					         	". $modal->onFailure ."
					        }
					    }
					
					    var client = new okra.create();
						var btn = document.querySelector('.okra');
						btn.addEventListener('click', function(){
							client.open(options);
						});
						
					</script>
				</div>			
			
			";

			return $output;
		}



	}