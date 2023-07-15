jQuery(document).ready(function($) {
  
    var product_row = $('.product-row').children().clone();
    var counter = 1;

    $('#add-product-btn').click(function() {
       $('.js-example-basic-single').select2('destroy');
        var new_row = $('<div class="row g-3 mt-2"></div>').append(product_row.clone());
        new_row.find('input, select').val('');
        new_row.find('.image-id').val('');
        new_row.find('select').attr('id', 'product_select_' + counter);
       
        $('.product-row').last().after(new_row);
        counter++;
    });

    $('.js-example-basic-single').select2();
});


  
    
