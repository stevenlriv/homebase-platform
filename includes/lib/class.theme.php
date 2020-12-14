<?php

 function are_messages_empty() {
	 global $form_success, $form_error, $form_info;

	 if(!empty($form_success) || !empty($form_error) || !empty($form_info)) {
		 return false;
	 }

	 return true;
 }
 function show_message($success = '', $error = '', $info = '', $big_info = false) {
	global $request;
	
    $type = '';

    if(!empty($success)) {
        $type = 'success';
        $message = $success;
	}
	elseif(!empty($info)) {
        $type = 'notice';
        $message = $info;
	}
    else {
        $type = 'error';
        $message = $error;
    }

	if($big_info && $type == 'notice' ) {
		echo '<div class="notification notice large margin-bottom-55">';
			echo '<h4>¡Aviso!</h4>';
			echo '<p>'.$message.'</p>';
		echo '</div>';
	}
    elseif($message != '') {
	    echo '<div class="notification '.$type.' closeable">';
	        echo '<p>'.$message.'</p>';
        echo '</div>';
	}

 }

 function booking_component($listing, $jquery_id) {
	
	// If there is a calendly link, show it
	if($listing['calendly_link'] != '') {
?>

            <!-- Tour Widget -->
            <div class="widget">
                <div id="booking-widget-anchor" class="boxed-widget booking-widget">
                    <a href="<?php echo $listing['calendly_link']; ?>" target="_blank" class="button book-now fullwidth margin-top-5">Programar una Cita</a>
                </div>
            </div>
            <!-- Tour Widget / End -->

<?php
	}
	else {
?>
            <!-- Tour Widget -->
            <div class="widget">
				<form action="/contact" type="GET">
					<input type="hidden" name="property" value="<?php echo $listing['uri']; ?>">
                	<div id="booking-widget-anchor" class="boxed-widget booking-widget">
						<button class="button book-now fullwidth margin-top-5">Programar una Cita</button>
                	</div>
				</form>
            </div>
            <!-- Tour Widget / End -->
<?php
	}

	// If there is a rent link, show it
	if($listing['rent_link'] != '') {
		?>
					<!-- Tour Widget -->
					<div class="widget">
						<div id="booking-widget-anchor" class="boxed-widget booking-widget">
							<a href="<?php echo $listing['rent_link']; ?>" target="_blank" class="button book-now fullwidth margin-top-5">Aquile Ahora</a>
						</div>
					</div>
					<!-- Tour Widget / End -->
		
		<?php
			}
			else {
		?>
            <!-- Booking Widget -->
			<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
            <div class="widget">
                <form action="/contact" type="GET">
                <input type="hidden" name="property" value="<?php echo $listing['uri']; ?>">
                <!-- Book Now -->
                <div id="booking-widget-anchor" class="boxed-widget booking-widget margin-top-35 margin-bottom-35">
                    <!--<h3><i class="fa fa-calendar-check-o "></i> Rent This Property</h3>
                    <div class="row with-forms  margin-top-0">

                        
                        <div class="col-lg-12">
                            <input name="date" type="text" id="<?php echo $jquery_id; ?>" placeholder="Date" readonly="readonly">
                        </div>

                    </div>-->
                    <!-- Book Now -->
                    <button class="button book-now fullwidth margin-top-5">Aquile Ahora</button>
                </div>
                <!-- Book Now / End -->
                </form>
            </div>
            <!-- Booking Widget / End -->
		<?php
			}
}

	function booking_component_js($listing, $jquery_id, $cache = '') {
		global $cache_bug_js_fix;
?>

			<script>
				$(function() {
					$('#<?php echo $jquery_id; ?>').daterangepicker({
						"opens": "left",
						singleDatePicker: true,

						// Disabling Date Ranges
						isInvalidDate: function(date) {
							// Disabling Date Range
							var disabled_start = moment('09/02/2015', 'MM/DD/YYYY');

							<?php
								//If the $listing var is not empty, that means that we are on a listing and we will be limiting
								//The dates based on that listing data
								$date = date("m/d/Y");

								if(!empty($listing)) {
									if($listing['available'] > strtotime(date("m/d/Y"))) {
										$date = date("m/d/Y", $listing['available']);
									}
								}

								if(is_on_listing_creation_page()) {
									//disable date is set to the current date so the person is able to change the available date to any date in the future
									//Here I should verify if an user is renting it to disable it or not
									echo "var disabled_end = moment('".date("m/d/Y")."', 'MM/DD/YYYY')";
									//echo "var disabled_end = moment('".$date."', 'MM/DD/YYYY')";
								}
								else {
									echo "var disabled_end = moment('".$date."', 'MM/DD/YYYY')";
								}
							?>
	
							return date.isAfter(disabled_start) && date.isBefore(disabled_end);
						},

						<?php 
							//If he is looking for a specific date and is not on a listing show it
							//Or if the listing date is <= that session date show session date as the selected one
							if(!empty($_SESSION['search-date']) && empty($listing) || !empty($_SESSION['search-date']) && !empty($listing) && $listing['available']<=strtotime($_SESSION['search-date'])) { 
								$date = $_SESSION['search-date'];
							} 
							 
							if(is_on_listing_creation_page()) {
								$lt_date = form_get_value($cache, $listing, 'available'); //We get the saved date
								
								if(is_numeric($lt_date) && $lt_date!=0) {
									$lt_date = date("m/d/Y", $lt_date);
								}
								elseif(empty($lt_date)) {

									$lt_date = date("m/d/Y");
								}

								// To also avoid reloading a new cache once the page is load
								// We don't show anything here if the variable is enabled to fix the js bug on page reload
								// The current date is already showed on "views/submit-property-login.php"
								// For more information on this bug go to views/footer.php
								if( !$cache_bug_js_fix ) {
							?>
								"startDate": "<?php echo sanitize_xss($lt_date); ?>",								
							<?php
								}
							}
							else {
							?>
								"startDate": "<?php echo sanitize_xss($date); ?>",
							<?php
							}
						?>
					});
				});

				// Calendar animation
				$('#<?php echo $jquery_id; ?>').on('showCalendar.daterangepicker', function(ev, picker) {
					$('.daterangepicker').addClass('calendar-animated');
				});
				$('#<?php echo $jquery_id; ?>').on('show.daterangepicker', function(ev, picker) {
					$('.daterangepicker').addClass('calendar-visible');
					$('.daterangepicker').removeClass('calendar-hidden');
				});
				$('#<?php echo $jquery_id; ?>').on('hide.daterangepicker', function(ev, picker) {
					$('.daterangepicker').removeClass('calendar-visible');
					$('.daterangepicker').addClass('calendar-hidden');
				});
			</script>

<?php
	}

function sidebar_component() {
    global $request, $user;
?>

        <!-- Widget -->
		<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manejar Cuenta</li>
						<li><a href="/my-profile" <?php if($request == '/my-profile') echo 'class="current"'; ?>><i class="sl sl-icon-user"></i> Perfil</a></li>
						<li><a href="/change-password" <?php if($request == '/change-password') echo 'class="current"'; ?>><i class="sl sl-icon-lock"></i> Cambiar Contraseña</a></li>
					</ul>

                    <?php
                        //Tenants Menu
                        if($user['type'] == 'tenants') {
                    ?>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Propiedades</li>
						<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> Su Propiedad</a></li>
						<!--<li><a href="#" <?php if($request == '/payments') echo 'class="current"'; ?>><i class="sl sl-icon-credit-card"></i> Payments</a></li>
                        <li><a href="#" <?php if($request == '/leases') echo 'class="current"'; ?>><i class="sl sl-icon-briefcase"></i> Lease</a></li>-->
					</ul>

                    <?php
						}
						
						//Lister Menu
						elseif($user['type'] == 'listers') {
					?>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Propiedades</li>
						<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> Todas las propiedades</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Finanzas</li>
						<!--<li><a href="#" <?php if($request == '/payments') echo 'class="current"'; ?>><i class="sl sl-icon-credit-card"></i> Payments</a></li>
                        <li><a href="#" <?php if($request == '/people-referred') echo 'class="current"'; ?>><i class="sl sl-icon-people"></i> People Referred</a></li>-->
                        <li><a href="/financial-settings" <?php if($request == '/financial-settings') echo 'class="current"'; ?>><i class="sl sl-icon-settings"></i> Información</a></li>
					</ul>
					<?php
						}

						//Realtor/Landlord/Admin Menus
                        else {

							// Users Menu for admins
							if(is_admin()) {
					?>
							<ul class="my-account-nav">
								<li class="sub-nav-title">Usuarios</li>
	
								<li><a href="/all-users" <?php if($request == '/all-users') echo 'class="current"'; ?>><i class="sl sl-icon-people"></i> Todos los usuarios</a></li>
								<li><a href="/new-user" <?php if($request == '/new-user') echo 'class="current"'; ?>><i class="sl sl-icon-action-redo"></i> Añadir un nuevo usuario</a></li>
							</ul>
					<?php
							}
                    ?>
					<ul class="my-account-nav">
						<li class="sub-nav-title">Propiedades</li>
						<?php
							if(is_admin()) {
						?>
							<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> Todas las propiedades</a></li>
						<?php
							}
							else {
						?>
							<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> Sus Propiedades</a></li>
						<?php
							}
						?>
						<li><a href="/submit-property"><i class="sl sl-icon-action-redo"></i> Añadir una nueva propiedad</a></li>
					</ul>


					<?php
							if(!is_admin()) {
					?>
					<ul class="my-account-nav">
						<li class="sub-nav-title">Finanzas</li>
						<li><a href="/payments" <?php if($request == '/payments') echo 'class="current"'; ?>><i class="sl sl-icon-credit-card"></i> Pagos</a></li>
                        <li><a href="/leases" <?php if($request == '/leases') echo 'class="current"'; ?>><i class="sl sl-icon-briefcase"></i> Contratos</a></li>
                        <li><a href="/financial-settings" <?php if($request == '/financial-settings') echo 'class="current"'; ?>><i class="sl sl-icon-settings"></i> Información Bancaria</a></li>
					</ul>

                    <?php
							}

							if(is_admin()) {
					?>
					<ul class="my-account-nav">
						<li class="sub-nav-title">Herramientas</li>
						<li><a href="/text-messages" <?php if($request == '/text-messages') echo 'class="current"'; ?>><i class="sl sl-icon-speech"></i> Send Text Messages</a></li>
					</ul>

                    <?php
							}
                        }
                    ?>

					<ul class="my-account-nav">
						<li><a href="/logout"><i class="sl sl-icon-power"></i> Salir</a></li>
					</ul>

				</div>

			</div>
		</div>

<?php
}

function full_search_form($type = '', $extra = '') {
	global $user;
	
	//action for search form
	if($type == 'my-properties') {
		$action = '/my-properties';
		$date_name = 'Available By';
	}
	elseif($type == 'profile') {
		$action = '/profile';
		$date_name = 'Available By';
		$view_user = get_user_by_id($extra);
	}
	else {
		$action = '/find-a-homebase';
		$date_name = 'Move In date';
	}
?>

<!-- Form -->
<form action="<?php echo $action; ?>" type="GET">
                        
						<?php
							if(is_admin() && !empty($view_user)) {
								echo '<input name="id" type="hidden" value="'.$view_user['id_user'].'" readonly="readonly">';
							}
						?>
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">

								<!-- Main Search Input -->
								<div class="col-fs-6">
									<input type="text" placeholder="Introduzca la dirección, calle, ciudad o estado." value="<?php if(!empty($_SESSION['search-location'])) echo sanitize_xss($_SESSION['search-location']); ?>" name="location"/>
								</div>

								<!-- Status -->
								<div class="col-fs-3">
                                    <input type="text" value="<?php echo $date_name; ?>" readonly="readonly" style="border: none !important; background: none !important;">
								</div>

								<!-- Property Type -->
								<div class="col-fs-3">
                                    <input name="date" type="text" id="date-picker" placeholder="Date" readonly="readonly">
								</div>

							</div>
							<!-- Row With Forms / End -->

							<!-- Search Button -->
							<button class="button fs-map-btn">Buscar</button>

							<!-- More Search Options -->
							<a href="#" class="more-search-options-trigger margin-top-20" data-open-title="More Options" data-close-title="Less Options"></a>

							<div class="more-search-options relative">
								<div class="more-search-options-container margin-top-30">

									<!-- Row With Forms -->
									<div class="row with-forms">

										<!-- Age of Home -->
										<div class="col-fs-3">
										    <select name="type" data-placeholder="Tipo (Cualquiera)" class="chosen-select-no-single">
												<option value="">Tipo (Cualquiera)</option>
                                                <option <?php if(!empty($_SESSION['search-type']) && $_SESSION['search-type'] == 'house') echo 'selected="selected"' ?> value="house">Casa</option>
											    <option <?php if(!empty($_SESSION['search-type']) && $_SESSION['search-type'] == 'apartment') echo 'selected="selected"' ?> value="apartment">Apartamento</option>
										    </select>
										</div>

										<!-- Rooms Area -->
										<div class="col-fs-3">
											<select name="bedroom" data-placeholder="Dormitorios (1-5)" class="chosen-select-no-single" >
												<option value="">Dormitorios (1-5)</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '1') echo 'selected="selected"' ?>>1</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '2') echo 'selected="selected"' ?>>2</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '3') echo 'selected="selected"' ?>>3</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '4') echo 'selected="selected"' ?>>4</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '5') echo 'selected="selected"' ?>>5</option>
											</select>
										</div>

										<!-- Max Area -->
										<div class="col-fs-3">
											<select name="bathroom" data-placeholder="Baños (1-5)" class="chosen-select-no-single" >
												<option value="">Baños (1-5)</option>	
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '1') echo 'selected="selected"' ?>>1</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '2') echo 'selected="selected"' ?>>2</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '3') echo 'selected="selected"' ?>>3</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '4') echo 'selected="selected"' ?>>4</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '5') echo 'selected="selected"' ?>>5</option>
											</select>
										</div>

										<div class="col-fs-3">
                                            <select name="maxprice" data-placeholder="Precio Máximo" class="chosen-select-no-single">	
                                                <option value="">Precio Máximo</option>
                                                <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '500') echo 'selected="selected"' ?>>500</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '1000') echo 'selected="selected"' ?>>1000</option>
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '2000') echo 'selected="selected"' ?>>2000</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '3000') echo 'selected="selected"' ?>>3000</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '4000') echo 'selected="selected"' ?>>4000</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '5000') echo 'selected="selected"' ?>>5000</option>	
										    </select>
										</div>

										<?php
											// Don't show this option to listers, because they only see active ones
											if($type == 'my-properties' && $user['type'] != 'listers') {
										?>
										<!-- Status -->
										<div class="col-fs-3">
										    <select name="status" data-placeholder="Status (Any)" class="chosen-select-no-single">
												<option value="">Estado de la propiedad</option>
                                                <option <?php if(!empty($_SESSION['search-status']) && $_SESSION['search-status'] == 'active') echo 'selected="selected"' ?> value="active">Activa</option>
											    <option <?php if(!empty($_SESSION['search-status']) && $_SESSION['search-status'] == 'inactive') echo 'selected="selected"' ?> value="inactive">Inactiva</option>

												<?php
													if(is_admin()) {
												?>
												<option <?php if(!empty($_SESSION['search-status']) && $_SESSION['search-status'] == 'pending') echo 'selected="selected"' ?> value="pending">Pendiente de Aprobación</option>
												<?php
													}
												?>
										    </select>
										</div>
										<?php
											}
										?>

									</div>
									<!-- Row With Forms / End -->

								</div>

							</div>
							<!-- More Search Options / End -->

						</div>
						<!-- Box / End -->
                        </form>

<?php
}

function user_search_form($type = '', $extra = '') {
	global $user;
	

		$action = '/all-users';

?>

<!-- Form -->
<form action="<?php echo $action; ?>" type="GET">
                        
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">

								<!-- Main Search Input -->
								<div class="col-fs-9">
									<input type="text" placeholder="Introduzca su nombre, email, número de teléfono o país." value="<?php if(!empty($_SESSION['user-query'])) echo sanitize_xss($_SESSION['user-query']); ?>" name="user-query"/>
								</div>

								<!-- Status -->
								<div class="col-fs-3">
									<!-- Search Button -->
									<button class="button fs-map-btn">Buscar</button>
								</div>

							</div>
							<!-- Row With Forms / End -->

						</div>
						<!-- Box / End -->
                        </form>

<?php
}

function calculate_homebase_listed_js($input_from, $input_to, $percentaje = 0.10) {
?>

<script>
	/*--------------------------------------------------*/
	/*  Submit Property
	/*--------------------------------------------------*/

	function round_homebase_fee(house_price, percentage) {
		var price = house_price * percentage;
		price = Math.ceil(price / 10) * 10;
        
  		return price;
	}

	$('form input[name="<?php echo $input_to; ?>"]').prop("disabled", true);

	// In case there is form data while editing or cache
	var monthly_rent = parseInt($( 'form input[name="<?php echo $input_from; ?>"]' ).val(), 10);
	var monthly_rent_homebase = monthly_rent + (round_homebase_fee(monthly_rent, <?php echo $percentaje; ?>));
	
	$('form input[name="<?php echo $input_to; ?>"]').attr('value', Math.trunc(monthly_rent_homebase));

	// When the form input is updated;
	$( 'form input[name="<?php echo $input_from; ?>"]' ).keyup(function() {
		monthly_rent = parseInt($( 'form input[name="<?php echo $input_from; ?>"]' ).val(), 10);
		monthly_rent_homebase = monthly_rent + (round_homebase_fee(monthly_rent, <?php echo $percentaje; ?>));

		
		$('form input[name="<?php echo $input_to; ?>"]').attr('value', Math.trunc(monthly_rent_homebase));
	});
</script>

<?php
}

//$v_user if false we will get the user data from $user var if true, we will get the user data from view_user
//this is used mainly for admin-edit-profile.php
function print_profile_image_form($id_input, $id_submit, $v_user = false) {
	global $user;

	if($v_user) {
		global $view_user;
		$user = $view_user;
	}
?>
	<form method="post" enctype="multipart/form-data">
		<!-- Avatar -->
		<div class="edit-profile-photo">
			<img src="<?php if(!empty($user['profile_image'])) { echo $user['profile_image']; } else { echo 'https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/agent-03.jpg'; }; ?>" alt="">
			<div class="change-photo-btn">
			<?php
				//dont shoe edit button if an admin is editting an user, only users can change their images
				if(!$v_user) {
			?>
				<div class="photoUpload">
					<span><i class="fa fa-upload"></i> Subir Foto</span>
					<input type="file" id="<?php echo $id_input; ?>" name="profile_image" class="upload" />
				</div>
			<?php
				}
			?>
			</div>
		</div>
		<button name="submit-image" id="<?php echo $id_submit; ?>" style="display: none;" class="button margin-top-20 margin-bottom-20">Subir Imagen</button>
	</form>
<?php
}

function print_profile_image_js($id_input, $id_submit) {
?>

<script>
	/*--------------------------------------------------*/
	/*  User Profile Image
	/*--------------------------------------------------*/
	$("#<?php echo $id_input; ?>").change(function(){
		$( "#<?php echo $id_submit; ?>" ).trigger( "click" );
    });
</script>

<?php
}
?>