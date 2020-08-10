<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
    //Cache settings
    $_SESSION['CACHE_MY_FINANCIALS'] = 'financial-settings';
	$cache_id = $_SESSION['CACHE_MY_FINANCIALS'];
	$cache = get_cache($cache_id);

	if ( isset($_POST['submit']) ) {
        
        if(empty($_POST['bank_name'])) {
            $form_error = 'Debe ingresar el nombre de su banco.';
        }

        if(empty($_POST['bank_sole_owner'])) {
            $form_error = 'Debe ingresar el nombre de la persona dueña de la cuenta de banco.';
        }

        if(empty($_POST['bank_routing_number'])) {
            $form_error = 'Debe ingresar el número de ruta del banco.';
        }

        if(empty($_POST['bank_account_number'])) {
            $form_error = 'Debe ingresar el número de cuenta del banco.';
        }

        if(empty($_POST['bank_confirm_account_number'])) {
            $form_error = 'Debe confirmar el número de cuenta del banco.';
        }

        if($_POST['bank_account_number']!=$_POST['bank_confirm_account_number']) {
            $form_error = 'Los números de cuenta ingresados no son los mismos, favor de intentar nuevamente.';
        }

        if(empty($form_error)) { 
            if(update_bank_information($user['id_user'], $_POST['bank_name'], $_POST['bank_sole_owner'], $_POST['bank_routing_number'], $_POST['bank_account_number'])) {
                $form_success = 'Bien! Su información bancaria fue actualizada.';
                delete_cache($cache_id);
                header("Refresh:1");
            }
            else {
                $form_error = 'Hubo un error al actualizar su información bancaria, favor de intentar nuevamente.';
            }
        }

    }
?>