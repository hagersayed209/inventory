<?php
if (!current_user_can('manage_options')) {
  wp_die('You do not have sufficient permissions to access this page.');
}

$suppliers = get_users(array(
    'role' => 'supplier'
));
    wp_enqueue_media();
  ?>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>

<div class="s-content">
    <h1>Add new Document</h1>
    <form class="f-supplier" method="post">
       
            <div class="row g-3 mt-5">
                <div class="col-sm-5 mb-3">
                    <label class="form-label"for="supplier_select">Select Supplier:</label>
                    <select class="js-example-basic-single js-example-responsive" style="width: 50%" name="supplier_select">
                        <option selected>Choose...</option>
                        <?php foreach ($suppliers as $supplier) : ?>
                            <option value="<?php echo $supplier->ID; ?>"><?php echo $supplier->display_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
               <div class="product-row">
  <div class="row g-3 mt-2">
    <div class="col-md-4">
      <label class="form-label" for="document_type">Document Type:</label>
      <input class="form-control" type="text" name="document_type[]">
    </div>
    <div class="col-md-4">
      <label class="form-label" for="date">Date:</label>
      <input type="date" name="date[]" id="date" class="form-control">
    </div>
    <div class="col-md-4">
    <label class="form-label" for="image_id">Image:</label>
      <input type="hidden" name="image_id[]" class="image-id">
      <button type="button" class="btn btn-submit select-image-btn form-control" id="select-image-btn">Select Image</button>
     </div>
  </div>
</div>

        <div class="col-sm-10">
            <input type="submit" value="Submit" class="btn btn-submit">
        </div>
    </form>

    <div class="col-sm-10">
        <button type="button" class="btn btn-secondary mt-3" id="add-product-btn">Add Another Document</button>
    </div>
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

 
if (isset($_POST['supplier_select']) && !empty($_POST['supplier_select'])) { 
    $supplier_id = $_POST['supplier_select'];
    $document_types = $_POST['document_type'];
    $image_ids = $_POST['image_id'];
   $expiry_date = $_POST['date'];
 

// Loop through the arrays and insert each row into the database
foreach ($document_types as $i => $document_type) {
  $wpdb->insert(
    $wpdb->prefix . 'documentations',
    array(
      'supplier_id' => $supplier_id,
      'document_type' => $document_type,
      'image_id' => $image_ids[$i],
      'expiry_date' => $expiry_date[$i]
    ),
    array(
      '%d',
      '%s',
      '%s',
      '%s'
    )
  );
}



   wp_redirect(admin_url('admin.php?page=documents'));
    exit;
}


