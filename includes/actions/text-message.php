<?php
    if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

	if ( isset($_POST['submit']) ) {

        if(empty($_POST['phone_number'])) {
            $form_error = 'Please indicate the phone number you are going to send the message to.';
        }

        if(empty($_POST['message'])) {
            $form_error = 'Please indicate the message you want to send.';
        }

        //Phones from twilio
        $from_phone = get_setting(32);

        if(empty($form_error)) { 
            if(send_text_message($from_phone, $_POST['phone_number'], $_POST['message'])) {
                $form_success = 'The message has been sent successfully.';
            }
            else {
                $form_error = 'There was an error sending the message.';
            }
        }

	}
?>