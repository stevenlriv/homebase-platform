<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	// Add +1 view to the listing table
	// Used to sort popular recommended listings that are available
	update_views($listing['uri']);
?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="property-titlebar margin-bottom-0">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<a href="/find-a-homebase?location=<?php echo $listing['city']; ?>" class="back-to-listings"></a>
				<div class="property-title">
					<h2><?php echo $listing['listing_title']; ?> <?php print_available_message('blue-label', $listing['available']); ?></h2>
					<span>
						<a href="#location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php echo $listing['physical_address']; ?>
						</a>
					</span>
				</div>

				<div class="property-pricing">
					<div class="property-price">$<?php echo $listing['monthly_house']; ?> / mensual</div>
					<?php
						if($listing['monthly_per_room'] != 0 && $listing['number_rooms']>1) {
							echo '<div class="sub-price">$'.$listing['monthly_per_room'].' / por habitación</div>';
						}
					?>
				</div>


			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->

<!-- Slider -->
<div class="fullwidth-property-slider margin-bottom-50">
	<?php
		if(!empty($listing['listing_images'])) {
			foreach ( get_json($listing['listing_images'], 'all') as $id => $image ) {
				echo '<a href="'.$image.'" data-background-image="'.$image.'" class="item mfp-gallery"></a>';
			}
		}
		else {
			echo '<a href="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/single-property-01.jpg" data-background-image="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/single-property-01.jpg" class="item mfp-gallery"></a>';
		}
	?>
</div>


<div class="container">
	<div class="row">

		<!-- Property Description -->
		<div class="col-lg-8 col-md-7">

			<!-- Show only on small devices -->
			<div class="hidden-md hidden-lg">
				<?php 
					booking_component($listing, 'date-picker-mobile');
				?>
			</div>

			<div class="property-description">

				<!-- Main Features -->
				<ul class="property-main-features">
					<li>Area <span><?php echo $listing['square_feet']; ?> sq ft</span></li>
					<li>Cuartos <span><?php echo $listing['number_rooms']; ?></span></li>
					<li>Baños <span><?php echo $listing['number_bathroom']; ?></span></li>
					<li>Diponibilidad <span><?php print_available_message('date', $listing['available']); ?></span></li>
				</ul>

				<!-- Description -->
				<h3 class="desc-headline">Descripción</h3>
				<div class="show-more">
					<p>
						<?php echo $listing['listing_description']; ?>
					</p>

					<a href="#" class="show-more-button">Mostrar más <i class="fa fa-angle-down"></i></a>
				</div>

				<!-- Features -->
				<h3 class="desc-headline">Incluye</h3>
				<ul class="property-features checkboxes margin-top-0">
					<?php if($listing['electricity']) echo '<li>Electricity Included</li>'; ?>
					<?php if($listing['water']) echo '<li>Water Included</li>'; ?>
					<?php if($listing['furnished']) echo '<li>Furnished</li>'; ?>
					<?php if($listing['wifi']) echo '<li>Internet</li>'; ?>

					<?php if($listing['air_conditioning']) echo '<li>Air Conditioning</li>'; ?>
					<?php if($listing['swimming_pool']) echo '<li>Swimming Pool</li>'; ?>
					<?php if($listing['gym']) echo '<li>Gym</li>'; ?>
					<?php if($listing['laundry_room']) echo '<li>Laundry Room</li>'; ?>

					<?php if($listing['alarm']) echo '<li>Alarm</li>'; ?>
					<?php if($listing['parking']) echo '<li>Parking</li>'; ?>
					<?php if($listing['pets']) echo '<li>Pets Allowed</li>'; ?>
					<?php if($listing['smoking']) echo '<li>Smoking Allowed</li>'; ?>					
				</ul>

				<?php 
					if($listing['video_tour'] != '') {
				?>
				<!-- Video -->
				<h3 class="desc-headline no-border">Tour de video</h3>
				<div class="responsive-iframe">
					<iframe width="560" height="315" src="<?php echo $listing['video_tour']; ?>" frameborder="0" allowfullscreen></iframe>
				</div>
				<?php
					}
				?>

				<?php 
					if($listing['latitude'] != '' && $listing['longitude'] != '') {
				?>
				<!-- Location -->
				<h3 class="desc-headline no-border" id="location">Ubicación</h3>
				<div id="propertyMap-container">
					<div id="propertyMap" data-latitude="<?php echo $listing['latitude']; ?>" data-longitude="<?php echo $listing['longitude']; ?>"></div>
					<a href="#" id="streetView">Street View</a>
				</div>
				<?php
					}
				?>

				<?php
					//We transform the date to unix to be able to do a search in the database
					//We only get listings that are not rented
					$qdate = strtotime(date("m/d/Y"));

					$query_related_listings = get_listings('all', array( 
						0 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"),
						1 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "id_listing", "command" => "!=", "value" => $listing['id_listing']),
						2 => array("type" => "CHR", "condition" => "AND", "loose" => true, "table" => "city", "command" => "LIKE", "value" => $listing['city']),
						3 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "available", "command" => "<=", "value" => $qdate)
					), "ORDER BY views_count DESC LIMIT 3");	

					// We need more than 1 to show the title
					if(count($query_related_listings) >= 1) {
				?>
					<!-- Similar Listings Container -->
					<h3 class="desc-headline no-border margin-bottom-35 margin-top-60">Propiedades Similares</h3>

				<?php
					}
				?>
				<!-- Layout Switcher -->

				<div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
				<div class="listings-container list-layout">

				<?php

					foreach ( $query_related_listings as $id => $value ) {
				?>
					<!-- Listing Item -->
					<div class="listing-item">

						<a href="/<?php echo $value['uri']; ?>" class="listing-img-container">

							<div class="listing-badges">
                            	<?php
							    	if($value['featured']) {
							        	echo '<span class="featured">Featured</span>';
							    	}

									print_available_message('label', $value['available']);
								?>
							</div>

							<div class="listing-img-content">
								<span class="listing-price">$<?php echo $value['monthly_house']; ?> <i>mensual</i></span>
								<span class="like-icon"></span>
							</div>

							<div class="listing-carousel">
								<div style="height: 280px;"><img src="<?php echo get_json($value['listing_images'], 0); ?>" alt="<?php echo $value['physical_address']; ?>" /></div>
							</div>
						</a>
						
						<div class="listing-content">

							<div class="listing-title">
								<h4><a href="/<?php echo $value['uri']; ?>"><?php echo $value['listing_title']; ?></a></h4>
								<a href="https://maps.google.com/maps?q=<?php echo $value['physical_address']; ?>" class="listing-address popup-gmaps">
									<i class="fa fa-map-marker"></i>
									<?php echo $value['physical_address']; ?>
								</a>

								<a href="/<?php echo $value['uri']; ?>" class="details button border">Detalles</a>
							</div>

							<ul class="listing-details">
								<li><?php echo $value['square_feet']; ?> sq ft</li>
								<li><?php echo $value['number_rooms']; ?> Cuartos</li>
								<li><?php echo $value['number_bathroom']; ?> Baños</li>
							</ul>

							<div class="listing-footer">
								<a href="#" style="visibility: hidden;"><i class="fa fa-user"></i> Chester Miller</a>
								<span><i class="fa fa-calendar-o"></i> <?php print_available_message('status', $value['available']); ?></span>
							</div>

						</div>
						<!-- Listing Item / End -->

					</div>
					<!-- Listing Item / End -->

				<?php
					}
				?>

				</div>
				<!-- Similar Listings Container / End -->

			</div>
		</div>
		<!-- Property Description / End -->


		<!-- Sidebar / Only show on desktop -->
		<div class="col-lg-4 col-md-5 hidden-xs hidden-sm">
			<div class="sidebar sticky right">
				<?php 
					booking_component($listing, 'date-picker'); 
				?>
			</div>
		</div>
		<!-- Sidebar / End -->

	</div>
</div>