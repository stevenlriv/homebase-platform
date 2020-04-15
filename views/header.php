<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!DOCTYPE html>
<head>

<!-- Basic Page Needs
================================================== -->
<title><?php echo seo_title($seo); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SEO
================================================== -->
<?php 
	if($seo == '404') {
		echo '<meta name="robots" content="noindex, follow">';
		echo '<meta name="googlebot" content="noindex, follow">';
	} 
	else {
		print_seo($seo);
	}
?>

<!-- CSS
================================================== -->
<link rel="stylesheet" href="/views/assets/css/style.css">
<link rel="stylesheet" href="/views/assets/css/color.css">

<!-- FAVICON
================================================== -->
<link rel="apple-touch-icon" sizes="180x180" href="/views/assets/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/views/assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/views/assets/favicon/favicon-16x16.png">
<link rel="manifest" href="/views/assets/favicon/site.webmanifest">
<link rel="mask-icon" href="/views/assets/favicon/safari-pinned-tab.svg" color="#274abb">
<link rel="shortcut icon" href="/views/assets/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/views/assets/favicon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

</head>

<body <?php if($request == '/find-a-homebase') echo 'class="overflow-hidden"'; ?>>

<!-- Wrapper -->
<div id="wrapper">


<!-- Header Container
================================================== -->
<header id="header-container" <?php if($request == '/find-a-homebase') echo 'class="fullwidth"'; ?>>

	<!-- Topbar -->
	<div id="top-bar">
		<div class="container">

			<!-- Left Side Content -->
			<div class="left-side">

				<!-- Top bar -->
				<ul class="top-bar-menu">
				</ul>

			</div>
			<!-- Left Side Content / End -->


			<!-- Left Side Content -->
			<div class="right-side">

				<!-- Social Icons -->
				<ul class="social-icons">
				</ul>

			</div>
			<!-- Left Side Content / End -->

		</div>
	</div>
	<div class="clearfix"></div>
	<!-- Topbar / End -->
	
	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href="/"><img src="/views/assets/images/homebase-logo-2.png" alt="Homebase"></a>
				</div>


				<!-- Mobile Navigation -->
				<div class="mmenu-trigger">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</div>


				<!-- Main Navigation -->
				<nav id="navigation" class="style-1">
					<ul id="responsive">

						<li><a <?php if($request == '/find-a-homebase' || !empty($listing)) echo 'class="current"'; ?> href="/find-a-homebase">Find a Homebase</a></li>

						<li><a <?php if($request == '/for-landlords') echo 'class="current"'; ?> href="/for-landlords">For Landlords</a></li>

						<li><a <?php if($request == '/for-realtors') echo 'class="current"'; ?> href="/for-realtors">For Realtors</a></li>

					</ul>
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->

			<!-- Right Side Content / End -->
			<div class="right-side">
				<!-- Header Widget -->
				<div class="header-widget">
					<a href="/account" class="sign-in"><i class="fa fa-user"></i> Log In </a>
					<a href="/submit-property" class="button border">Submit Property</a>
				</div>
				<!-- Header Widget / End -->
			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->