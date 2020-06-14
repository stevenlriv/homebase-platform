<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Financial Settings</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Financial Settings</li>
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
			<div class="row">


				<div class="col-md-12 my-profile">

					<form method="post" class="form-cache" name="financial-settings" id="<?php echo $cache_id; ?>">

						<?php
							if($cache && are_messages_empty()) {
								$form_info = 'Press the "Save Changes" button below to save your information.';
							}

							show_message($form_success, $form_error, $form_info);
						?>

                        <h4 class="margin-top-0 margin-bottom-30">Your Bank Information</h4>

						<label>Bank Name</label>
						<input name="bank_name" value="<?php form_print_value($cache, $user, 'bank_name'); ?>" type="text" maxlength="255" required>

						<label>Account Owner Name</label>
						<input name="bank_sole_owner" value="<?php form_print_value($cache, $user, 'bank_sole_owner'); ?>" type="text" maxlength="255" required>

						<label>Routing Number</label>
						<input name="bank_routing_number" value="<?php form_print_value($cache, $user, 'bank_routing_number'); ?>" type="number" maxlength="255" required>

						<label>Account Number</label>
						<input name="bank_account_number" value="<?php form_print_value($cache, $user, 'bank_account_number'); ?>" type="number" maxlength="255" required>

						<label>Confirm Account Number</label>
						<input name="bank_confirm_account_number" value="<?php form_print_value($cache, $user, 'bank_confirm_account_number'); ?>" type="number" maxlength="255" required>

						<button name="submit" class="button margin-top-20 margin-bottom-20">Save Changes</button>
					</form>
				</div>

			</div>
		</div>

	</div>
</div>


