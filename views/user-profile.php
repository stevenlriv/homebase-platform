<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

    // Add to the url the current user
    $url = $url."id={$view_user['id_user']}&";
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2><?php echo $view_user['fullname']; ?></h2>
				<?php if(!empty($view_user['country'])) { echo '<span>From '.$view_user['country'].'</span>'; } ?>
				
				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Inicio</a></li>
						<li>Perfil de Usuario</li>
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

		<div class="col-md-12">
			<div class="agent agent-page">

				<div class="agent-avatar">
					<img src="<?php if(!empty($view_user['profile_image'])) { echo $view_user['profile_image']; } else { echo 'https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/agent-03.jpg'; }; ?>" alt="">
				</div>

				<div class="agent-content">
					<div class="agent-name">
						<h4><?php echo $view_user['fullname']; ?></h4>
                        <?php if(!empty($view_user['country'])) { echo '<span>From '.$view_user['country'].'</span>'; } ?>

                        <?php
                            if(is_admin()) {
                        ?>
                            <span>Estado de cuenta: <?php echo $view_user['status']; ?></span>
                        <?php
                            }
                        ?>
					</div>

					<p><?php echo $view_user['profile_bio']; ?></p>

					<ul class="agent-contact-details">
						<li><i class="sl sl-icon-call-in"></i><a href="tel:<?php echo $view_user['phone_number']; ?>"><?php echo $view_user['phone_number']; ?></a></li>
						<li><i class="fa fa-envelope-o "></i><a href="mailto:<?php echo $view_user['email']; ?>"><?php echo $view_user['email']; ?></a></li>
					</ul>

					<ul class="social-icons">
                        <?php
                            if(!empty($view_user['profile_linkedIn'])) {
                        ?>
                        <li><a class="linkedin" href="<?php echo $view_user['profile_linkedIn']; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php
                            }
                        ?>
					</ul>
					<div class="clearfix"></div>
				</div>

			</div>
		</div>

	</div>
</div>

<?php
    //Show properties if is a landlord or realtor
    if($view_user['type'] == 'realtors' || $view_user['type'] == 'landlords') {

        //Show only this user properties
        array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_user", "command" => "=", "value" => $view_user['id_user']));

        //Only show active properties
        array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"));

        //Lets get the query results
        $total_results = get_listings('count', $query);

        //Pagination configuration
	    $pagination = new Pagination($total_results, $url, 'col-md-12');
?>
<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">

		<div class="col-lg-12 col-md-12">

			<h4 class="headline">Unidades del Usuario</h4>

            <?php
			    if($total_results == 0 && !isset($_GET)) {
		    ?>
			    <div class="col-md-8">
				    <h3>El usuario no tiene actualmente propiedades en la plataforma.</h3>
			    </div>

		    <?php
			    }
			    else {
		    ?>

			<!-- Main Search Input -->
            <?php full_search_form('profile', $view_user['id_user']); ?>
                <br />
                    <br />
			<!-- Listings -->
			<div class="listings-container list-layout">

                <?php
                    $query_listings = get_listings('all', $query, "ORDER BY id_listing DESC LIMIT {$pagination->get_offset()}, {$pagination->get_records_per_page()}");

                    foreach ( $query_listings as $id => $value ) {
				?>
					<!-- Listing Item -->
					<div class="listing-item">

						<a href="/<?php echo $value['uri']; ?>" class="listing-img-container" target="_blank">

							<div class="listing-badges">
                            	<?php
							    	if($value['featured']) {
							        	echo '<span class="featured">Featured</span>';
							    	}
								?>
								<span>En Alquiler</span>
							</div>

							<div class="listing-img-content">
								<span class="listing-price">$<?php echo $value['monthly_house']; ?> <i>mensual</i></span>
								<!--<span class="like-icon"></span>-->
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
								<h4><a href="/<?php echo $value['uri']; ?>" target="_blank"><?php echo $value['listing_title']; ?></a></h4>
								<a href="https://maps.google.com/maps?q=<?php echo $value['physical_address']; ?>" class="listing-address popup-gmaps">
									<i class="fa fa-map-marker"></i>
									<?php echo $value['physical_address']; ?>
								</a>

								<a href="/<?php echo $value['uri']; ?>" class="details button border" target="_blank">Detalles</a>
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
			<!-- Listings Container / End -->

			
			<!-- Pagination -->
			<?php
				$pagination->print();
			?>
			<!-- Pagination / End -->

            <?php
                } // End user has properties
            ?>

		</div>
    </div>
</div>
<?php
    }
?>