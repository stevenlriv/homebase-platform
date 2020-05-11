<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }
    
    $form_success = '';
    $form_error = '';
    $form_info = '';

    //update_profile_image($user['id_user'], $url)
    
	if ( isset($_POST['submit']) ) {

        //Verify if there is not an user with the same email, also confirm is not the same user
		if(get_user_by_email($_POST['email']) && get_user_by_email($_POST['email'])['id_user']!=$user['id_user']) {
			$form_error = 'That email address is already in use.';
		}

		if(!is_email($_POST['email'])) {
			$form_error = 'You have enter an invalid e-mail address, try again.';
        }
        
        if(empty($_POST['phone_number'])) {
            $form_error = 'You must enter your phone number.';
        }

        if(empty($_POST['fullname'])) {
            $form_error = 'You must enter your full name.';
        }

        if(empty($form_error)) { 
            if(update_profile($user['id_user'], $_POST['fullname'], $_POST['phone_number'], $_POST['email'], $_POST['profile_bio'], $_POST['profile_linkedIn'])) {
                $form_success = 'Great, your profile has been updated.';
                delete_cache('my-profile');
                header("Refresh:1");
            }
            else {
                $form_error = 'An error occurred while updating your profile, please try again.';
            }
        }

    }
    
    if ( isset($_POST['submit-image']) ) {
        if( empty($_FILES['profile_image'])) {
            $form_error = 'There is no profile image to be updated, please try again.';
        }

        if(empty($form_error)) { 
            if(profile_image($user['id_user'], $_FILES['profile_image'])){
                $form_success = 'Great, your profile image has been updated.';
                header("Refresh:1");
            }
            else {
                $form_error = 'An error occurred while updating your profile image, please try again.';
            }
        }
    }
?>