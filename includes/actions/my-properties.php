<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    ////////////////// HIDE ////////////////// 

    if(!empty($_GET['hide']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['hide'], true)) {
        $listing = is_uri($_GET['hide'], true);

        if(user_has_access_listing($listing) && $listing['status']!='inactive') {
            if(update_visibilty($listing['id_listing'], 'hide')) {
                $form_success = 'La propiedad fue ocultada exitosamente.';
            }
            else {
                $form_error = 'Hubo un error a ocultar la propiedad, favor de intentarlo nuevamente.';
            }
        }
    }

    ////////////////// SHOW ////////////////// 
    
    if(!empty($_GET['show']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['show'], true)) {
        $listing = is_uri($_GET['show'], true);

        if(user_has_access_listing($listing) && $listing['status']!='active') {
            if(update_visibilty($listing['id_listing'], 'show')) {
                $form_success = 'La propiedad fue activada correctamente.';
            }
            else {
                $form_error = 'Hubo un error, activando la propiedad, favor de intentarlo nuevamente.';
            }
        }
    }

    ////////////////// APPROVED ////////////////// 
    
    // Only admins can approve listings
    if(is_admin() && !empty($_GET['approve']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['approve'], true)) {
        $listing = is_uri($_GET['approve'], true);

        if($listing['status']=='pending') {
            if(update_visibilty($listing['id_listing'], 'approve')) {
                $form_success = 'La propiedad fue aprobada exitosamente.';
            }
            else {
                $form_error = 'Hubo un error aprobando la propedad, favor de intentarlo nuevamente.';
            }
        }
    }
    
    ////////////////// DELETE ////////////////// 
    
    if(!empty($_GET['delete']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['delete'], true)) {
        $listing = is_uri($_GET['delete'], true);

        //We get the image array so we can delete the images after the listing is deleted
        $images_array = json_decode($listing['listing_images']);

        if(user_has_access_listing($listing)) {
            if(delete_listing($listing['id_listing'])) {
                $form_success = 'La propiedad fue borrada exitosamente.';

                //We now procced to delete every image
                foreach($images_array as $id => $value) {
                    delete_image($value);
                }
            }
            else {
                $form_error = 'Hubo un error al borrar la propiedad, favor de intentarlo nuevamente.';
            }
        }
    }
?>