<?php
	if ( !defined('THEME_LOAD') ) { die ( header('Location: /not-found') ); }
?>
<!-- Footer
================================================== -->
<?php 
// The sticky footer is hidden for the find a homebase page
if($request != '/find-a-homebase') {

	// Space required if not index page
	if($request != '/' && $request != '/submit-property') {
		echo '<div class="margin-top-55"></div>'; 
	}
?>

<div id="footer" class="sticky-footer">
    <!-- Main -->
    <div class="container">
		<div class="row">
			<div class="col-md-5 col-sm-6">
				<img class="footer-logo" src="https://renthomebase.nyc3.digitaloceanspaces.com/general/theme/images/homebase-logo-2.png" alt="Homebase">
				<br><br>
				<p>Homebase is a marketplace where you can find your next home. It's easy, just take a tour and sign your lease, all online and in a few minutes.</p>
			</div>

			<div class="col-md-4 col-sm-6 ">
				<h4>Helpful Links</h4>
				<ul class="footer-links">
					<li><a href="/faq">FAQ</a></li>
					<li><a href="/find-a-homebase">Find a Homebase</a></li>
                    <li><a href="/for-landlords">For Landlords</a></li>
					<li><a href="/for-realtors">For Realtors</a></li>
				</ul>

				<ul class="footer-links">
				    <li><a href="/contact">Contact</a></li>
					<li><a href="/privacy">Privacy Policy</a></li>
                    <li><a href="/terms">Terms of Service</a></li>
				</ul>
				<div class="clearfix"></div>
			</div>		

			<div class="col-md-3  col-sm-12">
				<h4>Contact Us</h4>
				<div class="text-widget">
					<!--<span>12345 Little Lonsdale St, Melbourne</span> <br>-->
					<!--Phone: <span>(123) 123-456 </span><br>-->
					E-Mail:<span> <a href="mailto:<?php _setting(1); ?>"><?php _setting(1); ?></a> </span><br>
				</div>

				<ul class="social-icons margin-top-20">
					<li><a class="facebook" href="<?php _setting(2); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
					<li><a class="instagram" href="<?php _setting(3); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
				</ul>

			</div>

		</div>
		
		<!-- Copyright -->
		<div class="row">
			<div class="col-md-12">
				<div class="copyrights">© 2019-<?php echo date("Y"); ?> Homebase. All Rights Reserved.</div>
			</div>
		</div>

	</div>

</div>
<!-- Footer / End -->

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

<?php
	} //end sticky footer hidden
?>

<!-- Scripts
================================================== -->
<script type="text/javascript" src="/views/assets/scripts/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/jquery-migrate-3.1.0.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/chosen.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/owl.carousel.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/rangeSlider.js"></script>
<script type="text/javascript" src="/views/assets/scripts/sticky-kit.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/slick.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/mmenu.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/tooltips.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/masonry.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/custom.js"></script>

<!-- Maps -->

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo get_maps_api_key(); ?>&language=en"></script>
<script type="text/javascript" src="/views/assets/scripts/infobox.min.js"></script>
<script type="text/javascript" src="/views/assets/scripts/markerclusterer.js"></script>

<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-<?php echo get_google_analytics(); ?>', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->

<script type="text/javascript">

    // Marker
    // ----------------------------------------------- //
    var markerIcon = {
        path: 'M19.9,0c-0.2,0-1.6,0-1.8,0C8.8,0.6,1.4,8.2,1.4,17.8c0,1.4,0.2,3.1,0.5,4.2c-0.1-0.1,0.5,1.9,0.8,2.6c0.4,1,0.7,2.1,1.2,3 c2,3.6,6.2,9.7,14.6,18.5c0.2,0.2,0.4,0.5,0.6,0.7c0,0,0,0,0,0c0,0,0,0,0,0c0.2-0.2,0.4-0.5,0.6-0.7c8.4-8.7,12.5-14.8,14.6-18.5 c0.5-0.9,0.9-2,1.3-3c0.3-0.7,0.9-2.6,0.8-2.5c0.3-1.1,0.5-2.7,0.5-4.1C36.7,8.4,29.3,0.6,19.9,0z M2.2,22.9 C2.2,22.9,2.2,22.9,2.2,22.9C2.2,22.9,2.2,22.9,2.2,22.9C2.2,22.9,3,25.2,2.2,22.9z M19.1,26.8c-5.2,0-9.4-4.2-9.4-9.4 s4.2-9.4,9.4-9.4c5.2,0,9.4,4.2,9.4,9.4S24.3,26.8,19.1,26.8z M36,22.9C35.2,25.2,36,22.9,36,22.9C36,22.9,36,22.9,36,22.9 C36,22.9,36,22.9,36,22.9z M13.8,17.3a5.3,5.3 0 1,0 10.6,0a5.3,5.3 0 1,0 -10.6,0',
        strokeOpacity: 0,
        strokeWeight: 1,
        fillColor: '#274abb',
        fillOpacity: 1,
        rotation: 0,
        scale: 1,
        anchor: new google.maps.Point(19,50)
	}
	
	var location_array = [
		<?php

			if(!empty($query_listings)) {
          		foreach ( $query_listings as $id => $value ) { 
            		echo "[ locationData('/{$value['uri']}','$".$value['monthly_house']."','monthly','".get_json($value['listing_images'], 0)."','{$value['listing_title']}','{$value['physical_address']}'), {$value['latitude']}, {$value['longitude']}, ".($id+1).", markerIcon ],\n";
				  } 
			}
        ?>
	  ];

    // Locations
    // ----------------------------------------------- //
	function locationData(locationURL,locationPrice,locationPriceDetails,locationImg,locationTitle,locationAddress) {
          return('<a href="'+ locationURL +'" class="listing-img-container"><div class="infoBox-close"><i class="fa fa-times"></i></div><div class="listing-img-content"><span class="listing-price">'+ locationPrice +'<i>' + locationPriceDetails +'</i></span></div><img src="'+locationImg+'" alt=""></a><div class="listing-content"><div class="listing-title"><h4><a href="'+ locationURL +'">'+locationTitle+'</a></h4><p>'+locationAddress+'</p></div></div>')
      }

</script>

<script type="text/javascript" src="/views/assets/scripts/maps.js"></script>

<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
<script src="/views/assets/scripts/moment.min.js"></script>
<script src="/views/assets/scripts/daterangepicker.js"></script>
<script>
///////////////////////////////
// Calendar Init
$(function() {
	$('#date-picker').daterangepicker({
		"opens": "left",
		singleDatePicker: true,

		// Disabling Date Ranges
		isInvalidDate: function(date) {
		// Disabling Date Range
		var disabled_start = moment('09/02/2015', 'MM/DD/YYYY');

		<?php
			//If the $listing var is not empty, that means that we are on a listing and we will be limiting
			//The dates based on that listing data
			$date = date("m/d/Y");

			if(!empty($listing)) {
				if(strtotime($listing['available']) > strtotime(date("m/d/Y"))) {
					$date = $listing['available'];
				}
			}

			echo "var disabled_end = moment('".$date."', 'MM/DD/YYYY')";
		?>
	
		return date.isAfter(disabled_start) && date.isBefore(disabled_end);

		// Disabling Single Day
		// if (date.format('MM/DD/YYYY') == '08/08/2018') {
		//     return true; 
		// }
		},

		<?php 
			//If he is looking for a specific date and is not on a listing show it
			//Or if the listing date is <= that session date show session date as the selected one
			if(!empty($_SESSION['search-date']) && empty($listing) || !empty($_SESSION['search-date']) && !empty($listing) && strtotime($listing['available'])<=strtotime($_SESSION['search-date'])) { 
				$date = $_SESSION['search-date'];
			 } 
		?>

		"startDate": "<?php echo sanitize_xss($date); ?>",
	});
});

// Calendar animation
$('#date-picker').on('showCalendar.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-animated');
});
$('#date-picker').on('show.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-visible');
	$('.daterangepicker').removeClass('calendar-hidden');
});
$('#date-picker').on('hide.daterangepicker', function(ev, picker) {
	$('.daterangepicker').removeClass('calendar-visible');
	$('.daterangepicker').addClass('calendar-hidden');
});

//////////////////////////////////
// Calendar Init MOBILE
$(function() {
	$('#date-picker-mobile').daterangepicker({
		"opens": "center",
		singleDatePicker: true,

		// Disabling Date Ranges
		isInvalidDate: function(date) {
		// Disabling Date Range
		var disabled_start = moment('09/02/2015', 'MM/DD/YYYY');

		<?php
			//If the $listing var is not empty, that means that we are on a listing and we will be limiting
			//The dates based on that listing data
			$date = date("m/d/Y");

			if(!empty($listing)) {
				if(strtotime($listing['available']) > strtotime(date("m/d/Y"))) {
					$date = $listing['available'];
				}
			}

			echo "var disabled_end = moment('".$date."', 'MM/DD/YYYY')";
		?>
	
		return date.isAfter(disabled_start) && date.isBefore(disabled_end);

		// Disabling Single Day
		// if (date.format('MM/DD/YYYY') == '08/08/2018') {
		//     return true; 
		// }
		},

		<?php 
			//If he is looking for a specific date and is not on a listing show it
			//Or if the listing date is <= that session date show session date as the selected one
			if(!empty($_SESSION['search-date']) && empty($listing) || !empty($_SESSION['search-date']) && !empty($listing) && strtotime($listing['available'])<=strtotime($_SESSION['search-date'])) { 
				$date = $_SESSION['search-date'];
			 } 
		?>

		"startDate": "<?php echo sanitize_xss($date); ?>",
	});
});

// Calendar animation
$('#date-picker-mobile').on('showCalendar.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-animated');
});
$('#date-picker-mobile').on('show.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-visible');
	$('.daterangepicker').removeClass('calendar-hidden');
});
$('#date-picker-mobile').on('hide.daterangepicker', function(ev, picker) {
	$('.daterangepicker').removeClass('calendar-visible');
	$('.daterangepicker').addClass('calendar-hidden');
});
</script>

<?php
	if($request == '/submit-property' && $user || $request == '/edit-property' && $user ) {
?>
<script>
//////////////////////////////////
// Calendar Init Form
$(function() {
	$('#date-picker-property-form').daterangepicker({
		"opens": "left",
		singleDatePicker: true,

		// Disabling Date Ranges
		isInvalidDate: function(date) {
		// Disabling Date Range
		var disabled_start = moment('09/02/2015', 'MM/DD/YYYY');

		<?php
			//We get the saved date
			$lt_date = form_get_value($cache, $listing, 'available');

			if(empty($lt_date)) {
				$lt_date = date("m/d/Y");
			}

			//disable date is set to the current date so the person is able to change the available date to any date in the future
			echo "var disabled_end = moment('".date("m/d/Y")."', 'MM/DD/YYYY')";
		?>
	
		return date.isAfter(disabled_start) && date.isBefore(disabled_end);

		// Disabling Single Day
		// if (date.format('MM/DD/YYYY') == '08/08/2018') {
		//     return true; 
		// }
		},

		"startDate": "<?php echo sanitize_xss($lt_date); ?>",
	});
});

// Calendar animation
$('#date-picker-property-form').on('showCalendar.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-animated');
});
$('#date-picker-property-form').on('show.daterangepicker', function(ev, picker) {
	$('.daterangepicker').addClass('calendar-visible');
	$('.daterangepicker').removeClass('calendar-hidden');
});
$('#date-picker-property-form').on('hide.daterangepicker', function(ev, picker) {
	$('.daterangepicker').removeClass('calendar-visible');
	$('.daterangepicker').addClass('calendar-hidden');
});
</script>

<!-- DropZone | Documentation: http://dropzonejs.com -->
<script type="text/javascript" src="/views/assets/scripts/dropzone.js"></script>
<script>
	$(".dropzone").dropzone({
		acceptedFiles: "image/*",
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
		init: function () {		
			var th = this; //to access this "global" inside functions
			
			//function to add files  
        	this.addCustomFile = function(file, thumbnail_url , responce){
            	// Push file to collection
            	this.files.push(file);
            	// Emulate event to create interface
            	this.emit("addedfile", file);
            	// Add thumbnail url
            	this.emit("thumbnail", file, thumbnail_url);
            	// Add status processing to file
            	this.emit("processing", file);
            	// Add status success to file AND RUN EVENT success from responce
            	this.emit("success", file, responce , false);
            	// Add status complete to file
            	this.emit("complete", file);
			}

			//function to load current files
			this.loadAllFiles = function(){
				$.get('images.php?action=get-img', function(data) {
 					$.each(data.content, function(key,value){	  
					 	//+ one on key so "image 0" is not shown
					 	key = key + 1;
					 	th.addCustomFile(
            				// File options
            				{
                				// flag: processing is complete
                				processing: true,
                				// flag: file is accepted (for limiting maxFiles)
                				accepted: true,
                				// name of file on page
                				name: "Image " + key,
                				// image size
                				size: 2123455,
                				// image type
                				//type: 'image/jpeg',
                				// flag: status upload
								status: Dropzone.SUCCESS,
								imageURL: value,

								//file comes from a server
								isServer: true,
							},
				
            				// Thumbnail url
            				value,
            				// Custom responce for event success
            				{
                				status: "success"
            				}
        				);
 					});
				});
			}

			//we load all the files the first time
			this.loadAllFiles();

			//We establish the variable to know when we will need to reload files
			var loadTheFiles = true;

			//Once are the files are done, we let them load again
			this.on("queuecomplete", function(file) {
				loadTheFiles = true;
				//$("#dropzone-text").text(''); //remove text
			});

			//dropzone refresh manager
			this.on("complete", function(file) {
				//console.log(file);
				if(file.isServer) {
					//alert('file comes from server');
				}
				else {
					//alert('new file upload'); 				

					//Remove the current files from the dropzone
					//$("#dropzone-text").text('Processing images...'); //show message

					this.files.forEach(function(entry) {
						var _ref = entry.previewElement;

						//console.log('File' + entry.name);
						try {
							_ref.parentNode.removeChild(entry.previewElement);
						}
						catch(err) {
  							//console.log(err);
						}
					});

					//We load the files again, but from the server
					if(loadTheFiles) {
						th.loadAllFiles();
						loadTheFiles = false; //used to avoid multiple files load
					}
				}
			});
    	},
		addRemoveLinks: true,
		removedfile: function(file) {
			var imageURL = file.imageURL; 
			   
   			$.ajax({
     			type: 'POST',
     			url: '/images.php',
     			data: {action: 'remove-img', content: imageURL},
				success: function(data) {
					//console.log(data.response);
				},
			});
			   
   			var _ref;
    		return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
		 },
	});

</script>

<!-- Galery Section -->
<script>
$( "#galery-content" ).appendTo( "#galery-section" );
</script>
<?php
	}
?>


<!-- Replacing dropdown placeholder with selected time slot -->
<script>
$(".time-slot").each(function() {
	var timeSlot = $(this);
	$(this).find('input').on('change',function() {
		var timeSlotVal = timeSlot.find('strong').text();

		$('.panel-dropdown.time-slots-dropdown a').html(timeSlotVal);
		$('.panel-dropdown').removeClass('active');
	});
});
</script>

</div>
<!-- Wrapper / End -->

</body>
</html>