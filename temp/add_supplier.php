<?php
if (!current_user_can('manage_options')) {
  wp_die('You do not have sufficient permissions to access this page.');
}

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

<hi>Add new Supplier</h1>
<form class="f-supplier" method="post">
<div class="row g-3 mt-5">
  <div class="col-sm-5 mb-3">
    <label for="product_select">Select Product:</label>
    <select class="js-example-basic-single js-example-responsive" style="width: 50%" name="product_select" id="product_select" class="form-control">
    <option selected>Choose...</option>
    <?php foreach ($products as $product) : ?>
            <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
   <div class="col-sm-5 mb-3">
 <label for="supplier_select">Select Supplier:</label>
    <select class="js-example-basic-single js-example-responsive" style="width: 50%"  name="supplier_select" id="supplier_select">
     <option selected>Choose...</option>
        <?php foreach ($suppliers as $supplier) : ?>
            <option value="<?php echo $supplier->ID; ?>"><?php echo $supplier->display_name; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
	
	 <div class="col-sm-5 mb-3">
  <label for="commission">Commission:</label>
    <input type="text" name="commission" id="commission">
   
 
		</div>
	 <div class="col-sm-10">
    <input type="submit" value="Submit"class="btn btn-submit">
    </div>
</div>
</form>
	</div>
<?php
global $wpdb;

// Save data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_select'];
    $supplier_id = $_POST['supplier_select'];
    $commission = $_POST['commission'];
    // Save data to custom database table
    $table_name = $wpdb->prefix . 'suppliers';
    $data = array(
        'product_id' => $product_id,
        'supplier_id' => $supplier_id,
        'commission' => $commission
    );
    $wpdb->insert($table_name, $data);
    // Redirect to inventory page
    wp_redirect(admin_url('admin.php?page=inventory'));
    exit;
}

?>