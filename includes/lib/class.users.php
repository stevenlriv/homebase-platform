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
	 * 
	 */

	use \ParagonIE\Halite\{
		KeyFactory,
		Password,
		HiddenString
	};
	
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
					update_password($o['id_user'], $password);
				}

				if ( new_cookie ( 'USMP', $o['email'].'|'.$o['password'], $expire ) ) {
					return true;
				}
			} 
		}
		$q->close();

		return false;
	}

	function update_code($id_user, $code) {
		global $db;
		
		$q = $db->prepare ( "UPDATE xvls_users SET code = ? WHERE id_user = ?" );
		$q->bind_param ( 'si', $code, $id_user );		
	
		if ( $q->execute() ) {
			return true;
		}
		$q->close();
	
		return false;
	}

	function update_password($id_user, $password) {
		global $db;

		$key = KeyFactory::importEncryptionKey(new HiddenString(PWKEY));
		$new_password = Password::hash(new HiddenString($password), $key);
		
		$q = $db->prepare ( "UPDATE xvls_users SET password = ? WHERE id_user = ?" );
		$q->bind_param ( 'si', $new_password, $id_user );		
	
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
		
		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ?" );
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

	function get_user($var, $specific = '') {
		global $db;

		if ( $var == 'all' or $var == 'count' ) {
			$q = $db->prepare ( "SELECT * FROM xvls_users $specific" );
		}
		elseif ( is_email ($var) ) {
			$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ? LIMIT 1" );
			$q->bind_param ( 's', $var );
		}
		elseif( is_numeric ($var) ) {
			$q = $db->prepare ( "SELECT * FROM xvls_users WHERE id_user = ? LIMIT 1" );
			$q->bind_param ( 'i', $var );
		}

		$q->execute();
		$result = $q->get_result();
		$array = array();

		if ( $var == 'count' ) {
			return $result->num_rows;
		}

		while ( $o = $result->fetch_array ( MYSQLI_ASSOC ) ) {
			if ( $var == 'all' ) {
				array_push($array, $o);
			}
			else {
				return $o;
			}
		}
		$q->close();

		if ( $var == 'all' ) {
			return $array;
		}

		return false;
	}
?>
