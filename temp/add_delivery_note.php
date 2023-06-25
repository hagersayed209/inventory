<?php 

if (!current_user_can('manage_options')) {
  wp_die('You do not have sufficient permissions to access this page.');
}
wp_enqueue_media();
global $wpdb;
$products = get_posts(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
));
$suppliers = get_users(array(
    'role' => 'supplier'
));


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});</script>
<div class="s-content">

	
<hi>Add new Delivery Note</h1>
<form class="f-supplier" method="post">
<div class="row g-3 mt-5">
  <div class="col-sm-5 mb-3">
  
  <label for="product_id">Select Product:</label>
  <select name="product_id"class="js-example-basic-single js-example-responsive form-control" style="width: 50%" >
    <option selected>Choose...</option>
    <?php foreach ($products as $product) : ?>
            <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
   <div class="col-sm-5 mb-3">
 <label for="supplier_select">Select Supplier:</label>
    <select class="js-example-basic-single js-example-responsive" style="width: 50%"   name="supplier_select" id="supplier_select">
     <option selected>Choose...</option>
        <?php foreach ($suppliers as $supplier) : ?>
            <option value="<?php echo $supplier->ID; ?>"><?php echo $supplier->display_name; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
 	  </div>
 
 
 
<div class="row g-3 mt-5">
  <div class="col-sm-5 mb-3">
 <label for="date">Date:</label>
  <input type="date"style="width: 50%" name="date" id="date">
		</div>
  <div class="col-sm-5 mb-3">
  <label for="note">Note:</label>
 <textarea name="note" style="width: 50%"id="note"></textarea>
  
		</div>
          </div>
	 
<div class="row g-3 mt-5">
 <div class="col-sm-5 mb-3">
   <label for="qty">Quantity:</label>
  <input type="text" name="qty" id="qty">
  
  
		</div>
  <div class="col-sm-5 mb-3">
   <label for="image_id">Image:</label>
  <input type="hidden" name="image_id" id="image_id">
  <button type="button"class="btn btn-submit" id="select-image-btn">Select Image</button>
  
		</div>
	</div>
	
	 <div class="col-sm-10">
    <input type="submit" value="Submit"class="btn btn-submit">
    </div>
</div>
</form>
	</div>

<script>
jQuery(document).ready(function($) {
  $('#select-image-btn').click(function() {
    var frame = wp.media({
      title: 'Select Image',
      multiple: false,
      library: { type: 'image' },
      button: { text: 'Select' }
    });
    frame.on('select', function() {
      var attachment = frame.state().get('selection').first().toJSON();
      $('#image_id').val(attachment.id);
    });
    frame.open();
  });
  
});
</script>
<?php

global $wpdb;

   $table_name = $wpdb->prefix . 'delivery_notes';
    
if ( isset( $_POST['product_id'] ) && isset( $_POST['supplier_select'] ) && isset( $_POST['note'] )  && isset( $_POST['qty'] ) && isset( $_POST['date'] ) && isset( $_POST['image_id'] ) ) {
  $product_id = sanitize_text_field( $_POST['product_id'] );
      $supplier_id = sanitize_text_field( $_POST['supplier_select'] );
  $note = sanitize_text_field( $_POST['note'] );
  $qty = intval( $_POST['qty'] );
  $date = sanitize_text_field( $_POST['date'] );
  $image_id = intval( $_POST['image_id'] );
  
  $data = array(
    'product_id' => $product_id,
     'supplier_id' => $supplier_id,
    'note' => $note,
   
    'qty' => $qty,
    'date' => $date,
    'image_id' => $image_id,
  );
  
  $wpdb->insert( $table_name, $data );

// Redirect to inventory page
    wp_redirect(admin_url('admin.php?page=delivery-note'));
    exit;
}