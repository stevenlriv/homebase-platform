<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Reset Password</h2>
				
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Reset Password</li>
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
		show_message($form_success, $form_error);
	?>

		<div class="tabs-container alt">
			<!-- Login -->
				<form method="post" class="login">

				<?php
					if($approved_to_reset) {
	
						if(empty($form_success) && empty($form_error)) {
				?>
					<div class="notification notice closeable">
						<p>You might enter your new password now. Password must contain a minimum of 12 characters.</p>
					</div>
				<?php
						}
				?>

					<p class="form-row form-row-wide">
						<label for="username">New Password:
							<i class="im im-icon-Lock-User"></i>
							<input type="password" class="input-text" name="password" id="password" value="" required="required" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="username">Confirm Password:
							<i class="im im-icon-Repeat-3"></i>
							<input type="password" class="input-text" name="confirm" id="confirm" value="" required="required" />
						</label>
					</p>

				<?php
					}
					else {
				?>
					<p class="form-row form-row-wide">
						<label for="username">Email:
							<i class="im im-icon-Male"></i>
							<input type="email" class="input-text" name="email" id="username" value="" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
						</label>
					</p>
				<?php
					}
				?>

					<p class="form-row">
						<input type="submit" class="button border margin-top-10" name="reset-submit" value="Reset Password" />
					</p>
					
				</form>

		</div>
	</div>



	</div>
	</div>

</div>
<!-- Container / End -->