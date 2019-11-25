<?php

	function okra_get_navbar($active){

		global $submenu;
		$submenu_list = $submenu["okra_wordpress_plugin"];
		$output = "";

		for($i=0;$i<sizeof($submenu_list);$i++){
            if( $i==0 ){
                $output .= "<li class='nav-item shift-10 mx-4'>
                                        	<a class='nav-link text-secondary' href='".admin_url()."admin.php?page=".$submenu_list[$i][2]."'>All Forms</a>
                                    		<span class='".$active[$i]."'></span>
                                    	</li>";
            }else {
                $output .= "<li class='nav-item shift-10 mx-4'>
                                        	<a class='nav-link text-secondary' href='".admin_url()."admin.php?page=".$submenu_list[$i][2]."'>{$submenu_list[$i][0]}</a>
                                    		<span class='".$active[$i]."'></span>
                                    	</li>";
            }


		}
		return $output;
	}

	function okra_display_option( $array, $properties, $value, $selected ){
		$output = '';
		if( is_array($array) ){
			foreach ( $array as $single ){

				if( $single->$value == $selected ){
					$output .= "<option value='".$single->$value."' selected >{$single->$properties}</option>";
				}else{
					$output .= "<option value='".$single->$value."'>{$single->$properties}</option>";
				}
			}
		}else{
			$output .= "<option>No any option</option>";
		}
		return $output;
	}

	function okra_display_checkbox( $array, $name, $class, $property, $value, $checked_values_array = null, $disabled_values_array = null ){

		$output = '';
		$disabled = '';
		if(is_array($checked_values_array)){

			$i=0;

			if( is_array($array) ){
				$count = 1;
				$ml = '';
				foreach ($array as $single){

					$checked = '';


					if($count !== 1){
						$ml = 'ml-3';
					}


					if(isset($array[$i])){
						if(isset($checked_values_array[$i])) {
							if($checked_values_array[$i] == $single->$value){
								$checked = 'checked';
								$i++;
							}

						}
					}

					if(is_array($disabled_values_array)){
						if(in_array($single->$value, $disabled_values_array)){
							$disabled = "disabled";
						}else{
							$disabled = "";
						}
					}

					$output .= "
						<div class='". $class ."'>
							<label for='". $name . "". $count ."' class='form-check-label'>
								<input id='". $name . "". $count ."' type='checkbox' class='form-check-input ". $ml ."' name='". $name ."[]' value='{$single->$value}' ". $checked ." ". $disabled ." />
								{$single->$property}
							</label>
						</div>
					";
					$count++;
				}
			}else{
				$output .= "<p>No categories entered yet.</p>";
			}

		}else{
			if( is_array($array) ){
				$count = 1;
				$ml = '';
				$checked = '';
				foreach ($array as $single){

					if($count !== 1){
						$ml = 'ml-3';
					}

					if(is_array($disabled_values_array)){
						if(in_array($single->$value, $disabled_values_array)){
							$disabled = "disabled";
						}else{
							$disabled = "";
						}
					}
					$output .= "
						<div class='".$class."'>
						<label for='". $name . "". $count ."' class='form-check-label'>
							<input id='". $name . "". $count ."' type='checkbox' class='form-check-input ". $ml ."' name='". $name ."[]' value='{$single->$value}' ". $checked ." ". $disabled ." />
							{$single->$property}
						</label>
						</div>
					";
					$count++;
				}
			}else{
				$output .= "<p>No categories entered yet.</p>";
			}
		}

		return $output;
	}

	function okra_display_alert_msg( $value, $class ){

		$output = '';

		$output .= '
						<div class="alert '.$class.'  alert-dismissible fade show">
		                    <button type="button" class="close" data-dismiss="alert">&times;</button>
		                    '. $value .'
		                </div>
					';

		return $output;

	}

	function okra_quote_pattern($text){
		$text = str_replace('"', "<quote>", $text);
		return str_replace("'", "<quote>", $text);
	}

	function okra_generate_integration_json($integrations){

		$output = "integrations: [{<br/>";

		$count = 0;
		
		foreach($integrations as $item){

			$output .= "&nbsp;". $item->company . ": {<br/>";
			$output .= "&nbsp;&nbsp;dev_api_key: " . '"'.$item->dev_api_key.'"' . ",<br/>";
			$output .= "&nbsp;&nbsp;live_api_key: " . '"'.$item->live_api_key.'"' . ",<br/>";
			$output .= "&nbsp;&nbsp;env: " . '"'. $item->env .'"' . "<br/>}";
			
			if($count < sizeof($integrations)-1){
				$output .= ",<br />";
			}

			$count++;
		}

		$output .= "}]";
		
		return $output;

	}

