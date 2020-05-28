<?php

    ///////////////////////////////////////////////////////////////////////////
    //
    // INSTALLER
    //
    ///////////////////////////////////////////////////////////////////////////

    // Verify if configuration file already exists
    if(is_file('configuration.php')) {
      die( header('Location: /not-found') );
    }
  
    define('SCRIP_LOAD', true);
    require_once('lib/class.functions.php');

    if(!is_file('../vendor/autoload.php')) {
        die( 'Please install dependencies with composer' );
    }

    require_once ( '../vendor/autoload.php' );

    use \ParagonIE\Halite\KeyFactory;

    if( isset($_POST['submit']) ) {
        $postValues = array();
        foreach ( $_POST as $name => $value ) {
	        $postValues[$name] = sanitize_xss($value);
        }
        extract( $postValues );

        ///////////////////////////////////////////////////////////////////////////
        //
        // SECURITY KEYS
        //
        ///////////////////////////////////////////////////////////////////////////

        //We generate some randomness for directory name as where the keys are going to be placed

        //Generate Keys
        $keys_cookies = KeyFactory::generateEncryptionKey();
        $keys_password = KeyFactory::generateEncryptionKey();
        $keys_general = KeyFactory::generateEncryptionKey();

        //Save Keys
        $keys_cookies_hex = KeyFactory::export($keys_cookies)->getString();
        $keys_password_hex = KeyFactory::export($keys_password)->getString();
        $keys_general_hex = KeyFactory::export($keys_general)->getString();

        if( !$keys_cookies_hex || !$keys_password_hex || !$keys_general_hex ) {
            $error = 'An error occured while generating the security keys, please try again or do it manually.';
        }

        ///////////////////////////////////////////////////////////////////////////
        //
        // MYSQL DETAILS VERIFICATION
        //
        ///////////////////////////////////////////////////////////////////////////

        $db = new mysqli ( $host, $user, $password, $database );

        if ( $db->connect_errno ) { 
            $error = 'Error while connecting to database. Please verify you entered the corred MySQL details.';
        }

        ///////////////////////////////////////////////////////////////////////////
        //
        // CONFIGURATION FILE GENERATION
        //
        // @https://wordpress.org/support/article/changing-file-permissions/
        ///////////////////////////////////////////////////////////////////////////

        //Configuration file content
        $file_content = "<?php
        /**
         * MYSQL Host
         *
         * Is required for database access
         *
         * Needs to be changed every new project
         */
        define ( 'MYSQL_HOST', '$host' );
    
        /**
         * MYSQL USER
         *
         * Is required for database access
         *
         * Needs to be changed every new project
         */
        define ( 'MYSQL_USER', '$user' );
    
        /**
         * MYSQL PASSWORD
         *
         * Is required for database access
         *
         * Needs to be changed every new project
         */
        define ( 'MYSQL_PASSWORD', '$password' );
    
        /**
         * MYSQL DATABASE
         *
         * Is required for database access
         *
         * Needs to be changed every new project
         */
        define ( 'MYSQL_DATABASE', '$database' );
    
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // DO NOT EDIT BELOW THIS LINE
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    
        /**
         * MYSQL Connection
         */
        \$db = new mysqli ( MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE );
        \$db->set_charset ( 'utf8' );
    
        if ( \$db->connect_errno ) { 
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
        define( 'CKKEY', '$keys_cookies_hex' );
        define( 'PWKEY', '$keys_password_hex' );
        define( 'GNKEY', '$keys_general_hex' );
    
        if( !defined('CKKEY') || !defined('PWKEY') || !defined('GNKEY') ) {
            /**
             *  The script below will help you generate a key and save it to its location
             * 
             *  require_once ( 'vendor/autoload.php' );
             * 
             * 	use \ParagonIE\Halite\KeyFactory;
             *  \$encryptionKey = KeyFactory::generateEncryptionKey();
             *	\$key_hex = KeyFactory::export(\$encryptionKey)->getString();
             *
             *  TO USE THE KEYS THE FOLLOWING FUNCTION WILL HELP YOU
             *  \$enc_key = KeyFactory::importEncryptionKey(new HiddenString(\$key_hex));
             */
            die ('Keys are missing, generate them before continuing');
        }
    
        /**
         * Lets start the php sessions
         */
        if ( !isset(\$_SESSION) ) { session_start(); }
    ?>";

        //To generate the configuration file, we make sure that we were able to connect to the database
        if( !$db->connect_errno ) {
          //Generate the new configuration file
          if(!$fp = fopen('configuration.php', 'w')) {
            $error = 'Error opening configuration file, try again or do it manually.';
          }

          if(!fwrite($fp, $file_content)) {
            $error = 'Error writting to the configuration file, try again or do it manually.';
          }
        }

        ///////////////////////////////////////////////////////////////////////////
        //
        // DIRECTORY PERMISSION
        //
        // Directories - 0755
        // Any file not security critical - 0644
        // Security critical files like configuration.php - 0440
        ///////////////////////////////////////////////////////////////////////////
        
        //Securring Directories
        chmod('../includes', 0755);
        chmod('../vendor', 0755);
        chmod('../views', 0755);


        //Securring Important Files
        chmod('configuration.php', 0440);

        //
        ///////////////////////////////////////////////////////////////////////////

        if(empty($error)) {
            $success = 'Installation completed! This file is going to be deleted!';
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Installation</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <h2>Simple Installation.</h2>
        <p class="lead">
            On this installation we will create the security keys, grab your MySQL database details and with that information create the required configuration file.
        </p>
      </div>

      <div class="row">
        <div class="col-md-12 order-md-1">

        <?php 
            if(!empty($error)) {
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            }
            
            if(!empty($success)) {
                echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
            }
        ?>

          <h4 class="mb-3">MySQL Details</h4>
          <form class="needs-validation" method="POST" novalidate>

            <div class="mb-3">
              <label for="username">Host</label>
              <div class="input-group">
              <input type="text" class="form-control" id="host" name="host" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Your MySQL host name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username">User</label>
              <div class="input-group">
              <input type="text" class="form-control" id="user" name="user" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Your MySQL username is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username">Password</label>
              <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Your MySQL password is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username">Database</label>
              <div class="input-group">
              <input type="text" class="form-control" id="database" name="database" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Your MySQL database name is required.
                </div>
              </div>
            </div>

            <button class="btn btn-primary btn-lg btn-block" name="submit" type="submit">Install</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>

<?php
    //If success delete file
    if(!empty($success)) {
        unlink('install.php');
    }
?>
