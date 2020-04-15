<?php 
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
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

					<input type="hidden" name="property" value="<?php echo $listing['id_listing']; ?>">

					<!-- Book Now -->
					<div id="booking-widget-anchor" class="boxed-widget booking-widget margin-top-35 margin-bottom-35">
						<h3><i class="fa fa-calendar-check-o "></i> Rent This Property</h3>
						<div class="row with-forms  margin-top-0">

							<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
							<div class="col-lg-12">
								<input name="date" type="text" id="date-picker" placeholder="Date" readonly="readonly">
							</div>

							<!-- Panel Dropdown -->
							<div class="col-lg-12">
								<div class="panel-dropdown">
									<a href="#">Family Members <span class="qtyTotal" name="qtyTotal">1</span></a>
									<div class="panel-dropdown-content">

										<!-- Quantity Buttons -->
										<div class="qtyButtons">
											<div class="qtyTitle">Adults</div>
											<input type="text" name="qtyInput" value="1">
										</div>

										<div class="qtyButtons">
											<div class="qtyTitle">Childrens</div>
											<input type="text" name="qtyInput" value="0">
										</div>

									</div>
								</div>
							</div>
							<!-- Panel Dropdown / End -->

						</div>
						
						<!-- Book Now -->
						<button class="button book-now fullwidth margin-top-5">Rent Now</button>

					</div>
					<!-- Book Now / End -->

					</form>


				</div>
				<!-- Booking Widget / End -->