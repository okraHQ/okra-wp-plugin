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

										
					<button class='okra'>". $attr["btn-text"] ."</button>
						
					 <script type='text/javascript'>

					 window.document.head.insertAdjacentHTML('beforeend', `<style>svg, img, embed, object {display: initial; height: auto; max-width: 100%;}</style>`);

					 
					 const link = document.createElement('link');
					 link.rel = 'stylesheet';
					 link.type = 'text/css';
					 link.href = 'https://cdn.okra.ng/okra.css';
					 document.head.appendChild(link);
					 const script = document.createElement('script');
					 script.src = 'https://cdn.okra.ng/okra.min.js';
					 document.getElementsByTagName('head')[0].appendChild(script);

					 var client;

					 link.onload = function () {
						window.document.head.insertAdjacentHTML('beforeend', `<style> #okra-enabled {position: initial;}</style>`);
					};


					 if (script.readyState) {
						// IE
						script.onreadystatechange = () => {
						  if (
							script.readyState === 'loaded' ||
							script.readyState === 'complete'
						  ) {
							client = new window.okra.create();
							script.onreadystatechange = null;
							
						  }
						};
					  } else {
						script.onload = () => {
							client = new window.okra.create();
						};
					  }

					    /**
					    * SIMPLE OKRA MODAL
						*/
						
						var options = {
					        env: '". $settings->env ."', 
					        clientName: '". $settings->clientName ."', //TODO use this somehow with the button
					        key: '". $settings->key ."',
							token: '". $settings->token ."',
							callback_url: '". $settings->callback_url ."',
							corporate: '". $settings->corporate ."',
							source: 'wordpress',
					        options: {
								user: {
									first_name: '',
									last_name: '',
									middle_name: '', // optional
									email: '',
									bvn: '', //optional
									bank: '', //optional
									accounts: [] 
								},
							},
					        products: ". json_encode($products_array) .",
					        onClose: function() {
					            
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
					
						var btn = document.querySelector('.okra');
						btn.addEventListener('click', function(){
							console.log(options);
							client.open(options);
						});
						
					</script>
				</div>			
			
			";

			return $output;
		}
	}