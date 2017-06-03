/**
 * Created by Nhan on 27/01/2017.
 */
var Index = function (){

	var handleAutoCompleteMap = function (elementId) {
       
		function initialize() {
			var input = document.getElementById(elementId);
			var autocomplete = new google.maps.places.Autocomplete(input, {componentRestrictions:{'country': 'vn'}});
			google.maps.event.addListener(autocomplete, 'place_changed', function () {
				var place = autocomplete.getPlace();
			  
				document.getElementById('lat').value = place.geometry.location.lat();
				document.getElementById('lng').value = place.geometry.location.lng();
				//alert("This function is working!");
				//alert(place.name);
			   // alert(place.address_components[0].long_name);

			});
		}
		google.maps.event.addDomListener(window, 'load', initialize); 
        
        

	}
	

	return {
		init: function (){
			handleAutoCompleteMap('search_keyword');
			$('.btn_search_box').on('click', function(){
				var form  = $(this).closest('form');
				form.attr('action','/tim-kiem-ban-do');
				form.submit();
			});
			$('form').on('keyup keypress', function(e) {
			  var keyCode = e.keyCode || e.which;
			  if (keyCode === 13) { 
				e.preventDefault();
				return false;
			  }
			});
		}
	}
}();

$(function(){
	Index.init();
    Metronic.init();
});