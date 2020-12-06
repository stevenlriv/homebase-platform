<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Mi Perfil</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Mi Perfil</li>
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

				<!-- Show only on small devices -->
				<div class="col-md-4 hidden-md hidden-lg">
					<?php print_profile_image_form('profile_image_mobile', 'submit-image-mobile'); ?>
					<br />
				</div>

				<div class="col-md-8 my-profile">

					<form method="post" class="form-cache" name="my-profile" id="<?php echo $cache_id; ?>">

						<?php

							// Email confirmation message
							if(are_messages_empty()) {
								if($user['status']=='pending') {
									$form_error = 'Please confirm your email address to have full access to your account. If you have not received the email yet, <a href="/my-profile?resend=true" style="color: #274abb !important">click here</a> to resend it.';
								}
							}

							if($cache && are_messages_empty()) {
								$form_info = 'Presione el botón "Guardar cambios" a continuación para guardar su información.';
							}

							// Bank Account Information Message
							// Do not show message to tenants or realtors
							if(are_messages_empty() && $user['type'] != 'tenants' && $user['type'] != 'realtors' && !is_admin()) {
								if($user['bank_name']=='' || $user['bank_sole_owner']=='' || $user['bank_routing_number']=='' || $user['bank_account_number']=='') {
									$form_info = 'Recuerde configurar su información bancaria en la configuración financiera, para de esta forma poder recibir pagos.';
								}
							}

							show_message($form_success, $form_error, $form_info);
						?>

						<h4 class="margin-top-0 margin-bottom-30">Mi Cuenta</h4>

						<label>Nombre Completo</label>
						<input name="fullname" value="<?php form_print_value($cache, $user, 'fullname'); ?>" type="text">

							<!--
						<label>Primer Nombre</label>
						<input name="firstname" value="<?php form_print_value($cache, $user, 'firstname'); ?>" type="text">

						<label>Apellidos</label>
						<input name="lastname" value="<?php form_print_value($cache, $user, 'lastname'); ?>" type="text">-->

						<label>Número de licencia de conducir</label>
						<input name="driver_license" value="<?php form_print_value($cache, $user, 'driver_license'); ?>" type="number">

						<label>Teléfono</label>
						<input name="phone_number" value="<?php form_print_value($cache, $user, 'phone_number'); ?>" type="text">

						<label>Email</label>
						<input name="email" value="<?php form_print_value($cache, $user, 'email'); ?>" type="text">

						<!--<h4 class="margin-top-50 margin-bottom-25">Sobre Mi</h4>
						<textarea name="profile_bio" id="about" cols="30" rows="10"><?php form_print_value($cache, $user, 'profile_bio'); ?></textarea>-->
				
						<label>Dirección de Residencia</label>
						<input name="fs_address" value="<?php form_print_value($cache, $user, 'fs_address'); ?>" type="text">

						<label>Ciudad</label>
						<input name="city" value="<?php form_print_value($cache, $user, 'city'); ?>" type="text">

						<label>Estado (de no vivir en un estado use el nombre de su país)</label>
						<input name="fs_state" value="<?php form_print_value($cache, $user, 'fs_state'); ?>" type="text">

						<label>Código Postal</label>
						<input name="postal_code" value="<?php form_print_value($cache, $user, 'postal_code'); ?>" type="text">

						<label>País</label>
						<input name="country" value="<?php form_print_value($cache, $user, 'country'); ?>" type="text">

						<!--<h4 class="margin-top-50 margin-bottom-25"><i class="fa fa-linkedin"></i> Linkedin (opcional)</h4>

						<input name="profile_linkedIn" value="<?php form_print_value($cache, $user, 'profile_linkedIn'); ?>" type="text">-->

						<button name="submit" class="button margin-top-20 margin-bottom-20">Guardar Cambios</button>
					</form>
				</div>

				<!-- Only show on desktop -->
				<div class="col-md-4 hidden-xs hidden-sm">
					<?php print_profile_image_form('profile_image', 'submit-image'); ?>
				</div>


			</div>
		</div>

	</div>
</div>


