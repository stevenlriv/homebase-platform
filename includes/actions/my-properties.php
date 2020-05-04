<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    $form_success = '';
    $form_error = '';

    //You will need to verify the allowed actions and that that user has permission to manipulate that listings
    //Admins has all permisions for that

    ////////////////// HIDE ////////////////// 

    if(!empty($_GET['hide']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_listing_by_uri_id($_GET['hide'])) {
        $listing = is_listing_by_uri_id($_GET['hide']);

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
    
    if(!empty($_GET['show']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_listing_by_uri_id($_GET['show'])) {
        $listing = is_listing_by_uri_id($_GET['show']);

        if(user_has_access_listing($listing) && $listing['status']!='active') {
            if(update_visibilty($listing['id_listing'], 'show')) {
                $form_success = 'The property was enabled successfully.';
            }
            else {
                $form_error = 'There was an error enabling the property, please try again.';
            }
        }
    }
    
    ////////////////// DELETE ////////////////// 
    
    if(!empty($_GET['delete']) && !empty($_GET['confirm']) && $_GET['confirm'] == 'true' && is_listing_by_uri_id($_GET['delete'])) {
        $listing = is_listing_by_uri_id($_GET['delete']);

        if(user_has_access_listing($listing)) {
            if(delete_listing($listing['id_listing'])) {
                $form_success = 'The property was deleted successfully.';
            }
            else {
                $form_error = 'There was an error deleting the property, please try again.';
            }
        }
    }
?>