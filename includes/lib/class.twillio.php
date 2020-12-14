<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    use Twilio\Rest\Client;

    function send_text_message($from_phone, $to_phone, $message) {

        // Find your Account Sid and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = get_setting(33);
        $token = get_setting(34);
        $twilio = new Client($sid, $token);

        $prefix = "+1";

        //Clean numbers from prefix
        $to_phone = ltrim($to_phone, '+1');
        $from_phone = ltrim($from_phone, '+1');

        //Add Prefix
        $to_phone = $prefix.$to_phone;
        $from_phone = $prefix.$from_phone;

        if($twilio->messages->create("$to_phone", // to
                           ["body" => "$message", "from" => "$from_phone"]
                  )) {
                      return true;
                  }
        
        return false;
    }
?>