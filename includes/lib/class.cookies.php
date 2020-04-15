<?php
	/**
	 * This file compiles all cookies actions
	 *
	 * @category   Cookies
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 * 
	 * @resource https://paragonie.com/blog/2015/05/using-encryption-and-authentication-correctly
	 * @resource https://paragonie.com/blog/2016/05/solve-all-your-cryptography-problems-in-three-easy-steps-with-halite
	 */

	use \ParagonIE\Halite\{
		KeyFactory,
		Cookie
	};

	function get_cookie($name) {
		$cookieStorage = new Cookie(COOK_KEY);
		return $cookieStorage->fetch($name);
	}

	function delete_cookie($name) {
		if( new_cookie($name, 'pokls') ) {
			return true;
		}
		return false;
	}

	/**
	 * Create a Cookie
	 *
	 * Notes:
	 *   $expire - Expiration date (24 hours from now by default; time()+60*60*24*7 for 7 days)
	 *   $path - Path to be used on ('/' is global)
	 *   $domain - Domain of the cookie to be used on (blank for actual)
	 *   $secure - If true only create cookies on HTTPS request
	 *   $http - If true disable cookie use via JavaScript
	 *
	 * @return: true or false
	 */
	function new_cookie($name, $value, $expire = '') {

		$cookieStorage = new Cookie(COOK_KEY);

		if ( empty($expire) ) {
			$expire = time()+60*60*24;
		}

		$path = '/';
		$domain = get_host();

		if( substr_count(get_domain(), "localhost") ) {
			$secure = false; //localhost mostly works whithout ssl
		}
		else {
			$secure = true; //SSL Required for true
		}
		
		$http = true;
        
		if ( $cookieStorage->store($name, $value, $expire, $path, $domain, $secure, $http) ) {
			return true;
		}
        
		return false;
	}
?>
