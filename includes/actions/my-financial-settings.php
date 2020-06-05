<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
    //Cache settings
    $_SESSION['CACHE_MY_FINANCIALS'] = 'financial-settings';
	$cache_id = $_SESSION['CACHE_MY_FINANCIALS'];
	$cache = get_cache($cache_id);

	if ( isset($_POST['submit']) ) {
        
        if(empty($_POST['bank_name'])) {
            $form_error = 'You must enter your banks name.';
        }

        if(empty($_POST['bank_sole_owner'])) {
            $form_error = 'You must enter your bank accounts full name.';
        }

        if(empty($_POST['bank_routing_number'])) {
            $form_error = 'You must enter your bank account routing number.';
        }

        if(empty($_POST['bank_account_number'])) {
            $form_error = 'You must enter your bank account number.';
        }

        if(empty($form_error)) { 
            if(update_bank_information($user['id_user'], $_POST['bank_name'], $_POST['bank_sole_owner'], $_POST['bank_routing_number'], $_POST['bank_account_number'])) {
                $form_success = 'Great, your bank information has been updated.';
                delete_cache($cache_id);
                header("Refresh:1");
            }
            else {
                $form_error = 'An error occurred while updating your bank information, please try again.';
            }
        }

    }
?>