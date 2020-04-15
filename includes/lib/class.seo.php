<?php
if ( !defined('SCRIP_LOAD') ) { die ( header('Location: /not-found') ); }

function canonical_url($array) {
    $url = get_actual_url($array);

    echo "<link rel=\"canonical\" href=\"$url\" />\n";
}

function general_description($array) {

    if(!empty($array['description'])) {
        echo "<meta name=\"description\" content=\"{$array['description']}\">\n";
    }
}

function social_tags($array) {

    //General Tags
    echo '<meta name="twitter:site" content="'.get_setting(14).'">'."\n";
    echo '<meta property="og:site_name" content="'.get_setting(12).'" />'."\n";
    echo '<meta name="twitter:card" content="summary">'."\n";
    echo '<meta property="og:type" content="article" />'."\n";

    //Title Tags
    if(!empty($array['title'])) {
        echo '<meta name="twitter:title" content="'.$array['title'].'">'."\n";
        echo '<meta property="og:title" content="'.$array['title'].'" />'."\n";
    }

    //Description tags
    if(!empty($array['description'])) {
        echo '<meta name="twitter:description" content="'.$array['description'].'">'."\n";
    }

    //Twitter Summary card images must be at least 120x120px
    if(!empty($array['image'])) {
        // If its not a full url, we add the rest
        if (!filter_var($array['image'], FILTER_VALIDATE_URL)) {
            $array['image'] = get_domain().$array['image'];
        }

        echo '<meta name="twitter:image" content="'.$array['image'].'">'."\n";
        echo '<meta property="og:image" content="'.$array['image'].'" />'."\n";
    }

    //Url 
    echo '<meta property="og:url" content="'.get_actual_url($array).'" />'."\n";

}

function seo_title($array) {
    if ( !empty($array['extra_title']) ) { 
        echo $array['extra_title'].' &bull; '; 
    }	 
    if ( !empty($array['title']) ) { 
        echo $array['title']." &bull; "; 
    } 
    if ( $array == '404' ) {
        echo "Oops! Page not found &bull; "; 
    }

    _setting(12);
}

function print_seo($array) {
    canonical_url($array);
    general_description($array);

    social_tags($array);
}
?>