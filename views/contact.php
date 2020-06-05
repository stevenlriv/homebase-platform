<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	// Featured use so people can contact us about the house they are interested in renting out, while
	// We build the payment platform
	if( !empty($_GET['property']) && is_uri($_GET['property']) && !empty($_GET['date']) ) {

		$listing = is_uri($_GET['property']);

		if($listing) {
			$date = sanitize_xss($_GET['date']);

			$subject = "Interested in renting out {$listing['listing_title']}";
			$message = "Looking to rent the property located at {$listing['physical_address']}. The starting date of the rental agreement will be {$date}.";
		}
	}

	// Tenant Account Inquiry
	$tenant = false;
	if( !empty($_GET['inquiry']) ) {
		$tenant = true;

		if($_GET['inquiry'] == 'tenant') {
			$subject = "Interested in renting with Homebase";
			$message = "I'm a tenant, who is looking to rent a property with Homebase. The property is located at ...";	
		}	
	}
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

			<h4 class="headline margin-bottom-30">Find Us There</h4>

			<!-- Contact Details -->
			<div class="sidebar-textbox">
				<p>We’re available to help and answer any questions you may have.</p>

				<ul class="contact-details">
					<li><i class="im im-icon-Envelope"></i> <strong>E-Mail:</strong> <span><a href="mailto:<?php _setting(1); ?>"><?php _setting(1); ?></a></span></li>
					<li><i class="im im-icon-Facebook"></i> <strong>Facebook:</strong> <span><a href="<?php _setting(2); ?>" target="_blank"><?php _setting(13); ?></a></span></li>
					<li><i class="im im-icon-Instagram"></i> <strong>Instagram:</strong> <span><a href="<?php _setting(3); ?>" target="_blank"><?php _setting(14); ?></a></span></li>
				</ul>
			</div>

		</div>

		<!-- Contact Form -->
		<div class="col-md-8">

			<section id="contact">
				<h4 class="headline margin-bottom-35">Contact Form</h4>

				<div id="contact-message"></div> 

					<form method="post" action="/contact.php" name="contactform" id="contactform" autocomplete="on">

					<div class="row">
						<div class="col-md-6">
							<div>
								<?php
									if($user) {
										echo '<input name="name" type="hidden" id="name" value="'.$user['fullname'].'" />';
									}
									else {
										echo '<input name="name" type="text" id="name" placeholder="Your Name" />';
									}
								?>
							</div>
						</div>

						<div class="col-md-6">
							<div>
								<?php
									if($user) {
										echo '<input name="email" type="hidden" id="email" value="'.$user['email'].'" />';
									}
									else {
										echo '<input name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" />';
									}
								?>
							</div>
						</div>
					</div>

					<div>
						<input name="subject" type="<?php if(!empty($listing) || $tenant) { echo "hidden"; } else { echo "text"; } ?>" id="subject" placeholder="Subject" <?php if(!empty($subject)) echo 'value="'.$subject.'"'; ?> />
					</div>

					<?php
						// We first verify if we detect that this person was already reccomended
						if(!empty($listing) && !get_referral_cookie()) {
					?>
					<div>
						<input name="person" type="text" id="person" placeholder="Did any one recommended you the property?" value="" />
					</div>
					<?php
						}
					?>

					<div>
						<textarea name="comments" cols="40" rows="3" id="comments" placeholder="Message" spellcheck="true"><?php if(!empty($message)) echo $message; ?></textarea>
					</div>

					<input name="important" class="mfp-hide" type="text" id="important" placeholder="" value="" />

					<input type="submit" class="submit button" id="submit" value="Submit Message" />

					</form>
			</section>
		</div>
		<!-- Contact Form / End -->

	</div>

</div>
<!-- Container / End -->