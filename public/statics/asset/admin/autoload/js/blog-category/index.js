$(function(){
    Custom.initManualUpdate('blog-category');
    $('#btnAddNew').click(function(){
        Metronic.redirect('blog-category/edit/')
    });
});