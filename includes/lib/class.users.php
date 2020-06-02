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

	function is_admin() {
		global $user;

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
			if ($email == $o['email'] && Password::verify(new HiddenString($password), $o['password'], $key) && $o['status'] == 'active') {

				// Login successful, but first, check that our hash is still good (i.e. in case Halite updates)
				if (Password::needsRehash($o['password'], $key, KeyFactory::INTERACTIVE)) {
					update_user_table('password', $o['id_user'], $password);
				}

				if ( new_cookie ( 'USMP', $o['email'].'|'.$o['password'], $expire ) ) {
					return true;
				}
			} 
		}
		$q->close();

		return false;
	}

	function update_profile($id_user, $fullname, $phone_number, $email, $profile_bio, $profile_linkedin, $country) {
		global $db;

		//Verify if there is not an user with the same email, also confirm is not the same user in case that email belong to the user making the update
		if(get_user_by_email($email) && get_user_by_email($email)['id_user']!=$id_user) {
			return false;
		}
		
		$q = $db->prepare ( "UPDATE xvls_users SET fullname = ?, phone_number = ?, country = ?, email = ?, profile_bio = ?, profile_linkedin = ? WHERE id_user = ?" );
		$q->bind_param ( 'ssssssi', $fullname, $phone_number, $country, $email, $profile_bio, $profile_linkedin, $id_user );		
	
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
			return true;
		}
		$q->close();
	
		return false;
	}

	function update_user_table($table, $id_user, $value) {
		global $db;

		if($table != 'profile_image' && $table != 'password' && $table != 'code') {
			return false;
		}

		if($table == 'code') {
			$q = $db->prepare ( "UPDATE xvls_users SET code = ? WHERE id_user = ?" );
		}
		elseif($table == 'profile_image') {
			$q = $db->prepare ( "UPDATE xvls_users SET profile_image = ? WHERE id_user = ?" );
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

	function new_user($fullname, $email, $phone_number, $password) {
		global $db, $type;

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

		//Not in use
		$birthdate = '';
		$country = '';
		$code = '';
		$profile_image = '';
		$profile_bio = '';
		$profile_linkedIn = '';
		$bank_name = '';
		$bank_sole_owner = '';
		$bank_routing_number = '';
		$bank_account_number = '';
		$user_time_zone = '';
		$cookies_track = '';

		$q = $db->prepare ( "INSERT INTO xvls_users (id_user_referral, `type`, fullname, email, phone_number, birthdate, country, `password`, code, profile_image, profile_bio, profile_linkedIn,
													bank_name, bank_sole_owner, bank_routing_number, bank_account_number, user_time_zone, cookies_track) 
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
		$q->bind_param ( 'ssssssssssssssssss', $id_user_referral, $type, $fullname, $email, $phone_number, $birthdate, $country, $password, $code, $profile_image, $profile_bio, $profile_linkedIn, $bank_name, $bank_sole_owner, $bank_routing_number, $bank_account_number, $user_time_zone, $cookies_track );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;			
	}

	function get_user_by_email($email) {
		global $db;

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
?>
