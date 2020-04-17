<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	if ( isset($_POST['login-submit']) ) {

		if(empty($_POST['password'])) {
			$form_error = 'You must enter your password.';
		}

		//Form Verification
		if(!is_email($_POST['email'])) {
			$form_error = 'You have enter an invalid e-mail address, try again.';
		}

		//Try to log in
		if(empty($form_error)) {
			if ( login_user ($_POST['email'], $_POST['password']) ) {
				header("Refresh:0");
			}
			else {
				$form_error = 'We were not able to log you in with the details provided. Please try again.';
			}
		}
	}
?>