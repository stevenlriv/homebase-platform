<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/**
	 * This file compiles all functions
	 *
	 * @category   Functions
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 */
	
	function get_google_analytics() {
		if( get_host() == "localhost" || substr_count(get_host(), '.host') > 0  ) {
			//development enviroment
			return 'n/a';
		}
		else {
			//production enviroment
			return get_setting(15);
		}
	}

	function get_maps_api_key($is_server = false) {
		if($is_server) {
			//we return the server key is unrestricted but the public does not have access to it
			return get_setting(21);
		}

		if( get_host() == "localhost" || substr_count(get_host(), '.host') > 0  ) {
			//development enviroment
			return get_setting(10);
		}
		else {
			//production enviroment
			return get_setting(11);
		}
	}

	function form_get_value($cache, $database, $field_name) {
		$content = '';
		
		if($cache) {
			$content = get_cache_value($cache['form_name'], $field_name);
		}
		else {
			if(!empty($database[$field_name])) {
				$content = $database[$field_name];
			}
		}

		return $content;	
	}

	function form_print_value($cache, $database, $field_name) {
		$content = '';
		
		if($cache) {
			$content = get_cache_value($cache['form_name'], $field_name);
		}
		else {
			if(!empty($database[$field_name])) {
				$content = $database[$field_name];
			}
		}

		echo $content;
		
	}

	function generateNotSecureRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	function is_email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } 
        return false;
	}

	function get_actual_url($array = '') {
		$url = get_domain();
	
		//$request have an extra "/" at the start
		if(!empty($array['request'])) {
			$url = $url.$array['request'];
		}
	
		return $url;
	}

	// Get the host URL (ie. return: http://domain.com)
	function get_domain() {
		$url = base_url(TRUE);
		$url = substr($url, 0, -1);

		return $url;
	}

	// Get the host URL (ie. return: domain.com)
	function get_host() {
		$url = base_url(NULL, NULL, TRUE)['host'];

		return $url;
	}

	// Clean a String (eliminate html, php tags)
	function sanitize_xss($str) {
		$text = trim($str);
		$text = strip_tags($text);
		$text = htmlspecialchars($text);
		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');

		return $text;
	}

	// Clean a TEXT or URL (return ie. this-is-an-example)
	function clean_url($str) {
		$text = $str;

		$text = preg_replace ( '~[^\\pL0-9]+~u', '-', $text );
		$text = trim ( $text, "-" );
		$text = iconv ( "utf-8", "us-ascii//TRANSLIT", $text );
		$text = strtolower ( $text );
		$text = preg_replace ( '~[^-a-z0-9]+~', '', $text );

		return $text;
	}

	/**
	 * Get the base URL
	 *
	 * base_url() will produce something like: http://domain.com/admin/users/
	 * base_url(TRUE) will produce something like: http://domain.com/
	 * base_url(TRUE, TRUE); || echo base_url(NULL, TRUE), will produce something like: http://domain.com/admin/
	 * base_url(NULL, NULL, TRUE) will produce something like:
	 *		array(3) {
	 *			["scheme"] => string(4) "http"
	 * 			["host"] => string(12) "domain.com"
	 *			["path"] => string(35) "/admin/users/"
	 *		}
	 */
    function base_url ( $atRoot = FALSE, $atCore = FALSE, $parse = FALSE ) {
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }

	/**
	 * Get a relative date (ie. Today)
	 *
	 * get_relative_time($datetime, 1); //10 hours ago
	 * get_relative_time($datetime, 2); //10 hours and 50 minutes ago
	 * get_relative_time($datetime, 3); //10 hours, 50 minutes and 50 seconds ago
	 * get_relative_time($datetime, 4); //10 hours, 50 minutes and 50 seconds ago
	 *
	 * @return: date
	 */
	function get_relative_time ($datetime, $depth = 1) {

		if(!ctype_digit($datetime)) {
			$datetime = strtotime($datetime);
		}

		$units = array(
			"year" => 31104000,
			"month" => 2592000,
			"week" => 604800,
			"day" => 86400,
			"hour" => 3600,
			"minute" => 60,
			"second" => 1
		);

		$plural = "s";
		$conjugator = ' and ';
		$separator = ", ";
		$suffix1 = ' ago';
		$suffix2 = ' left';
		$now = "now";
		$empty = "";

		$timediff = time()-$datetime;
		if ($timediff == 0) return $now;
		if ($depth < 1) return $empty;

		$max_depth = count($units);
		$remainder = abs($timediff);
		$output = "";
		$count_depth = 0;
		$fix_depth = true;

		foreach ($units as $unit=>$value) {
			if ($remainder>$value && $depth-->0) {
				if ($fix_depth) {
					$max_depth -= ++$count_depth;
					if ($depth>=$max_depth) $depth=$max_depth;
					$fix_depth = false;
				}
				$u = (int)($remainder/$value);
				$remainder %= $value;
				$pluralise = $u>1?$plural:$empty;
				$separate = $remainder==0||$depth==0?$empty:
                            ($depth==1?$conjugator:$separator);
				$output .= "{$u} {$unit}{$pluralise}{$separate}";
			}
			$count_depth++;
		}
		return $output.($timediff<0?$suffix2:$suffix1);
	}
?>
