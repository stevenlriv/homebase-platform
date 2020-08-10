<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }

	// Featured use so people can contact us about the house they are interested in renting out, while
	// We build the payment platform
	if( !empty($_GET['property']) && is_uri($_GET['property']) ) {

		$listing = is_uri($_GET['property']);

		if($listing) {
			$subject = "Interested in renting out {$listing['listing_title']}";
			$message = "Phone Number, Email, Lease Length, Move-in Date";
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

			<h4 class="headline margin-bottom-30">Encuéntranos allí</h4>

			<!-- Contact Details -->
			<div class="sidebar-textbox">
				<p>Estamos disponibles para ayudar y responder a cualquier pregunta que pueda tener.</p>

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
				<h4 class="headline margin-bottom-35">Formulario de contacto</h4>

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
										echo '<input name="name" type="text" id="name" placeholder="Su Nombre" />';
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
										echo '<input name="email" type="email" id="email" placeholder="Email" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" />';
									}
								?>
							</div>
						</div>
					</div>

					<div>
						<input name="subject" type="<?php if(!empty($listing)) { echo "hidden"; } else { echo "text"; } ?>" id="subject" placeholder="Asunto" <?php if(!empty($subject)) echo 'value="'.$subject.'"'; ?> />
					</div>

					<?php
						// We first verify if we detect that this person was already reccomended
						if(!empty($listing) && !get_referral_cookie()) {
					?>
					<div>
						<input name="person" type="text" id="person" placeholder="¿Alguien le recomendó la propiedad?" value="" />
					</div>
					<?php
						}
					?>

					<div>
						<textarea name="comments" cols="40" rows="3" id="comments" placeholder="Mensaje" spellcheck="true"><?php if(!empty($message)) echo $message; ?></textarea>
					</div>

					<input name="important" class="mfp-hide" type="text" id="important" placeholder="" value="" />

					<input type="submit" class="submit button" id="submit" value="Enviar Mensaje" />

					</form>
			</section>
		</div>
		<!-- Contact Form / End -->

	</div>

</div>
<!-- Container / End -->