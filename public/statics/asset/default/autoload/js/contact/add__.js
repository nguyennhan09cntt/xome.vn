var AddIndex = function () {
    // Map Initial Location
    var initLatitude = 10.762622;
    var initLongitude = 106.660172;
    var circleArray = [];
    var handleMap = function () {
        function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: initLatitude, lng: initLongitude},
                zoom: 13,
                mapTypeId: 'roadmap'
            });

            // Create the search box and link it to the UI element.
            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function () {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function (marker) {
                    marker.setMap(null);
                });
                circleArray.forEach(function (circle) {
                    circle.setMap(null);
                });
                circleArray = [];
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    /*markers.push(new google.maps.Marker({
                     map: map,
                     icon: {
                     path: google.maps.SymbolPath.CIRCLE,
                     fillOpacity: 0.5,
                     fillColor: '#ff0000',
                     strokeOpacity: 1.0,
                     strokeColor: '#fff000',
                     strokeWeight: 3.0,
                     clickable: false,
                     editable: true,
                     zIndex: 1,
                     scale: 20 //pixels
                     clickable: false,
                     editable: true,
                     zIndex: 1,
                     },
                     title: place.name,
                     position: place.geometry.location
                     }));*/


                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                });
                map.fitBounds(bounds);
                var circle = new google.maps.Circle({
                    fillColor: '#0FF000',
                    fillOpacity: 0.4,
                    strokeOpacity: 0.8,//opacité des bords du polygone
                    strokeColor: "#0FF000",
                    strokeWeight: 2,
                    clickable: false,
                    editable: true,
                    zIndex: 1,
                    map: map,
                    center: bounds.getCenter(),
                    radius: getRadiusBoundsZoomLevel(bounds, 3963.0)*1000
                });
                var currMarker = new google.maps.Marker({
                    position: bounds.getCenter(),
                    draggable: true,
                    icon: { url: "https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle_blue.png",
                        size: new google.maps.Size(7,7),
                        anchor: new google.maps.Point(4,4)
                    },
                    map:map
                });
                circle.bindTo('center', currMarker, 'position');
                circleArray.push(circle);

            });
            var drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.MARKER,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT,
                    drawingModes: ['circle']
                },
                markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
                circleOptions: {
                    fillColor: '#0FF000',
                    fillOpacity: 0.4,
                    strokeOpacity: 0.8,//opacité des bords du polygone
                    strokeColor: "#0FF000",
                    strokeWeight: 2,
                    clickable: false,
                    editable: true,
                    zIndex: 1
                }
            });
            drawingManager.setMap(map);
        }


        initAutocomplete();

    }
    var getRadiusBoundsZoomLevel = function (bounds, radius) {

        var center = bounds.getCenter();
        var ne = bounds.getNorthEast();


// Convert lat or lng from decimal degrees into radians (divide by 57.2958)
        var lat1 = center.lat() / 57.2958;
        var lon1 = center.lng() / 57.2958;
        var lat2 = ne.lat() / 57.2958;
        var lon2 = ne.lng() / 57.2958;

// distance = circle radius from center to Northeast corner of bounds
        var dis = radius * Math.acos(Math.sin(lat1) * Math.sin(lat2) +
            Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));
        return dis;
    }


    return {
        init: function () {

            handleMap();
        }
    }
}();

$(function () {
    AddIndex.init();
    Metronic.init();
});