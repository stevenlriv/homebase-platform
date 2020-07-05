<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	use \ParagonIE\Halite\{
		KeyFactory,
		HiddenString
    };

    $approved_to_reset = false;

    if(!empty($_GET['email']) && !empty($_GET['validation'])) {
        //First verify that the validation code is the same cypher text that we have in the database
        $user_details = get_user_by_email($_GET['email']);
        $validation = sanitize_xss($_GET['validation']); //new

        if($validation==$user_details['code']) {
            //Now lets double check everything
            $key = KeyFactory::importEncryptionKey(new HiddenString(GNKEY));

            $plaintext_database = \ParagonIE\Halite\Symmetric\Crypto::decrypt(
                $user_details['code'],
                $key
            );

            $plaintext_browser = \ParagonIE\Halite\Symmetric\Crypto::decrypt(
                $validation,
                $key
            );

            $plaintext_database = explode('|', trim($plaintext_database)); //0=code, 1=date
            $plaintext_browser = explode('|', trim($plaintext_browser)); //0=code, 1=date
            
            if ( $plaintext_browser[0] == $plaintext_database[0] && $plaintext_browser[1] == $plaintext_database[1] && time()<$plaintext_database[1] ) {
                $approved_to_reset = true;
            }

        }
    }
    
	if ( isset($_POST['submit']) ) {

        if($approved_to_reset) {

            if(empty($_POST['password'])) {
                $form_error = 'You must enter your password.';
            }

            if(empty($_POST['password'])) {
            }

            if ( strlen($_POST['password'])<8 ) {
                $form_error = 'You password must be 8 characters or more.';
            }

            if(empty($_POST['confirm'])) {
                $form_error = 'You must confirm your password.';
            }

            if($_POST['password']!=$_POST['confirm']) {
                $form_error = 'Your passwords does not match, please enter them again.';
            }

            if(empty($form_error)) { 
                if(update_user_table('password', $user_details['id_user'], $_POST['password'])) {
                    update_user_table('code', $user_details['id_user'], '');
                    $form_success = 'Great, your password has been updated.';

                    //Auto log-in them
                    login_user($user_details['email'], $_POST['password']);
                    header("Refresh:1");
                }
                else {
                    $form_error = 'An error occurred while updating your password, please try again again.';
                }
            }
        }
        else {

		    if(!is_email($_POST['email'])) {
			    $form_error = 'You have enter an invalid e-mail address, try again.';
		    }

		    if(empty($form_error)) { 
            
                //Details for recovery email
                $user_details = get_user_by_email($_POST['email']);  

                if($user_details) {
                    $random_code = generateNotSecureRandomString(16).rand(120000,999999);
                    $date = time()+60*60*24; // Code expire in 24 hours

                    $code = $random_code.'|'.$date;

                    $key = KeyFactory::importEncryptionKey(new HiddenString(GNKEY));
                    $ciphertext = \ParagonIE\Halite\Symmetric\Crypto::encrypt(
                        new HiddenString($code),
                        $key
                    );

                    update_user_table('code', $user_details['id_user'], $ciphertext);

                    $link = get_domain()."/reset-password?email={$user_details['email']}&validation=$ciphertext";
                    send_recover_email($user_details['fullname'], $_POST['email'], $link);
                }

			    //Don't give any details to a hacker or other person, just a general message
                $form_success = 'If the details provided are linked to an existing account, you will be receiving an email in the next 5 minutes (check in your SPAM folder). If not, just contact us and we will help you out.';
            }
        }
	}
?>