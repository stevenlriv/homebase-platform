<?php

 function show_message($success = '', $error = '') {

    $type = '';

    if(!empty($success)) {
        $type = 'success ';
        $message = $success;
    }
    else {
        $type = 'error ';
        $message = $error;
    }

    if($message != '') {
	    echo '<div class="notification '.$type.' closeable">';
	        echo '<p>'.$message.'</p>';
        echo '</div>';
    }

 }

 function booking_component($listing, $jquery_id) {
    
    if($listing['calendly_link'] != '') {
?>
            <!-- Tour Widget -->
            <div class="widget">
                <div id="booking-widget-anchor" class="boxed-widget booking-widget">
                    <a href="<?php echo $listing['calendly_link']; ?>" target="_blank" class="button book-now fullwidth margin-top-5">Schedule a Tour</a>
                </div>
            </div>
            <!-- Tour Widget / End -->
            <?php
                }
            ?>

            <!-- Booking Widget -->
            <div class="widget">

                <form action="/contact" type="GET">

                <input type="hidden" name="property" value="<?php echo $listing['uri']; ?>">

                <!-- Book Now -->
                <div id="booking-widget-anchor" class="boxed-widget booking-widget margin-top-35 margin-bottom-35">
                    <h3><i class="fa fa-calendar-check-o "></i> Rent This Property</h3>
                    <div class="row with-forms  margin-top-0">

                        <!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
                        <div class="col-lg-12">
                            <input name="date" type="text" id="<?php echo $jquery_id; ?>" placeholder="Date" readonly="readonly">
                        </div>

                    </div>
                    
                    <!-- Book Now -->
                    <button class="button book-now fullwidth margin-top-5">Rent Now</button>

                </div>
                <!-- Book Now / End -->

                </form>


            </div>
            <!-- Booking Widget / End -->

<?php
}

function sidebar_component() {
    global $request;
?>

        <!-- Widget -->
		<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="/my-profile" <?php if($request == '/my-profile') echo 'class="current"'; ?>><i class="sl sl-icon-user"></i> My Profile</a></li>
						<li><a href="/change-password" <?php if($request == '/change-password') echo 'class="current"'; ?>><i class="sl sl-icon-lock"></i> Change Password</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> My Properties</a></li>
						<li><a href="/submit-property"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li><a href="/logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>

<?php
}
?>