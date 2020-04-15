<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	$city = get_cities('one', $listing['id_city']);	
?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="property-titlebar margin-bottom-0">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<a href="/find-a-homebase?location=<?php echo $city['uri']; ?>" class="back-to-listings"></a>
				<div class="property-title">
					<h2><?php echo $listing['listing_title']; ?> <span class="property-badge">For Rent</span></h2>
					<span>
						<a href="#location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php echo $listing['physical_address']; ?>
						</a>
					</span>
				</div>

				<div class="property-pricing">
					<div class="property-price">$<?php echo $listing['monthly_house']; ?> / monthly</div>
					<?php
						if($listing['monthly_per_room'] != 0 && $listing['number_rooms']>1) {
							echo '<div class="sub-price">$'.$listing['monthly_per_room'].' / per room</div>';
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
		foreach ( get_json($listing['listing_images'], 'all') as $id => $image ) {
			echo '<a href="'.$image.'" data-background-image="'.$image.'" class="item mfp-gallery"></a>';
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
					$date_picker = 'date-picker-mobile';
					require('listings-booking-component.php'); 
				?>
			</div>

			<div class="property-description">

				<!-- Main Features -->
				<ul class="property-main-features">
					<li>Area <span><?php echo $listing['square_feet']; ?> sq ft</span></li>
					<li>Bedrooms <span><?php echo $listing['number_rooms']; ?></span></li>
					<li>Bathrooms <span><?php echo $listing['number_bathroom']; ?></span></li>
					<li>Available <span><?php 
								
								if($listing['available'] > date("m/d/Y")) {
									echo "on ".$listing['available'];
								}
								else {
									echo "Today";
								}
								
						?></span></li>
				</ul>


				<!-- Description -->
				<h3 class="desc-headline">Description</h3>
				<div class="show-more">
					<p>
						<?php echo $listing['listing_description']; ?>
					</p>

					<a href="#" class="show-more-button">Show More <i class="fa fa-angle-down"></i></a>
				</div>

				<!-- Features -->
				<h3 class="desc-headline">Features</h3>
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
				<h3 class="desc-headline no-border">Video Tour</h3>
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
				<h3 class="desc-headline no-border" id="location">Location</h3>
				<div id="propertyMap-container">
					<div id="propertyMap" data-latitude="<?php echo $listing['latitude']; ?>" data-longitude="<?php echo $listing['longitude']; ?>"></div>
					<a href="#" id="streetView">Street View</a>
				</div>
				<?php
					}
				?>

				<!-- Similar Listings Container -->
				<h3 class="desc-headline no-border margin-bottom-35 margin-top-60">Similar Properties</h3>

				<!-- Layout Switcher -->

				<div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
				<div class="listings-container list-layout">

				<?php
					$query_related_listings = get_listings('all', array( 
						0 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"),
						1 => array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_city", "command" => "=", "value" => $listing['id_city']),
						2 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "id_listing", "command" => "!=", "value" => $listing['id_listing']),
					), "ORDER BY id_listing DESC LIMIT 3");	

					foreach ( $query_related_listings as $id => $value ) {
				?>
					<!-- Listing Item -->
					<div class="listing-item">

						<a href="/<?php echo $value['uri']; ?>" class="listing-img-container">

							<div class="listing-badges">
								<span>For Rent</span>
							</div>

							<div class="listing-img-content">
								<span class="listing-price">$<?php echo $value['monthly_house']; ?> <i>monthly</i></span>
								<span class="like-icon"></span>
							</div>

							<div class="listing-carousel">
								<?php
									foreach ( get_json($value['listing_images'], 'all') as $id => $image ) {
										echo '<div style="height: 280px;"><img src="'.$image.'" alt="'.$value['physical_address'].'"></div>';
									}
								?>
							</div>
						</a>
						
						<div class="listing-content">

							<div class="listing-title">
								<h4><a href="/<?php echo $value['uri']; ?>"><?php echo $value['listing_title']; ?></a></h4>
								<a href="https://maps.google.com/maps?q=<?php echo $value['physical_address']; ?>" class="listing-address popup-gmaps">
									<i class="fa fa-map-marker"></i>
									<?php echo $value['physical_address']; ?>
								</a>

								<a href="/<?php echo $value['uri']; ?>" class="details button border">Details</a>
							</div>

							<ul class="listing-details">
								<li><?php echo $value['square_feet']; ?> sq ft</li>
								<li><?php echo $value['number_rooms']; ?> Bedrooms</li>
								<li><?php echo $value['number_bathroom']; ?> Bathrooms</li>
							</ul>

							<div class="listing-footer">
								<a href="#" style="visibility: hidden;"><i class="fa fa-user"></i> Chester Miller</a>
								<span><i class="fa fa-calendar-o"></i> <?php 
								
								if($value['available'] > date("m/d/Y")) {
									echo "Available soon";
								}
								else {
									echo "Available now";
								}
								
								?></span>
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
					$date_picker = 'date-picker-desktop';
					require('listings-booking-component.php'); 
				?>
			</div>
		</div>
		<!-- Sidebar / End -->

	</div>
</div>