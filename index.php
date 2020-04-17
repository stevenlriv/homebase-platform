<?php

define('SCRIP_LOAD', true);
define('THEME_LOAD', true);

if(!is_file(__DIR__ . '/includes/configuration.php') && is_file(__DIR__ . '/includes/install.php')) {
    die( header('Location: /includes/install.php') );
}

require_once __DIR__ . '/includes/configuration.php';
require_once __DIR__ . '/includes/lib.php';

$request = $_SERVER['REQUEST_URI'];
$user = is_login_user();

if (substr_count($request, "?") > 0) {
    $pieces = explode("?", $request);
    $request = $pieces[0];
}

switch ($request) {
    case '/' :
        $seo = array(
            "description" => "Homebase is a marketplace where you can find your next home. It's easy, just take a tour and sign your lease, all online and in a few minutes.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/index.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '' :
        $seo = array(
            "description" => "Homebase is a marketplace where you can find your next home. It's easy, just take a tour and sign your lease, all online and in a few minutes.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/index.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/login' :
        if($user) {
            header('Location: /my-profile');
        }
        $seo = array(
            "title" => "Login",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/login.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/login.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/reset-password' :
        if($user) {
            header('Location: /my-profile');
        }
        $seo = array(
            "title" => "Reset Password",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/reset-password.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/reset-password.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/my-profile' :
        if(!$user) {
            header('Location: /');
        }
        $seo = array(
            "title" => "My Profile",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-profile.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/my-properties' :
        if(!$user) {
            header('Location: /');
        }
        $seo = array(
            "title" => "My Properties",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-properties.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/change-password' :
        if(!$user) {
            header('Location: /');
        }
        $seo = array(
            "title" => "Change Password",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-profile-change-password.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/logout' :
        if($user) {
            logout_user();
            header('Location: /');
        }
        else {
            header('Location: /');
        }
        break;
    case '/find-a-homebase' :
        $seo = array(
            "title" => "Search For a House",
            "description" => "Easily find your next home. Just take a tour and sign your lease, all online and in a few minutes.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/find-a-homebase.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/for-landlords' :
        $seo = array(
            "title" => "For Landlords",
            "description" => "A marketplace where everything it's easy and done for you, just add your house and get it rented, all online.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-landlords.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/for-realtors' :
        $seo = array(
            "title" => "For Realtors",
            "description" => "As realtors, you can bring clients to our platform to make their life and your life easier. And at the same time, you can earn up to $100 in extra commission.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-realtors.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/submit-property' :
        $seo = array(
            "title" => "Add a New Property",
            "description" => "",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/submit-property.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/privacy' :
        $seo = array(
            "title" => "Privacy Policy",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/privacy.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/terms' :
        $seo = array(
            "title" => "Terms of Service",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/terms.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/faq' :
        $seo = array(
            "title" => "Frequently Asked Questions",
            "description" => "We gathered some of the most frequent questions about Homebase and our answers to them.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/faq.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/contact' :
        $seo = array(
            "title" => "Contact us",
            "description" => "We’re available to help and answer any questions you may have.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/contact.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    /*
    case '/rent' :
        $seo = array(
            "title" => "Contact Us",
            "description" => "Get in touch with us easily, we will reach out to you in less than 24 hours.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/contact.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    */
    default:
        $request_strip = str_replace('/', '', trim($request));
        $listing = is_uri($request_strip);
        if($listing) {
            $seo = array(
                "title" => $listing['listing_title'],
                "description" => substr($listing['listing_description'],0,150)."...",
                "image" => get_json($listing['listing_images'], 0),
                "request" => $request,
            );
            require_once __DIR__ . '/views/header.php';
            require_once __DIR__ . '/views/listings.php';
            require_once __DIR__ . '/views/footer.php';
        }
        else {
            http_response_code(404);
            $seo = '404';
            require_once __DIR__ . '/views/header.php';
            require_once __DIR__ . '/views/404.php';
            require_once __DIR__ . '/views/footer.php';
        }
        break;
}
?>