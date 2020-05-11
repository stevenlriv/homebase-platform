<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
	
	$cache = get_cache('my-profile');
?>

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>My Profile</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>My Profile</li>
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


		<?php sidebar_component(); ?>

		<div class="col-md-8">
			<div class="row">


				<div class="col-md-8 my-profile">

					<form method="post" class="form-cache" id="my-profile">

						<?php
							if($cache) {
								$form_info = 'Press the "Save Changes" button below to save your information.';
							}

							show_message($form_success, $form_error, $form_info);
						?>

						<h4 class="margin-top-0 margin-bottom-30">My Account</h4>

						<label>Full Name</label>
						<input name="fullname" value="<?php form_print_value($cache, $user, 'fullname'); ?>" type="text">

						<label>Phone</label>
						<input name="phone_number" value="<?php form_print_value($cache, $user, 'phone_number'); ?>" type="text">

						<label>Email</label>
						<input name="email" value="<?php form_print_value($cache, $user, 'email'); ?>" type="text">


						<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
						<textarea name="profile_bio" id="about" cols="30" rows="10"><?php form_print_value($cache, $user, 'profile_bio'); ?></textarea>
				

						<h4 class="margin-top-50 margin-bottom-25"><i class="fa fa-linkedin"></i> Linkedin</h4>

						<input name="profile_linkedIn" value="<?php form_print_value($cache, $user, 'profile_linkedIn'); ?>" type="text">

						<button name="submit" class="button margin-top-20 margin-bottom-20">Save Changes</button>
					</form>
				</div>

				<div class="col-md-4">
					<form method="post" enctype="multipart/form-data">
						<!-- Avatar -->
						<div class="edit-profile-photo">
							<img src="<?php if(!empty($user['profile_image'])) { echo $user['profile_image']; } else { echo 'https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/agent-03.jpg'; }; ?>" alt="">
							<div class="change-photo-btn">
								<div class="photoUpload">
							    	<span><i class="fa fa-upload"></i> Upload Photo</span>
							    	<input type="file" id="profile_image" name="profile_image" class="upload" />
								</div>
							</div>
						</div>
						<button name="submit-image" id="submit-image" style="display: none;" class="button margin-top-20 margin-bottom-20">Upload Image</button>
					</form>
				</div>


			</div>
		</div>

	</div>
</div>


