<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    //Cache Setting
    if($request == '/edit-property') {
        $_SESSION['CACHE_ID_LISTING'] = 'edit-property-'.$listing['id_listing'];
        $_SESSION['CACHE_IMG_LISTING'] = 'edit-property-images-'.$listing['id_listing'];
    }
    else {
        $_SESSION['CACHE_ID_LISTING'] = 'add-property';
        $_SESSION['CACHE_IMG_LISTING'] = 'add-property-images';
    }
    
	if ( isset($_POST['submit']) ) {

        if(empty($listing) && get_unique_uri(array( 'title' => $_POST['listing_title'], 'id_city' => $_POST['id_city']), true)) {
            $form_error = 'You will need to change your property title, because there is an existing property with the same title';
        }

        if(empty($_POST['listing_title'])) {
            $form_error = 'You must enter a title for your property listing.';
        }
        
        if(empty($_POST['type'])) {
            $form_error = 'You must select a type for your property.';
        }
        
        if(empty($_POST['number_rooms'])) {
            $form_error = 'You must select the number of rooms for your property.';
        }
        
        if(empty($_POST['number_bathroom'])) {
            $form_error = 'You must select the number of rooms for your property.';
        }
        
        if(empty($_POST['monthly_house'])) {
            $form_error = 'You must set the monthly rent.';
        }
   
        if(empty($_POST['deposit_house'])) {
            $form_error = 'You must set the property required security deposit.';
        }

        if(empty($_POST['square_feet'])) {
            $form_error = 'You must set the property square feet.';
        }
        
        if(empty($_POST['available'])) {
            $form_error = 'You must set the property availability date.';
        }     
    
        if(empty($_POST['physical_address'])) {
            $form_error = 'You must set the property physical address.';
        }     
        
        if(empty($_POST['id_city'])) {
            $form_error = 'You must select city where your property is located.';
        }
        
        if(empty($_POST['zipcode'])) {
            $form_error = 'You must set the property zip code.';
        }    
        
        if(empty($_POST['listing_description'])) {
            $form_error = 'You must set the property listing description.';
        }  
        
        if(empty($_POST['keywords'])) {
            $_POST['keywords'] = '';
        }    

        if (!empty($_POST['calendly_link']) && !filter_var($_POST['calendly_link'], FILTER_VALIDATE_URL)) {
            $form_error = 'You must use a valid calendly link.';
        }

        if (!empty($_POST['video_tour']) && !filter_var($_POST['video_tour'], FILTER_VALIDATE_URL)) {
            $form_error = 'You must use a valid video tour link.';
        }

        if(empty($_POST['calendly_link'])) {
            $_POST['calendly_link'] = '';
        }    
  
        if(empty($_POST['video_tour'])) {
            $_POST['video_tour'] = '';
        }    

        //Proccess the check ones
        if(empty($_POST['electricity'])) { $_POST['electricity'] = '0'; }
        if(empty($_POST['water'])) { $_POST['water'] = '0'; }
        if(empty($_POST['furnished'])) { $_POST['furnished'] = '0'; }
        if(empty($_POST['parking'])) { $_POST['parking'] = '0'; }

        if(empty($_POST['wifi'])) { $_POST['wifi'] = '0'; }
        if(empty($_POST['alarm'])) { $_POST['alarm'] = '0'; }
        if(empty($_POST['laundry_room'])) { $_POST['laundry_room'] = '0'; }
        if(empty($_POST['air_conditioning'])) { $_POST['air_conditioning'] = '0'; }

        if(empty($_POST['gym'])) { $_POST['gym'] = '0'; }
        if(empty($_POST['swimming_pool'])) { $_POST['swimming_pool'] = '0'; }
        if(empty($_POST['pets'])) { $_POST['pets'] = '0'; }
        if(empty($_POST['smoking'])) { $_POST['smoking'] = '0'; }

        //Get GPS Latitude and Longitude
        $address = urlencode($_POST['physical_address']);
        $apikey  = urlencode(get_maps_api_key(true));
        $url     = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apikey}";
        $resp    = json_decode( file_get_contents( $url ), true );

        // Latitude and Longitude (PHP 7 syntax)
        $latitude    = $resp['results'][0]['geometry']['location']['lat'] ?? '';
        $longitude   = $resp['results'][0]['geometry']['location']['lng'] ?? '';

        //Get $listing_images from JQUERY
        $listing_images = '';

        //We change the listing pricing using our current business model of 10% mark up
        //Also on the footer.php there is some js code to let the lister know how much is going to be listed at Homebase
        //No decimals numbers use round()
        $_POST['monthly_house'] = round($_POST['monthly_house'] + ($_POST['monthly_house']*0.10));
        $_POST['deposit_house'] = round($_POST['deposit_house'] + ($_POST['deposit_house']*0.10));

        //Not in use currently
        $monthly_per_room = 0;
        $deposit_per_room = 0;
        $postal_address = '';
        $checkin_images = ''; 
        $checkin_description = '';

        if(empty($form_error)) { 
            ///determine if is an update or a new listing
            if(!empty($listing)) {
                //Get images from cache is already encoded
                if(get_cache($_SESSION['CACHE_IMG_LISTING'])) {
                    $listing_images = get_cache($_SESSION['CACHE_IMG_LISTING'])['content'];
                }
                //If there is not image in cache that means that we are not doing any update, so just use the
                //Same data saved in the database
                else {
                    $listing_images = $listing['listing_images'];
                }

                if(update_listing ( $listing['id_listing'], $_POST['id_city'], $_POST['type'], $_POST['available'], $_POST['zipcode'], $_POST['keywords'], $_POST['monthly_house'], $monthly_per_room, $_POST['deposit_house'], $deposit_per_room, $_POST['number_rooms'],
                $_POST['number_bathroom'], $_POST['square_feet'], $_POST['physical_address'], $postal_address, $latitude, $longitude, $_POST['listing_title'], $_POST['listing_description'], $listing_images, $_POST['video_tour'],
                $_POST['calendly_link'], $checkin_images, $checkin_description, $_POST['air_conditioning'], $_POST['electricity'], $_POST['furnished'], $_POST['parking'], $_POST['pets'], $_POST['smoking'], $_POST['water'], $_POST['wifi'], 
                $_POST['laundry_room'], $_POST['gym'], $_POST['alarm'], $_POST['swimming_pool']) ) {
                    $form_success = 'Great, your property was updated.';
                    delete_cache($_SESSION['CACHE_ID_LISTING']);
                    delete_cache($_SESSION['CACHE_IMG_LISTING']);
                    header("Refresh:1");
                }
                else {
                    $form_error = 'An error occurred while adding your listing, please try again.';
                }
            }
            else {
                //Get images from cache; is already encoded
                $listing_images = get_cache($_SESSION['CACHE_IMG_LISTING'])['content'];

                if(new_listing ( $_POST['id_city'], $_POST['type'], $_POST['available'], $_POST['zipcode'], $_POST['keywords'], $_POST['monthly_house'], $monthly_per_room, $_POST['deposit_house'], $deposit_per_room, $_POST['number_rooms'],
                $_POST['number_bathroom'], $_POST['square_feet'], $_POST['physical_address'], $postal_address, $latitude, $longitude, $_POST['listing_title'], $_POST['listing_description'], $listing_images, $_POST['video_tour'],
                $_POST['calendly_link'], $checkin_images, $checkin_description, $_POST['air_conditioning'], $_POST['electricity'], $_POST['furnished'], $_POST['parking'], $_POST['pets'], $_POST['smoking'], $_POST['water'], $_POST['wifi'], 
                $_POST['laundry_room'], $_POST['gym'], $_POST['alarm'], $_POST['swimming_pool']) ) {
                    $form_success = 'Great, your property was added.';
                    delete_cache($_SESSION['CACHE_ID_LISTING']);
                    delete_cache($_SESSION['CACHE_IMG_LISTING']);
                }
                else {
                    $form_error = 'An error occurred while adding your listing, please try again.';
                }
            }
        }
    }
?>