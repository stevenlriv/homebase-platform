<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
    if($user['status']=='pending') {
        require_once('submit-property-login-pending.php');
    }
    else {

        //Before showing the user the ability to add a property, required them their information and bank account number
        if($user['driver_license']=='' || $user['fs_address']=='' || $user['city']=='' || $user['fs_state']=='' || $user['postal_code']=='' || $user['country']=='' || $user['bank_name']=='' || $user['bank_sole_owner']=='' || $user['bank_routing_number']=='' || $user['bank_account_number']=='') {
            require_once('submit-property-login-user-information.php');
        }
        else {
            require_once('submit-property-login.php');
        }
    }
?>




