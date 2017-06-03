var PropertyValueMap = function () {
    var $gmap = null;
    var cityCircleArray = [];
    var infoWindowArray = [];
    var initMap = function () {
        var initLatitude = 10.762622;
        var initLongitude = 106.660172;
        var zoom = 12;
        var last_infowindow = null;
        if ($('#lat').val()) {
            initLatitude = $('#lat').val();
        }
        if ($('#lng').val()) {
            initLongitude = $('#lng').val();
        }

        if ($('#search_district').val() != 0) {
            zoom = 14;
        }

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

        var mapOptions = {
            center: new google.maps.LatLng(initLatitude, initLongitude),
            zoom: 16,
            overviewMapControl: true,
            overviewMapControlOptions: {
                opened: false
            },
            panControl: false,
            rotateControl: false,
            scaleControl: false,
            markers: mapMarkers,
            zoomControl: false,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                position: google.maps.ControlPosition.TOP_RIGHT
            }
        };

        $gmap = new google.maps.Map(document.getElementById('map'), mapOptions);
        var cityCircle = new google.maps.Circle({
            strokeColor: '#90b5bb',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#90b5bb',
            fillOpacity: 0.35,
            map: $gmap,
            center: new google.maps.LatLng(initLatitude, initLongitude),
            radius: 900
        });
        var priceDefault = 'Thỏa thuận';
        $.each(markers, function (index, markerObject) {

            if(markerObject.latitude == initLatitude && markerObject.longitude == initLongitude){
                var glatlng = new google.maps.LatLng(parseFloat(markerObject.latitude), parseFloat(markerObject.longitude));

                var gmarker = new google.maps.Marker({
                    position: glatlng
                });
                var image = markerObject.image;

                var price = markerObject.price;
                priceDefault = price;
            }else{
                var glatlng = new google.maps.LatLng(parseFloat(markerObject.latitude), parseFloat(markerObject.longitude));

                var gmarker = new google.maps.Marker({
                    position: glatlng
                });
                var image = markerObject.image;

                var price = markerObject.price;
                var marker_icon;
                var marker_content = "<div class=\"marker\"><div class=\"marker-inner\"><img width=\"150\" height=\"150\" src=\"" + image + "\" class=\"attachment-post-thumbnail size-post-thumbnail wp-post-image\" alt=\"interiors\" \/><span>"+price+"<\/span><\/div><\/div>";
                marker_icon = new google.maps.MarkerImage('/statics/asset/default/img/marker.png');

                marker_icon.size = new google.maps.Size(40, 40);
                marker_icon.anchor = new google.maps.Point(20, 40);
                gmarker.setIcon(marker_icon);

                gmarker.marker = new InfoBox({
                    draggable: true,
                    content: marker_content,
                    image: image,
                    disableAutoPan: true,
                    pixelOffset: new google.maps.Size(-20, -40),
                    position: glatlng,
                    closeBoxURL: "",
                    isHidden: false,
                    pane: "floatPane",
                    enableEventPropagation: true
                });
                gmarker.marker.isHidden = false;
                gmarker.marker.open($gmap, gmarker);
                gmarker.setMap($gmap);

                var content = "<div class=\"infobox\"><a class=\"infobox-image\" href=\"" + markerObject.link + "\" target=\"_blank\"><img width=\"150\" height=\"150\" src=\"" + markerObject.image + "\" class=\"attachment-thumbnail size-thumbnail wp-post-image\" alt=\"interiors\" \/><\/a><div class=\"infobox-content\"><div class=\"infobox-content-title\"><a href=\"" + markerObject.link + "\" title=\"" + markerObject.title + "\" target=\"_blank\">" + markerObject.title + "<\/a><\/div><div class=\"infobox-content-body\"><div class=\"infobox-content-body-location\">" + markerObject.district + " <\/div><div class=\"infobox-content-body-area\"><span>Diện tích: <\/span><strong>" + markerObject.area + " m2<\/strong><\/div><div class=\"infobox-content-body-beds\"><span>Giá: <\/span><strong>" + markerObject.price + "<\/strong> <a class=\"pull-right product-detail-link\" href=\"" + markerObject.link + "\" target=\"_blank\"><strong>Chi tiết<\/strong><\/a><\/div><div class=\"infobox-content-phone\"><span>Phone: <\/span><strong>" + markerObject.phone + "<\/strong><\/div><\/div><\/div><\/div>";

                var infowindow = new google.maps.InfoWindow({
                    content: content
                });
                infowindow.setZIndex(9999);
                google.maps.event.addListener(gmarker, 'click', function () {
                    if (last_infowindow) {
                        last_infowindow.close();
                    }
                    infowindow.open($gmap, gmarker);
                    last_infowindow = infowindow;
                });
            }

        });

        var glatlng = new google.maps.LatLng(parseFloat(initLatitude), parseFloat(initLongitude));

        var gmarker = new google.maps.Marker({
            position: glatlng
        });
        var image = '';

        var price = $('#price').val();
        var marker_icon;
        var marker_content = "<div class=\"marker-center\"><div class=\"marker-inner\"><span>"+price+"<\/span><\/div><\/div><div class=\"pulse\"><\/div>";
        marker_icon = new google.maps.MarkerImage('/statics/asset/default/img/marker.png');

        marker_icon.size = new google.maps.Size(40, 40);
        marker_icon.anchor = new google.maps.Point(20, 40);
        gmarker.setIcon(marker_icon);

        gmarker.marker = new InfoBox({
            draggable: true,
            content: marker_content,
            image: image,
            disableAutoPan: true,
            pixelOffset: new google.maps.Size(-20, -40),
            position: glatlng,
            closeBoxURL: "",
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: true
        });
        gmarker.marker.isHidden = false;
        gmarker.marker.open($gmap, gmarker);
        gmarker.setMap($gmap);


    }
    var generateInfo = function (info) {
        var html = '';
        return html;
    }
    var closeInfoWindow = function () {
        if (infoWindowArray.length > 0) {
            $.each(infoWindowArray, function (index, infoWindow) {
                infoWindow.close();
            });
        }
    }
    return {
        init: function () {
            initMap();

        },
        closeInfoWindow: function() {
            closeInfoWindow();
        }
    }
}();
$(document).ready(function () {
    PropertyValueMap.init();
});
