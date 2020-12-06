<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	//We proccess the query details and the current search URL
	$url = '';
    $query = array();
    
    ///////////////// QUERY /////////////////
        //Location
        if(!empty($_GET['user-query'])) {
			$location = sanitize_xss($_GET['user-query']);
			$_SESSION['user-query'] = $location;
			$url = $url."user-query=$location&";

			//Fullname
			array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "fullname", "command" => "LIKE", "value" => $location));
					
			//Email
			array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "email", "command" => "LIKE", "value" => $location));

			//Phone Number
			array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "phone_number", "command" => "LIKE", "value" => $location));

			//Country
			array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "country", "command" => "LIKE", "value" => $location));
			
			//State
			array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "fs_state", "command" => "LIKE", "value" => $location));
                    			
		}
		else {
			$_SESSION['user-query'] = ''; //to reset for fields if left empty
		}
?>