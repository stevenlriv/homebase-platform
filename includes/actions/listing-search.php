<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	//We proccess the query details and the current search URL
	$url = '';
    $query = array();
    
    ///////////////// QUERY /////////////////
        //Location
        if(!empty($_GET['location'])) {
			$location = sanitize_xss($_GET['location']);
			$_SESSION['search-location'] = $location;
			$url = $url."location=$location&";

			//By Zipcode
			if(is_numeric($location)) {
                array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "zipcode", "command" => "=", "value" => $location));			
			}
			else {
				//Search for a city; Limit one because all we need is the first city id
				$city = get_cities('one', array( 
					0 => array("type" => "CHR", "condition" => "AND", "loose" => true, "table" => "name", "command" => "LIKE", "value" => $location),
					1 => array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "state", "command" => "LIKE", "value" => $location),
					2 => array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "country", "command" => "LIKE", "value" => $location),
				), "LIMIT 1");	

				if($city) {
                    array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_city", "command" => "=", "value" => $city['id_city']));	
				}
				else {
					//Physical Address
                    array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => true, "table" => "physical_address", "command" => "LIKE", "value" => $location));
                    
                    //Keywords
					array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "keywords", "command" => "LIKE", "value" => $location));	
					
                    //Listing Title
                    array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "listing_title", "command" => "LIKE", "value" => $location));	
				}				
			}
		}
		else {
			$_SESSION['search-location'] = ''; //to reset for fields if left empty
		}

        //Type
        if(!empty($_GET['type'])) {
            $type = sanitize_xss($_GET['type']);
			$_SESSION['search-type'] = $type;

            if($type == 'apartment' || $type == 'house') {
                $url = $url."type=$type&";

                array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "type", "command" => "=", "value" => $type));
            }
        }
		else {
			$_SESSION['search-type'] = ''; //to reset for fields if left empty
		}

        //Date
        if(!empty($_GET['date'])) {
			$date = sanitize_xss($_GET['date']);
			$_SESSION['search-date'] = $date;

			//We transform the date to unix to be able to do a search in the database
			$available = strtotime($date);

            $url = $url."date=$date&";

            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "available", "command" => "<=", "value" => $available));	
        }
		else {
			//$_SESSION['search-date'] = ''; //to reset for fields if left empty; do not reset due to user experience resons
			//If a user selected a date, just wait until the user change that date
		}

        //Bedroom
        if(!empty($_GET['bedroom'])) {
			$bedroom = sanitize_xss($_GET['bedroom']);
			$_SESSION['search-bedroom'] = $bedroom;
            $url = $url."bedroom=$bedroom&";

            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "number_rooms", "command" => "=", "value" => $bedroom));
        }
		else {
			$_SESSION['search-bedroom'] = ''; //to reset for fields if left empty
		}

        //Bathroom
        if(!empty($_GET['bathroom'])) {
			$bathroom = sanitize_xss($_GET['bathroom']);
			$_SESSION['search-bathroom'] = $bathroom;
            $url = $url."bathroom=$bathroom&";

            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "number_bathroom", "command" => "=", "value" => $bathroom));
        }
		else {
			$_SESSION['search-bathroom'] = ''; //to reset for fields if left empty
		}

        //Maxprice
        if(!empty($_GET['maxprice']) && is_numeric($_GET['maxprice'])) {
			$maxprice = sanitize_xss($_GET['maxprice']);
			$_SESSION['search-maxprice'] = $maxprice;
            $url = $url."maxprice=$maxprice&";

            array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "monthly_house", "command" => "<=", "value" => $maxprice));
        }
		else {
			$_SESSION['search-maxprice'] = ''; //to reset for fields if left empty
		}

	//This url variable is used on the class.seo.php to show the real canonical url while searching
	//This will help SEO to better index our pages
	$url_canonical = $url;
    /////////////////////////////////////////


?>