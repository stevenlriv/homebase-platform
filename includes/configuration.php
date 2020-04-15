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

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// DO NOT EDIT BELOW THIS LINE
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * MYSQL Connection
	 */
	$db = new mysqli ( MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE );
	$db->set_charset ( 'utf8' );

	if ( $db->connect_errno ) { 
		die ('Error while connecting to database');
	}

	/**
	 * We verify if crypto keys exists, if not they will need to be generated
	 * 
	 * The code to generating keys is commented out, in case for an error a key is 
	 * replaced, this will invalidate any data encrypted with that key. You will need to 
	 * include the vendor folder in order for the library Halite to be access.
	 * 
	 * Change the keys directory with every single installation
	 * 
	 * Help
	 * @ https://paragonie.com/blog/2016/05/solve-all-your-cryptography-problems-in-three-easy-steps-with-halite
	 * @ https://paragonie.com/blog/2015/05/using-encryption-and-authentication-correctly
	 */
	define( 'CKKEY', 'includes/lib/key-pkjhgfde/encryption56-cs.key' );
	define( 'PWKEY', 'includes/lib/key-pkjhgfde/encryption59-pw.key' );

	if( !is_file(CKKEY) || !is_file(PWKEY) ) {
		/**
		 * 	use \ParagonIE\Halite\KeyFactory;
		 *	$encryptionKey = KeyFactory::generateEncryptionKey();
		 *	KeyFactory::save($encryptionKey, '/path/to/encryption.key');
		 */
		die ('Keys are missing, generate them before continuing');
	}

	/**
	 * Lets start the php sessions
	 */
	if ( !isset($_SESSION) ) { session_start(); }

	/**
	 * Lets define the basic upload location
	 */
	define ( 'UPLOAD_LOCATION', dirname(__DIR__).'/uploads/' );
?>
