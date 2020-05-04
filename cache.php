<?php
    //There needs to be a POST request to manipulate cache actions
    if(!$_POST) exit( header('Location: /not-found') );

    define('SCRIP_LOAD', true);

    require __DIR__ . '/includes/configuration.php';
    require __DIR__ . '/includes/lib.php';

    //There needs to be an user logged in 
    $user = is_login_user();
    if(!$user) {
        exit( header('Location: /not-found') );
    }

    //Define default response
    $response['response'] = 'false';

    header('Content-Type: application/json');

    //We verify if the cookie already exist to see if we update it or create a new one
    if(!empty($_POST['form_name']) && !empty($_POST['content'])) {
        if(get_cache($_POST['form_name'])) {
            // Update cache
            $json = json_encode($_POST['content']);

            if(update_cache($_POST['form_name'], $json)) {
                $response['response'] = 'true'; 
            }
        }
        else {
            // Add new cache
            $json = json_encode($_POST['content']);

            if(new_cache($_POST['form_name'], $json)) {
                $response['response'] = 'true'; 
            }
        }
    }

    echo json_encode($response);
?>