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
	 */

	use \ParagonIE\Halite\{
		KeyFactory,
		Cookie,
		HiddenString
	};

	function get_cookie($name) {
		$key = KeyFactory::importEncryptionKey(new HiddenString(CKKEY));
		$cookie = new Cookie($key);

		return $cookie->fetch($name);
	}

	function delete_cookie($name) {
		if( new_cookie($name, '', time()-3600) ) {
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
		$key = KeyFactory::importEncryptionKey(new HiddenString(CKKEY));
		$cookie = new Cookie($key);

		if ( empty($expire) ) {
			$expire = time()+60*60*24;
		}

		$path = '/';
		$domain = get_host();

		$secure = true; //SSL Required for true
		
		$http = true;
        
		if ( $cookie->store($name, $value, $expire, $path, $domain, $secure, $http) ) {
			return true;
		}
        
		return false;
	}
?>
