var AddIndex = function () {
    var shape = null;
    var handleMap = function () {
        var drawingManager;
        var selectedShape;
        var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
        var selectedColor;
        var colorButtons = {};

        var initLatitude = 10.762622;
        var initLongitude = 106.660172;


        function clearSelection() {
            if (selectedShape) {
                if (selectedShape.type !== 'marker') {
                    selectedShape.setEditable(false);
                }

                selectedShape = null;
            }
        }

        function setSelection(shape) {
            if (shape.type !== 'marker') {
                clearSelection();
                shape.setEditable(true);
                selectColor(shape.get('fillColor') || shape.get('strokeColor'));
            }

            selectedShape = shape;
        }

        function deleteSelectedShape() {
            if (selectedShape) {
                selectedShape.setMap(null);
            }
            shape = null;
        }

        function selectColor(color) {
            selectedColor = color;
            for (var i = 0; i < colors.length; ++i) {
                var currColor = colors[i];
                colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
            }

            // Retrieves the current options from the drawing manager and replaces the
            // stroke or fill color as appropriate.
            /*var polylineOptions = drawingManager.get('polylineOptions');
             polylineOptions.strokeColor = color;
             drawingManager.set('polylineOptions', polylineOptions);

             var rectangleOptions = drawingManager.get('rectangleOptions');
             rectangleOptions.fillColor = color;
             drawingManager.set('rectangleOptions', rectangleOptions);*/

            var circleOptions = drawingManager.get('circleOptions');
            circleOptions.fillColor = color;
            drawingManager.set('circleOptions', circleOptions);

            /*var polygonOptions = drawingManager.get('polygonOptions');
             polygonOptions.fillColor = color;
             drawingManager.set('polygonOptions', polygonOptions);*/
        }

        function setSelectedShapeColor(color) {
            if (selectedShape) {
                if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
                    selectedShape.set('strokeColor', color);
                } else {
                    selectedShape.set('fillColor', color);
                }
            }
        }

        function makeColorButton(color) {
            var button = document.createElement('span');
            button.className = 'color-button';
            button.style.backgroundColor = color;
            google.maps.event.addDomListener(button, 'click', function () {
                selectColor(color);
                setSelectedShapeColor(color);
            });

            return button;
        }

        function buildColorPalette() {
            var colorPalette = document.getElementById('color-palette');
            for (var i = 0; i < colors.length; ++i) {
                var currColor = colors[i];
                var colorButton = makeColorButton(currColor);
                colorPalette.appendChild(colorButton);
                colorButtons[currColor] = colorButton;
            }
            selectColor(colors[0]);
        }

        function addNewShape(newShape) {
            google.maps.event.addListener(newShape, 'click', function () {
                setSelection(newShape);
            });
            setSelection(newShape);
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

        function initialize() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: new google.maps.LatLng(initLatitude, initLongitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                zoomControl: true
            });

            var polyOptions = {
                strokeWeight: 0,
                fillOpacity: 0.45,
                editable: true,
                draggable: true
            };
            // Creates a drawing manager attached to the map that allows the user to draw
            // markers, lines, and shapes.
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.CIRCLE,
                markerOptions: {
                    draggable: true
                },
                drawingControlOptions: {
                    drawingModes: ['circle']
                },


                circleOptions: polyOptions,

                map: map
            });


            // begin
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

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }

                });
                map.fitBounds(bounds);
                shape = new google.maps.Circle({
                    fillColor: colors[0],

                    strokeOpacity: 0.8,//opacité des bords du polygone
                    strokeColor: colors[0],
                    strokeWeight: 2,
                    fillOpacity: 0.4,
                    draggable: true,
                    editable: true,
                    zIndex: 1,
                    map: map,
                    center: bounds.getCenter(),
                    radius: getRadiusBoundsZoomLevel(bounds, 3963.0) * 1000
                });
                //circle.setOptions();

                addNewShape(shape);
                drawingManager.setDrawingMode(null);

            });


            // end

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
                if (shape) {
                    shape.setMap(null);
                }
                var newShape = e.overlay;

                newShape.type = e.type;


                if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                    // Switch back to non-drawing mode after drawing a shape.
                    drawingManager.setDrawingMode(null);

                    // Add an event listener that selects the newly-drawn shape when the user
                    // mouses down on it.
                    google.maps.event.addListener(newShape, 'click', function (e) {
                        if (e.vertex !== undefined) {
                            if (newShape.type === google.maps.drawing.OverlayType.POLYGON) {
                                var path = newShape.getPaths().getAt(e.path);
                                path.removeAt(e.vertex);
                                if (path.length < 3) {
                                    newShape.setMap(null);
                                }
                            }
                            if (newShape.type === google.maps.drawing.OverlayType.POLYLINE) {
                                var path = newShape.getPath();
                                path.removeAt(e.vertex);
                                if (path.length < 2) {
                                    newShape.setMap(null);
                                }
                            }
                        }
                        setSelection(newShape);
                    });
                    setSelection(newShape);
                }
                else {
                    google.maps.event.addListener(newShape, 'click', function (e) {
                        setSelection(newShape);
                    });
                    setSelection(newShape);
                }
                shape = newShape;
            });

            // Clear the current selection when the drawing mode is changed, or when the
            // map is clicked.
            google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
            google.maps.event.addListener(map, 'click', clearSelection);
            google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);

            buildColorPalette();
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    }
    var showBlockProcessing = function () {
        var html = '<div style="font-style:italic;">Processing, please wait...</div>';
        $.blockUI
        ({
            message: html,
            css: {
                background: '#333',
                color: '#fff',
                border: '2px double #ccc',
                showOverlay: true,
                width: '400px',
                top: '100px',
                left: ($(window).width() - 300) / 2 + 'px',
                padding: '5px',
                borderRadius: '8px'
            }
        });
    };
    var handleForm = function () {
        $('#form-contact').on('submit', function () {

            if (shape == null) {
                alert('Bạn hãy vẽ khu vực bạn cần tìm phòng');
                return false;
            }
            $('#map_lat').val(shape.getCenter().lat());
            $('#map_lng').val(shape.getCenter().lng());
            $('#map_radius').val(shape.getRadius());
            $('#map_color').val(shape.get('fillColor'));

        });
    }

    return {
        init: function () {

            handleMap();
            handleForm();
        }
    }
}();

$(function () {
    AddIndex.init();
    Metronic.init();
});