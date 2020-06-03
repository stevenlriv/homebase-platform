<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

    function get_referral_cookie() {
        
        if(get_cookie('USRF')) {
			$cookie = get_cookie ( 'USRF' );
            $pieces = explode('|', $cookie); // [0] = fullname, [1] = id_user_referral
            
            return $pieces;
        }

        return false;
    }

    function establish_referral() {

        //?ref=
        if(!empty($_GET['ref'])) {

            // Lets verify if a user exists with that referral id
            $user = get_user_by_referral($_GET['ref']);

            if($user) {
                // We verify if a referral cookie is not active
                // We create a cookie with the user referral id for 30 days, that way we now whom referred the user first
                if(!get_cookie('USRF')) {
                    new_cookie('USRF', $user['fullname'].'|'.$user['id_user_referral'], time()+60*60*24*30);
                    return true;
                }
            }
        }

        return false;
    }
?>