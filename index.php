<?php

define('SCRIP_LOAD', true);
define('THEME_LOAD', true);


// Verify if there is an installation file
if(!is_file(__DIR__ . '/includes/configuration.php') && is_file(__DIR__ . '/includes/install.php')) {
    die( header('Location: /includes/install.php') );
}


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
            "description" => "Homebase es un mercado donde puedes encontrar tu próximo hogar. Es fácil, sólo haz un recorrido y firma tu contrato de arrendamiento, todo en línea y en unos pocos minutos.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/index.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '' :
        $seo = array(
            "description" => "Homebase es un mercado donde puedes encontrar tu próximo hogar. Es fácil, sólo haz un recorrido y firma tu contrato de arrendamiento, todo en línea y en unos pocos minutos.",
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
            "title" => "Ingresa en",
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
        
        if($_GET['type'] == 'landlords' || $_GET['type'] == 'listers' || $_GET['type'] == 'tenants') {
            $type = $_GET['type'];
        }

        $seo = array(
            "title" => "Registrarse",
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
            "title" => "Restablecer la contraseña",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/reset-password.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/reset-password.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/confirm' :
        $seo = array(
            "title" => "Confirmación de la cuenta",
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
            "title" => "Actualización de la plataforma",
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
            "title" => "Mi perfil",
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
            "title" => "Usar el perfil",
            "request" => $request,
        );
        
        require_once __DIR__ . '/includes/actions/listing-search.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/user-profile.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/edit-user' :
        // Only allow admins to edit users
        $view_user = get_user_by_id($_GET['id']);

        if(!$user || !is_admin() || !$view_user) {
            header('Location: /');
        }
        $seo = array(
            "title" => "Editar el usuario",
            "request" => $request,
        );
        
        require_once __DIR__ . '/includes/actions/admin-edit-profile.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/admin-edit-profile.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/financial-settings' :
        // Also don't allow admins or realtors, because they will be able to setup their bank info per lease
        if(!$user || $user['type'] == 'realtors' || is_admin()) {
            header('Location: /');
        }
        $seo = array(
            "title" => "Ajustes financieros",
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
            "title" => "Mis propiedades",
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
    case '/all-users' :
        if(!is_admin()) {
            header('Location: /');
        }
        $seo = array(
            "title" => "Todos los usuarios",
            "request" => $request,
        );

        require_once __DIR__ . '/includes/actions/all-users.php';
        require_once __DIR__ . '/includes/actions/all-users-search.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/all-users.php';
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
            "title" => "Cambiar la contraseña",
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
            "title" => "Editar la propiedad",
            "description" => "",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/submit-property.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/submit-property.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/submit-property' :
        //The user needs to be logged in and it cannot be a tenant or lister
        if(!$user || $user['type'] == 'tenants' || $user['type'] == 'listers') {
            header('Location: /');
        }

        $seo = array(
            "title" => "Añadir una nueva propiedad",
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
            "title" => "Buscar una casa",
            "description" => "Encontrar fácilmente su próximo hogar. Sólo haga un recorrido y firme su contrato de arrendamiento, todo en línea y en unos pocos minutos.",
            "request" => $request,
        );
        require_once __DIR__ . '/includes/actions/listing-search.php';
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/find-a-homebase.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/make-money' :
        $seo = array(
            "title" => "Ganar dinero",
            "description" => "Nunca ha sido más fácil hacer dinero con los bienes raíces. Cero inversión y todo en línea.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-listers.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/list-your-home' :
        $seo = array(
            "title" => "Para los propietarios",
            "description" => "Un mercado en el que todo es fácil y está hecho para ti, sólo tienes que añadir tu casa y alquilarla rápidamente, todo en línea.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/for-landlords.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/privacy' :
        $seo = array(
            "title" => "Política de privacidad",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/privacy.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/terms' :
        $seo = array(
            "title" => "Condiciones de servicio",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/terms.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/faq' :
        $seo = array(
            "title" => "Preguntas frecuentes",
            "description" => "Hemos reunido algunas de las preguntas más frecuentes sobre Homebase y nuestras respuestas a ellas.",
            "request" => $request,
        );
        require_once __DIR__ . '/views/header.php';
        require_once __DIR__ . '/views/faq.php';
        require_once __DIR__ . '/views/footer.php';
        break;
    case '/contact' :
        $seo = array(
            "title" => "Contáctanos",
            "description" => "Estamos disponibles para ayudar y responder a cualquier pregunta que pueda tener.",
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