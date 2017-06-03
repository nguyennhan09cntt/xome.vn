/**
 * 
 */
var BlogIndex = function() {

	return {
		// main function to initiate the module

		init : function(clazzName) {
			var itemHeight = $($(clazzName)).height();
			var parent = $($(clazzName).closest('.row')[0]);
			var parentHeight = $(parent).height();
			if (itemHeight < (parentHeight - 30)) {
				var elemnt = $(clazzName + ' .blog-desciption');
				elemnt.each(function() {
					var height = $(this).height()
							+ (parentHeight - 30 - itemHeight);
					$(this).height(height);
				});
			}
		},
		initEventChangeCategory : function() {
			$('select.blog-category-list').on('change', function() {
				window.location.href = this.value;
			});
		}

	};

}();

// Document ready functions
$(document).ready(function() {
	BlogIndex.init('.blog-fashion-single');
	BlogIndex.init('.blog-entermaint-single');
	BlogIndex.initEventChangeCategory();

});
