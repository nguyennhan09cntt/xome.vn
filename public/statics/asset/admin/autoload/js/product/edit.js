/**
 * Created by Nhan on 4/4/2016.
 */
var ProductEdit = {
    createMarker: function (latlng, name, html) {
        var contentString = html;
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            zIndex: Math.round(latlng.lat() * -100000) << 5
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(contentString);
            infowindow.open(map, marker);
        });
        google.maps.event.trigger(marker, 'click');
        return marker;
    },
    showMap: function () {
        var address = $('#address').val();
        var lng = $('input#lng').val();
        var lat = $('input#lat').val();
        if (lat && lng) {
            if (lat != 0 && lng != 0) {
                ProductEdit.init(parseFloat(lat), parseFloat(lng));
                return;
            }
        }
        ProductEdit.initMap(16, address)
    },
    init: function ($lat, $lng) {
        var geocoder;

        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            zoom: 16,
            center: {lat: $lat, lng: $lng}
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        var marker = new google.maps.Marker({
            // The below line is equivalent to writing:
            // position: new google.maps.LatLng(-34.397, 150.644)
            position: {lat: $lat, lng: $lng},
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker, "dragend", function (e) {
            var lat, lng, address;
            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = marker.getPosition().lat();
                    lng = marker.getPosition().lng();
                    address = results[0].formatted_address;
                    $('input#lat').val(lat);
                    $('input#lng').val(lng);

                }
            });
        });
        google.maps.event.addListener(marker, 'click', function () {
            var lat, lng, address;
            geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = marker.getPosition().lat();
                    lng = marker.getPosition().lng();
                    address = results[0].formatted_address;
                    $('input#lat').val(lat);
                    $('input#lng').val(lng);

                }
            });
        });
    },
    initMap: function (zoom, address) {
        function initialize(zoom, address) {
            var geocoder;
            var map;
            var mapOptions;
            geocoder = new google.maps.Geocoder();
            geocoder
                .geocode(
                {
                    'address': address
                },
                function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {

                        zoom = parseInt(zoom);
                        mapOptions = {
                            zoom: zoom,
                            center: results[0].geometry.location,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                        var object = document
                            .getElementById('map-canvas');

                        map = new google.maps.Map(object,
                            mapOptions);
                        for (var i = 0, length = results.length; i < 1; i++) {
                            marker = new google.maps.Marker({
                                map: map,
                                position: results[i].geometry.location,
                                draggable: true,
                                animation: google.maps.Animation.DROP
                            });

                            $('input#lat').val(marker.getPosition().lat());
                            $('input#lng').val(marker.getPosition().lng());

                            google.maps.event.addListener(marker, "dragend", function (event) {
                                var lat, lng, address;
                                var contentString = "<b>Location</b><br>" + event.latLng;
                                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        lat = marker.getPosition().lat();
                                        lng = marker.getPosition().lng();
                                        address = results[0].formatted_address;
                                        $('input#lat').val(lat);
                                        $('input#lng').val(lng);
                                        infowindow.setContent(contentString);
                                        infowindow.open(map, marker);
                                    }
                                });
                            });


                            google.maps.event.addListener(marker, 'click', function (event) {
                                var lat, lng, address;
                                var contentString = "<b>Location</b><br>" + event.latLng;
                                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                                    if (status == google.maps.GeocoderStatus.OK) {
                                        lat = marker.getPosition().lat();
                                        lng = marker.getPosition().lng();
                                        address = results[0].formatted_address;
                                        $('input#lat').val(lat);
                                        $('input#lng').val(lng);
                                        infowindow.setContent(contentString);
                                        infowindow.open(map, marker);
                                    }
                                });
                            });
                        }


                    } else {
                        //alert("Geocode was not successful for the following reason: " + status);
                    }

                }
            );

        }

        initialize(zoom, address);
        return true;

    }
}
var infowindow = new google.maps.InfoWindow(
    {
        size: new google.maps.Size(150, 50)
    });
$(function () {
    setTimeout(ProductEdit.showMap, 500);
    $('#btn-search-map').on('click', function () {
        var address = $('#address').val();
        ProductEdit.initMap(16, address);
    });
    Custom.initFCK('description');
    //Custom.initFCK('shortDescription');
});