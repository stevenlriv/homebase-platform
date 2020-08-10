<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	if ( isset($_POST['submit']) ) {

		if(empty($_POST['password'])) {
			$form_error = 'Debe de ingresar su contraseña.';
		}

		//Form Verification
		if(!is_email($_POST['email'])) {
			$form_error = 'El correo electrónico ingresado no es válido, favor de intentar nuevamente.';
		}

		//Try to log in
		if(empty($form_error)) {
			if ( login_user ($_POST['email'], $_POST['password']) ) {
				header("Refresh:0");
			}
			else {
				$form_error = 'Hubo un error, favor de intentarlo nuevamente.';
			}
		}
	}
?>