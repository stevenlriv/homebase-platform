<?php
    define('SCRIP_LOAD', true);
    require_once('lib/class.functions.php');

    if(!is_file('../vendor/autoload.php')) {
        die( 'Please install dependencies with composer' );
    }

    require_once ( '../vendor/autoload.php' );

    use \ParagonIE\Halite\KeyFactory;

    function generatenotsecuredRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

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
        $keys_dir = generatenotsecuredRandomString(12).'/';
        $keys_cookies_path = $keys_dir.generatenotsecuredRandomString(15).'.key';
        $keys_general_path = $keys_dir.generatenotsecuredRandomString(15).'.key';

        //Generate folder if it does not exists
        if(!is_dir($keys_dir)) {
            mkdir($keys_dir, 0755);
        }

        //Generate Keys
        $keys_cookies = KeyFactory::generateEncryptionKey();
        $keys_general = KeyFactory::generateEncryptionKey();

        //Save Keys
        if( !KeyFactory::save($keys_cookies, $keys_cookies_path) || !KeyFactory::save($keys_general , $keys_general_path) ) {
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

        //Due to how the files are load in index.php, we need to give global variables for include
        $keys_cookies_path_alter = 'includes/'.$keys_cookies_path;
        $keys_general_path_alter = 'includes/'.$keys_general_path;

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
         * @ https://paragonie.com/blog/2016/05/solve-all-your-cryptography-problems-in-three-easy-steps-with-halite
         * @ https://paragonie.com/blog/2015/05/using-encryption-and-authentication-correctly
         */
        define( 'CKKEY', '$keys_cookies_path_alter' );
        define( 'PWKEY', '$keys_general_path_alter' );
    
        if( !is_file(CKKEY) || !is_file(PWKEY) ) {
            /**
             *  The script below will help you generate a key and save it to its location
             * 
             *  require_once ( 'vendor/autoload.php' );
             * 
             * 	use \ParagonIE\Halite\KeyFactory;
             *  \$encryptionKey = KeyFactory::generateEncryptionKey();
             *	KeyFactory::save(\$encryptionKey, '/path/to/encryption.key');
             */
            die ('Keys are missing, generate them before continuing');
        }
    
        /**
         * Lets start the php sessions
         */
        if ( !isset(\$_SESSION) ) { session_start(); }
    
        /**
         * Lets define the basic upload location
         */
        define ( 'UPLOAD_LOCATION', dirname(__DIR__).'/uploads/' );
    ?>";

        //Generate the new configuration file
        if(!$fp = fopen('configuration.php', 'w')) {
            $error = 'Error opening configuration file, try again or do it manually.';
        }

        if(!fwrite($fp, $file_content)) {
            $error = 'Error writting to the configuration file, try again or do it manually.';
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
        chmod($keys_cookies_path, 0440);
        chmod($keys_general_path, 0440);

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
