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
		Password
	};
	
	function check_perm_user($page = '') {
		if ( !is_login_user() ) {
			return false;
		}

		if ( empty($page) ) {
			$page = basename ($_SERVER['PHP_SELF']);
		}

		$role = is_login_user()['privilege'];

		if ( $role == 2657 ) {
			return true;
		}
		elseif ( $role == 3) {
			$access = array ( 'project', 'contact', 'service', 'apps', 'image', 'translate' );
		}
		elseif ( $role == 1) {
			$access = array ( 'project', 'contact', 'apps', 'image', 'translate' );
		}
		elseif ( $role == 2) {
			$access = array ( 'project', 'apps', 'image', 'translate' );
		}

		foreach ( $access as $name ) {
			if ( substr_count($page, $name) > 0) {
				return true;
			}
		}

		return false;
	}

	function is_login_user() {
		global $db;
		//$crypt = new CryptoLib();

		if( get_cookie ( 'VOS_USREM' ) && get_cookie ( 'VOS_USRS' ) ) {
			$email = get_cookie ( 'VOS_USREM' );

			$q = $db->prepare ( "SELECT * FROM vos_gen_users WHERE email = ?" );
			$q->bind_param ( 's', $email );
			$q->execute();
			$result = $q->get_result();

			while ( $o = $result->fetch_array(MYSQLI_ASSOC) ) {
				if ( get_cookie ( 'VOS_USREM' ) == $o['email'] && get_cookie ( 'VOS_USRS' ) == $o['password'] ) {
					return $o;
				}
			}
			$q->close();
		}
		return false;
	}

	function logout_user() {
		if ( is_login_user() ) {
			if ( delete_cookie ( 'VOS_USREM' ) && delete_cookie ( 'VOS_USRS' ) ) {
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

		$q = $db->prepare ( "SELECT * FROM xvls_users WHERE email = ?" );
		$q->bind_param ( 's', $email );
		$q->execute();
		$result = $q->get_result();

		while ( $o = $result->fetch_array ( MYSQLI_ASSOC ) ) {
			//if ( $email == $o['email'] && $crypt->validateHash($o['password'], $password) && $o['status'] == 'PUBLISHED' ) {
              if ( $email == $o['email'] && md5($password) === $o['password'] && $o['status'] == 'active' ) {
				if ( new_cookie ( 'USRM', $o['email'], $expire ) && new_cookie ( 'USRP', $o['password'], $expire ) ) {
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
			$q = $db->prepare ( "SELECT * FROM vos_gen_users $specific" );
		}
		elseif ( is_email ($var) ) {
			$q = $db->prepare ( "SELECT * FROM vos_gen_users WHERE email = ?" );
			$q->bind_param ( 's', $var );
		}
		elseif( is_numeric ($var) ) {
			$q = $db->prepare ( "SELECT * FROM vos_gen_users WHERE id_user = ?" );
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
