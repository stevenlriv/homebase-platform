<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    //Cache Setting
    if($request == '/edit-property') {
        $_SESSION['CACHE_ID_LISTING'] = 'edit-property-'.$listing['id_listing'];
        $_SESSION['CACHE_IMG_LISTING'] = 'edit-property-images-'.$listing['id_listing'];
        $_SESSION['CACHE_IMG_CHECKIN'] = 'edit-property-images-checkin-'.$listing['id_listing'];
    }
    else {
        $_SESSION['CACHE_ID_LISTING'] = 'add-property';
        $_SESSION['CACHE_IMG_LISTING'] = 'add-property-images';
        $_SESSION['CACHE_IMG_CHECKIN'] = 'add-property-images-checkin';
    }
    
	if ( isset($_POST['submit']) ) {

        if(empty($listing) && get_unique_uri(array( 'title' => $_POST['listing_title'], 'city' => $_POST['city'], 'state' => $_POST['state'], 'country' => $_POST['country']), true)) {
            $form_error = 'Tendrá que cambiar su título de propiedad, porque hay una propiedad existente con el mismo título';
        }

        if(empty($_POST['listing_title'])) {
            $form_error = 'Debe introducir un título para su lista de propiedades.';
        }

        if ( strlen($_POST['listing_title'])>40 ) {
            $form_error = 'El título de la lista debe tener 40 caracteres o menos.';
        }
        
        if(empty($_POST['type'])) {
            $form_error = 'Debe seleccionar un tipo para su propiedad.';
        }
        
        if(empty($_POST['number_rooms'])) {
            $form_error = 'Debe seleccionar el número de habitaciones de su propiedad.';
        }
        
        if(empty($_POST['number_bathroom'])) {
            $form_error = 'Debe seleccionar el número de baños de su propiedad.';
        }
        
        if(empty($_POST['monthly_house_original'])) {
            $form_error = 'Debes fijar la renta mensual.';
        }
   
        if(empty($_POST['deposit_house_original'])) {
            //$form_error = 'Debe establecer el depósito de seguridad requerido para la propiedad.';
            $_POST['deposit_house_original'] = 0;
        }

        if(empty($_POST['square_feet'])) {
            $form_error = 'Debes poner los pies cuadrados de la propiedad.';
        }
        
        if(empty($_POST['available'])) {
            $form_error = 'Debe fijar la fecha de disponibilidad de la propiedad.';
        }     
    
        if(empty($_POST['physical_address'])) {
            $form_error = 'Debe establecer la dirección física de la propiedad.';
        }     
        
        if(empty($_POST['country'])) {
            $form_error = 'Debe entrar en el país donde se encuentra su propiedad.';
        }

        if(empty($_POST['state'])) {
            $form_error = 'Debe entrar en el estado donde se encuentra su propiedad.';
        }

        if(empty($_POST['city'])) {
            $form_error = 'Debe entrar en la ciudad donde se encuentra su propiedad.';
        }
        
        if(empty($_POST['zipcode'])) {
            $form_error = 'Debes establecer el código postal de la propiedad.';
        }    
        
        if(empty($_POST['listing_description'])) {
            $form_error = 'Debe establecer la descripción del listado de propiedades.';
        }  
        
        if(empty($_POST['keywords'])) {
            $_POST['keywords'] = '';
        }    

        if ( strlen($_POST['keywords'])>100 ) {
            $form_error = 'Sus palabras clave deben tener 100 caracteres o menos.';
        }

        if(empty($_POST['checkin_access_code'])) {
            //$form_error = 'You must set the property access code.';
            $_POST['checkin_access_code'] = '';
        }  

        if(empty($_POST['checkin_description'])) {
            //$form_error = 'You must explain the tenant how to get into the property using the access code.';
            $_POST['checkin_description'] = '';
        }  

        if (!empty($_POST['video_tour']) && !filter_var($_POST['video_tour'], FILTER_VALIDATE_URL)) {
            $form_error = 'Debes usar un enlace válido para el tour de video.';
        }

        if(empty($_POST['postal_address'])) {
            $_POST['postal_address'] = '';
        }    
  
        if(empty($_POST['video_tour'])) {
            $_POST['video_tour'] = '';
        }    

        if(empty($_POST['check_required'])) {
           // $form_error = 'You must agree to our terms before adding or editing the listing.';
           $_POST['check_required'] = '';
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

        //Verify if there are images availables
        //Get images from cache is already encoded
        if(get_cache($_SESSION['CACHE_IMG_LISTING'])) {
            $listing_images = get_cache($_SESSION['CACHE_IMG_LISTING'])['content'];
        }

        //If there is not image in cache that means that we are not doing any update, so just use the
        //Same data saved in the database
        elseif(!empty($listing['listing_images'])) {
            $listing_images = $listing['listing_images'];
        }

        else {
            $listing_images = '';
            $form_error = 'Se requiere que su lista tenga al menos una imagen.';
        }

        //Verify if there are checkin images available
        if(get_cache($_SESSION['CACHE_IMG_CHECKIN'])) {
            $checkin_images = get_cache($_SESSION['CACHE_IMG_CHECKIN'])['content'];
        }

        //If there is not image in cache that means that we are not doing any update, so just use the
        //Same data saved in the database
        elseif(!empty($listing['checkin_images'])) {
            $checkin_images = $listing['checkin_images'];
        }

        else {
            $checkin_images = ''; 
            //$form_error = 'Your listing is required to have at least 1 checkin image.';
        }

        //Get GPS Latitude and Longitude
        if(empty($form_error)) {
            $address = urlencode($_POST['physical_address']);
            $apikey  = urlencode(get_maps_api_key(true));
            $url     = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apikey}";
            $resp    = json_decode( file_get_contents( $url ), true );

            // Latitude and Longitude (PHP 7 syntax)
            $latitude    = $resp['results'][0]['geometry']['location']['lat'] ?? '';
            $longitude   = $resp['results'][0]['geometry']['location']['lng'] ?? '';
        }
        
        //Not in use currently
        $monthly_per_room = 0;
        $deposit_per_room = 0;

        // Calendly Link
        if(!empty($_POST['calendly_link'])) {
            $calendly_link = $_POST['calendly_link'];
        }
        elseif(!empty($listing['calendly_link'])) {
            $calendly_link = $listing['calendly_link'];
        }
        else {
            $calendly_link = '';
        }

        //In use
        $postal_address = $_POST['postal_address'];
        $checkin_description = $_POST['checkin_description'];

        if(empty($form_error)) { 
            // edit an existing listing
            if(!empty($listing)) {
                if(update_listing ( $listing['id_listing'], $_POST['type'], $_POST['available'], $_POST['zipcode'], $_POST['keywords'], $_POST['monthly_house_original'], $monthly_per_room, $_POST['deposit_house_original'], $deposit_per_room, $_POST['number_rooms'],
                    $_POST['number_bathroom'], $_POST['square_feet'], $_POST['physical_address'], $postal_address, $latitude, $longitude, $_POST['listing_title'], $_POST['listing_description'], $listing_images, $_POST['video_tour'],
                    $calendly_link, $checkin_images, $checkin_description, $_POST['air_conditioning'], $_POST['electricity'], $_POST['furnished'], $_POST['parking'], $_POST['pets'], $_POST['smoking'], $_POST['water'], $_POST['wifi'], 
                    $_POST['laundry_room'], $_POST['gym'], $_POST['alarm'], $_POST['swimming_pool'], $_POST['checkin_access_code'], $_POST['country'], $_POST['state'], $_POST['city']) ) {
                    $form_success = 'Great, your property was updated.';

                    // Delete cache
                        delete_cache($_SESSION['CACHE_ID_LISTING']);
                        delete_cache($_SESSION['CACHE_IMG_LISTING']); 
                        delete_cache($_SESSION['CACHE_IMG_CHECKIN']);

                    //header("Refresh:1");
                }
                else {
                    $form_error = 'Se ha producido un error al actualizar tu lista, por favor inténtalo de nuevo.';
                }
            }
            // add a new listing
            else {
                if(new_listing ( $_POST['type'], $_POST['available'], $_POST['zipcode'], $_POST['keywords'], $_POST['monthly_house_original'], $monthly_per_room, $_POST['deposit_house_original'], $deposit_per_room, $_POST['number_rooms'],
                    $_POST['number_bathroom'], $_POST['square_feet'], $_POST['physical_address'], $postal_address, $latitude, $longitude, $_POST['listing_title'], $_POST['listing_description'], $listing_images, $_POST['video_tour'],
                    $calendly_link, $checkin_images, $checkin_description, $_POST['air_conditioning'], $_POST['electricity'], $_POST['furnished'], $_POST['parking'], $_POST['pets'], $_POST['smoking'], $_POST['water'], $_POST['wifi'], 
                    $_POST['laundry_room'], $_POST['gym'], $_POST['alarm'], $_POST['swimming_pool'], $_POST['checkin_access_code'], $_POST['country'], $_POST['state'], $_POST['city']) ) {
                    $form_success = 'Great, your property was added.';

                    // Delete Cache
                        delete_cache($_SESSION['CACHE_ID_LISTING']);
                        delete_cache($_SESSION['CACHE_IMG_LISTING']);
                        delete_cache($_SESSION['CACHE_IMG_CHECKIN']);
                }
                else {
                    $form_error = 'Se ha producido un error al añadir tu lista, por favor inténtalo de nuevo.';
                }
            }
        }
    }
?>