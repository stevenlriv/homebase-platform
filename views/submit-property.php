<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
    if($user) {
        require_once('submit-property-login.php');
    }
    else {
        require_once('submit-property-not-login.php');
    }
?>




