<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Añadir Nuevo Usuario</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Añadir nuevo usuario</li>
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

					<form method="post" class="form-cache" name="my-profile">

						<?php
							show_message($form_success, $form_error, $form_info);
						?>

						<h4 class="margin-top-0 margin-bottom-30">Detalles Generales</h4>

						<label>Tipo de cuenta</label>
						<select name="type">
							<option value="landlords" selected>Landlord</option>
							<option value="tenants">Tenant</option>
							<option value="listers">Listers</option>
						</select>

						<label>Nombre Completo</label>
						<input name="fullname" value="" type="text">

						<label>Número de licencia de conducir</label>
						<input name="driver_license" value="" type="number">

						<label>Teléfono</label>
						<input name="phone_number" value="" type="text">

						<label>Email</label>
						<input name="email" value="" type="text">

						<label>Dirección de Residencia</label>
						<input name="fs_address" value="" type="text">

						<label>Ciudad</label>
						<input name="city" value="" type="text">

						<label>Estado (de no vivir en un estado use el nombre de su país)</label>
						<input name="fs_state" value="" type="text">

						<label>Código Postal</label>
						<input name="postal_code" value="" type="text">

						<label>País</label>
						<input name="country" value="" type="text">

                        <br />
                            <br />

                        <h4 class="margin-top-0 margin-bottom-30">Información Bancaria</h4>

						<label>Nombre del banco (opcional)</label>
						<input name="bank_name" value="" type="text" maxlength="255">

						<label>Nombre del propietario de la cuenta (opcional)</label>
						<input name="bank_sole_owner" value="" type="text" maxlength="255">

						<label>Número de ruta (opcional)</label>
						<input name="bank_routing_number" value="" type="number" maxlength="255">

						<label>Número de cuenta (opcional)</label>
						<input name="bank_account_number" value="" type="number" maxlength="255">

						<label>Confirmar el número de cuenta (opcional)</label>
						<input name="bank_confirm_account_number" value="" type="number" maxlength="255">

						<label>Lenguaje de Preferencia</label>
						<select name="preferred_lang">
							<?php
								foreach(return_supported_languages() as $id => $value) {
									echo '<option value="'.$value['code'].'"';
									if($value['code']==$user['preferred_lang']) echo ' selected';
									echo '>'.$value['name'].'</option>';
								}
							?>
						</select>

						<button name="submit" class="button margin-top-20 margin-bottom-20">Crear Usuario</button>
					</form>
				</div>

			</div>
		</div>

	</div>
</div>


