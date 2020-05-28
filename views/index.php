<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Banner
================================================== -->
<div class="parallax" data-background="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/home-parallax-1.jpg" data-color="#36383e" data-color-opacity="0.45" data-img-width="2500" data-img-height="1600">
	<div class="parallax-content">

		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<!-- Main Search Container -->
					<div class="main-search-container">
						<h2>Home is just a few clicks away.</h2>
						
						<!-- Main Search -->
						<form class="main-search-form" action="/find-a-homebase" type="GET">
							
							<!-- Type -->
							<div class="search-type">
								<label class="active"><input class="first-tab" checked="checked" type="radio">For Rent</label>
								<!--<label><input name="tab" type="radio">For Sale</label>-->
								<!--<label><input name="tab" type="radio">For Rent</label>-->
								<div class="search-type-arrow"></div>
							</div>

							
							<!-- Box -->
							<div class="main-search-box">
								
								<!-- Main Search Input -->
								<div class="main-search-input larger-input">
									<input name="location" type="text" class="ico-01" id="autocomplete-input" placeholder="Enter address e.g. street, city and state or zip" required />
									<button class="button">Search</button>
								</div>

								<!-- Row -->
								<div class="row with-forms">

									<!-- Moving Date -->
									<div class="col-md-4">
                                        <input type="text" value="Move In date" readonly="readonly" style="border: none !important; background: none !important;">
									</div>

									<div class="col-md-4">
                                        <input name="date" type="text" id="date-picker" placeholder="Date" readonly="readonly">
									</div>

									<!-- Property Type -->
									<div class="col-md-4">
										<select name="type" data-placeholder="Type" class="chosen-select-no-single">
											<option value="">Type (Any)</option>
                                            <option value="house">House</option>
											<option value="apartment">Apartment</option>
										</select>
									</div>
                                    
								</div>
								<!-- Row / End -->


							</div>
							<!-- Box / End -->

						</form>
						<!-- Main Search -->

					</div>
					<!-- Main Search Container / End -->

				</div>
			</div>
		</div>

	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
	
		<div class="col-md-12">
			<h3 class="headline margin-bottom-25 margin-top-65">Newly Added</h3>
		</div>
		
		<!-- Carousel -->
		<div class="col-md-12">
			<div class="carousel">
				
			<?php
				$index_query = array(
					0 => array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active")
				);

				foreach ( get_listings('all', $index_query, 'ORDER BY id_listing DESC LIMIT 5') as $id => $value ) {
			?>

				<!-- Listing Item -->
				<div class="carousel-item">
					<div class="listing-item">

						<a href="/<?php echo $value['uri']; ?>" class="listing-img-container">

							<div class="listing-badges">
                            	<?php
							    	if($value['featured']) {
							        	echo '<span class="featured">Featured</span>';
							    	}
								?>
								<span>For Rent</span>
							</div>

							<div class="listing-img-content">
								<span class="listing-price">$<?php echo $value['monthly_house']; ?> <i>monthly</i></span>
								<!--<span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>
								<span class="compare-button with-tip" data-tip-content="Add to Compare"></span>-->
							</div>

							<div class="listing-carousel">
								<?php
									if(!empty($value['listing_images'])) {
										foreach ( get_json($value['listing_images'], 'all') as $id => $image ) {
											echo '<div style="height: 280px;"><img src="'.$image.'" alt="'.$value['physical_address'].'"></div>';
										}
									}
									else {
										echo '<div style="height: 280px;"><img src="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/single-property-01.jpg" alt="'.$value['physical_address'].'"></div>';
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
							</div>

							<ul class="listing-features">
								<li>Area <span><?php echo $value['square_feet']; ?> sq ft</span></li>
								<li>Bedrooms <span><?php echo $value['number_rooms']; ?></span></li>
								<li>Bathrooms <span><?php echo $value['number_bathroom']; ?></span></li>
							</ul>

							<div class="listing-footer">
								<a href="#" style="visibility: hidden;"><i class="fa fa-user"></i> Chester Miller</a>
								<span><i class="fa fa-calendar-o"></i> <?php print_available_status($value['available']); ?>
							</span>
							</div>

						</div>
						<!-- Listing Item / End -->

					</div>
				</div>
				<!-- Listing Item / End -->


			<?php
				}
			?>

			</div>
		</div>
		<!-- Carousel / End -->

	</div>
</div>


<!-- Fullwidth Section -->
<section class="fullwidth margin-top-105" data-background-color="#f7f7f7">

	<!-- Box Headline -->
	<h3 class="headline-box">What are you looking for?</h3>
	
	<!-- Content -->
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-sm-12">
				<!-- Icon Box -->
				<div class="icon-box-1">

					<div class="icon-container">
						<i class="im im-icon-Home-2"></i>
						<div class="icon-links">
							<!--<a href="listings-grid-standard-with-sidebar.html">For Sale</a>-->
							<a href="/find-a-homebase?type=house">For Rent</a>
						</div>
					</div>

					<h3>Houses</h3>
					<p>More space and privacy, easier to split rent with others.</p>
				</div>
			</div>

			<div class="col-md-6 col-sm-12">
				<!-- Icon Box -->
				<div class="icon-box-1">

					<div class="icon-container">
						<i class="im im-icon-Office"></i>
						<div class="icon-links">
							<!--<a href="listings-grid-standard-with-sidebar.html">For Sale</a>-->
							<a href="/find-a-homebase?type=apartment">For Rent</a>
						</div>
					</div>

					<h3>Apartments</h3>
					<p>Less maintenance, and well located. Lots of places walking distance.</p>
				</div>
			</div>

		</div>
	</div>
</section>
<!-- Fullwidth Section / End -->

<!-- Fullwidth Section -->
<section class="fullwidth border-bottom margin-top-0 margin-bottom-0 padding-top-50 padding-bottom-50" data-background-color="#ffffff">

	<!-- Content -->
	<div class="container">
		<div class="row">

            <div class="col-md-12">
			    <h3 class="headline centered margin-bottom-35 margin-top-10">Why Homebase? <span>We make residential leasing as easy as booking a vacation with Airbnb.</span></h3>
		    </div>

			<div class="col-md-4">
				<!-- Icon Box -->
				<div class="icon-box-1 alternative">

					<div class="icon-container">
						<i class="im im-icon-Mustache-6"></i>
					</div>

					<h3>Options for every lifestyle</h3>
					<p>Rent by the room or reserve an entire home. Choose from furnished, unfurnished, or move-in ready with internet and utilities included.</p>
				</div>
			</div>

			<div class="col-md-4">
				<!-- Icon Box -->
				<div class="icon-box-1 alternative">

					<div class="icon-container">
						<i class="im im-icon-Aerobics-2"></i>
					</div>

					<h3>Flexible lease duration</h3>
					<p>Life is uncertain and flexibility is the new stability. Find homes available from 3 months to 3 years and everything in-between.</p>
				</div>
			</div>

			<div class="col-md-4">
				<!-- Icon Box -->
				<div class="icon-box-1 alternative">

					<div class="icon-container">
						<i class="im im-icon-Idea"></i>
					</div>

					<h3>Video tours and self-tours</h3>
					<p>You know what you want in a home. Take a sneak peek with our online video tours or book an in-person self-tour on your schedule.</p>
				</div>
			</div>

		</div>
	</div>

</section>
<!-- Fullwidth Section / End -->


<!-- Flip banner -->
<a href="/find-a-homebase" class="flip-banner parallax" data-background="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/intro-minimized.jpg" data-color="#274abb" data-color-opacity="0.9" data-img-width="2500" data-img-height="1600">
	<div class="flip-banner-content">
		<h2 class="flip-visible">We help people and homes find each other</h2>
		<h2 class="flip-hidden">Browse Properties <i class="sl sl-icon-arrow-right"></i></h2>
	</div>
</a>
<!-- Flip banner / End -->