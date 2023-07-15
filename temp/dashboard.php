<?php

$current_user_id = get_current_user_id();
$curruser = wp_get_current_user();
$name = $curruser->display_name;
$logo_id = get_theme_mod( 'custom_logo' );
$logo_url = wp_get_attachment_image_src( $logo_id , 'full' )[0];
$prof_url = get_user_meta( $curruser->ID, 'profile_image', true );

global $wpdb;
$table_name = $wpdb->prefix . "suppliers";
$query = "SELECT product_id FROM {$table_name} WHERE supplier_id = %d";
$product_ids = $wpdb->get_col($wpdb->prepare($query, $current_user_id));
if (is_supplier_user()) { ?>

<!----===== Boxicons CSS ===== -->
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<nav class="sidebar sideebar  close shadow-sm p-3 mb-5 bg-white rounded">
    <header>
        <div class="image-text">
            <span class="image">
                <?php echo '<img src="' . $logo_url . '" alt="Logo">';
?>

            </span>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
    </header>
    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">

                <li class="nav-link  active">
                    <a href="#stock">
                        <i class='bx bx-store-alt icon'></i>
                        <span class="text nav-text">Stock</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#note">
                        <i class='bx bx-package icon'></i>
                        <span class="text nav-text">Delivery Note</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#pay">
                        <i class='bx bx-money-withdraw icon'></i>
                        <span class="text nav-text">payments</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="#doc">
                        <i class='bx bxs-file-doc icon'></i>
                        <span class="text nav-text">Documentation</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="bottom-content">
            <li class="">
                <a href="<?php echo wp_logout_url(home_url('/nlogin/')); ?>">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>

        </div>
    </div>

</nav>

<div class="navbar flex shadow-sm p-3 mb-5 bg-white rounded">
    <i class="bx bx-menu" id="sidebar-open"></i>
		<a href="<?php echo get_permalink(get_page_by_title('supplierprofile')); ?>" class="btn btn-added">
    <?php echo $name; ?>
</a>

    <span class="nav_image">

       <img src="<?php echo $prof_url; ?>" width="300" class="card-img-top" alt="...">
    </span>
</div>
<section class="home">
    <div class="text">
        <div  id="stock">
			<?php
			if ($product_ids) {?>
       

            <table id="example" class="table   mt-5 table-bordered  ">
                <?php 
						 echo '<thead class="table-dark">

                      <th >Brand</th>
                        <th >Product Name</th>
                        <th>Product Image</th>
                        <th >Product Price</th>
                        <th >Quantity</th>
                        <th >receipt Date</th>
                        <th >Current Stock</th>
                        <th >Last Stock Update</th></tr>
                    </thead>';
              foreach ($product_ids as $product_id) {

                $args = ["post_type" => "product", "p" => $product_id];
                $query = new WP_Query($args);
                while ($query->have_posts()) {
                  $query->the_post();
                  $product = wc_get_product(get_the_ID());
					 $product_id = $product->ID;
                  if ($product->is_type('simple')) {

                    $current_stock_quantity = $product->get_stock_quantity();

                  // Query completed orders with the product ID
    $order_query = new WC_Order_Query(array(
        'status' => 'completed',
        'type' => 'shop_order',
        'limit' => -1,
        'return' => 'ids',
        'meta_query' => array(
            array(
                'key' => '_product_id',
                'value' => $product_id,
                'compare' => '=',
            ),
        ),
    ));

    $order_ids = $order_query->get_orders();
    $product_qty_sold = 0;

    // Loop through the orders and count the number of items sold
    foreach ($order_ids as $order_id) {
        $order = wc_get_order($order_id);
        $items = $order->get_items();
        foreach ($items as $item) {
            if ($item->get_product_id() === $product_id) {
                $product_qty_sold += $item->get_quantity();
            }
        }
    }

                    // Calculate the total product quantity
                    $product_qty = $product_qty_sold;

                    $product_id = "product_" . get_the_ID();
                    $brand = get_post_meta(get_the_ID(), 'brand', true);
                    $product_name = get_the_title();
                    $product_image = $product->get_image();
                    $product_price = $product->get_price();

                    $completed_order_quantity = 10; // Replace with your logic to calculate completed order quantity
                    $quantity = $current_stock_quantity + $completed_order_quantity;
                    $last_stock_update = get_post_modified_time('F j, Y g:i a', true, get_the_ID());

                    echo '<tr data-bs-toggle="collapse" data-bs-target="#' . $product_id . '" aria-expanded="false" aria-controls="' . $product_id . '">';
                    echo "<td>" . $brand . "</td>";
                    echo "<td>" . $product_name . "</td>";
                    echo "<td >" . $product_image . "</td>";
                    echo "<td>" . $product_price . "</td>";
                    echo "<td>" . $product_qty . "</td>";

                    echo "<td>" . $last_stock_update . "</td>";
                    echo "<td>" . $current_stock_quantity . "</td>";
                    echo "<td>" . $last_stock_update . "</td>";
                    echo "</tr>";
                  } else {
                    $variations = $product->get_available_variations();
                    foreach ($variations as $variation) {
                      $variation_id = $variation["variation_id"];
                      $variation_product = new WC_Product_Variation($variation_id);
                      $variation_name = implode(", ", $variation["attributes"]);
                      $variation_image = wp_get_attachment_image($variation["image_id"]);
                      $variation_price = $variation["display_price"];
                      $variation_current_stock_quantity = $variation["max_qty"];
                      $completed_order_quantity = 10; // Replace with your logic to calculate completed order quantity
                      $variation_quantity = $variation_current_stock_quantity + $completed_order_quantity;
                      $variation_date_modified = get_post_modified_time('F j, Y g:i a', true, get_the_ID());

                      echo '<tr data-bs-toggle="collapse" data-bs-target="#' . $product_id . '" aria-expanded="false" aria-controls="' . $product_id . '">';
                      echo "<td>" . get_post_meta(get_the_ID(), 'brand', true) . "</td>";
                      echo "<td>" . $variation_product . "</td>";
                      echo "<td>" . $variation_image . "</td>";
                      echo "<td>" . $variation_price . "</td>";
                      echo "<td>" . $variation_quantity . "</td>";
                      echo "<td>" . $variation_current_stock_quantity . "</td>";
                      echo "<td>" . $variation_date_modified . "</td>";
                      echo "</tr>";
                    }
                  }
                  wp_reset_postdata();
                }
              }
              ?>

            </table>
       <?php
            } else {?>
            <p class="mt-5">There are no products for you</p>
         <?php } ?></div>
        <div id="note"> <?php

          $table_name3 = $wpdb->prefix . 'delivery_notes';
          $notes = $wpdb->get_results(
            $wpdb->prepare("
        SELECT * FROM $table_name3
        WHERE  supplier_id = %d
    ", $current_user_id)
          );



          if ($notes) {
            ?>
           
                <table id="example" class="table   mt-5 table-bordered  ">
                <thead class="table-dark">
<tr>
                  <th class="tabel-th">Product Name</th>

                  <th class="tabel-th">Product Price</th>
                  <th class="tabel-th">Quantity</th>
                  <th class="tabel-th">receipt Date</th>
                  <th class="tabel-th">Note</th>
                  <th class="tabel-th">image</th>
                  <th scope="col">State </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($notes as $note) {
                    $image_url = wp_get_attachment_url($note->image_id);
                    $product = wc_get_product($note->product_id);
                    ?>
                    <tr>

                      <?php
                      echo "<td>" . get_the_title($note->product_id) . "</td>";
                      echo "<td>" . wc_price($product->get_price()) . "</td>"; ?>
                      <td>
                        <?php echo $note->qty; ?>
                      </td>
                      <td>
                        <?php echo $note->date; ?>
                      </td>
                      <td>
                        <?php echo $note->note; ?>
                      </td>
                      <td><?php
  $image_ids = explode(',', $note->image_ids); 
  foreach ($image_ids as $image_id) {
    echo '<img  width="50" height="50" src="' . wp_get_attachment_url($image_id) . '">';
  }
?></td>
                     <td>
        <label class="<?php echo $row->state == 1 ? 'btn btn-primary' : ($row->state == 2 ? 'btn btn-success' : 'btn btn-danger'); ?>">
			<?php echo $row->state == 1 ? "pending" : ($row->state == 2 ? "approve" : "cancel"); ?></label>
</td>

                      </tr>

                    <?php }?>
                 </tbody>
                  </table>
			<?php
          } else {?>
            <p class="mt-5">No orders has been sent yet</p>
         <?php } ?></div>
        <div id="pay">pay</div>
        <div id="doc"> <?php
            $table_name4 = $wpdb->prefix . 'documentations';
            $docs = $wpdb->get_results(
              $wpdb->prepare("
        SELECT * FROM $table_name4
        WHERE  supplier_id = %d
    ", $current_user_id)
            );
            if ($docs) { ?>
               <table id="example" class="table   mt-5 table-bordered  ">
                <thead class="table-dark">
				   <tr>
                    <th class="tabel-th">Document Name</th>
                    <th class="tabel-th">image</th>
                    <th class="tabel-th">Expiry date</th>
                   
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($docs as $doc) {
                 ?>
                      <tr>
                          <td><?php echo $doc->document_type; ?></td>
          
          <td><?php if ($doc->image_id) : 
          $image_ids = explode(',', $doc->image_id); 
          foreach ($image_ids as $image_id) {
            echo '<img width="50" height="50" src="' . wp_get_attachment_url($image_id) . '">';
          }
        ?>
      <?php endif; ?>
    </td>
 <td><?php echo $doc->expiry_date; ?></td></tr>
                      <?php }?>
                    </tbody>
                    </table>
			<?php
            } else {?>
            <p class="mt-5">No documents have been uploaded yet</p>
         <?php } ?></div>
    </div>
</section>



<?php } elseif (!is_user_logged_in()) {
    // Redirect to login page using JavaScript
    echo '<script>window.location.href = "' .
        home_url("/nlogin/") .
        '";</script>';
} else {
    // Display error message
    echo "<p>Sorry, you are not allowed to access this page..</p>";
}
?>