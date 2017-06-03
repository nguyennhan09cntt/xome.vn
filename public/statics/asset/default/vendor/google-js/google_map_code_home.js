/*global google */
/*global Modernizr */
/*global InfoBox */
/*global googlecode_home_vars*/
var gmarkers = [];
var current_place=0;
var actions=[];
var categories=[];
var vertical_pan=-190;
var map_open;
var vertical_off=0;
var pins='';
var markers='';
var category=null;
var vertical_off=0;
var width_browser=null;
var infobox_width=null;
var wraper_height=null;
var infoBox=null;
var info_image=null;
var map;
var selected_id         =   '';

function initialize(){
    "use strict";

    var mapOptions = {
        flat:false,
        noClear:false,
        zoom: parseInt(googlecode_home_vars.page_custom_zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng( googlecode_home_vars.general_latitude, googlecode_home_vars.general_longitude),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        streetViewControl:false
    };
    map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    google.maps.visualRefresh = true;




    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#gmap-loading').remove();
    });



    if (Modernizr.mq('only all and (max-width: 1025px)')) {
        map.setOptions({'draggable': false});
    }


    pins=googlecode_home_vars.markers;
    markers = jQuery.parseJSON(pins);
    setMarkers(map, markers);
    if(googlecode_home_vars.idx_status==='1'){
        placeidx(map,markers);
    }



    map_cluster();


}


////////////////////////////////////////////////////////////////////
/// set markers function
//////////////////////////////////////////////////////////////////////


function setMarkers(map, locations) {
    "use strict";

    var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };


    var boxText = document.createElement("div");
    width_browser= jQuery(window).width();
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
        infobox_width=500;
    }
    if (width_browser<600){
        infobox_width=400;
    }
    if (width_browser<400){
        infobox_width=200;
    }


    var myOptions = {content: boxText,
        disableAutoPan: true,
        maxWidth: infobox_width,
        boxClass:"mybox",
        zIndex: null,
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: false

    };
    infoBox = new InfoBox(myOptions);


    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
        var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: custompin(decodeURIComponent ( beach[8]) ),
            shape: shape,
            title: decodeURIComponent(  beach[0].replace(/\+/g,' ')),
            zIndex: beach[3],
            image:decodeURIComponent ( beach[4] ),
            price:decodeURIComponent ( beach[5] ),
            type:decodeURIComponent ( beach[6] ),
            type2:decodeURIComponent ( beach[7] ),
            link:decodeURIComponent ( beach[9] ),
            infoWindowIndex : i ,
            animation: google.maps.Animation.DROP
        });


        gmarkers.push(marker);



        google.maps.event.addListener(marker, 'click', function(event) {


            var ua = navigator.userAgent;
            var  event = (ua.match(/iPad/i)) ? "touchstart" : "click";




            jQuery('#googleMap').animate({'height': '590px'});
            jQuery('#search_map_form').hide();
            jQuery('#advanced_search_map_form').hide();

            if(this.image===''){
                info_image='<img src="' + googlecode_home_vars.path + '/idxdefault.jpg" alt="image" />';
            }else{
                info_image=this.image;
            }

            var title   =  decodeURIComponent( this.title.replace(/\+/g,' '));
            var type    =  decodeURIComponent( this.type.replace(/-/g,' ') );
            var type2   =  decodeURIComponent( this.type2.replace(/-/g,' ') );
            var in_type =   mapfunctions_vars.in_text;
            if(type==='' || type2===''){
                in_type=" ";
            }

            var extra_adv_class='';
            if(mapfunctions_vars.adv_search === '3'){
                extra_adv_class='small-info';
            }

            // prevent ghost clicks on ipad
            if(event==='touchstart'){     //alert('touch');
                infoBox.setContent('<div class="info_details '+extra_adv_class+'" ><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span>'+info_image+'<a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_details"><span id="info_inside">'+type+" "+in_type+" "+type2+this.price+'</span></div>' );
            }else{
                infoBox.setContent('<div class="info_details '+extra_adv_class+'" ><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_details"><span id="info_inside">'+type+" "+in_type+" "+type2+this.price+'</span></div>' );

            }




            infoBox.open(map, this);
            map.setCenter(this.position);


            switch (infobox_width){
                case 700:
                    if(mapfunctions_vars.adv_search === '3'){
                        //190 vs 160 for adv search 3
                        vertical_pan=-175-vertical_off;
                    }else{
                        vertical_pan=-187-vertical_off;
                    }

                    map.panBy(380,vertical_pan);
                    vertical_off=0;
                    break;
                case 500:
                    map.panBy(210,-220);
                    break;
                case 400:
                    map.panBy(100,-220);
                    break;
                case 200:
                    map.panBy(20,-170);
                    break;
            }
            close_adv_search();



        }); // end click even
    }//end for
}// end setMarkers


function stopPropagation(myEvent){
    if(!myEvent){
        myEvent=window.event;
    }
    myEvent.cancelBubble=true;
    if(myEvent.stopPropagation){
        myEvent.stopPropagation();
    }
}

google.maps.event.addDomListener(window, 'load', initialize);
