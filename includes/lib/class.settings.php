<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	/**
	 * This file compiles all settings actions
	 *
	 * @category   Settings
	 * @author     Steven Rivera <stevenlrr@gmail.com>
	 * @copyright  2018 VOS Group
	 * @license    http://creativecommons.org/licenses/by-nc-nd/4.0/
	 * @version    1.0.0
	 * @since      File available since 1.0.0
	 */
	
	function _setting($var, $specific = '') {
		echo get_setting($var, $specific);
	}

	function get_setting($var, $specific = '') {
		global $db;

		if ( $specific == true ) {
			$q = $db->prepare ( "SELECT * FROM xvls_settings WHERE id_setting = ? LIMIT 1" );
			$q->bind_param ( 'i', $var );
		}
		else {
			$q = $db->prepare ( "SELECT value FROM xvls_settings WHERE id_setting = ? LIMIT 1" );
			$q->bind_param ( 'i', $var );
		}

		$q->execute();
		$result = $q->get_result();
		$array = array();
		
		while ( $o = $result->fetch_array ( MYSQLI_ASSOC ) ) {
			if ( $specific == true ) {
				return $o;	
			}
			else {
				return $o['value'];	
			}
		}
		$q->close();
		
		return false;
	}
?>