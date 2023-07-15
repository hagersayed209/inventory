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

<div class="s-content">

<hi>Add new Supplier</h1>
<form class="f-supplier" method="post">
<div class="row g-3 mt-5">
  
   <div class="col-sm-5 mb-2">
 <label for="supplier_select">Select Supplier:</label>
    <select class="js-example-basic-single js-example-responsive" style="width: 50%"  name="supplier_select" id="supplier_select">
     <option selected>Choose...</option>
        <?php foreach ($suppliers as $supplier) : ?>
            <option value="<?php echo $supplier->ID; ?>"><?php echo $supplier->display_name; ?></option>
        <?php endforeach; ?>
    </select>
  </div>
  <div class="product-row">
	<div class="row g-3 mt-2">
	 
          <div class="col-md-4">
                <label for="product_id">Select Product:</label>
                <select name="product_id[]" style="width: 50%" class="js-example-basic-single js-example-responsive ">
                  <option selected>Choose...</option>
                  <?php foreach ($products as $product) : ?>
                  <option value="<?php echo $product->ID; ?>">
                    <?php echo $product->post_title; ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
  <div class="col-sm-5 mb-3">
  <label for="commission">Commission:</label>
    <input type="text" name="commission[]" id="commission">
   
 
		</div>
  </div>
  
  </div>
         <div class="col-sm-10">
        <button type="button" class="btn btn-secondary mt-3" id="add-product-btn">Add Another Product</button>
    </div>
	 <div class="col-sm-10">
    <input type="submit" value="Submit"class="btn btn-submit">
    </div>
</div>
</form>
	</div>

<?php
global $wpdb;


  if (isset($_POST['supplier_select']) && !empty($_POST['supplier_select'])) { 
    $supplier_id = $_POST['supplier_select'];
    $product_ids = $_POST['product_id'];
    $commissions = $_POST['commission'];

    for ($i = 0; $i < count($product_ids); $i++) {
        $wpdb->insert(
            $wpdb->prefix . 'suppliers',
            array(
                'supplier_id' => $supplier_id,
                'product_id' => $product_ids[$i],
                'commission' => $commissions[$i]
            ),
            array(
                '%d',
                '%d',
                '%d'
            )
        );
    }

    wp_redirect(admin_url('admin.php?page=inventory'));
    exit;
}


?>