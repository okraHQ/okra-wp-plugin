<?php

	function okra_modal_shortcode( $attr ){

		if(!empty($attr['id'])){

			global $wpdb;
			$modal = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."okra_all_forms` WHERE id={$attr['id']}");
		

			if(sizeof($modal) === 0){
				return "No modal created";
			}

			$modal = array_shift($modal);


			$theme_css = substr(plugins_url(dirname(PLUGIN_URI)), 0, strlen(plugins_url(dirname(PLUGIN_URI)))-1);

			$output = "
				
				<div id='okra-enabled'>

										
					<button class='okra'>". $attr["btn-text"] ."</button>
						
					 <script type='text/javascript'>
					 const script = document.createElement('script');
					 script.src = 'https://cdn.okra.ng/v2/bundle.js';
					 document.getElementsByTagName('head')[0].appendChild(script);	
					
						var btn = document.querySelector('.okra');
						btn.addEventListener('click', function(){
							Okra.buildWithShortUrl({
								short_url: '". $modal->short_code ."', //Your short url from the link builder
								onSuccess: function(data){
								},
								onClose: function(){
								}
							})
						});
						
					</script>
				</div>			
			
			";

			return $output;
		}
	}