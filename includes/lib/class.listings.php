<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/**
	 * This file compiles all Personal Management actions
	 *
	 * @category   Personal Management
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 */

	// Examples
		// 43 -> 50
		// 56.4 -> 60
	function round_homebase_fee($house_price, $percentage = 0.10) {
		$price = $house_price * $percentage;

		//If ends on 5 and up it will always round up
		//In the case that is below 4 we will just add 5 to be able to round it up
			//We split the decimals from inter to verifi and add up more
			if(substr_count($price, '.') >= 0) {
				//Lets get the last number and 
				$pieces = explode('.', $price); //int = [0], decimals = [1]

				// Lets get the last number
				$lastint = substr($pieces[0], -1);

				// If is below 5, we add 5 so we can round the number up and don't loose money on the deal
				if($lastint<5) {
					$price = $price + 5;
				}
			}
		$price = round($price, -1);
		//echo $price."----------";
		return $price;
	}

	function is_on_listing_creation_page() {
		global $user, $request;

		if($request == '/submit-property' && $user || $request == '/edit-property' && $user ) {
			return true;
		}

		return false;
	}

	function user_has_access_listing($listing) {
		global $user;

		$user = is_login_user();

		//We will only give access to a listing if the user is an 'super_admin' an 'admin' or the owner of the listing
        if($listing['id_user']==$user['id_user'] || $listing['id_user']!=$user['id_user'] && $user['type']=='super_admin' || $listing['id_user']!=$user['id_user'] && $user['type']=='admin') {
            return true;
		}
		
		return false;
	}

	function print_available_message($type, $available_date) {
		if($available_date > strtotime(date("m/d/Y"))) {
			if($type == 'admin')
				echo "<a href='#lease-link'>until ".date("m/d/Y", $available_date)."</a>";
			elseif($type == 'date')
				echo "on ".date("m/d/Y", $available_date);
			elseif($type == 'status')
				echo "Disponible pronto";
			elseif($type == 'label')
				echo '<span style="background: red;">Alquilada</span>';
			elseif($type == 'blue-label')
				echo '<span class="property-badge" style="background: red;">Alquilada</span>';
		}
		else {
			if($type == 'admin')
				echo "none";
			elseif($type == 'date')
				echo "Hoy";
			elseif($type == 'status')
				echo "Disponible Ahora";
			elseif($type == 'label')
				echo "<span>En Alquiler</span>";	
			elseif($type == 'blue-label')
				echo '<span class="property-badge">En Alquiler</span>';		
		}
	}

	function get_unique_uri($array, $only_verify = false) {

		//Basic uri
		$uri = clean_url($array['title']);
		$uri_city = clean_url($array['city']);
		$uri_state = clean_url($array['state']);
		$uri_country = clean_url($array['country']);

		//If basic uri exists, just combine uri + city name
		if(is_uri($uri, true)) {
			$uri = $uri_city.'-'.$uri;
			$uri = clean_url($uri); //new uri city-title
		}
		
			//If it also exists with the city add the state
			if(is_uri($uri, true)) {
				$uri = $uri_state.'-'.$uri;
				$uri = clean_url($uri); //new uri state-city-title
			}

				//If it also exists with the state add the country
				if(is_uri($uri, true)) {
					$uri = $uri_country.'-'.$uri;
					$uri = clean_url($uri); //new uri country-state-city-title
				}

		// Verify if the url already exists; do not return the uri
		if($only_verify) {
			if(is_uri($uri, true)) {
				return true;
			}

			return false;
		}

		// Return the url uri
		return $uri;
	}

	function is_uri($uri, $by_uri_id = false) {
		$uri = clean_url($uri);

		if($by_uri_id) {
			//When we search by uri id, the listing does not have to be active
			$query = get_listings('one', array( 
				0 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "uri", "command" => "=", "value" => $uri) 
			), "LIMIT 1");	
		}
		else {
			//Property needs to be active when searching if an uri exists
			$query = get_listings('one', array( 
				0 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"),
				1 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "uri", "command" => "=", "value" => $uri) 
			), "LIMIT 1");	
		}

		if($query) {
			return $query;
		}
		return false;
	}

	function get_json ($string, $position) {
		$array = json_decode($string, true);

		if($position === 'all') {
			return $array;
		}
		
		if(is_array($array))
			return $array[$position];
	}


	function update_views($uri) {
		global $db;

		//We only count +1 per 24h per listing 
		if ( !empty($_SESSION['LTVWS']) && substr_count($_SESSION['LTVWS'], $uri) > 0 ) {
			return;
		}

		if(!empty($_SESSION['LTVWS'])) {
			$_SESSION['LTVWS'] = $_SESSION['LTVWS']."-".$uri;
		}
		else {
			$_SESSION['LTVWS'] = $uri;
		}
		
		
		$q = $db->prepare ( "UPDATE xvls_listings SET views_count = views_count + 1 WHERE uri = ?" );
		$q->bind_param ( 's', $uri );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;
	}

	function update_visibilty($id_listing, $type) {
		global $db;

		$status = 'inactive';

		if($type == 'show' || $type == 'approve') {
			$status = 'active';
		}
		
		$q = $db->prepare ( "UPDATE xvls_listings SET status = ? WHERE id_listing = ?" );
		$q->bind_param ( 'si', $status, $id_listing );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;
	}

	function delete_listing($id_listing) {
		global $db;

		$q = $db->prepare ( "DELETE FROM xvls_listings WHERE id_listing = ?" );
		$q->bind_param ( 'i', $id_listing );

		if ( $q->execute() ) {
			return true;
		}

		return false;
	}

	function update_listing ( $id_listing, $type, $available, $zipcode, $keywords, $monthly_house, $monthly_per_room, $deposit_house, $deposit_per_room, $number_rooms,
						$number_bathroom, $square_feet, $physical_address, $postal_address, $latitude, $longitude, $listing_title, $listing_description, $listing_images, $video_tour,
						$calendly_link, $checkin_images, $checkin_description, $air_conditioning, $electricity, $furnished, $parking, $pets, $smoking, $water, $wifi, 
						$laundry_room, $gym, $alarm, $swimming_pool, $checkin_access_code, $country, $state, $city) {
		global $db;

		//URI CANT BE CHANGED AFTER IT IS CREATED
		$available = strtotime($available);

		//Trim keywords
		$keywords = trim($keywords);

		//Original Rent Cost
		$original_rent_cost = $monthly_house;
		$deposit_house_original = $deposit_house;

        //We change the listing pricing using our current business model of 10% mark up
        //Also on the footer.php there is some js code to let the lister know how much is going to be listed at Homebase
		//No decimals numbers use round()
		$percentage_markup = get_setting(26); //homabase cut
		$monthly_house = round($monthly_house + round_homebase_fee($monthly_house, $percentage_markup));
		$deposit_house = round($deposit_house + round_homebase_fee($deposit_house, $percentage_markup));
		
		$q = $db->prepare ( "UPDATE xvls_listings SET `type` = ?, available = ?, country = ?, `state` = ?, city = ?, zipcode = ?, keywords = ?, monthly_house = ?, monthly_house_original = ?, monthly_per_room = ?, deposit_house = ?, deposit_house_original = ?, deposit_per_room = ?, number_rooms = ?,
											number_bathroom = ?, square_feet = ?, physical_address = ?, postal_address = ?, latitude = ?, longitude = ?, listing_title = ?, listing_description = ?, listing_images = ?, video_tour = ?,
											calendly_link = ?, checkin_access_code = ?, checkin_images = ?, checkin_description = ?, air_conditioning = ?, electricity = ?, furnished = ?, parking = ?, pets = ?, smoking = ?, water = ?, wifi = ?,
											laundry_room = ?, gym = ?, alarm = ?, swimming_pool = ? WHERE id_listing = ?" );
									
		$q->bind_param ( 'ssssssssssssssssssssssssssssssssssssssssi', $type, $available, $country, $state, $city, $zipcode, $keywords, $monthly_house, $original_rent_cost, $monthly_per_room, $deposit_house, $deposit_house_original, $deposit_per_room, $number_rooms,
										$number_bathroom, $square_feet, $physical_address, $postal_address, $latitude, $longitude, $listing_title, $listing_description, $listing_images, $video_tour,
										$calendly_link, $checkin_access_code, $checkin_images, $checkin_description, $air_conditioning, $electricity, $furnished, $parking, $pets, $smoking, $water, $wifi,
										$laundry_room, $gym, $alarm, $swimming_pool, $id_listing);

		if ( $q->execute() ) {
			return true;
		}
		//echo $q->error;
		$q->close();

		return false;
	}

	function new_listing ( $type, $available, $zipcode, $keywords, $monthly_house, $monthly_per_room, $deposit_house, $deposit_per_room, $number_rooms,
						$number_bathroom, $square_feet, $physical_address, $postal_address, $latitude, $longitude, $listing_title, $listing_description, $listing_images, $video_tour,
						$calendly_link, $checkin_images, $checkin_description, $air_conditioning, $electricity, $furnished, $parking, $pets, $smoking, $water, $wifi, 
						$laundry_room, $gym, $alarm, $swimming_pool, $checkin_access_code, $country, $state, $city) {
		global $db;

		// Listing status on publish
		// Admins will need to approve it
		$status = 'pending';

		// Change date to time stamp to be able to compare
		$available = strtotime($available);

		$id_user = is_login_user()['id_user'];

		$uri = get_unique_uri(array( 'title' => $listing_title, 'city' => $city, 'state' => $state, 'country' => $country));

		//Trim keywords
		$keywords = trim($keywords);

		//Original Rent Cost
		$original_rent_cost = $monthly_house;
		$deposit_house_original = $deposit_house;

        //We change the listing pricing using our current business model of 10% mark up
        //Also on the footer.php there is some js code to let the lister know how much is going to be listed at Homebase
		//No decimals numbers use round()
		$percentage_markup = get_setting(26); //homabase cut
		$monthly_house = round($monthly_house + round_homebase_fee($monthly_house, $percentage_markup));
		$deposit_house = round($deposit_house + round_homebase_fee($deposit_house, $percentage_markup));

		$q = $db->prepare ( "INSERT INTO xvls_listings (id_user, `status`, `type`, available, country, `state`, city, zipcode, uri, keywords, monthly_house, monthly_house_original, monthly_per_room, deposit_house, deposit_house_original, deposit_per_room, number_rooms,
											number_bathroom, square_feet, physical_address, postal_address, latitude, longitude, listing_title, listing_description, listing_images, video_tour,
											calendly_link, checkin_access_code, checkin_images, checkin_description, air_conditioning, electricity, furnished, parking, pets, smoking, water, wifi,
											laundry_room, gym, alarm, swimming_pool)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
									
		$q->bind_param ( 'issssssssssssssssssssssssssssssssssssssssss', $id_user, $status, $type, $available, $country, $state, $city, $zipcode, $uri, $keywords, $monthly_house, $original_rent_cost, $monthly_per_room, $deposit_house, $deposit_house_original, $deposit_per_room, $number_rooms,
										$number_bathroom, $square_feet, $physical_address, $postal_address, $latitude, $longitude, $listing_title, $listing_description, $listing_images, $video_tour,
										$calendly_link, $checkin_access_code, $checkin_images, $checkin_description, $air_conditioning, $electricity, $furnished, $parking, $pets, $smoking, $water, $wifi,
										$laundry_room, $gym, $alarm, $swimming_pool);

		if ( $q->execute() ) {
			// Send Email of Approval
			$emails = get_array_by_comma(get_setting(22), 'email');

			foreach($emails as $id => $value) {
				send_pending_listing_email($value);
			}

			return true;
		}
		//echo $q->error;
		$q->close();

		return false;
	}

	/***
	 * Safe SQL Query Explanations
	 * 
	 * $type values are 'all' to get an array of all result and 'count' to renturn a query count, 'one' for return the single result
	 * $extra is for extra sql that does not need to be validated, for example 'LIMIT 1'
	 * $query which could be a value or an array
	 * 		The query array is based on
	 * 			- 'type' to know if is an integer or character; 'INT' or 'CHR
	 * 			- 'condition' which can be sql AND, OR, IN, NOT IN	
	 * 			- 'loose' whis is used to add '%value%' to create a loose match in sql
	 * 			- 'table' which its the database table to be queried
	 * 			- 'command' which its the type of query like '=' or 'LIKE'
	 * 			- 'value' which its the value to be searched
	 */
	function get_listings ($type, $query = '', $extra = '') {
		global $db;

		if(is_array($query)) {
			$bind_param_type = '';
			$bind_param_values = array();
			$build_query = '';

			foreach ( $query  as $id => $value ) {
				//If is the first one, we dont use the condition, instead we use "WHERE"
				if($id == 0) {
					$build_query = $build_query."WHERE {$value['table']} {$value['command']} ?";
				}
				else {
					$build_query = $build_query." {$value['condition']} {$value['table']} {$value['command']} ?";
				}

				//We get the bind_param character type
				if($value['type'] == 'INT') {
					$bind_param_type = $bind_param_type . "i";
				}
				else {
					$bind_param_type = $bind_param_type . "s";
				}

				//We get the variable
				if($value['loose']) {
					$value['value'] = "%{$value['value']}%";
				}
				array_push($bind_param_values, $value['value']);
			}

			$q = $db->prepare ( "SELECT * FROM xvls_listings $build_query $extra" );

			//Now using count we will select the corrent bin param
			//Remmeber that arrays start at "0"
			$array_count = count($bind_param_values);
			
			if($array_count == 1) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0] );	
			}
			elseif($array_count == 2) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1] );
			}
			elseif($array_count == 3) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2] );
			}
			elseif($array_count == 4) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3] );
			}
			elseif($array_count == 5) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4] );
			}
			elseif($array_count == 6) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5] );
			}
			elseif($array_count == 7) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5], $bind_param_values[6] );
			}
			elseif($array_count == 8) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5], $bind_param_values[6], $bind_param_values[7] );
			}
			elseif($array_count == 9) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5], $bind_param_values[6], $bind_param_values[7], $bind_param_values[8] );
			}
			elseif($array_count == 10) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5], $bind_param_values[6], $bind_param_values[7], $bind_param_values[8], $bind_param_values[9]  );
			}
			elseif($array_count == 11) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5], $bind_param_values[6], $bind_param_values[7], $bind_param_values[8], $bind_param_values[9], $bind_param_values[10]  );
			}
			elseif($array_count == 12) {
				$q->bind_param ( $bind_param_type, $bind_param_values[0], $bind_param_values[1], $bind_param_values[2], $bind_param_values[3], $bind_param_values[4], $bind_param_values[5], $bind_param_values[6], $bind_param_values[7], $bind_param_values[8], $bind_param_values[9], $bind_param_values[10], $bind_param_values[11]  );
			}
			elseif($array_count > 12) {
				die('MORE THAN 12 QUERY');
			}
		}
		else {
			$q = $db->prepare ( "SELECT * FROM xvls_listings WHERE id_listing = ? LIMIT 1" );
			$q->bind_param ( 'i', $query );			
		}

		$q->execute();
		$result = $q->get_result();
		$array = array();

		if ( $type == 'count' ) {
			return $result->num_rows;
		}

		while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {
			if ( $type == 'all' ) {
				array_push($array, $o);
			}
			else {
				return $o;
			}
		}
		$q->close();

		if ( $type == 'all' ) {
			return $array;
		}

		return false;
	}
?>
