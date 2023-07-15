<?php

if (!current_user_can('manage_options')) {
  wp_die('You do not have sufficient permissions to access this page.');
}
wp_enqueue_media();
global $wpdb;
$products = get_posts(
  array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
  )
);
$suppliers = get_users(
  array(
    'role' => 'supplier'
  )
);


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script>
  $(document).ready(function () {
    $('.js-example-basic-single').select2();
  });
</script>
<div class="s-content">


  <hi>Add new Delivery Note</h1>







    <form class="f-supplier" method="post">
      <div class="row g-3 mt-5">

        <div class="col-sm-4 mb-3">
          <label for="supplier_select">Select Supplier:</label>
          <select class="js-example-basic-single js-example-responsive" style="width: 50%" name="supplier_select"
            id="supplier_select">
            <option selected>Choose...</option>
            <?php foreach ($suppliers as $supplier): ?>
              <option value="<?php echo $supplier->ID; ?>"><?php echo $supplier->display_name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-4 mb-3">
          <label for="total">Total:</label>
          <input type="number" name="total" id="total">

        </div>
        <div class="col-sm-4 mb-3">
          <label for="numproducts">Number of Products:</label>
          <input type="number" name="numproducts" id="numproducts">
          <input type="hidden" name="delivery_note_id" value="<?php echo $order_id; ?>">

        </div>
      </div>



      <div class="row g-3 mt-5">
        <div class="col-sm-5 mb-3">
          <label for="date">Date:</label>
          <input type="date" style="width: 50%" name="date" id="date">

        </div>
        <div class="col-sm-5 mb-3">
          <label for="image2_id">invoice Image:</label>
          <input type="hidden" name="image2_id" id="image2_id">
          <button type="button" class="btn btn-submit" id="select-image2-btn">Select Image</button>

        </div>
      </div>

      <div class="row g-3 mt-5">

      </div>

      <div class="product-row">
        <div class="row g-3 mt-5">
          <div class="col-sm-5 mb-3">

            <label for="product_id">Select Product:</label>
            <select name="product_id" class="js-example-basic-single js-example-responsive form-control"
              style="width: 50%">
              <option selected>Choose...</option>
              <?php foreach ($products as $product): ?>
                <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-sm-5 mb-3">
            <label for="qty">Product Quantity:</label>
            <input type="text" name="qty" id="qty">


          </div>
        </div>





        <div class="row g-3 mt-5">
          <div class="col-sm-5 mb-3">
            <label for="note">Note:</label>
            <textarea name="note" style="width: 50%" id="note"></textarea>

          </div>
          <div class="col-sm-5 mb-3">
            <label for="image_id">Images:</label>
            <input type="hidden" name="image_id" id="image_id">
            <button type="button" class="btn btn-submit" id="select-image-btn">Select Image</button>

          </div>
        </div>
      </div>
      <div class="col-sm-10">

        <button type="button" class="btn btn-secondary mt-3" id="add-product-btn">Add Another Product</button>
      </div>


      <div class="col-sm-10">
        <button type="submit" class="btn btn-submit">submit</button>
      </div>
</div>
</form>




</div>

<script>
  jQuery(document).ready(function ($) {
    var product_row = $('.product-row').first().clone();

    $('#add-product-btn').click(function () {
      var new_row = product_row.clone();
      new_row.find('input, select, textarea').val('');
      $('.product-row').last().after(new_row);
    });
  });
</script>
<script>
  jQuery(document).ready(function ($) {
    $('#select-image-btn').click(function () {
      var frame = wp.media({
        title: 'Select Image',
        multiple: false,
        library: {
          type: 'image'
        },
        button: {
          text: 'Select'
        }
      });
      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        $('#image_id').val(attachment.id);
      });
      frame.open();
    });
    $('#select-image2-btn').click(function () {
      var frame = wp.media({
        title: 'Select Image',
        multiple: false,
        library: {
          type: 'image'
        },
        button: {
          text: 'Select'
        }
      });
      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        $('#image2_id').val(attachment.id);
      });
      frame.open();
    });
  });
</script>
<?php

global $wpdb;
$table_name1 = $wpdb->prefix . 'order_details';
if (isset($_POST['product_id']) && isset($_POST['note']) && isset($_POST['qty']) && isset($_POST['image_id']) && isset($_POST['numproducts']) && isset($_POST['supplier_select']) && isset($_POST['total']) && isset($_POST['date']) && isset($_POST['image_id'])) {



  $supplier_id = sanitize_text_field($_POST['supplier_select']);
  $total = intval($_POST['total']);
  $numproducts = intval($_POST['numproducts']);
  $date = sanitize_text_field($_POST['date']);
  $image_id = intval($_POST['image_id']);

  $data = array(

    'supplier_id' => $supplier_id,
    'numproducts' => $numproducts,
    'total' => $total,
    'date' => $date,
    'image_id' => $image_id,

  );

  $wpdb->insert($table_name1, $data);

  // Get the ID of the inserted row
  $order_details_id = $wpdb->insert_id;




  $table_name = $wpdb->prefix . 'delivery_notes';

  $order_number = sanitize_text_field($_POST['order_number']);
  $order_exists = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}order_details WHERE order_number = '$order_number'");

  $product_id = sanitize_text_field($_POST['product_id']);
  $supplier_id = sanitize_text_field($_POST['supplier_select']);
  $note = sanitize_text_field($_POST['note']);
  $qty = intval($_POST['qty']);
  $date2 = sanitize_text_field($_POST['date']);
  $image2_id = intval($_POST['image2_id']);

  $data = array(
    'product_id' => $product_id,
    'supplier_id' => $supplier_id,
    'note' => $note,
    'qty' => $qty,
    'date' => $date2,
    'image_id' => $image2_id,
    'order_number' => $order_details_id,
  );

  $wpdb->insert($table_name, $data);
}