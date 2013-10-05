google.maps.Map.prototype.panToWithOffset = function(latlng, offsetX, offsetY) {
	"use strict";
	var map = this,
		ov = new google.maps.OverlayView();
	ov.onAdd = function () {
		var proj = this.getProjection(),
			aPoint = proj.fromLatLngToContainerPixel(latlng);
		aPoint.x = aPoint.x+offsetX;
		aPoint.y = aPoint.y+offsetY;
		map.setCenter(proj.fromContainerPixelToLatLng(aPoint));
	};
	ov.draw = function() {};
	ov.setMap(this);
};

function initialize(contact_content, gmap_zoom, latitude, longitude, gmap_custom_style, gmap_color, gmap_color_rgb) {
	"use strict";
	var styles = [];
	if (gmap_custom_style) {
		styles = [
			{
				stylers: [{
					hue: gmap_color_rgb
				}, {
					saturation: -20
				}
				]
			}, {
				featureType: "road",
				elementType: "geometry",
				stylers: [{
					lightness: 100
				}, {
					visibility: "simplified"
				}
				]
			}, {
				featureType: "road.arterial",
				elementType: "geometry.fill",
				stylers: [  { lightness: -50 },
					{ saturation: 40 },
					{ hue: gmap_color_rgb }
				]
			}, {
				featureType: "road.arterial",
				elementType: "labels.text",
				stylers: [{
					color: "#ffffff"
				}, {
					weight: 2
				}
				]
			}, {
				featureType: "poi",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}, {
				featureType: "water",
				elementType: "geometry",
				stylers: [  { lightness: -20 },
					{ saturation: 20 },
					{ hue: gmap_color_rgb }
				]
			}, {
				elementType: "labels.text.stroke",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
		];
	}
	var styledMap = new google.maps.StyledMapType(styles, {
			name: "Styled Map"
		}),
		myLatLng = new google.maps.LatLng(latitude, longitude),
		mapOptions = {
			center: myLatLng,
			scrollwheel: false,
			// draggable: false,
			disableDefaultUI: false,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
				position: google.maps.ControlPosition.LEFT_TOP
				},
			zoom: parseInt(gmap_zoom),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		},
		floatMap = new google.maps.Map(document.getElementById("map_canvas"),mapOptions),
		marker = new google.maps.Marker({
			position: myLatLng,
			visible: false
		});

	floatMap.mapTypes.set('map_style', styledMap);
	floatMap.setMapTypeId('map_style');

	marker.setMap(floatMap);


	var boxText = document.createElement("div");
	boxText.innerHTML = contact_content;

	var myOptions = {
		content: boxText,
		disableAutoPan: false,
		maxWidth: 0,
		pixelOffset: new google.maps.Size(-24,-24),
		zIndex: null,
		boxStyle: {
			width: "300px",
			height: "260px"
		},
		closeBoxURL: "",
		infoBoxClearance: new google.maps.Size(1, 1),
		isHidden: false,
		pane: "floatPane",
		enableEventPropagation: false

	};
	var ib = new InfoBox(myOptions);
	ib.open(floatMap, marker);

	google.maps.event.addDomListener(window, 'resize', function () {
		window.setTimeout(function () {
			if(is_touch_device()) {
				floatMap.panTo(marker.getPosition());
			} else {
				floatMap.panToWithOffset(myLatLng, -22, -50);
			}
		}, 500);
	});

	//Move The Map Center
	if(is_touch_device()) {
		floatMap.panToWithOffset(myLatLng, 0, 0);
	} else {
		floatMap.panToWithOffset(myLatLng, -22, -50);
	}
}

function is_touch_device() {
	"use strict";
	return !!('ontouchstart' in window) || !!('onmsgesturechange' in window); // works on ie10
}

(function ($) {
	"use strict";

	//Function to convert hex format to a rgb color
	function rgb2hex(rgb){
		rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
		return (rgb && rgb.length === 4) ? "#" +
			("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
			("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
			("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
	}

	function get_url_parameter(needed_param, gmap_url) {
		var sURLVariables = (gmap_url.split('?'))[1].split('&');
		for (var i = 0; i < sURLVariables.length; i++)  {
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == needed_param) {
				return sParameterName[1];
			}
		}
	}

	//Include bellow independent scripts calls.
	$(document).ready(function(){
		var colorrgb = $('html').data('accentcolor'),
			contact_html = $('.contact-info-wrapper').html(),
			gmap_link = $('.contact-info-wrapper').data('gmap-url'),
			gmap_do_custom_style = $('.contact-info-wrapper').data('custom-style'),
			accent_color = rgb2hex(colorrgb),
			colorhex = rgb2hex(colorrgb);
			
		$('.contact-info-wrapper').remove();
		$('#gmap')
			.height($('#gmap').parent().height())
			.width($('#gmap').parent().width());

		//Parse the URL and load variables (ll = latitude/longitude; z = zoom)
		var gmap_variables = get_url_parameter('ll', gmap_link);
		if (gmap_variables == undefined) {
			var gmap_variables = get_url_parameter('sll', gmap_link);
		}
		var gmap_zoom = get_url_parameter('z', gmap_link);
		if (typeof gmap_zoom === "undefined") {
			gmap_zoom = 10;
		}
		var gmap_coordinates = gmap_variables.split(',');

		// Initialize the map
		initialize(contact_html, gmap_zoom, gmap_coordinates[0], gmap_coordinates[1], gmap_do_custom_style, colorhex, colorrgb);
	});
})(jQuery);



