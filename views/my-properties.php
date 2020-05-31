<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
    if($user['type'] == 'tenants') {
        require_once('my-properties-tenants.php');
    }
    elseif($user['type'] == 'listers') {
        require_once('my-properties-lister.php');
    }
    else {
        require_once('my-properties-realtors-landlords.php');
    }
?>