
var pin_images=mapfunctions_vars.pin_images;
var images = jQuery.parseJSON(pin_images);
var ipad_time=0;



function map_cluster(){
    if(mapfunctions_vars.user_cluster==='yes'){
        var clusterStyles = [
            {
                opt_textColor: 'white',
                url: mapfunctions_vars.path+'/cloud.png',
                height: 56,
                width: 56,
                textSize:15
            }
        ];
        var mcOptions = {gridSize: 50, maxZoom: mapfunctions_vars.zoom_cluster, styles: clusterStyles};
        var mc = new MarkerClusterer(map, gmarkers, mcOptions);
    }

}


//////////////////////////////////////////////////////////////////////
/// geolocation
//////////////////////////////////////////////////////////////////////

if(  document.getElementById('geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('geolocation-button'), 'click', function () {

        myposition(map);
        close_adv_search();
    });
}

if(  document.getElementById('mobile-geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('mobile-geolocation-button'), 'click', function () {

        myposition(map);
        close_adv_search();
    });
}

jQuery('#mobile-geolocation-button,#geolocation-button').click(function(){

    myposition(map);
})


function myposition(map){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showMyPosition,errorCallback,{timeout:10000});
    }
    else
    {
        alert("Geolocation is not supported by this browser.");
    }
}

function errorCallback(){
    alert('The browser couldn\'t detect your position!');
}

function showMyPosition(pos){

    var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };

    var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
    map.setCenter(MyPoint);

    var marker = new google.maps.Marker({
        position: MyPoint,
        map: map,
        icon: custompinchild(),
        shape: shape,
        title: '',
        zIndex: 999999999,
        image:'',
        price:'',
        type:'',
        type2:'',
        link:'' ,
        infoWindowIndex : 99 ,
        radius: parseInt(mapfunctions_vars.geolocation_radius,10)+" m "+mapfunctions_vars.radius
    });

    var populationOptions = {
        strokeColor: '#67cfd8',
        strokeOpacity: 0.6,
        strokeWeight: 1,
        fillColor: '#67cfd8',
        fillOpacity: 0.2,
        map: map,
        center: MyPoint,
        radius: parseInt(mapfunctions_vars.geolocation_radius,10)
    };
    var cityCircle = new google.maps.Circle(populationOptions);

    var label = new Label({
        map: map
    });
    label.bindTo('position', marker);
    label.bindTo('text', marker, 'radius');
    label.bindTo('visible', marker);
    label.bindTo('clickable', marker);
    label.bindTo('zIndex', marker);

}



function custompinchild(){
    "use strict";
    var custom_img;
    if(images['userpin']===''){
        custom_img= mapfunctions_vars.path+'/'+'userpin'+'.png';
    }else{
        custom_img=images['userpin'];
    }

    var   image = {
        url: custom_img,
        size: new google.maps.Size(38, 59),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(16,59 )
    };

    return image;

}


////////////////////////////////////////////////////////////////////
/// 
//////////////////////////////////////////////////////////////////////
/*
 google.maps.event.clearListeners(document.getElementById('googleMap'), 'click');
 google.maps.event.addDomListener(document.getElementById('googleMap'), 'click', function (event) {
 console.log(event.target.nodeName)
 event.stopPropagation();
 event.cancelBubble = true;
 console.log('kick');
 if(map.scrollwheel===false){
 map.setOptions({'scrollwheel': true});
 }else{
 map.setOptions({'scrollwheel': false});
 }
 jQuery('.tooltip').fadeOut("fast");


 if (Modernizr.mq('only all and (max-width: 1925px)')) {
 alert('plm');
 if(map.draggable === false){
 map.setOptions({'draggable': true});
 }else{
 map.setOptions({'draggable': false});
 }
 }


 });  
 */
// same thing as above but with ipad double click workaroud solutin
jQuery('#googleMap').click(function(event){
    var time_diff;

    //alert(event.currentTarget.id + event.isPropagationStopped() +"/"+event.isDefaultPrevented()+"/"+event.timeStamp )

    time_diff=event.timeStamp-ipad_time;

    if(time_diff>3000){
        // alert(event.timeStamp-ipad_time);
        ipad_time=event.timeStamp;
        if(map.scrollwheel===false){
            map.setOptions({'scrollwheel': true});
        }else{
            map.setOptions({'scrollwheel': false});
        }
        jQuery('.tooltip').fadeOut("fast");


        if (Modernizr.mq('only all and (max-width: 1025px)')) {

            if(map.draggable === false){
                map.setOptions({'draggable': true});
            }else{
                map.setOptions({'draggable': false});
            }
        }

    }
});


////////////////////////////////////////////////////////////////////
/// 
//////////////////////////////////////////////////////////////////////

if( document.getElementById('gmap') ){
    google.maps.event.addDomListener(document.getElementById('gmap'), 'mouseout', function () {
        map.setOptions({'scrollwheel': true});
        google.maps.event.trigger(map, "resize");
    });
}


if( document.getElementById('googleMap') && map){
    google.maps.event.addDomListener(document.getElementById('googleMap'), 'mouseout', function () {
        map.setOptions({'scrollwheel': false});
    });
}

if(  document.getElementById('search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('search_map_button'), 'click', function () {
        infoBox.close();
    });
}



if(  document.getElementById('advanced_search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('advanced_search_map_button'), 'click', function () {
        infoBox.close();
    });
}

////////////////////////////////////////////////////////////////////
/// navigate troguh pins
//////////////////////////////////////////////////////////////////////

if(  document.getElementById('gmap-next') ){
    google.maps.event.addDomListener(document.getElementById('gmap-next'), 'click', function () {
        current_place++;

        if (current_place>gmarkers.length){
            current_place=1;
        }

        while(gmarkers[current_place-1].visible===false){
            current_place++;
            if (current_place>gmarkers.length){
                current_place=1;
            }
        }

        google.maps.event.trigger(gmarkers[current_place-1], 'click');

    });
}

if(  document.getElementById('gmap-prev') ){
    google.maps.event.addDomListener(document.getElementById('gmap-prev'), 'click', function () {
        current_place--;

        if (current_place<1){
            current_place=gmarkers.length;
        }

        while(gmarkers[current_place-1].visible===false){
            current_place--;
            if (current_place>gmarkers.length){
                current_place=1;
            }
        }

        google.maps.event.trigger(gmarkers[current_place-1], 'click');
    });

}



////////////////////////////////////////////////////////////////////
/// filter pins 
//////////////////////////////////////////////////////////////////////
if(  document.getElementById('gmap-menu') ){
    google.maps.event.addDomListener(document.getElementById('gmap-menu'), 'click', function (event) {
        infoBox.close();

        if (event.target.nodeName==='INPUT'){
            category=event.target.className;

            if(event.target.name==="filter_action[]"){
                if(actions.indexOf(category)!==-1){
                    actions.splice(actions.indexOf(category),1);
                }else{
                    actions.push(category);
                }
            }

            if(event.target.name==="filter_type[]"){
                if(categories.indexOf(category)!==-1){
                    categories.splice(categories.indexOf(category),1);
                }else{
                    categories.push(category);
                }
            }

            show(actions,categories);
        }

    });
}

////////////////////////////////////////////////////////////////////
/// shows all markers of a particular category, and make sure the checkbox is checked
//////////////////////////////////////////////////////////////////////

function show(actions,categories) {
    "use strict";
    for (var i=0; i<gmarkers.length; i++) {
        if(actions.indexOf(gmarkers[i].type2)===-1 ){

            if ( gmarkers[i]!=='undefined' && categories.indexOf(gmarkers[i].type)===-1 ) {
                gmarkers[i].setVisible(true);
            }else{
                gmarkers[i].setVisible(false);
            }
        }else{
            gmarkers[i].setVisible(false);
        }

    }
}



////////////////////////////////////////////////////////////////////
/// get pin image
//////////////////////////////////////////////////////////////////////

function custompin(image){
    "use strict";
    var custom_img;

    if(image!==''){
        if(images[image]===''){
            custom_img= mapfunctions_vars.path+'/'+image+'.png';
        }else{
            custom_img=images[image];
        }
    }else{
        custom_img= mapfunctions_vars.path+'/none.png';
    }

    if( typeof(custom_img)==='undefined'){
        custom_img= mapfunctions_vars.path+'/none.png';
    }

    image = {
        url: custom_img,
        size: new google.maps.Size(38, 59),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(16,59 )
    };


    return image;
}



function custompin2(image){
    "use strict";

    image = {
        url: mapfunctions_vars.path+'/'+image+'.png',
        size: new google.maps.Size(38, 59),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(16,59 )
    };

    return image;
}







////////////////////////////////////////////////////////////////////
/// Circle label
//////////////////////////////////////////////////////////////////////



function Label(opt_options) {
    // Initialization
    this.setValues(opt_options);


    // Label specific
    var span = this.span_ = document.createElement('span');
    span.style.cssText = 'position: relative; left: -50%; top: 8px; ' +
    'white-space: nowrap;  ' +
    'padding: 2px; background-color: white;opacity:0.7';


    var div = this.div_ = document.createElement('div');
    div.appendChild(span);
    div.style.cssText = 'position: absolute; display: none';
};
Label.prototype = new google.maps.OverlayView;


// Implement onAdd
Label.prototype.onAdd = function() {
    var pane = this.getPanes().overlayImage;
    pane.appendChild(this.div_);


    // Ensures the label is redrawn if the text or position is changed.
    var me = this;
    this.listeners_ = [
        google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'visible_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'clickable_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'zindex_changed', function() { me.draw(); }),
        google.maps.event.addDomListener(this.div_, 'click', function() {
            if (me.get('clickable')) {
                google.maps.event.trigger(me, 'click');
            }
        })
    ];
};


// Implement onRemove
Label.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);


    // Label is removed from the map, stop updating its position/text.
    for (var i = 0, I = this.listeners_.length; i < I; ++i) {
        google.maps.event.removeListener(this.listeners_[i]);
    }
};


// Implement draw
Label.prototype.draw = function() {
    var projection = this.getProjection();
    var position = projection.fromLatLngToDivPixel(this.get('position'));


    var div = this.div_;
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';


    var visible = this.get('visible');
    div.style.display = visible ? 'block' : 'none';


    var clickable = this.get('clickable');
    this.span_.style.cursor = clickable ? 'pointer' : '';


    var zIndex = this.get('zIndex');
    div.style.zIndex = zIndex;


    this.span_.innerHTML = this.get('text').toString();
};



//////////////////////////////////////////////////////////////////////
/// close advanced search
//////////////////////////////////////////////////////////////////////


function close_adv_search(){
    // for advanced search 2
    console.log('yes we close in here');
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
        if(mapfunctions_vars.adv_search === '2' || mapfunctions_vars.adv_search === 2 ){
            adv_search2=0;
            jQuery('#adv-search-2').fadeOut(50,function(){
                jQuery('#search_wrapper').animate({
                    top:112+"px"
                },200);
            });
            jQuery(this).removeClass('adv2_close');
        }

        // for advanced search 2           
        if(mapfunctions_vars.adv_search === '4' || mapfunctions_vars.adv_search === 4){
            adv_search4=0;
            jQuery('#adv-search-4').fadeOut(50,function(){
                jQuery('#search_wrapper').animate({
                    top:112+"px"
                },200);
            });
            jQuery(this).addClass('adv4_close');
        }

        if(mapfunctions_vars.adv_search === '5' || mapfunctions_vars.adv_search === 5){
            adv_search5=0;
            console.log('ho ho');
            jQuery('#search_wrapper').animate({
                top:3+"px"
            },200);

            jQuery('#adv-search-5').animate({
                width:200+"px"
            },200)
            jQuery('#adv-search-5').removeClass('advhome geohide').show();
            jQuery('#adv_5_closer').empty().append('<i class="fa fa-chevron-down"></i>');
            jQuery('.adv5_label').show();
            jQuery('.adv5_hider').hide();

        }
    }
}


//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////

function show_advanced_search(closer){
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
        jQuery('#search_map_button,#advanced_search_map_button').show();
        jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').show();
    }


    if(closer==='close'){
        close_adv_search();
        if (!Modernizr.mq('only all and (max-width: 960px)')) {
            if(mapfunctions_vars.adv_search === '4' ){
                jQuery('#adv-search-header-4').show();
                jQuery('#adv-search-4').css({display:'none'});
                jQuery('#search_wrapper') .css({top:'112px'});
            }
            if(mapfunctions_vars.adv_search === '2'){
                jQuery('#adv-search-header-2').show();
                jQuery('#adv-search-2').css({display:'none'});
                jQuery('#search_wrapper') .css({top:'112px'});

            }
            if(mapfunctions_vars.adv_search === '5'){
                // jQuery('#adv-search-5').hide();
            }

        }



    }else{

        jQuery('#adv-search-header-4,#adv-search-4').show();
        jQuery('#adv-search-header-2,#adv-search-2').show();
        jQuery('#adv-search-5').show();
        jQuery('#search_wrapper') .css({top:'200px'});
    }




    jQuery('#openmap').addClass('mapopen');
}


//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////

function hide_advanced_search(){
    jQuery('#search_map_button,#search_map_form, #advanced_search_map_button,#advanced_search_map_form').hide();
    jQuery('#adv-search-header-4,#adv-search-4').hide();
    jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').hide();
    jQuery('#adv-search-header-2,#adv-search-2').hide();
    jQuery('#adv-search-5').hide();
    jQuery('#advanced_search_map_form').hide();
    jQuery('#openmap').removeClass('mapopen');
}