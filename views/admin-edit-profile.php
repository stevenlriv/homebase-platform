<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Editar Usuario</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Editar Usuario</li>
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
                    <?php 
                        //true = use of view use var
                        print_profile_image_form('profile_image_mobile', 'submit-image-mobile', true); ?>
					<br />
				</div>

				<div class="col-md-8 my-profile">

					<form method="post" class="form-cache" name="my-profile">

						<?php
							show_message($form_success, $form_error, $form_info);
						?>

						<h4 class="margin-top-0 margin-bottom-30">Mi Cuenta</h4>

						<label>Nombre Completo</label>
						<input name="fullname" value="<?php echo $view_user['fullname']; ?>" type="text">

						<label>Número de licencia de conducir</label>
						<input name="driver_license" value="<?php echo $view_user['driver_license']; ?>" type="number">

						<label>Teléfono</label>
						<input name="phone_number" value="<?php echo $view_user['phone_number']; ?>" type="text">

						<label>Email</label>
						<input name="email" value="<?php echo $view_user['email']; ?>" type="text">
				
						<label>Dirección de Residencia</label>
						<input name="fs_address" value="<?php echo $view_user['fs_address']; ?>" type="text">

						<label>Ciudad</label>
						<input name="city" value="<?php echo $view_user['city']; ?>" type="text">

						<label>Estado (de no vivir en un estado use el nombre de su país)</label>
						<input name="fs_state" value="<?php echo $view_user['fs_state']; ?>" type="text">

						<label>Código Postal</label>
						<input name="postal_code" value="<?php echo $view_user['postal_code']; ?>" type="text">

						<label>País</label>
						<input name="country" value="<?php echo $view_user['country']; ?>" type="text">

						<label>Lenguaje de Preferencia</label>
						<select name="preferred_lang">
							<?php
								foreach(return_supported_languages() as $id => $value) {
									echo '<option value="'.$value['code'].'"';
									if($value['code']==$view_user['preferred_lang']) echo ' selected';
									echo '>'.$value['name'].'</option>';
								}
							?>
						</select>

						<button name="submit" class="button margin-top-20 margin-bottom-20">Guardar Cambios</button>
					</form>
				</div>

				<!-- Only show on desktop -->
				<div class="col-md-4 hidden-xs hidden-sm">
                    <?php 
                        //true = use of view_user var
                        print_profile_image_form('profile_image', 'submit-image', true); ?>
				</div>


			</div>
		</div>

	</div>
</div>


