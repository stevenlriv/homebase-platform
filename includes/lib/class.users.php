<?php
	/**
	 * This file compiles all users actions
	 *
	 * @category   Users
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 */

	use \ParagonIE\Halite\{
		KeyFactory,
		Password,
		HiddenString
	};

	function get_user_fullname() {
		global $user;

		return $user['firstname'] .' '. $user['lastname'];
	}

	function is_admin_by_id($id) {
		$user = get_user_by_id($id);

		if( $user['type'] == "super_admin" || $user['type'] == "admin" ) {
			return true;
		}

		return false;
	}

	function is_admin() {
		global $user;

		// There is no user data
		if( empty($user)) {
			return false;
		}

		if( $user['type'] == "super_admin" || $user['type'] == "admin" ) {
			return true;
		}

		return false;
	}

	function is_login_user() {
		global $db;
		
		if( get_cookie ( 'USMP' ) && !empty(get_cookie( 'USMP' )) ) {
			$cookie = get_cookie ( 'USMP' );
			$pieces = explode('|', $cookie);

			$email = $pieces[0];
			$password_hash = $pieces[1];

			$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ? LIMIT 1" );
			$q->bind_param ( 's', $email );
			$q->execute();
			$result = $q->get_result();

			while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {
				if ( $email == $o['email'] && $password_hash == $o['password'] ) {
					return $o;
				}
			}

		}
		return false;
	}

	function logout_user() {
		if ( is_login_user() ) {
			if ( delete_cookie ( 'USMP' ) ) {
				return true;
			}
		}
		return false;
	}

	function login_user($email, $password, $remember = 'true') {
		global $db;

		// Lower case email
		$email = strtolower($email);  

		if ( !is_email($email) ) {
			return false;
		}

		$password = sanitize_xss($password);

		$expire = '';
		if ( $remember == 'true' ) {
			$expire = time()+60*60*24*45;//45 days
		}

		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ? LIMIT 1" );
		$q->bind_param ( 's', $email );
		$q->execute();
		$result = $q->get_result();

		$key = KeyFactory::importEncryptionKey(new HiddenString(PWKEY));

		while ( $o = $result->fetch_array ( MYSQLI_ASSOC ) ) {
			if ($email == $o['email'] && Password::verify(new HiddenString($password), $o['password'], $key)) {

				// We verify first that the user is active or pending email confirmation
				if($o['status'] == 'active' || $o['status'] == 'pending') {
					// Login successful, but first, check that our hash is still good (i.e. in case Halite updates)
					if (Password::needsRehash($o['password'], $key, KeyFactory::INTERACTIVE)) {
						update_user_table('password', $o['id_user'], $password);
					}

					if ( new_cookie ( 'USMP', $o['email'].'|'.$o['password'], $expire ) ) {
						return true;
					}
				}
			} 
		}
		$q->close();

		return false;
	}

	function update_status($id_user, $type) {
		global $db;

		$status = 'inactive';

		if($type == 'show' || $type == 'approve') {
			$status = 'active';
		}
		
		$q = $db->prepare ( "UPDATE xvls_users SET status = ? WHERE id_user = ?" );
		$q->bind_param ( 'si', $status, $id_user );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;
	}

	//$v_user if false we will get the user data from $user var if true, we will get the user data from view_user
	//this is used mainly for actions/admin-edit-profile.php
	function update_profile($id_user, $fullname, $phone_number, $email, $profile_bio, $profile_linkedin, $country, $driver_license, $address, $city, $state, $postal_code, $preferred_lang, $v_user = false) {
		global $db, $user;

		if($v_user) {
			global $view_user;
			$user = $view_user;
		}

		// Lower case email
		$email = strtolower($email);  

		//Verify if there is not an user with the same email, also confirm is not the same user in case that email belong to the user making the update
		if(get_user_by_email($email) && get_user_by_email($email)['id_user']!=$id_user) {
			return false;
		}

		//If an user is changing their email, lets update the user cookie
		//Do not update the cookie if is an admin makin an user update
		if( !$v_user && $user['id_user'] == $id_user && $user['email']!=$email && get_cookie ( 'USMP' ) && !empty(get_cookie( 'USMP' )) ) {
			$cookie = get_cookie ( 'USMP' );
			$pieces = explode('|', $cookie);

			$old_email = $pieces[0];
			$password_hash = $pieces[1];

			//New cookie
			$expire = time()+60*60*24*45;//45 days
			new_cookie ( 'USMP', $email.'|'.$password_hash, $expire );
		}
		
		$q = $db->prepare ( "UPDATE xvls_users SET fullname = ?, phone_number = ?, driver_license = ?, fs_address = ?, city = ?, fs_state = ?, postal_code = ?, country = ?, email = ?, profile_bio = ?, profile_linkedin = ?, preferred_lang = ? WHERE id_user = ?" );
		$q->bind_param ( 'ssssssssssssi', $fullname, $phone_number, $driver_license, $address, $city, $state, $postal_code, $country, $email, $profile_bio, $profile_linkedin, $preferred_lang, $id_user );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;
	}

	function update_bank_information($id_user, $bank_name, $bank_sole_owner, $bank_routing_number, $bank_account_number) {
		global $db;
		
		$q = $db->prepare ( "UPDATE xvls_users SET bank_name = ?, bank_sole_owner = ?, bank_routing_number = ?, bank_account_number = ? WHERE id_user = ?" );
		$q->bind_param ( 'ssssi', $bank_name, $bank_sole_owner, $bank_routing_number, $bank_account_number, $id_user );		
	
		if ( $q->execute() ) {

			// Send Email of Notification
			if(get_setting(31)=='true') {
				$emails = get_array_by_comma(get_setting(22), 'email');

				foreach($emails as $id => $value) {
					send_notification_user_bank_information($value);
				}
			}
			
			return true;
		}
		$q->close();
	
		return false;
	}

	function update_user_table($table, $id_user, $value) {
		global $db;

		if($table != 'profile_image' && $table != 'password' && $table != 'code' && $table != 'status') {
			return false;
		}

		if($table == 'code') {
			$q = $db->prepare ( "UPDATE xvls_users SET code = ? WHERE id_user = ?" );
		}
		elseif($table == 'profile_image') {
			$q = $db->prepare ( "UPDATE xvls_users SET profile_image = ? WHERE id_user = ?" );
		}
		elseif($table == 'status') {
			$q = $db->prepare ( "UPDATE xvls_users SET `status` = ? WHERE id_user = ?" );
		}
		elseif($table == 'password') {
			$key = KeyFactory::importEncryptionKey(new HiddenString(PWKEY));
			$value = Password::hash(new HiddenString($value), $key);

			$q = $db->prepare ( "UPDATE xvls_users SET password = ? WHERE id_user = ?" );
		}

		$q->bind_param ( 'si', $value, $id_user );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;		
	}

	function new_user($fullname, $email, $phone_number, $password, $country = '', $driver_license = '', $fs_address = '', $city = '', $fs_state = '', $postal_code = '', $preferred_lang = 'en_EN', $bank_name = '', $bank_sole_owner = '', $bank_routing_number = '', $bank_account_number = '') {
		global $db, $type;

		// Lower case email
		$email = strtolower($email);  

        // Verify if the email address is already in use
		if(get_user_by_email($email)) {
			return false;
		}

		//Verify Account type
        if($type != 'landlords' && $type != 'realtors' && $type != 'listers' && $type != 'tenants') {
            return false;
		}

		// We create its referral id; timestamp + random string
		$id_user_referral = generateNotSecureRandomString(10).time();

		//Password
		$key = KeyFactory::importEncryptionKey(new HiddenString(PWKEY));
		$password = Password::hash(new HiddenString($password), $key);
	
		// Account confirmation
		if(get_setting(24) == 'true') {
			$status = 'pending';
		}
		else {
			$status = 'active';
		}

		//Not in use
		$birthdate = '';
		$code = '';
		$profile_image = '';
		$profile_bio = '';
		$profile_linkedIn = '';
		$user_time_zone = '';
		$cookies_track = '';
		$firstname = '';
		$lastname = '';

		$q = $db->prepare ( "INSERT INTO xvls_users (id_user_referral, `status`, `type`, fullname, email, phone_number, birthdate, firstname, lastname, driver_license, fs_address, city, fs_state, postal_code, country, `password`, code, profile_image, profile_bio, profile_linkedIn,
													bank_name, bank_sole_owner, bank_routing_number, bank_account_number, user_time_zone, cookies_track, preferred_lang) 
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
		$q->bind_param ( 'sssssssssssssssssssssssssss', $id_user_referral, $status, $type, $fullname, $email, $phone_number, $birthdate, $firstname, $lastname, $driver_license, $fs_address, $city, $fs_state, $postal_code, $country, $password, $code, $profile_image, $profile_bio, $profile_linkedIn, $bank_name, $bank_sole_owner, $bank_routing_number, $bank_account_number, $user_time_zone, $cookies_track, $preferred_lang );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;			
	}

	function get_user_by_referral($id_user_referral) {
		global $db;
		
		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE id_user_referral = ? LIMIT 1" );
		$q->bind_param ( 's', $id_user_referral );
		$q->execute();
		$result = $q->get_result();
	
		while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {	
			return $o;
		}
		return false;
	}

	function get_user_by_email($email) {
		global $db;

		// Lower case email
		$email = strtolower($email);  
		
		if ( !is_email($email) ) {
			return false;
		}
		
		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ? LIMIT 1" );
		$q->bind_param ( 's', $email );
		$q->execute();
		$result = $q->get_result();
	
		while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {	
			if ( $o['email'] == $email ) {
				return $o;
			}		
		}
		return false;
	}

	function get_user_by_id($id) {
		global $db;
		
		if(!is_numeric($id)) {
			return false;
		}

		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE id_user = ? LIMIT 1" );
		$q->bind_param ( 'i', $id );
		$q->execute();
		$result = $q->get_result();
	
		while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {	
			return $o;
		}
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
	function get_users ($type, $query = '', $extra = '') {
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

			$q = $db->prepare ( "SELECT * FROM xvls_users $build_query $extra" );

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
			$q = $db->prepare ( "SELECT * FROM xvls_users WHERE id_user = ? LIMIT 1" );
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
