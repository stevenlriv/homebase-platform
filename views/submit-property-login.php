<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	if(!empty($listing)) {
		$form_name = 'edit-property-'.$listing['id_listing'];
		$cache = get_cache($form_name);
	}
	else {
		$form_name = 'add-property';
		$cache = get_cache($form_name);
		$listing = '';
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
				<h2><i class="fa fa-edit"></i> <a href="/<?php echo $listing['uri']; ?>" target="_blank">Edit Property - <?php echo $listing['listing_title']; ?></a> </h2>
			<?php
				}
				else {
			?>
				<h2><i class="fa fa-plus-circle"></i> Add Property</h2>
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
			if($cache && $form_error=='') {
				if(!empty($listing)) {
					$form_info = 'Press the "Save Changes" button below to save your changes.';
				}
				else {
					$form_info = 'Press the "Add New" button below to add your new property.';
				}
			}

			show_message($form_success, $form_error, $form_info);
		?>

		<!-- Section -->
		<h3>Basic Information</h3>
		<div class="submit-section">
		<form method="post" enctype="multipart/form-data" class="form-cache" id="<?php echo $form_name; ?>">

			<!-- Title -->
			<div class="form">
				<h5>Property Title <i class="tip" data-tip-content="Type title that will also contains an unique feature of your property (e.g. renovated, air contidioned)"></i></h5>
				<input name="listing_title" class="search-field" type="text" value="<?php form_print_value($cache, $listing, 'listing_title'); ?>" required/>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<!-- Type -->
				<div class="col-md-12">
					<h5>Type</h5>
					<select name="type" class="chosen-select-no-single" required>
						<option label="blank"></option>		
						<option <?php if(form_get_value($cache, $listing, 'type') == 'apartment') echo 'selected="selected"' ?> value="apartment">Apartment</option>
						<option <?php if(form_get_value($cache, $listing, 'type') == 'house') echo 'selected="selected"' ?> value="house">House</option>
					</select>
				</div>

			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<!-- Beds -->
				<div class="col-md-6">
					<h5>Bedrooms</h5>
					<select name="number_rooms" class="chosen-select-no-single" required>
						<option label="blank"></option>	
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 1) echo 'selected="selected"' ?> value="1">1</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 2) echo 'selected="selected"' ?> value="2">2</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 3) echo 'selected="selected"' ?> value="3">3</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 4) echo 'selected="selected"' ?> value="4">4</option>
						<option <?php if(form_get_value($cache, $listing, 'number_rooms') == 5) echo 'selected="selected"' ?> value="5">5</option>
					</select>
				</div>

				<!-- Baths -->
				<div class="col-md-6">
					<h5>Bathrooms</h5>
					<select name="number_bathroom" class="chosen-select-no-single" required>
						<option label="blank"></option>	
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 1) echo 'selected="selected"' ?> value="1">1</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 2) echo 'selected="selected"' ?> value="2">2</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 3) echo 'selected="selected"' ?> value="3">3</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 4) echo 'selected="selected"' ?> value="4">4</option>
						<option <?php if(form_get_value($cache, $listing, 'number_bathroom') == 5) echo 'selected="selected"' ?> value="5">5</option>
					</select>
				</div>

			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<!-- Price -->
				<div class="col-md-4">
					<h5>Monthly Rent <i class="tip" data-tip-content="Monthly rent for the property"></i></h5>
					<div class="select-input disabled-first-option">
						<input name="monthly_house" value="<?php form_print_value($cache, $listing, 'monthly_house'); ?>" type="number" data-unit="USD" required>
					</div>
				</div>

				<!-- Price -->
				<div class="col-md-4">
					<h5>Deposit <i class="tip" data-tip-content="Property deposit"></i></h5>
					<div class="select-input disabled-first-option">
						<input name="deposit_house" value="<?php form_print_value($cache, $listing, 'deposit_house'); ?>" type="number" data-unit="USD" required>
					</div>
				</div>
				
				<!-- Area -->
				<div class="col-md-4">
					<h5>Area <i class="tip" data-tip-content="Property size in square feet"></i></h5>
					<div class="select-input disabled-first-option">
						<input name="square_feet" value="<?php form_print_value($cache, $listing, 'square_feet'); ?>" type="number" data-unit="Sq Ft" required>
					</div>
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->

		<h3>Specifics</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-12">
					<h5>Availability <i class="tip" data-tip-content="When is the property available to start being rented"></i></h5>
                    <input name="available" type="text" id="date-picker-property-form" placeholder="Date" value="<?php form_print_value($cache, $listing, 'square_feet'); ?>" required>
				</div>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-12">

				<!-- Checkboxes -->
				<h5 class="margin-top-30">Whats included? <i class="tip" data-tip-content="Select everything thats included in the property"></i></h5>
				<div class="checkboxes in-row margin-bottom-20">

					<input name="electricity" type="checkbox" id="check-1" <?php if(form_get_value($cache, $listing, 'electricity') == '1') echo 'checked' ?> value="1">
					<label for="check-1">Electricity</label>

					<input name="water" type="checkbox" id="check-2" <?php if(form_get_value($cache, $listing, 'water') == '1') echo 'checked' ?> value="1">
					<label for="check-2">Water</label>

					<input name="furnished" type="checkbox" id="check-3" <?php if(form_get_value($cache, $listing, 'furnished') == '1') echo 'checked' ?> value="1">
					<label for="check-3">Furnished</label>

					<input name="parking" type="checkbox" id="check-4" <?php if(form_get_value($cache, $listing, 'parking') == '1') echo 'checked' ?> value="1">
					<label for="check-4">Parking</label>	

					<input name="wifi" type="checkbox" id="check-5" <?php if(form_get_value($cache, $listing, 'wifi') == '1') echo 'checked' ?> value="1">
					<label for="check-5">Wifi</label>

					<input name="alarm" type="checkbox" id="check-6" <?php if(form_get_value($cache, $listing, 'alarm') == '1') echo 'checked' ?> value="1">
					<label for="check-6">Alarm</label>

					<input name="laundry_room" type="checkbox" id="check-7" <?php if(form_get_value($cache, $listing, 'laundry_room') == '1') echo 'checked' ?> value="1">
					<label for="check-7">Laundry Room</label>
		
				</div>

				<div class="checkboxes in-row margin-bottom-20">
		
					<input name="air_conditioning" type="checkbox" id="check-8" <?php if(form_get_value($cache, $listing, 'air_conditioning') == '1') echo 'checked' ?> value="1">
					<label for="check-8">Air Conditioning</label>

					<input name="gym" type="checkbox" id="check-9" <?php if(form_get_value($cache, $listing, 'gym') == '1') echo 'checked' ?> value="1">
					<label for="check-9">Gym</label>

					<input name="swimming_pool" type="checkbox" id="check-10" <?php if(form_get_value($cache, $listing, 'swimming_pool') == '1') echo 'checked' ?> value="1">
					<label for="check-10">Swimming Pool</label>

					<input name="pets" type="checkbox" id="check-11" <?php if(form_get_value($cache, $listing, 'pets') == '1') echo 'checked' ?> value="1">
					<label for="check-11">Pets Allowed?</label>

					<input name="smoking" type="checkbox" id="check-12" <?php if(form_get_value($cache, $listing, 'smoking') == '1') echo 'checked' ?> value="1">
					<label for="check-12">Smoking Allowed?</label>
		
				</div>
				<!-- Checkboxes / End -->
				</div>
			</div>

		</div>

		<!-- Section / End -->

		<!-- Section -->
		<h3>Location</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Address -->
				<div class="col-md-12">
					<h5>Physical Address</h5>
					<input name="physical_address" type="text" value="<?php form_print_value($cache, $listing, 'physical_address'); ?>" required>
				</div>

				<!-- City -->
				<div class="col-md-6">
					<h5>City</h5>
					<select name="id_city" class="chosen-select-no-single" required>
						<option label="blank"></option>	
						<?php
							$id_city = form_get_value($cache, $listing, 'id_city');
							if(!empty($id_city)) {
								$city = get_cities('one', array( 
									0 => array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_city", "command" => "=", "value" => $id_city),
								), "LIMIT 1");	
				
								if($city) {
									echo '<option selected="selected" value="'.$city['id_city'].'">'.$city['name'].', '.$city['state'].'</option>';
									echo '<option label="blank">--- ---</option>';
								}
							}

							foreach ( get_cities('all', array())  as $id => $value ) {
								echo '<option value="'.$value['id_city'].'">'.$value['name'].', '.$value['state'].'</option>';
							}
						?>
					</select>
				</div>

				<!-- Zip-Code -->
				<div class="col-md-6">
					<h5>Address Zipcode</h5>
					<input name="zipcode" type="text" value="<?php form_print_value($cache, $listing, 'zipcode'); ?>" required>
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->

		<!-- Section -->
		<h3>Detailed Information</h3>
		<div class="submit-section">

			<!-- Description -->
			<div class="form">
				<h5>Description <i class="tip" data-tip-content="Sell your property, describe how it looks like and what they could get"></i></h5>
				<textarea name="listing_description" class="WYSIWYG" cols="40" rows="3" id="summary" spellcheck="true" required><?php form_print_value($cache, $listing, 'listing_description'); ?></textarea>
			</div>

			<div class="form">
				<h5>Search Keywords <i class="tip" data-tip-content="Add keywords separated by comma, that you think a tenant would search an example would be a restaurant or mural name near the property"></i></h5>
				<textarea name="keywords" cols="10" rows="1" id="keywords" spellcheck="true"><?php form_print_value($cache, $listing, 'keywords'); ?></textarea>
			</div>

		</div>
		<!-- Section / End -->


		<!-- Section -->
		<h3>Virtual Details</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Name -->
				<div class="col-md-12">
					<h5>Calendly <i class="tip" data-tip-content="Link to calendly where tenants can schedule showing appointments"></i></h5>
					<input name="calendly_link" type="text" value="<?php form_print_value($cache, $listing, 'calendly_link'); ?>">
				</div>

				<!-- Email -->
				<div class="col-md-12">
					<h5>Video Tour <i class="tip" data-tip-content="Youtube video link where people can see a video tour of the property"></i></h5>
					<input name="video_tour" type="text" value="<?php form_print_value($cache, $listing, 'video_tour'); ?>">
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->

		<div class="divider"></div>

		<button name="submit" class="button margin-top-5 margin-bottom-20 preview"> <?php if(!empty($listing)) { echo 'Save Changes'; } else { echo 'Add New'; } ?> <i class="fa fa-arrow-circle-right"></i></button>

		</div>
		</form>
	</div>

</div>
</div>