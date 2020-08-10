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
            $form_error = 'Hubo un error al confirmar su contraseña, favor de ingresarla nuevamente.';
        }        

        if(empty($_POST['confirm'])) {
            $form_error = 'Debe confirmar su contraseña.';
        }

        if ( strlen($_POST['password'])<8 ) {
            $form_error = 'Su contraseña debe contener 8 o más caracteres.';
        }

        if(empty($_POST['password'])) {
            $form_error = 'Debe ingresar su nueva contraseña.';
        }

        if(!empty($_POST['old']) && !Password::verify(new HiddenString(sanitize_xss($_POST['old'])), $hash, $key)) {
            $form_error = 'La contraseña actual que ingreso no es la correcta, favor de intentarlo nuevamente.';
        }

        if(empty($_POST['old'])) {
            $form_error = 'Debe ingresar su contraseña actual.';
        }

        if(empty($form_error)) { 
            if(update_user_table('password', $user['id_user'], $_POST['password'])) {
                $form_success = 'Bien, su contraseña ha sido cambiada exitosamente.';

                //Auto log-in them
                login_user($user['email'], $_POST['password']);
            }
            else {
                $form_error = 'Hubo un error al intentar cambiar su contraseña, favor de intentarlo nuevamente.';
            }
        }

	}
?>