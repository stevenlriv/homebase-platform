<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    ////////////////// HIDE ////////////////// 

    if(!empty($_GET['hide']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['hide'], true)) {
        $listing = is_uri($_GET['hide'], true);

        if(user_has_access_listing($listing) && $listing['status']!='inactive') {
            if(update_visibilty($listing['id_listing'], 'hide')) {
                $form_success = 'The property was hidden successfully.';
            }
            else {
                $form_error = 'There was an error hidding the listing, please try again.';
            }
        }
    }

    ////////////////// SHOW ////////////////// 
    
    if(!empty($_GET['show']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['show'], true)) {
        $listing = is_uri($_GET['show'], true);

        if(user_has_access_listing($listing) && $listing['status']!='active') {
            if(update_visibilty($listing['id_listing'], 'show')) {
                $form_success = 'The property was enabled successfully.';
            }
            else {
                $form_error = 'There was an error enabling the property, please try again.';
            }
        }
    }

    ////////////////// APPROVED ////////////////// 
    
    // Only admins can approve listings
    if(is_admin() && !empty($_GET['approve']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_uri($_GET['approve'], true)) {
        $listing = is_uri($_GET['approve'], true);

        if($listing['status']=='pending') {
            if(update_visibilty($listing['id_listing'], 'approve')) {
                $form_success = 'The property was approved successfully.';
            }
            else {
                $form_error = 'There was an error approving the property, please try again.';
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
                $form_success = 'The property was deleted successfully.';

                //We now procced to delete every image
                foreach($images_array as $id => $value) {
                    delete_image($value);
                }
            }
            else {
                $form_error = 'There was an error deleting the property, please try again.';
            }
        }
    }
?>