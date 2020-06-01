<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
    if($type!='') {
        require_once('register-form.php');
    }
    else {
        require_once('register-options.php');
    }
?>