// Map Markers
var mapMarkers = [{
    address: ""+$('#address').val(),
    html: "<strong>"+$('#title').val()+"</strong><br>"+$('#address').val(),
    icon: {
        image: "/statics/asset/default/img/pin.png",
        iconsize: [26, 46],
        iconanchor: [12, 46]
    },
    popup: true
}];

// Map Initial Location
var initLatitude = 10.762622;
var initLongitude = 106.660172;

if($('#lat').val()){
    initLatitude = $('#lat').val();
}
if($('#lng').val()){
    initLongitude = $('#lng').val();
}
// Map Extended Settings
var mapSettings = {
    controls: {
        draggable: (($.browser.mobile) ? false : true),
        panControl: true,
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        overviewMapControl: true
    },
    scrollwheel: false,
    markers: mapMarkers,
    latitude: initLatitude,
    longitude: initLongitude,
    zoom: 16
};

var map = $("#googlemaps").gMap(mapSettings);

// Map Center At
var mapCenterAt = function(options, e) {
    e.preventDefault();
    $("#googlemaps").gMap("centerAt", options);
}

$(document).ready(function() {
        
        google.maps.event.trigger(map, 'resize');
		$('.fancybox').fancybox();		

        $('a[href="#tab_5_2"]').on('shown.bs.tab', function(e) {
            google.maps.event.trigger(map, 'resize');
        });

       
});