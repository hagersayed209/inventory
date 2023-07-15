<?php
    if ( isset( $_GET['delivery_note_id'] ) ) {
        $delivery_note_id = intval( $_GET['delivery_note_id'] );
      
    require_once ABSPATH . 'wp-load.php';
wp_enqueue_media();

global $wpdb;
$delivery_note = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}delivery_notes WHERE id = $delivery_note_id");
 $image_url = wp_get_attachment_url( $delivery_note->image_id );

        $image_url = wp_get_attachment_url( $row->image_id );
     
    }
global $wpdb;
$products = get_posts(array(
  'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
));
$users = get_users(array(
    'role' => 'supplier'
));
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>

<div class="s-content">
	
<hi>Edit Supplier</h1>
<form class="f-supplier" method="post">
    <div class="row g-3 mt-5">
  <div class="col-sm-5 mb-3">
  
  <label for="product_id"> Product:</label>
 <select class="js-example-basic-single js-example-responsive form-control" style="width: 50%"   name="product_id" id="product_id">
            <?php foreach ($products as $product) : ?>
                <option value="<?php echo $product->ID; ?>" <?php if ($product->ID == $delivery_note->product_id) { echo 'selected'; } ?>><?php echo $product->post_title; ?></option>
            <?php endforeach; ?>
       </select>
  </div>
   <div class="col-sm-5 mb-3">
 <label for="supplier_select"> Supplier:</label>
    <select class="js-example-basic-single js-example-responsive "style="width: 50%" name="supplier_select" id="supplier_select">
            <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user->ID; ?>" <?php if ($user->ID == $delivery_note->supplier_id) { echo 'selected'; } ?>><?php echo $user->display_name; ?></option>
            <?php endforeach; ?>
      </select>
  </div>
 	  </div>
<div class="row g-3 mt-5">
  <div class="col-sm-5 mb-3">
 <label for="date">Date:</label>
 <input  name="date" style="width: 50%"id="date" value="<?php echo $delivery_note->date; ?>"type="date">

		</div>
  <div class="col-sm-5 mb-3">
  <label for="note">Note:</label>
 <textarea style="width: 50%" name="note" id="note"><?php echo $delivery_note->note; ?></textarea>
  
		</div>
          </div>
	 
<div class="row g-3 mt-5">
 <div class="col-sm-5 mb-3">
   <label for="qty">Quantity:</label>
  <input type="text" name="qty" id="qty"value="<?php echo $delivery_note->qty; ?>">
  
  
		</div>
        
  <div class="col-sm-5 mb-3">
   <label for="image_id">Image:</label>
  <input type="hidden" name="image_id" id="image_id"value="<?php echo $delivery_note->image_ids; ?>">
  <button type="button"class="btn btn-submit" id="select-image-btn">Select Image</button>
    
 <?php if ($delivery_note->image_ids) : 
       
          $image_ids = explode(',', $delivery_note->image_ids); 
          foreach ($image_ids as $image_id) {
            echo '<img width="50" height="50" src="' . wp_get_attachment_url($image_id) . '">';
          }
        ?>
      <?php endif; ?>
    
  
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
$(document).on('click', '.select-image-btn', function() {
  var button = $(this);
  var frame = wp.media({
    title: 'Select Image',
    multiple: "add",
    library: { type: 'image' },
    button: { text: 'Select' }
  });
  frame.on('select', function() {
    var attachments = frame.state().get('selection').toJSON();
    var imageIds = [];
    $.each(attachments, function(index, attachment) {
      imageIds.push(attachment.id);
    });
    button.closest('.row').find('.image-id').val(imageIds.join(','));
  });
  frame.open();
});


});
</script>
<?php

$table_name = $wpdb->prefix . 'delivery_notes';
	
if ( isset( $_POST['product_id'] ) && isset( $_POST['supplier_select'] ) && isset( $_POST['note'] )  && isset( $_POST['qty'] ) && isset( $_POST['date'] ) && isset( $_POST['image_id'] ) ) {
  $product_id = sanitize_text_field( $_POST['product_id'] );
  $supplier_id = sanitize_text_field( $_POST['supplier_select'] );
  $note = sanitize_text_field( $_POST['note'] );
  $qty = intval( $_POST['qty'] );
  
  $date = sanitize_text_field( $_POST['date'] );
 $image_ids = $_POST['image_id']; 
  $data = array(
    'product_id' => $product_id,
     'supplier_id' => $supplier_id,
    'note' => $note,
   
    'qty' => $qty,
    'date' => $date,
    'image_ids' => $image_ids,
  );
  
    $where = array(
        'id' => $delivery_note_id
    );
    $wpdb->update($table_name, $data, $where);

    wp_redirect(admin_url('admin.php?page=delivery-note'));
    exit;
}
