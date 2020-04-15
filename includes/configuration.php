<?php
	/**
	 * MYSQL Host
	 *
	 * Is required for database access
	 *
	 * Needs to be changed every new project
	 */
	define ( 'MYSQL_HOST', 'localhost' );

	/**
	 * MYSQL USER
	 *
	 * Is required for database access
	 *
	 * Needs to be changed every new project
	 */
	define ( 'MYSQL_USER', 'root' );

	/**
	 * MYSQL PASSWORD
	 *
	 * Is required for database access
	 *
	 * Needs to be changed every new project
	 */
	define ( 'MYSQL_PASSWORD', 'root' );

	/**
	 * MYSQL DATABASE
	 *
	 * Is required for database access
	 *
	 * Needs to be changed every new project
	 */
	define ( 'MYSQL_DATABASE', 'test' );

	/**
	 *
	 * DO NOT EDIT BELOW THIS LINE
	 *
	 * ///////////////////////////////////////////////////////////////////////////////////////////////////////////
	 *
	 * Note on globals vars
	 *
	 * GENERAL: $db
	 */
	define ( 'UPLOAD_LOCATION', dirname(__DIR__).'/uploads/' );

	$db = new mysqli ( MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE );
	$db->set_charset ( 'utf8' );

	if ( $db->connect_errno ) die ('Error while connecting to database');

	if ( !isset($_SESSION) ) { session_start(); }
?>
