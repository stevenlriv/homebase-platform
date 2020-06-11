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
<link rel="apple-touch-icon" sizes="180x180" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/favicon-16x16.png">
<link rel="manifest" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/site.webmanifest">
<link rel="mask-icon" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/safari-pinned-tab.svg" color="#274abb">
<link rel="shortcut icon" href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/favicon/browserconfig.xml">
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
					<a href="/"><img src="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/homebase-logo-2.png" alt="Homebase"></a>
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

						<li><a <?php if($request == '/find-a-homebase' || !empty($listing)) echo 'class="current"'; ?> href="/find-a-homebase">Search Homes</a></li>

						<li><a <?php if($request == '/list-your-home') echo 'class="current"'; ?> href="/list-your-home">List Your Home</a></li>

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

					<?php
						if($user) {
							$name = explode(" ", $user['fullname'])[0];
					?>

					<!-- User Menu -->
					<div class="user-menu">
						<div class="user-name"><span><img src="<?php if(!empty($user['profile_image'])) { echo $user['profile_image']; } else { echo 'https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/agent-03.jpg'; }; ?>" alt=""></span><?php if(!empty($name)) { echo 'Hi, '.$name.'!'; } else { echo 'Hi, cool user!'; }; ?></div>
						<ul>
							<li><a href="/my-profile"><i class="sl sl-icon-user"></i> My Profile</a></li>

							<li><a href="/my-properties"><i class="sl sl-icon-docs"></i>
								<?php
									if($user['type'] == 'tenants') {
										echo 'My Property';
									}
									elseif($user['type'] == 'listers') {
										echo 'Properties';
									}
									else {
										echo 'My Properties';
									}
								?>
							</a></li>
							 
							<li><a href="/logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
						</ul>
					</div>

					<?php
						}
						else {
					?>

					<a href="/login" class="sign-in"><i class="fa fa-user"></i> Log In </a>

					<?php
						}
					?>

					<?php
						//If the user is logged in, Hide from tenants and listers
						if(!empty($user) && $user['type'] != 'tenants' && $user['type'] != 'listers') {
							echo '<a href="/submit-property" class="button border">Submit Property</a>';
						}
						else {
							echo '<a href="/register" class="button border">Register</a>';
						}
					?>
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