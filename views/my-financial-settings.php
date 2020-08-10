<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Configuración Financiera</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Configuración Financiera</li>
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
								$form_info = 'Presione el botón "Guardar cambios" a continuación para guardar su información.';
							}

							show_message($form_success, $form_error, $form_info);
						?>

                        <h4 class="margin-top-0 margin-bottom-30">Su información bancaria</h4>

						<label>Nombre del banco</label>
						<input name="bank_name" value="<?php form_print_value($cache, $user, 'bank_name'); ?>" type="text" maxlength="255" required>

						<label>Nombre del propietario de la cuenta</label>
						<input name="bank_sole_owner" value="<?php form_print_value($cache, $user, 'bank_sole_owner'); ?>" type="text" maxlength="255" required>

						<label>Número de ruta</label>
						<input name="bank_routing_number" value="<?php form_print_value($cache, $user, 'bank_routing_number'); ?>" type="number" maxlength="255" required>

						<label>Número de cuenta</label>
						<input name="bank_account_number" value="<?php form_print_value($cache, $user, 'bank_account_number'); ?>" type="number" maxlength="255" required>

						<label>Confirmar el número de cuenta</label>
						<input name="bank_confirm_account_number" value="<?php form_print_value($cache, $user, 'bank_confirm_account_number'); ?>" type="number" maxlength="255" required>

						<button name="submit" class="button margin-top-20 margin-bottom-20">Guardar los cambios</button>
					</form>
				</div>

			</div>
		</div>

	</div>
</div>


