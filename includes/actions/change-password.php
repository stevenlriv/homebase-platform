<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	use \ParagonIE\Halite\{
		KeyFactory,
		Password,
		HiddenString
	};

	if ( isset($_POST['submit']) ) {

        $key = KeyFactory::importEncryptionKey(new HiddenString(PWKEY));
        $hash = explode('|', get_cookie ( 'USMP' ))[1];

        if($_POST['password']!=$_POST['confirm']) {
            $form_error = 'Your new password does not match, please enter it again.';
        }        

        if(empty($_POST['confirm'])) {
            $form_error = 'You must confirm your new password.';
        }

        if ( strlen($_POST['password'])<12 ) {
            $form_error = 'You password must be 12 characters or more.';
        }

        if(empty($_POST['password'])) {
            $form_error = 'You must enter your new password.';
        }

        if(!empty($_POST['old']) && !Password::verify(new HiddenString(sanitize_xss($_POST['old'])), $hash, $key)) {
            $form_error = 'Your current password does not match, please enter them again.';
        }

        if(empty($_POST['old'])) {
            $form_error = 'You must enter your current password.';
        }

        if(empty($form_error)) { 
            if(update_user_table('password', $user['id_user'], $_POST['password'])) {
                $form_success = 'Great, your password has been updated.';

                //Auto log-in them
                login_user($user['email'], $_POST['password']);
            }
            else {
                $form_error = 'An error occurred while updating your password, please try again.';
            }
        }

	}
?>