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
         * @ https://github.com/paragonie/halite/tree/master/doc
         * @ https://github.com/paragonie/halite/blob/master/doc/Basic.md
         */
        define( 'CKKEY', '314004002e3d950d25195f71b2a420891326c63459c0518208059a86ce27436d19b96be96726e07ae2b18a012c973081a56d8069298c94bd6e8bce275e84458fc228d5f93bc17cd171e6c8c808f3922fb2b2eb618177415e9a78891cedd2256d53d09927' );
        define( 'PWKEY', '31400400b76380d53f88477ded3743f9c558223948ebe1527aefe6b3bc26a3246ec6155a0908a15ac92bc54fd56091a61916c68b59ed5834bb85844231c1987359afb4068ba6435cecc2fe322788f1e5b4cc2a158f3fe0ab8ef95641bf6da96895b1d584' );
        define( 'GNKEY', '314004006c8aade1e827efc8339adc94e743868727390d813ae6454b03d22b90d151e33263bf4a5ad182f6cc12442638e3b6c8ea145d86f7949c113acb5dbb2727cc9837bde07efd88aa0b4e0b3c5ef30f6057b4148956624b692e0c13d20a32ff8a6eaf' );
    
        if( !defined('CKKEY') || !defined('PWKEY') || !defined('GNKEY') ) {
            /**
             *  The script below will help you generate a key and save it to its location
             * 
             *  require_once ( 'vendor/autoload.php' );
             * 
             * 	use \ParagonIE\Halite\KeyFactory;
             *  $encryptionKey = KeyFactory::generateEncryptionKey();
             *	$key_hex = KeyFactory::export($encryptionKey)->getString();
             *
             *  TO USE THE KEYS THE FOLLOWING FUNCTION WILL HELP YOU
             *  $enc_key = KeyFactory::importEncryptionKey(new HiddenString($key_hex));
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