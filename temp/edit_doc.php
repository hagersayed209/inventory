<?php
    if ( isset( $_GET['doc_id'] ) ) {
        $doc_id = intval( $_GET['doc_id'] );
    require_once ABSPATH . 'wp-load.php';
wp_enqueue_media();

global $wpdb;
$documents = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}documentations WHERE id = $doc_id");
 
    }
global $wpdb;

$users = get_users(array(
    'role' => 'supplier'
));
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>

<div class="s-content">
	
<hi>Edit Documents</h1>
<form class="f-supplier" method="post">
    <div class="row g-3 mt-5">
                <div class="col-sm-5 mb-3">
 <label for="supplier_select"> Supplier:</label>
    <select class="js-example-basic-single js-example-responsive "style="width: 50%" name="supplier_select" id="supplier_select">
            <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user->ID; ?>" <?php if ($user->ID == $documents->supplier_id) { echo 'selected'; } ?>><?php echo $user->display_name; ?></option>
            <?php endforeach; ?>
      </select>
  </div>
  <div class="col-md-4">
   <label class="form-label" for="document_type">Document Type:</label>
  <input type="text" class="form-control" name="document_type" id="document_type"value="<?php echo $documents->document_type; ?>">
  
  
		</div>
 	  </div>
<div class="row g-3 mt-5">
  <div class="col-md-4">
 <label class="form-label" for="date">Expiry Date:</label>
 <input  name="date" class="form-control" value="<?php echo $documents->expiry_date; ?>"type="date">

		</div>
  

  <div class="col-md-4">
  <label class="form-label" for="image_id">Image:</label>
      <input type="hidden" value="<?php echo $documents->image_id; ?> "name="image_id" class="image-id">
      <button type="button" class="btn btn-submit select-image-btn form-control"id="select-image-btn">Select Image</button>
     
 <?php if ($documents->image_id) : 
       
          $image_ids = explode(',', $documents->image_id); 
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

global $wpdb;
   $table_name = $wpdb->prefix . 'documentations';
if (isset($_POST['supplier_select']) && !empty($_POST['supplier_select'])) { 
  
 
    $supplier_id = sanitize_text_field($_POST['supplier_select']);
   
     $document_type = sanitize_text_field($_POST['document_type']);
    $date = sanitize_text_field($_POST['date']);
    $image_id = $_POST['image_id'];

    $data = array(
    
      'supplier_id' => $supplier_id,
       'document_type' => $document_type,
      
      'expiry_date' => $date,
      'image_id' => $image_id,
      
    );

  
    $where = array(
        'id' => $doc_id
    );
    $wpdb->update($table_name, $data, $where);

    wp_redirect(admin_url('admin.php?page=documents'));
    exit;
}
