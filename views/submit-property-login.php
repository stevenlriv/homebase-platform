<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	//Cache settings
	if(!empty($listing)) {
		$form_cache_id = $_SESSION['CACHE_ID_LISTING'];
		$cache = get_cache($form_cache_id);

		$form_cache_img_id = $_SESSION['CACHE_IMG_LISTING'];
		$cache_img = get_cache($form_cache_img_id);
	}
	else {
		$form_cache_id = $_SESSION['CACHE_ID_LISTING'];
		$cache = get_cache($_SESSION['CACHE_ID_LISTING']);

		$form_cache_img_id = $_SESSION['CACHE_IMG_LISTING'];
		$cache_img = get_cache($form_cache_img_id);		

		$listing = ''; //to indicate we are not editing a listing
	}
?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="submit-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

			<?php
				if(!empty($listing)) {
			?>
				<h2><i class="fa fa-edit"></i> <a href="/<?php echo $listing['uri']; ?>" target="_blank">Edita Propiedad - <?php echo $listing['listing_title']; ?></a> </h2>
			<?php
				}
				else {
			?>
				<h2><i class="fa fa-plus-circle"></i> Añadir propiedad</h2>
			<?php
				}			
			?>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
<div class="row">

	<!-- Submit Page -->
	<div class="col-md-12">
		<div class="submit-page">

		<?php
			if($cache && are_messages_empty() || $cache_img && are_messages_empty()) {
				if(!empty($listing)) {
					$form_info = 'Parece que tienes algunos cambios pendientes. Presiona el botón "Guardar cambios" a continuación para guardar tus cambios.';
				}
				else {
					$form_info = 'Parece que tienes una lista de borradores. Presione el botón "Agregar nuevo" abajo para agregar su nueva propiedad.';
				}
			}

			show_message($form_success, $form_error, $form_info, true);
		?>

		<?php dropzone_box('Fotos', 'dropzone-listing', 'galery-content'); ?>

		<?php //dropzone_box('Access Images', 'dropzone-checkin', 'checkin-content', 'col-md-12', '/images-checkin.php'); ?>

		<form method="post" enctype="multipart/form-data" class="form-cache" name="submit-property" id="<?php echo $form_cache_id; ?>">

		<!-- Section -->
		<h3>Información Básica</h3>
		<div class="submit-section">

			<!-- Title -->
			<div class="form">
				<h5>Título de la propiedad <i class="tip" data-tip-content="Escriba el título limpio que también contiene una característica única de su propiedad (por ejemplo, renovada, con aire acondicionado). Límite de 40 caracteres. No haga títulos como 2 cama/1 baño, cama y baño siempre se indican cuando mostramos los listados."></i></h5>
				<input name="listing_title" class="search-field" type="text" value="<?php form_print_value($cache, $listing, 'listing_title'); ?>" maxlength="40"/>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<!-- Type -->
				<div class="col-md-6">
					<h5>Tipo</h5>
					<select name="type" class="chosen-select-no-single">
						<option label="Seleccione una opción"></option>		
						<option <?php if(form_get_value($cache, $listing, 'type') == 'apartment') echo 'selected="selected"' ?> value="apartment">Apartamento</option>
						<option <?php if(form_get_value($cache, $listing, 'type') == 'house') echo 'selected="selected"' ?> value="house">Casa</option>
					</select>
				</div>

				<!-- Area -->
				<div class="col-md-6">
					<h5>Area <i class="tip" data-tip-content="El tamaño de la propiedad en pies cuadrados"></i></h5>
					<div class="select-input disabled-first-option">
						<input name="square_feet" value="<?php form_print_value($cache, $listing, 'square_feet'); ?>" type="number" data-unit="Sq Ft">
					</div>
				</div>
			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<!-- Beds -->
				<div class="col-md-6">
					<h5>Cuartos</h5>
					<select name="number_rooms" class="chosen-select-no-single">
						<option label="Seleccione una opción"></option>	
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 1) echo 'selected="selected"' ?> value="1">1</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 2) echo 'selected="selected"' ?> value="2">2</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 3) echo 'selected="selected"' ?> value="3">3</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 4) echo 'selected="selected"' ?> value="4">4</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 5) echo 'selected="selected"' ?> value="5">5</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 6) echo 'selected="selected"' ?> value="6">6</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 7) echo 'selected="selected"' ?> value="7">7</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 8) echo 'selected="selected"' ?> value="8">8</option>
					</select>
				</div>

				<!-- Baths -->
				<div class="col-md-6">
					<h5>Baños</h5>
					<select name="number_bathroom" class="chosen-select-no-single">
						<option label="Seleccione una opción"></option>	
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 1) echo 'selected="selected"' ?> value="1">1</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 1.5) echo 'selected="selected"' ?> value="1.5">1.5</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 2) echo 'selected="selected"' ?> value="2">2</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 2.5) echo 'selected="selected"' ?> value="2.5">2.5</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 3) echo 'selected="selected"' ?> value="3">3</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 3.5) echo 'selected="selected"' ?> value="3.5">3.5</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 4) echo 'selected="selected"' ?> value="4">4</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 4.5) echo 'selected="selected"' ?> value="4.5">4.5</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 5) echo 'selected="selected"' ?> value="5">5</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 5.5) echo 'selected="selected"' ?> value="5.5">5.5</option>
					</select>
				</div>

			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<!-- Price -->
				<div class="col-md-6">
					<h5>Renta Mensual <i class="tip" data-tip-content="El alquiler mensual de la propiedad"></i></h5>
					<div class="select-input disabled-first-option">
						<input name="monthly_house_original" value="<?php form_print_value($cache, $listing, 'monthly_house_original'); //we always get the original value ?>" type="number" data-unit="USD">
					</div>
				</div>

				<!-- Price -->
				<div class="col-md-6">
					<h5>Deposito de Seguridad <i class="tip" data-tip-content="Depósito de propiedad. Puede ser $0 si desea."></i></h5>
					<div class="select-input disabled-first-option">
						<input name="deposit_house_original" value="<?php form_print_value($cache, $listing, 'deposit_house_original'); ?>" type="number" data-unit="USD">
					</div>
				</div>

			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">
				<!-- Price -->
				<div class="col-md-6">
					<h5>Homebase Listing Rent <i class="tip" data-tip-content="This is the price your property will be listed at Homebase. Currently is a <?php echo get_setting(26)*100; ?>% markup rounded up to the nearest 10."></i></h5>
					<div class="select-input disabled-first-option">
						<input name="monthly_house_homebase" value="" type="number" data-unit="USD">
					</div>
				</div>

				<!-- Price -->
				<div class="col-md-6">
					<h5>Homebase Listing Deposit <i class="tip" data-tip-content="This is the deposit amount your property will be listed at Homebase. Currently is a <?php echo get_setting(26)*100; ?>% markup rounded up to the nearest 10."></i></h5>
					<div class="select-input disabled-first-option">
						<input name="deposit_house_homebase" value="" type="number" data-unit="USD">
					</div>
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->

		<h3>Específicas</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Address -->
				<div class="col-md-12">
					<h5>Dirección postal completa <i>(opcional)</i> <i class="tip" data-tip-content="Si la propiedad puede recibir correo, agregue la imagen de la dirección postal completa incluyendo el país, estado y código postal. Sólo se mostrará al usuario una vez que firme el contrato de arrendamiento."></i></h5>
					<input name="postal_address" type="text" value="<?php form_print_value($cache, $listing, 'postal_address'); ?>">
				</div>

				<div class="col-md-12">
					<h5>Disponibilidad <i class="tip" data-tip-content="¿Cuándo está disponible la propiedad para empezar a ser alquilada?"></i></h5>
					<input name="available" type="text" id="date-picker-property-form" placeholder="Date" value="<?php 
						// More info on the bug read "views/footer.php" and "lib/class.theme.php"
						$cache_bug_js_fix = true; 
						if( !empty($cache) || !empty($listing) ) { 
							if(is_numeric(form_get_value($cache, $listing, 'available'))) {
								echo date("m/d/Y", form_get_value($cache, $listing, 'available')); 
							}
							else {
								form_print_value($cache, $listing, 'available'); 
							}
						} 
						else { 
							echo date("m/d/Y"); 
						} ?>" required>
				</div>

			</div>

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-12">

				<!-- Checkboxes -->
				<h5 class="margin-top-30">¿Qué está incluido? <i class="tip" data-tip-content="Seleccione todo lo que está incluido en la propiedad"></i></h5>
				<div class="checkboxes in-row margin-bottom-20">

					<input name="electricity" type="checkbox" id="check-1" <?php if(form_get_value($cache, $listing, 'electricity') == '1') echo 'checked' ?> value="1">
					<label for="check-1">Electricidad</label>

					<input name="water" type="checkbox" id="check-2" <?php if(form_get_value($cache, $listing, 'water') == '1') echo 'checked' ?> value="1">
					<label for="check-2">Agua</label>

					<input name="furnished" type="checkbox" id="check-3" <?php if(form_get_value($cache, $listing, 'furnished') == '1') echo 'checked' ?> value="1">
					<label for="check-3">Amueblado</label>

					<input name="parking" type="checkbox" id="check-4" <?php if(form_get_value($cache, $listing, 'parking') == '1') echo 'checked' ?> value="1">
					<label for="check-4">Parking</label>	

					<input name="wifi" type="checkbox" id="check-5" <?php if(form_get_value($cache, $listing, 'wifi') == '1') echo 'checked' ?> value="1">
					<label for="check-5">Wifi</label>

					<input name="alarm" type="checkbox" id="check-6" <?php if(form_get_value($cache, $listing, 'alarm') == '1') echo 'checked' ?> value="1">
					<label for="check-6">Alarma</label>

					<input name="laundry_room" type="checkbox" id="check-7" <?php if(form_get_value($cache, $listing, 'laundry_room') == '1') echo 'checked' ?> value="1">
					<label for="check-7">Laundry Room</label>
		
				</div>

				<div class="checkboxes in-row margin-bottom-20">
		
					<input name="air_conditioning" type="checkbox" id="check-8" <?php if(form_get_value($cache, $listing, 'air_conditioning') == '1') echo 'checked' ?> value="1">
					<label for="check-8">Aire Acondicionado</label>

					<input name="gym" type="checkbox" id="check-9" <?php if(form_get_value($cache, $listing, 'gym') == '1') echo 'checked' ?> value="1">
					<label for="check-9">Gym</label>

					<input name="swimming_pool" type="checkbox" id="check-10" <?php if(form_get_value($cache, $listing, 'swimming_pool') == '1') echo 'checked' ?> value="1">
					<label for="check-10">Piscina</label>

					<input name="pets" type="checkbox" id="check-11" <?php if(form_get_value($cache, $listing, 'pets') == '1') echo 'checked' ?> value="1">
					<label for="check-11">Macotas Permitidad?</label>

					<input name="smoking" type="checkbox" id="check-12" <?php if(form_get_value($cache, $listing, 'smoking') == '1') echo 'checked' ?> value="1">
					<label for="check-12">Fumar permitido?</label>
		
				</div>
				<!-- Checkboxes / End -->
				</div>
			</div>

		</div>

		<!-- Section / End -->

		<!-- Section -->
		<h3>Ubicación</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Address -->
				<div class="col-md-12">
					<h5>Dirección física</h5>
					<input name="physical_address" type="text" value="<?php form_print_value($cache, $listing, 'physical_address'); ?>">
				</div>

				<!-- Country -->
				<div class="col-md-6">
					<h5>País</h5>
					<input name="country" type="text" value="<?php form_print_value($cache, $listing, 'country'); ?>">
				</div>

				<!-- State -->
				<div class="col-md-6" id="state">
					<h5>Estado</h5>
					<input name="state" type="text" value="<?php form_print_value($cache, $listing, 'state'); ?>">
				</div>

				<!-- City -->
				<div class="col-md-6">
					<h5>Ciudad</h5>
					<input name="city" type="text" value="<?php form_print_value($cache, $listing, 'city'); ?>">
				</div>

				<!-- Zip-Code -->
				<div class="col-md-6">
					<h5>Código Postal</h5>
					<input name="zipcode" type="text" value="<?php form_print_value($cache, $listing, 'zipcode'); ?>">
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->

		<!-- Section -->
		<h3>Información detallada</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Description -->
				<div class="col-md-12">
					<h5>Descripción <i class="tip" data-tip-content="Venda su propiedad, describa cómo se ve y qué podrían obtener"></i></h5>
					<textarea name="listing_description" class="WYSIWYG" cols="40" rows="3" id="summary" spellcheck="true"><?php form_print_value($cache, $listing, 'listing_description'); ?></textarea>
				</div>

				<div class="col-md-12">
					<h5>Palabras cláves para busquedas <i class="tip" data-tip-content="Añada palabras clave separadas por coma, que crea que un inquilino buscaría un ejemplo sería el nombre de un restaurante o un mural cerca de la propiedad. Limite 100 caracteres."></i></h5>
					<input name="keywords" id="keywords" type="text" value="<?php form_print_value($cache, $listing, 'keywords'); ?>" maxlength="100">
				</div>

			</div>

		</div>
		<!-- Section / End -->

		<?php dropzone_form('galery-section'); ?>
		
		<!-- Section -->
		<?php
			if(is_admin()) {
		?>
		<h3><span style="color: red;">Admin Settings</span></h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Name -->
				<div class="col-md-12">
					<?php //show_message('', '', 'A property access code is a simple way to allow for remote access to potential tenants. We call this "self-guided tours" and this is how you will be able to handle more properties and tenants request. It usually means the code to a lockbox near your house or the code of a pin pad in your front door. For more information about this, contact us at <a href="mailto:'.get_setting(1).'" style="color: red !important;">'.get_setting(1).'</a>.'); ?>
				</div>

				<!--<div class="col-md-12">
					<h5>Property Access Code <i class="tip" data-tip-content="Access code so the tenant can enter when doing a non-guided tour"></i></h5>
					<input name="checkin_access_code" type="text" value="<?php form_print_value($cache, $listing, 'checkin_access_code'); ?>">
				</div>-->

				<!-- Description -->
				<!--<div class="col-md-12">
					<h5>Access Description <i class="tip" data-tip-content="A brief description on what the potential tenant should do when they get to the property, to be able to perform a self-guided tour."></i></h5>
					<textarea name="checkin_description" class="WYSIWYG" cols="40" rows="3" id="checkin_description" maxlength="2000" spellcheck="true"><?php form_print_value($cache, $listing, 'checkin_description'); ?></textarea>
				</div>-->

				<?php //dropzone_form('checkin-section'); ?>

				<!-- Email -->
				<div class="col-md-12">
					<h5>Programar una Cita Link <i>(optional)</i> </h5>
					<input name="calendly_link" type="text" value="<?php form_print_value($cache, $listing, 'calendly_link'); ?>">
				</div>

				<!-- Email -->
				<div class="col-md-12">
					<h5>Alquile Ahora Link <i>(optional)</i> </h5>
					<input name="rent_link" type="text" value="<?php form_print_value($cache, $listing, 'rent_link'); ?>">
				</div>

				<!-- Email -->
				<div class="col-md-12">
					<h5>Video Tour Link <i>(optional)</i> </h5>
					<input name="video_tour" type="text" value="<?php form_print_value($cache, $listing, 'video_tour'); ?>">
				</div>

				<!-- Email -->
				<div class="col-md-12">
					<h5>PandaDoc Template Id <i class="tip" data-tip-content="The listing will always have the standard doc id, but if there is a customer that wants a custom one, it can be done."></i></h5>
					<input name="pandadoc_template_id" type="text" value="<?php if(form_get_value($cache, $listing, 'pandadoc_template_id')!='') { form_print_value($cache, $listing, 'pandadoc_template_id'); } else { echo get_setting(28); }; ?>">
				</div>
			</div>
			<!-- Row / End -->

			<!--<div class="checkboxes in-row margin-bottom-20 margin-top-10">
				<input id="check-30" type="checkbox" name="check_required">
				<label for="check-30">I certify that this property can be accessed with the details provided above. I understand that if this property is not able to be accessed remotely, my account can be penalized and I will not be able to list on Homebase anymore. <i style="color: red;">*required</i></label>
			</div>-->
		</div>
		<!-- Section / End -->
		<?php
			}
		?>

		<div class="divider"></div>

		<button name="submit" class="button margin-top-10 margin-bottom-20 preview"> <?php if(!empty($listing)) { echo 'Guardar Cambios'; } else { echo 'Añadir Nueva'; } ?> <i class="fa fa-arrow-circle-right"></i></button>

		</form>
		</div>
	</div>

</div>
</div>