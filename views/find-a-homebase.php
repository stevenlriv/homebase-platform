<?php
    if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
    
	//We proccess the query details and the current search URL
	$url = '';
	$query = array();
		//Only Show Active Properties
		array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "status", "command" => "=", "value" => "active"));

    ///////////////// QUERY /////////////////
    //0 => ( array() ),
        //Location
        if(!empty($_GET['location'])) {
			$location = sanitize_xss($_GET['location']);
			$_SESSION['search-location'] = $location;
			$url = $url."location=$location&";

			//By Zipcode
			if(is_numeric($location)) {
                array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "zipcode", "command" => "=", "value" => $location));			
			}
			else {
				//Search for a city; Limit one because all we need is the first city id
				$city = get_cities('one', array( 
					0 => array("type" => "CHR", "condition" => "AND", "loose" => true, "table" => "name", "command" => "LIKE", "value" => $location),
					1 => array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "state", "command" => "LIKE", "value" => $location),
					2 => array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "country", "command" => "LIKE", "value" => $location),
				), "LIMIT 1");	

				if($city) {
                    array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "id_city", "command" => "=", "value" => $city['id_city']));	
				}
				else {
					//Physical Address
                    array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => true, "table" => "physical_address", "command" => "LIKE", "value" => $location));
                    
                    //Keywords
                    array_push($query, array("type" => "CHR", "condition" => "OR", "loose" => true, "table" => "keywords", "command" => "LIKE", "value" => $location));	
				}				
			}
		}
		else {
			$_SESSION['search-location'] = ''; //to reset for fields if left empty
		}

        //Type
        if(!empty($_GET['type'])) {
            $type = sanitize_xss($_GET['type']);
			$_SESSION['search-type'] = $type;

            if($type == 'apartment' || $type == 'house') {
                $url = $url."type=$type&";

                array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "type", "command" => "=", "value" => $type));
            }
        }
		else {
			$_SESSION['search-type'] = ''; //to reset for fields if left empty
		}

        //Date
        if(!empty($_GET['date'])) {
			$date = sanitize_xss($_GET['date']);
			$_SESSION['search-date'] = $date;

            $url = $url."date=$date&";

            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "available", "command" => "<=", "value" => $date));	
        }
		else {
			$_SESSION['search-date'] = ''; //to reset for fields if left empty
		}

        //Bedroom
        if(!empty($_GET['bedroom'])) {
			$bedroom = sanitize_xss($_GET['bedroom']);
			$_SESSION['search-bedroom'] = $bedroom;
            $url = $url."bedroom=$bedroom&";

            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "number_rooms", "command" => "=", "value" => $bedroom));
        }
		else {
			$_SESSION['search-bedroom'] = ''; //to reset for fields if left empty
		}

        //Bathroom
        if(!empty($_GET['bathroom'])) {
			$bathroom = sanitize_xss($_GET['bathroom']);
			$_SESSION['search-bathroom'] = $bathroom;
            $url = $url."bathroom=$bathroom&";

            array_push($query, array("type" => "CHR", "condition" => "AND", "loose" => false, "table" => "number_bathroom", "command" => "=", "value" => $bathroom));
        }
		else {
			$_SESSION['search-bathroom'] = ''; //to reset for fields if left empty
		}

        //Maxprice
        if(!empty($_GET['maxprice']) && is_numeric($_GET['maxprice'])) {
			$maxprice = sanitize_xss($_GET['maxprice']);
			$_SESSION['search-maxprice'] = $maxprice;
            $url = $url."maxprice=$maxprice&";

            array_push($query, array("type" => "INT", "condition" => "AND", "loose" => false, "table" => "monthly_house", "command" => "<=", "value" => $maxprice));
        }
		else {
			$_SESSION['search-maxprice'] = ''; //to reset for fields if left empty
		}

    /////////////////////////////////////////

    //Lets get the query results
    $total_results = get_listings('count', $query);

    //Pagination configuration
    //Lets get the actual page
    if (!empty($_GET['p']) && is_numeric($_GET['p'])) {
        $page = $_GET['p'];
    } 
    else {
        $page = 1;
    }

    $no_of_records_per_page = 10;
    $offset = ($page-1) * $no_of_records_per_page; 
    $total_pages = ceil($total_results / $no_of_records_per_page);
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
			    <li><a href="#" id="prevpoint" title="Previous point on map">Prev</a></li>
			    <li><a href="#" id="nextpoint" title="Next point on mp">Next</a></li>
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
						<h4 class="search-title">Find Your Home</h4>

						<!-- Form -->
                        <form action="/find-a-homebase" type="GET">
                        
						<div class="main-search-box no-shadow">


							<!-- Row With Forms -->
							<div class="row with-forms">

								<!-- Main Search Input -->
								<div class="col-fs-6">
									<input type="text" placeholder="Enter address e.g. street, city or state" value="<?php if(!empty($_SESSION['search-location'])) echo sanitize_xss($_SESSION['search-location']); ?>" name="location"/>
								</div>

								<!-- Status -->
								<div class="col-fs-3">
                                    <input type="text" value="Move In date" readonly="readonly" style="border: none !important; background: none !important;">
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

									</div>
									<!-- Row With Forms / End -->

								</div>

							</div>
							<!-- More Search Options / End -->

						</div>
						<!-- Box / End -->
                        </form>
					</div>
				</div>

			</section>
			<!-- Search / End -->

			<!-- Sorting / Layout Switcher -->
			<div class="row fs-switcher">

				<div class="col-md-6">
					<!-- Showing Results -->
					<p class="showing-results"><?php echo $total_results; ?> Results Found </p>
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
                $query_listings = get_listings('all', $query, "ORDER BY id_listing DESC LIMIT $offset, $no_of_records_per_page");

				foreach ( $query_listings  as $id => $value ) {
			?>
				<!-- Listing Item -->
				<div class="listing-item">

					<a href="/<?php echo $value['uri']; ?>" class="listing-img-container">

						<div class="listing-badges">
                            <?php
							    //We randomly add the featured tab to "odd" "id_listing
							    if($value['id_listing'] % 2 != 0) {
							        echo '<span class="featured">Featured</span>';
							    }
							?>
							<span>For Rent</span>
						</div>

						<div class="listing-img-content">
							<span class="listing-price">$<?php echo $value['monthly_house']; ?>  <i>monthly</i></span>
							<!--<span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>
							<span class="compare-button with-tip" data-tip-content="Add to Compare"></span>-->
						</div>

                        <div class="listing-carousel">
								<?php
									foreach ( get_json($value['listing_images'], 'all') as $id => $image ) {
										echo '<div style="height: 280px;"><img src="'.$image.'" alt="'.$value['physical_address'].'"></div>';
									}
								?>
							</div>

					</a>
					
					<div class="listing-content">

						<div class="listing-title">
							<h4><a href="/<?php echo $value['uri']; ?>"><?php echo $value['listing_title']; ?></a></h4>
							<a href="https://maps.google.com/maps?q=<?php echo $value['physical_address']; ?>" class="listing-address popup-gmaps">
								<i class="fa fa-map-marker"></i>
								<?php echo $value['physical_address']; ?>
							</a>

							<a href="/<?php echo $value['uri']; ?>" class="details button border">Details</a>
						</div>

						<ul class="listing-details">
							<li><?php echo $value['square_feet']; ?> sq ft</li>
							<li><?php echo $value['number_rooms']; ?> Bedrooms</li>
							<li><?php echo $value['number_bathroom']; ?> Bathrooms</li>
						</ul>

						<div class="listing-footer">
							<a href="#" style="visibility: hidden;"><i class="fa fa-user"></i> Harriette Clark</a>
							<span><i class="fa fa-calendar-o"></i> <?php 
								
                                if($value['available'] > date("m/d/Y")) {
                                    echo "Available soon";
                                }
                                else {
                                    echo "Available now";
                                }
                                
                        ?></span>
						</div>

					</div>

				</div>
				<!-- Listing Item / End -->

            <?php
				}
			?>

			</div>
			<!-- Listings Container / End -->


			<!-- Pagination Container -->
			<div class="row fs-listings">
				<div class="col-md-12">

					<!-- Pagination -->
					<div class="clearfix"></div>
					<div class="pagination-container margin-top-10 margin-bottom-45">
						<nav class="pagination">
							<ul>
                                <?php
                                    if($total_pages > 1 ) {
                                        
                                        //First page
                                        if($page != 1) {
                                            echo "<li><a href=\"?p=1&{$url}\">1</a></li>\n";
                                        }

                                        //Place holder
                                        //We don't show it in the first 3 pages
                                        if($page != 1 && $page != 2 && $page != 3) {
                                            echo "<li class=\"blank\">...</li>\n";
                                        }

                                        //Backward pages
                                        if( ($page-2)>=2 ) {
                                            echo "<li><a href=\"?p=".($page-2)."&{$url}\">".($page-2)."</a></li>\n";
                                        }
                                        if( ($page-1)>1 ) {
                                            echo "<li><a href=\"?p=".($page-1)."&{$url}\">".($page-1)."</a></li>\n";
                                        }

                                        //Show current page
                                        echo "<li class=\"blank\">".($page)."</li>\n";                             

                                        //Foward pages
                                        if( ($page+1)<$total_pages ) {
                                            echo "<li><a href=\"?p=".($page+1)."&{$url}\">".($page+1)."</a></li>\n";
                                        }
                                        if( ($page+2)<$total_pages ) {
                                            echo "<li><a href=\"?p=".($page+2)."&{$url}\">".($page+2)."</a></li>\n";
                                        }

                                        //Place holder
                                        //We don't show it is its the last 3 pages
                                        if($page != $total_pages && $page != ($total_pages-1) && $page != ($total_pages-2)) {
                                            echo "<li class=\"blank\">...</li>\n";
                                        }
                                        
                                        //Last page
                                        if($page != $total_pages) {
                                            echo "<li><a href=\"?p=".($total_pages)."&{$url}\">".($total_pages)."</a></li>\n";
                                        }
                                        
                                    }
                                ?>
							</ul>
						</nav>

						<nav class="pagination-next-prev">
							<ul>
                                <?php
                                    if($page > 1) {
                                        echo '<li><a href="?p='.($page-1).'&'.$url.'" class="prev">Previous</a></li>';
                                    }
                                    
                                    if($page < $total_pages) {
                                        echo '<li><a href="?p='.($page+1).'&'.$url.'" class="next">Next</a></li>';
                                    }
                                ?>
							</ul>
						</nav>
					</div>

				</div>
			</div>
			<!-- Pagination Container / End -->
			

		</div>
	</div>

</div>