<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Send a Text Message</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Send a Text Message</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">


		<?php sidebar_component(); ?>

		<div class="col-md-8">

			<div class="row" style="margin-top: -30px;">
				<div class="col-md-12 my-profile">
					<form method="post" name="">

						<?php
							show_message($form_success, $form_error, $form_info);
						?>

						<label>Phone Number (just the phone number, no "+1" at the beginning)</label>
						<input type="number" name="phone_number">

						<label>Message</label>
						<textarea name="message"></textarea>

						<button type="submit" name="submit" class="button border margin-top-10">Send Message</button>
					</form>
				</div>

			</div>
		</div>

	</div>
</div>