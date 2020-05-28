<?php

 function show_message($success = '', $error = '', $info = '', $big_info = false) {
	global $request;
	
    $type = '';

    if(!empty($success)) {
        $type = 'success';
        $message = $success;
	}
	elseif(!empty($info)) {
        $type = 'notice';
        $message = $info;
	}
    else {
        $type = 'error';
        $message = $error;
    }

	if($big_info && $type == 'notice' ) {
		echo '<div class="notification notice large margin-bottom-55">';
			echo '<h4>Quick Notice!</h4>';
			echo '<p>'.$message.'</p>';
		echo '</div>';
	}
    elseif($message != '') {
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
    global $request, $user;
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

                    <?php
                        //Tenants Menu
                        if($user['type'] == 'tenants') {
                    ?>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Your Property</li>
						<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> My Property</a></li>
						<li><a href="#" <?php if($request == '/payments') echo 'class="current"'; ?>><i class="sl sl-icon-credit-card"></i> Payments</a></li>
                        <li><a href="#" <?php if($request == '/leases') echo 'class="current"'; ?>><i class="sl sl-icon-briefcase"></i> Lease</a></li>
					</ul>

                    <?php
                        //Realtor Menu
                        }
                        else {
                    ?>
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Properties</li>
						<li><a href="/my-properties" <?php if($request == '/my-properties') echo 'class="current"'; ?>><i class="sl sl-icon-docs"></i> My Properties</a></li>
						<li><a href="/submit-property"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Financials</li>
						<li><a href="#" <?php if($request == '/payments') echo 'class="current"'; ?>><i class="sl sl-icon-credit-card"></i> Payments</a></li>
                        <li><a href="#" <?php if($request == '/leases') echo 'class="current"'; ?>><i class="sl sl-icon-briefcase"></i> Leases</a></li>
                        <li><a href="#" <?php if($request == '/financial-settings') echo 'class="current"'; ?>><i class="sl sl-icon-settings"></i> Settings</a></li>
					</ul>
                    <?php
                        }
                    ?>

					<ul class="my-account-nav">
						<li><a href="/logout"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>

<?php
}

function full_search_form($type = '') {
	//action for search form
	if($type == 'my-properties') {
		$action = '/my-properties';
		$date_name = 'Available By';
	}
	else {
		$action = '/find-a-homebase';
		$date_name = 'Move In date';
	}
?>

<!-- Form -->
<form action="<?php echo $action; ?>" type="GET">
                        
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">

								<!-- Main Search Input -->
								<div class="col-fs-6">
									<input type="text" placeholder="Enter address e.g. street, city or state" value="<?php if(!empty($_SESSION['search-location'])) echo sanitize_xss($_SESSION['search-location']); ?>" name="location"/>
								</div>

								<!-- Status -->
								<div class="col-fs-3">
                                    <input type="text" value="<?php echo $date_name; ?>" readonly="readonly" style="border: none !important; background: none !important;">
								</div>

								<!-- Property Type -->
								<div class="col-fs-3">
                                    <input name="date" type="text" id="date-picker" placeholder="Date" readonly="readonly">
								</div>

							</div>
							<!-- Row With Forms / End -->

							<!-- Search Button -->
							<button class="button fs-map-btn">Search</button>

							<!-- More Search Options -->
							<a href="#" class="more-search-options-trigger margin-top-20" data-open-title="More Options" data-close-title="Less Options"></a>

							<div class="more-search-options relative">
								<div class="more-search-options-container margin-top-30">

									<!-- Row With Forms -->
									<div class="row with-forms">

										<!-- Age of Home -->
										<div class="col-fs-3">
										    <select name="type" data-placeholder="Type (Any)" class="chosen-select-no-single">
												<option value="">Type (Any)</option>
                                                <option <?php if(!empty($_SESSION['search-type']) && $_SESSION['search-type'] == 'house') echo 'selected="selected"' ?> value="house">House</option>
											    <option <?php if(!empty($_SESSION['search-type']) && $_SESSION['search-type'] == 'apartment') echo 'selected="selected"' ?> value="apartment">Apartment</option>
										    </select>
										</div>

										<!-- Rooms Area -->
										<div class="col-fs-3">
											<select name="bedroom" data-placeholder="Bedrooms (Any)" class="chosen-select-no-single" >
												<option value="">Bedrooms (Any)</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '1') echo 'selected="selected"' ?>>1</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '2') echo 'selected="selected"' ?>>2</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '3') echo 'selected="selected"' ?>>3</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '4') echo 'selected="selected"' ?>>4</option>
												<option <?php if(!empty($_SESSION['search-bedroom']) && $_SESSION['search-bedroom'] == '5') echo 'selected="selected"' ?>>5</option>
											</select>
										</div>

										<!-- Max Area -->
										<div class="col-fs-3">
											<select name="bathroom" data-placeholder="Bathrooms (Any)" class="chosen-select-no-single" >
												<option value="">Bathrooms (Any)</option>	
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '1') echo 'selected="selected"' ?>>1</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '2') echo 'selected="selected"' ?>>2</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '3') echo 'selected="selected"' ?>>3</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '4') echo 'selected="selected"' ?>>4</option>
												<option <?php if(!empty($_SESSION['search-bathroom']) && $_SESSION['search-bathroom'] == '5') echo 'selected="selected"' ?>>5</option>
											</select>
										</div>

										<div class="col-fs-3">
                                            <select name="maxprice" data-placeholder="Max Price (None)" class="chosen-select-no-single">	
                                                <option value="">Max Price (None)</option>
                                                <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '500') echo 'selected="selected"' ?>>500</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '1000') echo 'selected="selected"' ?>>1000</option>
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '2000') echo 'selected="selected"' ?>>2000</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '3000') echo 'selected="selected"' ?>>3000</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '4000') echo 'selected="selected"' ?>>4000</option>	
											    <option <?php if(!empty($_SESSION['search-maxprice']) && $_SESSION['search-maxprice'] == '5000') echo 'selected="selected"' ?>>5000</option>	
										    </select>
										</div>

										<?php
											if($type == 'my-properties') {
										?>
										<!-- Status -->
										<div class="col-fs-3">
										    <select name="status" data-placeholder="Status (Any)" class="chosen-select-no-single">
												<option value="">Prop. Status (Any)</option>
                                                <option <?php if(!empty($_SESSION['search-status']) && $_SESSION['search-status'] == 'active') echo 'selected="selected"' ?> value="active">Active</option>
											    <option <?php if(!empty($_SESSION['search-status']) && $_SESSION['search-status'] == 'inactive') echo 'selected="selected"' ?> value="inactive">Hidden</option>
										    </select>
										</div>
										<?php
											}
										?>

									</div>
									<!-- Row With Forms / End -->

								</div>

							</div>
							<!-- More Search Options / End -->

						</div>
						<!-- Box / End -->
                        </form>





<?php
}
?>