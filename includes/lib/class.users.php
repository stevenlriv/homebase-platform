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
	 * @resource https://paragonie.com/blog/2016/05/solve-all-your-cryptography-problems-in-three-easy-steps-with-halite
	 */

	use \ParagonIE\Halite\{
		KeyFactory,
		Password
	};

	function is_login_user() {
		global $db;

		if( get_cookie ( 'USM' ) && get_cookie ( 'USP' ) ) {
			$email = get_cookie ( 'USM' );

			$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ? LIMIT 1" );
			$q->bind_param ( 's', $email );
			$q->execute();
			$result = $q->get_result();

			while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {
				if ( get_cookie ( 'USM' ) == $o['email'] && get_cookie ( 'USP' ) == $o['password'] ) {
					return $o;
				}
			}

		}
		return false;
	}

	function logout_user() {
		if ( is_login_user() ) {
			if ( delete_cookie ( 'USM' ) && delete_cookie ( 'USP' ) ) {
				return true;
			}
		}
		return false;
	}

	function login_user($email, $password, $remember = '') {
		global $db;

		if ( !is_email($email) ) {
			return false;
		}

		$expire = '';
		if ( $remember == 'true' ) {
			$expire = time()+60*60*24*45;//45 days
		}

		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ? LIMIT 1" );
		$q->bind_param ( 's', $email );
		$q->execute();
		$result = $q->get_result();

		$key = KeyFactory::loadEncryptionKey('includes/lib/key-pkjhgfde/encryption59-pw.key');

		while ( $o = $result->fetch_array ( MYSQLI_ASSOC ) ) {
			if ($email == $o['email'] && Password::verify($password, $o['password'], $key) && $o['status'] == 'active') {

				/*
				// Login successful, but first, check that our hash is still good (i.e. in case Halite updates):
				if (Password::needsRehash($hash, $key, KeyFactory::INTERACTIVE)) {
					$replaceStoredHash = Password::hash($password, $key);
				}
				*/
				if ( new_cookie ( 'USM', $o['email'], $expire ) && new_cookie ( 'USP', $o['password'], $expire ) ) {
					return true;
				}
			} 
		}
		$q->close();

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
