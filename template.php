<!DOCTYPE html>
<html>
[[$meta-head]]
<body>

<div id="map" class="map"></div>

<div class="left">

<div class="logo">
  <img src="/images/lifecell/logo-light.png" alt="LifeCell">
</div>

<div id="location-menu" class="nav">
<h3>Regions</h3>
<ul>
  [[getResources?
    &parents=`[[*id]]`
    &tpl=`tpl_regions`
    &includeTVs=`1`
    &processTVs=`1`
    &tvPrefix=``
    &sortby=`{"menuindex":"ASC"}`
    &limit=`0`
    &depth=`0`
    &showHidden=`1`
  ]]
</ul>
<h3>Stores</h3>
  <ul style="margin-bottom:230px;">
    [[getResources?
    &parents=`[[*id]]`
    &tpl=`tpl_stores`
    &includeTVs=`1`
    &processTVs=`1`
    &tvPrefix=``
    &sortby=`{"pagetitle":"ASC"}`
    &limit=`8`
    &depth=`2`
    &hideContainers=`1`
    &idx=`0`
    &showHidden=`1`
    ]]
  </ul>
</div>

[[$key]]

</div>


<script type="text/javascript">
    // Define your locations: HTML content for the info window, latitude, longitude
    var locations = [
[[getResources?
&parents=`[[*id]]`
&tpl=`tpl_locations`
&tplLast=`tpl_locationsLast`
&includeTVs=`1`
&processTVs=`1`
&tvPrefix=``
&sortby=`{"pagetitle":"ASC"}`
&limit=`0`
&depth=`2`
&hideContainers=`1`
&showHidden=`1`
]]
    ];


  // Create an array of styles.
  var styles = [
    {
      stylers: [
        { hue: "#ee7515" },
        { saturation: -100 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: 100 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];

  // Create a new StyledMapType object, passing it the array of styles,
  // as well as the name to be displayed on the map type control.
  var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});




    // Setup the different icons and shadows
    var iconURLPrefix = '/images/lifecell/';

    var icons = [
[[getResources?
&parents=`[[*id]]`
&tpl=`tpl_icons`
&tplLast=`tpl_iconsLast`
&includeTVs=`1`
&processTVs=`1`
&tvPrefix=``
&sortby=`{"pagetitle":"ASC"}`
&limit=`0`
&depth=`1`
&hideContainers=`1`
&showHidden=`1`
]]
    ]
    var icons_length = icons.length;


    var shadow = {
      anchor: new google.maps.Point(15,33),
      url: iconURLPrefix + 'msmarker.shadow.png'
    };

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: new google.maps.LatLng(-37.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControl: false,
      streetViewControl: false,
      panControl: false,
      zoomControlOptions: {
         position: google.maps.ControlPosition.RIGHT_TOP
      }

    });

    var infowindow = new google.maps.InfoWindow({
      maxWidth: 250
    });

    var marker;
    var markers = new Array();

    var iconCounter = 0;

    // Add the markers and infowindows to the map
    for (var i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
		title: locations[i][3],
        icon : icons[iconCounter],
        shadow: shadow
      });

      markers.push(marker);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));

      iconCounter++;
      // We only have a limited number of possible icon colors, so we may have to restart the counter
      if(iconCounter >= icons_length){
        iconCounter = 0;
      }
    }
    // panControl
        function clickroute(lati,long,zoom) {
          var latLng = new google.maps.LatLng(lati, long); //Makes a latlng
          map.setZoom(zoom);
          map.panTo(latLng); //Make map global
        }


    function AutoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      $.each(markers, function (index, marker) {
        bounds.extend(marker.position);
      });
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
    AutoCenter();


    // panTo
[[getResources?
&parents=`[[*id]]`
&tpl=`tpl_panTo`
&includeTVs=`1`
&processTVs=`1`
&tvPrefix=``
&sortby=`{"pagetitle":"ASC"}`
&limit=`0`
&depth=`1`
&hideContainers=`1`
&idx=`0`
&showHidden=`1`
]]

  //Associate the styled map with the MapTypeId and set it to display.
  map.mapTypes.set('map_style', styledMap);
  map.setMapTypeId('map_style');

  </script>

[[$fixed-header-code]]

</body>
</html>
