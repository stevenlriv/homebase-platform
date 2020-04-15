 (function($){
    "use strict";

    /* Half Map Adjustments */
    $(window).on('load resize', function() {

      var topbarHeight = $("#top-bar").height();
      var headerHeight = $("#header").innerHeight() + topbarHeight;

      $(".fs-container").css('height', '' + $(window).height() - headerHeight +'px');
    });


    // Main Main
    // ----------------------------------------------- //
    function mainMap() {

     var locations = location_array;

      var mapZoomAttr = $('#map').attr('data-map-zoom');
      var mapScrollAttr = $('#map').attr('data-map-scroll');

      if (typeof mapZoomAttr !== typeof undefined && mapZoomAttr !== false) {
          var zoomLevel = parseInt(mapZoomAttr);
      } else {
          var zoomLevel = 5;
      }

      if (typeof mapScrollAttr !== typeof undefined && mapScrollAttr !== false) {
         var scrollEnabled = parseInt(mapScrollAttr);
      } else {
        var scrollEnabled = false;
      }

      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoomLevel,
        scrollwheel: scrollEnabled,
        center: new google.maps.LatLng(38, -96),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        panControl: false,
        navigationControl: false,
        streetViewControl: false,
        gestureHandling: 'cooperative',

        // Google Map Style
        styles: [{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"23"}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"color":"#f38eb0"}]},{"featureType":"poi.government","elementType":"geometry.fill","stylers":[{"color":"#ced7db"}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#ffa5a8"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c7e5c8"}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"color":"#d6cbc7"}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"color":"#c4c9e8"}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"color":"#b1eaf1"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":"100"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"},{"lightness":"100"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffd4a5"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffe9d2"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"weight":"3.00"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"weight":"0.30"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"36"}]},{"featureType":"road.local","elementType":"labels.text.stroke","stylers":[{"color":"#e9e5dc"},{"lightness":"30"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":"100"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d2e7f7"}]}]

      });


      var boxText = document.createElement("div");
      boxText.className = 'map-box'

      var currentInfobox;

      var boxOptions = {
              content: boxText,
              disableAutoPan: true,
              alignBottom : true,
              maxWidth: 0,
              pixelOffset: new google.maps.Size(-60, -55),
              zIndex: null,
              boxStyle: {
                width: "260px"
              },
              closeBoxMargin: "0",
              closeBoxURL: "",
              infoBoxClearance: new google.maps.Size(1, 1),
              isHidden: false,
              pane: "floatPane",
              enableEventPropagation: false,
      };


      var markerCluster, marker, i;
      var allMarkers = [];

      var clusterStyles = [
      {
        textColor: 'white',
        url: '',
        height: 50,
        width: 50
      }
      ];



        // Custom zoom buttons
        var zoomControlDiv = document.createElement('div');
        var zoomControl = new ZoomControl(zoomControlDiv, map);

        function ZoomControl(controlDiv, map) {

          zoomControlDiv.index = 1;
          map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
          // Creating divs & styles for custom zoom control
          controlDiv.style.padding = '5px';

          // Set CSS for the control wrapper
          var controlWrapper = document.createElement('div');
          controlDiv.appendChild(controlWrapper);

          // Set CSS for the zoomIn
          var zoomInButton = document.createElement('div');
          zoomInButton.className = "custom-zoom-in";
          controlWrapper.appendChild(zoomInButton);

          // Set CSS for the zoomOut
          var zoomOutButton = document.createElement('div');
          zoomOutButton.className = "custom-zoom-out";
          controlWrapper.appendChild(zoomOutButton);

          // Setup the click event listener - zoomIn
          google.maps.event.addDomListener(zoomInButton, 'click', function() {
            map.setZoom(map.getZoom() + 1);
          });

          // Setup the click event listener - zoomOut
          google.maps.event.addDomListener(zoomOutButton, 'click', function() {
            map.setZoom(map.getZoom() - 1);
          });

      }


      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),

          icon: locations[i][4],
          id : i
        });
        allMarkers.push(marker);

        var ib = new InfoBox();

        google.maps.event.addListener(marker, 'click', (function(marker, i) {


          return function() {
             ib.setOptions(boxOptions);
             boxText.innerHTML = locations[i][0];
             ib.close();
             ib.open(map, marker);
             
             currentInfobox = marker.id;
             var latLng = new google.maps.LatLng(locations[i][1], locations[i][2]);
             map.panTo(latLng);
             map.panBy(0,-180);


            google.maps.event.addListener(ib,'domready',function(){
              $('.infoBox-close').click(function(e) {
            e.preventDefault();
                  ib.close();
              });
            });

          }
        })(marker, i));

      } //eof for

      var options = {
          imagePath: 'images/',
          styles : clusterStyles,
          minClusterSize : 2

      };

      markerCluster = new MarkerClusterer(map, allMarkers, options);

      google.maps.event.addDomListener(window, "resize", function() {
          var center = map.getCenter();
          google.maps.event.trigger(map, "resize");
          map.setCenter(center);
      });


      // Scroll enabling button
      var scrollEnabling = $('#scrollEnabling');

      $(scrollEnabling).click(function(e){
          e.preventDefault();
          $(this).toggleClass("enabled");

          if ( $(this).is(".enabled") ) {
             map.setOptions({'scrollwheel': true});
          } else {
             map.setOptions({'scrollwheel': false});
          }
      })


      // Geo location button
      $("#geoLocation").click(function(e){
          e.preventDefault();
          geolocate();
      });

      function geolocate() {

          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function (position) {
                  var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                  map.setCenter(pos);
                  map.setZoom(12);
              });
          }
      }


      // Next / Prev buttons
        $('#nextpoint').click(function(e){
            e.preventDefault();

             map.setZoom(15);

            var index = currentInfobox;
            if (index+1 < allMarkers.length ) {
                google.maps.event.trigger(allMarkers[index+1],'click');

            } else {
                google.maps.event.trigger(allMarkers[0],'click');
            }
        });


        $('#prevpoint').click(function(e){
            e.preventDefault();

             map.setZoom(15);

            if ( typeof(currentInfobox) == "undefined" ) {
                 google.maps.event.trigger(allMarkers[allMarkers.length-1],'click');
            } else {
                 var index = currentInfobox;
                 if(index-1 < 0) {
                    //if index is less than zero than open last marker from array
                   google.maps.event.trigger(allMarkers[allMarkers.length-1],'click');
                 } else {
                    google.maps.event.trigger(allMarkers[index-1],'click');
                 }
            }
      });

    }


    // Map Init
    var map =  document.getElementById('map');
    if (typeof(map) != 'undefined' && map != null) {
      google.maps.event.addDomListener(window, 'load',  mainMap);
    }


    // ---------------- Main Map / End ---------------- //



    // Single Property Map
    // ----------------------------------------------- //

    function singlePropertyMap() {

      var myLatLng = {lng: $( '#propertyMap' ).data('longitude'),lat: $( '#propertyMap' ).data('latitude'), };

      var single_map = new google.maps.Map(document.getElementById('propertyMap'), {
        zoom: 13,
        center: myLatLng,
        scrollwheel: false,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        panControl: false,
        navigationControl: false,
        streetViewControl: false,
        styles:  [{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"23"}]},{"featureType":"poi.attraction","elementType":"geometry.fill","stylers":[{"color":"#f38eb0"}]},{"featureType":"poi.government","elementType":"geometry.fill","stylers":[{"color":"#ced7db"}]},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#ffa5a8"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c7e5c8"}]},{"featureType":"poi.place_of_worship","elementType":"geometry.fill","stylers":[{"color":"#d6cbc7"}]},{"featureType":"poi.school","elementType":"geometry.fill","stylers":[{"color":"#c4c9e8"}]},{"featureType":"poi.sports_complex","elementType":"geometry.fill","stylers":[{"color":"#b1eaf1"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":"100"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"},{"lightness":"100"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffd4a5"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffe9d2"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"weight":"3.00"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"weight":"0.30"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#747474"},{"lightness":"36"}]},{"featureType":"road.local","elementType":"labels.text.stroke","stylers":[{"color":"#e9e5dc"},{"lightness":"30"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":"100"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d2e7f7"}]}]

      });

      var marker = new google.maps.Marker({
          position: myLatLng,
          map: single_map,
          icon: markerIcon
        });


      // Custom zoom buttons
      var zoomControlDiv = document.createElement('div');
      var zoomControl = new ZoomControl(zoomControlDiv, single_map);

      function ZoomControl(controlDiv, single_map) {

      zoomControlDiv.index = 1;
      single_map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(zoomControlDiv);
      // Creating divs & styles for custom zoom control
      controlDiv.style.padding = '5px';

      // Set CSS for the control wrapper
      var controlWrapper = document.createElement('div');
      controlDiv.appendChild(controlWrapper);

      // Set CSS for the zoomIn
      var zoomInButton = document.createElement('div');
      zoomInButton.className = "custom-zoom-in";
      controlWrapper.appendChild(zoomInButton);

      // Set CSS for the zoomOut
      var zoomOutButton = document.createElement('div');
      zoomOutButton.className = "custom-zoom-out";
      controlWrapper.appendChild(zoomOutButton);

      // Setup the click event listener - zoomIn
      google.maps.event.addDomListener(zoomInButton, 'click', function() {
        single_map.setZoom(single_map.getZoom() + 1);
      });

      // Setup the click event listener - zoomOut
      google.maps.event.addDomListener(zoomOutButton, 'click', function() {
        single_map.setZoom(single_map.getZoom() - 1);
      });

      }

      $('#streetView').click(function(e){
         e.preventDefault();
         single_map.getStreetView().setOptions({visible:true,position:myLatLng});
         $(this).css('display', 'none')
      });

    }


    // Single Property Map Init
    var single_map =  document.getElementById('propertyMap');
    if (typeof(single_map) != 'undefined' && single_map != null) {
      google.maps.event.addDomListener(window, 'load',  singlePropertyMap);
    }


    // -------------- Single Property Map / End -------------- //


})(this.jQuery);
