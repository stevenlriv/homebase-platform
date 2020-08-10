<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	//Only Show Active Properties
	array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"));

    //Lets get the query results
    $total_results = get_listings('count', $query);

	//Pagination configuration
	$pagination = new Pagination($total_results, $url);
?>
<!-- Content
================================================== -->
<div class="fs-container">

	<div class="fs-inner-container">

		<!-- Map -->
		<div id="map-container">
		    <div id="map" data-map-zoom="4" data-map-scroll="true">
		        <!-- map goes here -->
		    </div>

		    <!-- Map Navigation -->
			<a href="#" id="geoLocation" title="Your location"></a>
			<ul id="mapnav-buttons" class="top">
			    <li><a href="#" id="prevpoint" title="Previous point on map">Anterior</a></li>
			    <li><a href="#" id="nextpoint" title="Next point on mp">Siguiente</a></li>
			</ul>
		</div>

	</div>


	<div class="fs-inner-container">
		<div class="fs-content">

			<!-- Search -->
			<section class="search margin-bottom-30">

				<div class="row">
					<div class="col-md-12">

						<!-- Title -->
						<h4 class="search-title">Encontrar Una Casa</h4>

						<?php full_search_form(); ?>
   
					</div>
				</div>

			</section>
			<!-- Search / End -->

			<!-- Sorting / Layout Switcher -->
			<div class="row fs-switcher">

				<div class="col-md-6">
					<!-- Showing Results -->
					<p class="showing-results"><?php echo $total_results; ?> Resultados Encontrados </p>
				</div>

				<div class="col-md-6">
					<!-- Layout Switcher -->
					<div class="layout-switcher hidden">
						<a href="#" class="list"><i class="fa fa-th-list"></i></a>
						<a href="#" class="grid"><i class="fa fa-th-large"></i></a>
					</div>
				</div>
			</div>

			<?php
				if($total_results == 0) {
			?>

				<!-- No results / Cities -->

			<?php
				}
			?>
			<!-- Listings -->
			<div class="listings-container list-layout row fs-listings">

			<?php
                $query_listings = get_listings('all', $query, "ORDER BY id_listing DESC LIMIT {$pagination->get_offset()}, {$pagination->get_records_per_page()}");

				foreach ( $query_listings  as $id => $value ) {
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
							<span class="listing-price">$<?php echo $value['monthly_house']; ?>  <i>mensual</i></span>
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
							<a href="#" style="visibility: hidden;"><i class="fa fa-user"></i> Harriette Clark</a>
							<span><i class="fa fa-calendar-o"></i> <?php print_available_message('status', $value['available']); ?></span>
						</div>

					</div>

				</div>
				<!-- Listing Item / End -->

            <?php
				}
			?>

			</div>
			<!-- Listings Container / End -->


			<?php
				$pagination->print();
			?>
			

		</div>
	</div>

</div>