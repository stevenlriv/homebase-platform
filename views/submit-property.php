<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
    if(is_login_user()) {
        //user is logged in, he might add a listing depending on its account status
    }
    else {
        require_once('submit-property-not-login.php');
    }
?>




