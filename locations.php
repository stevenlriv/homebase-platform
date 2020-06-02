<?php
    //There needs to be a POST request to manipulate cache actions
    if(!$_GET) exit( header('Location: /not-found') );

    define('SCRIP_LOAD', true);

    require __DIR__ . '/includes/configuration.php';
    require __DIR__ . '/includes/lib.php';

    //There needs to be an user logged in, the user can't be a tenant or lister
    $user = is_login_user();
    if(!$user || $user['type'] == 'tenants' || $user['type'] == 'listers') {
        exit( header('Location: /not-found') );
    }

    //Define default response
    $response['response'] = 'false';

    header('Content-Type: application/json');

    if(!empty($_GET['action']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        if($_GET['action'] == 'state') {
            // Get array of States and json them
            if( $_GET['action'] == 'state' ) {
                $array = get_location('state', 'all', array(
                    0 => array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_country", "command" => "=", "value" => $_GET['id']),
                ));
            }

            if($array) {
                $json = json_encode($array);
            }

            // If there is no array just choose show the option N/A
            else {
                $json = json_encode(array('name' => 'N/A'));
            }

            $response['response'] = 'true'; 
            $response['content'] = $json;
        }
    }

    echo json_encode($response);
?>