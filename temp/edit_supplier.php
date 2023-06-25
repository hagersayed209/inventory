<?php
    if ( isset( $_GET['supplier_id'] ) ) {
        $supplier_id = intval( $_GET['supplier_id'] );
        // Use $supplier_id to query database and retrieve supplier data for editing
    require_once ABSPATH . 'wp-load.php';


global $wpdb;
$supplier = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}suppliers WHERE id = $supplier_id");

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

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});</script>
<div class="s-content">
	
<hi>Edit Supplier</h1>
<form class="f-supplier" method="post">
    <div class="col-sm-5 mb-3">
        <label for="product_select">Select Product:</label>
         <select class="js-example-basic-single js-example-responsive" style="width: 50%" name="product_select" id="product_select">
            <?php foreach ($products as $product) : ?>
                <option value="<?php echo $product->ID; ?>" <?php if ($product->ID == $supplier->product_id) { echo 'selected'; } ?>><?php echo $product->post_title; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-sm-5 mb-3">
        <label for="supplier_select">Select Supplier:</label>
         <select class="js-example-basic-single js-example-responsive" style="width: 50%" name="supplier_select" id="supplier_select">
            <?php foreach ($users as $user) : ?>
                <option value="<?php echo $user->ID; ?>" <?php if ($user->ID == $supplier->supplier_id) { echo 'selected'; } ?>><?php echo $user->display_name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-sm-5 mb-3">
        <label for="commission">Commission:</label>
        <input type="text" name="commission" id="commission" value="<?php echo $supplier->commission; ?>">
    </div>

    <div class="col-sm-10">
        <input type="submit" value="Update" class="btn btn-submit">
    </div>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_select'];
    $suplier_id = $_POST['supplier_select'];
    $commission = $_POST['commission'];
    // Update data in custom database table
    $table_name = $wpdb->prefix . 'suppliers';
    $data = array(
        'product_id' => $product_id,
		'supplier_id' => $suplier_id,
        'commission' => $commission,
		
    );
    $where = array(
        'id' => $supplier_id
    );
    $wpdb->update($table_name, $data, $where);
// Redirect to inventory page
    wp_redirect(admin_url('admin.php?page=inventory'));
    exit;
}
}