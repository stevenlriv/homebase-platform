<?php

define('SCRIP_LOAD', true);
define('THEME_LOAD', true);

// Include the required libraries
require_once __DIR__ . '/includes/configuration.php';
require_once __DIR__ . '/includes/lib.php';

// Get the referral URL
establish_referral();

// Establish blank messages
$form_success = '';
$form_error = '';
$form_info = '';

$request = $_SERVER['REQUEST_URI'];
$user = is_login_user();

// We separate the $_GET from the real url
if (substr_count($request, "?") > 0) {
    $pieces = explode("?", $request);
    $request = $pieces[0];
}

// We verify if there are platform upgrade
if(get_setting(23) == 'true' && $user && $request != '/upgrade') {
    header('Location: /upgrade');
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
    case '/register' :
        if($user) {
            header('Location: /my-profile');
        }

        $type = '';
        if(empty($_GET['type'])) {
            $_GET['type'] = '';
        }
        
        if($_GET['type'] == 'landlords' || $_GET['type'] == 'realtors' || $_GET['type'] == 'listers' || $_GET['type'] == 'tenants') {
            $type = $_GET['type'];
        }

        //There are a couple of accounts that are not available at this moment: tenants
        if($type == 'tenants'){
            header('Location: /contact?inquiry=tenant');
        }

        $seo = array(
            "title" => "Register",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/register.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/register.php';
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
    case '/confirm' :
        $seo = array(
            "title" => "Account Confirmation",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/confirm-account.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/confirm-account.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/upgrade' :
        if(get_setting(23) == 'false' || !$user) {
            header('Location: /my-profile');
        }

        $seo = array(
            "title" => "Platform Upgrade",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/platform-upgrade.php';
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
        require_once __DIR__ . '/includes/actions/my-profile.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-profile.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/profile' :
        // Only allow admins to view users profiles for now
        $view_user = get_user_by_id($_GET['id']);

        if(!$user || !is_admin() || !$view_user) {
            header('Location: /');
        }
        $seo = array(
            "title" => "Use profile",
            "request" => $request,
        );
        
        require_once __DIR__ . '/includes/actions/listing-search.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/user-profile.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/financial-settings' :
        // Don't allow tenants to edit bank information, their payments are managed with PandaDocs
        // Also don't allow admins
        if(!$user || $user['type'] == 'tenants' || is_admin()) {
            header('Location: /');
        }
        $seo = array(
            "title" => "Financial Settings",
            "request" => $request,
        );

        require_once __DIR__ . '/includes/actions/my-financial-settings.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-financial-settings.php';
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

        //Hide Property Actions For Tenants and Listers
        if($user['type'] != 'tenants' && $user['type'] != 'listers') {
            require_once __DIR__ . '/includes/actions/my-properties.php';
        }
        
        require_once __DIR__ . '/includes/actions/listing-search.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-properties.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/draft' :
        if(!$user || empty($_GET['uri'])) {
            header('Location: /');
        }

        $listing = is_uri($_GET['uri'], true);

        // We verify the listing exists and that the user has access
        if(!$listing || !user_has_access_listing($listing)) {
            header('Location: /my-properties');
        }
        
        $seo = array(
            "title" => $listing['listing_title'],
            "description" => substr($listing['listing_description'],0,150)."...",
            "image" => get_json($listing['listing_images'], 0),
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/listings.php';
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
        require_once __DIR__ . '/includes/actions/change-password.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/my-profile-change-password.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/edit-property' :
        //The user needs to be logged in and it cannot be a tenant or lister
        if(!$user || $user['type'] == 'tenants' || $user['type'] == 'listers') {
            header('Location: /');
        }

        //If is an admin allow him access every property don't matter the status
        if( is_admin() ) {
            $listing = is_uri($_GET['q'], true);
        }
        else {
            $listing = is_uri($_GET['q']);
        }

        //Verify if property exists and that the user has access
        if(!$listing || !user_has_access_listing($listing)) {
            header('Location: /my-properties');
        }

        $seo = array(
            "title" => "Edit Property",
            "description" => "",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/submit-property.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/submit-property.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/submit-property' :
        //Submit property has a section for logged in users and non logged in users
        //But if the logged in user is a tenant or lister, we don't allow him access to the page
        if($user && $user['type'] == 'tenants' || $user && $user['type'] == 'listers') {
            header('Location: /my-profile');
        }

        $seo = array(
            "title" => "Add a New Property",
            "description" => "",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/submit-property.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/submit-property.php';
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
        require_once __DIR__ . '/includes/actions/listing-search.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/find-a-homebase.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/for-listers' :
        $seo = array(
            "title" => "For Listers",
            "description" => "It has never been easier to make money with real estate. Cero investment and all online.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-listers.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/for-landlords' :
        $seo = array(
            "title" => "For Landlords",
            "description" => "A marketplace where everything it's easy and done for you, just add your house and get it rented quickly, all online.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-landlords.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/for-realtors' :
        $seo = array(
            "title" => "For Realtors",
            "description" => "As realtors, you can bring clients to our platform to make their life and your life easier.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-realtors.php';
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