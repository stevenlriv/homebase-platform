<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>All Properties</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>All Properties</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>

<!-- Contact
================================================== -->

<!-- Container -->
<div class="container">

	<div class="row">
	<div class="col-md-4 col-md-offset-4">

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40">

	<?php
        $form_error = 'Please confirm your email address to have full access to your account. <a href="/my-profile?resend=true" style="color: #274abb !important">Click here</a> to resend the confirmation email.';
        
		show_message($form_success, $form_error, $form_info);
	?>

	</div>



	</div>
	</div>

</div>
<!-- Container / End -->