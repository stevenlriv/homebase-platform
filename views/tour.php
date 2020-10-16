<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Content
================================================== -->

<!-- Map Container -->
<div class="contact-map margin-bottom-55">
</div>
<div class="clearfix"></div>
<!-- Map Container / End -->


<!-- Container / Start -->
<div class="container">

	<div class="row">

		<!-- Contact Details -->
		<div class="col-md-4 margin-bottom-35">

			<h4 class="headline margin-bottom-30"><?php echo $listing['listing_title']; ?> Tour</h4>

			<!-- Contact Details -->
			<div class="sidebar-textbox">
                <div style="height: 280px;"><img src="<?php echo get_json($listing['listing_images'], 0); ?>" alt="<?php echo $listing['physical_address']; ?>" class="img-thumbnail"/></div>

                <div>
				<ul class="contact-details">
					<li><i class="im im-icon-Clock"></i> <strong>Duración</strong> <span>15 minutos</span></li>
					<li><i class="im im-icon-Map-Marker"></i> <strong>Ubicación</strong> <span><a href="https://maps.google.com/maps?q=<?php echo $listing['physical_address']; ?>" class="listing-address popup-gmaps"><?php echo $listing['physical_address']; ?></a></span></li>
                    <!--<li><i class="im im-icon-Landscape"></i> <strong>Local Time Zone</strong> <span><a href="https://maps.google.com/maps?q=<?php echo $listing['physical_address']; ?>" class="listing-address popup-gmaps"><?php echo $listing['physical_address']; ?></a></span></li>-->
				</ul>
                </div>
			</div>

		</div>

		<!-- Contact Form -->
		<div class="col-md-8">

			<section id="contact">
				<h4 class="headline margin-bottom-35">Selecione la hora y el día para coordinar su cita</h4>

                <?php
					if(are_messages_empty()) {
                        if($user) {
                            $form_info = 'Hola, '.$user['fullname'].'. Recibirá un mensaje de texto con las instrucciones.';
                        }
                        else {
                            $form_info = 'Recibirá un mensaje de texto con las instrucciones.';
                        }
                    }
                    
		            show_message($form_success, $form_error, $form_info);
	            ?>

                    <br />

					<div id="bookingjs"></div>

			</section>
		</div>
		<!-- Contact Form / End -->

	</div>

</div>
<!-- Container / End -->