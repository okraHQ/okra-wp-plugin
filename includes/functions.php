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


