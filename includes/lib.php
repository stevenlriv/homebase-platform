<?php
	require_once ( 'vendor/autoload.php' );

	require_once ( dirname(__FILE__).'/lib/class.functions.php' );
	require_once ( dirname(__FILE__).'/lib/class.settings.php' );
	require_once ( dirname(__FILE__).'/lib/class.cookies.php' );
	require_once ( dirname(__FILE__).'/lib/class.cache.php' );
	require_once ( dirname(__FILE__).'/lib/class.users.php' );
	require_once ( dirname(__FILE__).'/lib/class.lister.php' );
	require_once ( dirname(__FILE__).'/lib/class.email.php' );
	require_once ( dirname(__FILE__).'/lib/class.theme.php' );

	require_once ( dirname(__FILE__).'/lib/class.listings.php' );
	require_once ( dirname(__FILE__).'/lib/class.location.php' );
	require_once ( dirname(__FILE__).'/lib/class.seo.php' );
	require_once ( dirname(__FILE__).'/lib/class.pagination.php' );
	require_once ( dirname(__FILE__).'/lib/class.images.php' );
	require_once ( dirname(__FILE__).'/lib/class.dropzone.php' );

    if(is_production_enviroment()) { ini_set('display_errors','off'); }
?>
