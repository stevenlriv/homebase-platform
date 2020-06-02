<?php
    if(!$_POST && !$_FILES && !$_GET) exit( header('Location: /not-found') );

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

    //We get the listing from the session id if it exists
    if(empty($_SESSION['CACHE_IMG_LISTING'])) { 
        $_SESSION['CACHE_IMG_LISTING'] = ''; 
    }
    $listing_id = str_replace('edit-property-images-', '', $_SESSION['CACHE_IMG_LISTING']);

    if(is_numeric($listing_id)) {
        $listing = get_listings('one', array( 
            0 => array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_listing", "command" => "=", "value" => $listing_id),
            ), "LIMIT 1");
    }
    else {
        $listing = '';
    }	

    if(!empty($_POST['action']) || !empty($_GET['action'])) {
        if($_GET['action'] == 'get-img') {

            //** If there is no cache only show database, if there is cache, do not show database images as it would be already included in cache */
	        if(get_cache($_SESSION['CACHE_IMG_LISTING'])) {
		        $array = get_cache($_SESSION['CACHE_IMG_LISTING']);
                $response['content'] = json_decode($array['content']);
                $response['response'] = 'true';
	        }
	        elseif(!empty($listing['listing_images'])){
                $response['content'] = json_decode($listing['listing_images']);
                $response['response'] = 'true';
            } 
        }
        elseif($_POST['action'] == 'remove-img') {

            //Need to verify if user have access due to this being a $_POST ajax script
            //This also verify if the listing exists
            if(!empty($listing) && user_has_access_listing($listing)) {
                //Add the database image url to cache so we can manipulate it easier
                if(!get_cache($_SESSION['CACHE_IMG_LISTING'])) {
                    new_cache($_SESSION['CACHE_IMG_LISTING'], $listing['listing_images']);
                }  

                //Now you can remove that image from the cache
                $new_array = array();
                $array = get_cache($_SESSION['CACHE_IMG_LISTING']);
                $array = json_decode($array['content']);

                //Remove the image from array and delete file
                $file_url = $_POST['content'];
                foreach ( $array as $id => $value ) {
                    if($value == $file_url) { continue; }
                    array_push($new_array, $value);
                }
                delete_image($file_url);

                //Encode and Update the cache
                $json = json_encode($new_array);

                if(update_cache($_SESSION['CACHE_IMG_LISTING'], $json)) {
                    $response['response'] = 'true'; 
                }
            }

            //Need to have cache data to work with
            elseif(get_cache($_SESSION['CACHE_IMG_LISTING'])) {

                //Now you can remove that image from the cache
                $new_array = array();
                $array = get_cache($_SESSION['CACHE_IMG_LISTING']);
                $array = json_decode($array['content']);

                //Remove the image from array and delete file
                $file_url = $_POST['content'];
                foreach ( $array as $id => $value ) {
                    if($value == $file_url) { continue; }
                    array_push($new_array, $value);
                }
                delete_image($file_url);

                //Encode and Update the cache
                $json = json_encode($new_array);

                if(update_cache($_SESSION['CACHE_IMG_LISTING'], $json)) {
                    $response['response'] = 'true'; 
                }
            }
        }
    }

    elseif(!empty($_FILES) && !empty($_SESSION['CACHE_IMG_LISTING'])) {
        //File to be uploaded
        $file_data = $_FILES['file'];

        //*** Add database images to cache to preserve the order */
        //In preparation for later images update	
        if(!empty($listing['listing_images'])) {
            new_cache($_SESSION['CACHE_IMG_LISTING'], $listing['listing_images']);
        }
        ////////////////////////////////

        if(get_cache($_SESSION['CACHE_IMG_LISTING'])) {
            //Decode image array
            $array = get_cache($_SESSION['CACHE_IMG_LISTING']);
            $array = json_decode($array['content']);

            //Upload image so you can get the URL
            $image_url = listing_image($file_data);

            if($image_url) {
                //Add new image to array
                array_push($array, $image_url);

                //Then encode again
                $json = json_encode($array);

                if(update_cache($_SESSION['CACHE_IMG_LISTING'], $json)) {
                    $response['response'] = 'true'; 
                }
            }
            else {
                $response['error'] = 'File could not be saved.'; 
            }
        }
        else {
            //Upload image so you can get the URL
            $image_url = listing_image($file_data);

            if($image_url) {
                // Add new cache
                $array = array();
                array_push($array, $image_url);

                //Encode content
                $json = json_encode($array);

                if(new_cache($_SESSION['CACHE_IMG_LISTING'], $json)) {
                    $response['response'] = 'true'; 
                }
            }
            else {
                $response['error'] = 'File could not be saved.'; 
            }
        }
    }

    echo json_encode($response);
?>