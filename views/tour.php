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
					<li><i class="im im-icon-Clock"></i> <strong>Duration</strong> <span>15 minutes</span></li>
					<li><i class="im im-icon-Map-Marker"></i> <strong>Location</strong> <span><a href="https://maps.google.com/maps?q=<?php echo $listing['physical_address']; ?>" class="listing-address popup-gmaps"><?php echo $listing['physical_address']; ?></a></span></li>
                    <li><i class="im im-icon-Landscape"></i> <strong>Local Time Zone</strong> <span><a href="https://maps.google.com/maps?q=<?php echo $listing['physical_address']; ?>" class="listing-address popup-gmaps"><?php echo $listing['physical_address']; ?></a></span></li>
				</ul>
                </div>
			</div>

		</div>

		<!-- Contact Form -->
		<div class="col-md-8">

			<section id="contact">
				<h4 class="headline margin-bottom-35">Fill Out The Form To Schedule A Tour</h4>

                <?php
					if(are_messages_empty()) {
                        if($user) {
                            $form_info = 'Hi, '.$user['fullname'].'. You will receive the instructions as a text message.';
                        }
                        else {
                            $form_info = 'You will receive the instructions as a text message.';
                        }
                    }
                    
		            show_message($form_success, $form_error, $form_info);
	            ?>

                    <br />

					<form method="post" autocomplete="on">

					<div class="row">
						<div class="col-md-6">
							<div>
								<?php
									if($user) {
										echo '<input name="name" type="hidden" id="name" value="'.$user['fullname'].'" />';
									}
									else {
                                        echo '<label for="username">Full Name </label>';
										echo '<input name="name" type="text" id="name" placeholder="Your Full Name" />';
									}
								?>
							</div>
						</div>

						<div class="col-md-6">
							<div>
								<?php
									if($user) {
										echo '<input name="phone_number" type="hidden" id="phone_number" value="'.$user['phone_number'].'" />';
									}
									else {
                                        echo '<label for="username">Phone Number </label>';
										echo '<input name="phone_number" type="text" id="phone_number" placeholder="Your Phone Number" />';
									}
								?>
							</div>
						</div>
					</div>

                    <br />

                    <div>
                        <?php
						    if($user) {
							    echo '<input name="email" type="hidden" id="email" value="'.$user['email'].'" />';
							}
							else {
                                echo '<label for="username">Email</label>';
								echo '<input name="email" type="text" id="email" placeholder="Your Email" />';
							}
						?>
                    </div>

                    <div>
                        <label for="username">Drivers Licence Number</label>
						<input name="driver" type="text" id="driver" placeholder="Your Drivers License Number" />
                    </div>

                    <br />

					<div>
                        <label for="username">Select Date & Time </label> <br />
                        <input type="text" id="date-picker" placeholder="Date" readonly="readonly">
					</div>

                    <div>
                    </div>

					<input name="property" type="hidden" id="property" value="<?php echo $listing['id_property']; ?>" />

                    <br />
					<input type="submit" class="submit button" id="submit" value="Schedule Tour" />

					</form>
			</section>
		</div>
		<!-- Contact Form / End -->

	</div>

</div>
<!-- Container / End -->