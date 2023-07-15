<?php 

global $wpdb;
$products = get_posts(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
));
$table_name = $wpdb->prefix . 'delivery_notes';


$rows = $wpdb->get_results( "SELECT * FROM $table_name" );

 $table_suppliers = $wpdb->prefix . 'suppliers';
 $results = $wpdb->get_results("SELECT * FROM $table_suppliers");

 ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

 <div class="container">
     
     
       
            <div class="container mt-4">
                <div class="page-header">
                    <div class="page-title">
                    <h4>Delivery Notes List</h4>
                  
                    </div>
                    <div class="page-btn">
                        <a href="<?php echo admin_url('admin.php?page=add-delivery-note');?>" class="btn btn-added">
                            <i class="bi bi-plus-lg"></i> Add Delivery Note
                        </a>
                        </div>
                    </div>
             
 <div class="table-responsive">
                    <table id="example"class="table  mt-5  ">
                        <thead class="table-light">
                            <tr>
                            <th scope="col">ID</th>
                               <th scope="col">product</th>
                               <th scope="col">Supplier</th>
                               <th scope="col"> Note</th>
<th scope="col">Quantity</th>
<th scope="col">Date</th>
<th scope="col">Image</th>
<th scope="col">State </th>
<th scope="col"> Actions</th>

                            </tr>
                        </thead>
                        <tbody>

    <?php foreach ( $rows as $row ) :
    
        $image_url = wp_get_attachment_url( $row->image_id );
        
      ?>
      <tr>
        <td><?php echo $row->id; ?></td>
        <?php
         echo "<td>" . get_the_title($row->product_id) . "</td>";
       
        echo '<td>' . get_userdata($row->supplier_id)->display_name . '</td>';?>
       
        <td><?php echo $row->note; ?></td>
        <td><?php echo $row->qty; ?></td>
        <td><?php echo $row->date; ?></td>

       
      
<td><?php
  $image_ids = explode(',', $row->image_ids); 
  foreach ($image_ids as $image_id) {
    echo '<img  width="50" height="50" src="' . wp_get_attachment_url($image_id) . '">';
  }
?></td><td>
        <label class="<?php echo $row->state == 1 ? 'btn btn-primary' : ($row->state == 2 ? 'btn btn-success' : 'btn btn-danger'); ?>">
			<?php echo $row->state == 1 ? "pending" : ($row->state == 2 ? "approve" : "cancel"); ?></label>
</td>



    <?php    echo '<td><a href=' . admin_url( 'admin.php?page=edit-delivery-note&delivery_note_id=' . $row->id ) . '" > <button type="button" class="btn">
                                        <span class="bi bi-pencil text-warning"></span></a> <a href=' . admin_url( 'admin.php?page=delete-delivery-note&delivery_note_id=' . $row->id ) . '" > <button type="button" class="btn">
                                        <span class="bi bi-trash text-danger"></span></a></td>';
        echo '</tr>';?>
      </tr>
    <?php endforeach; ?>
   
                        </tbody>
                    </table>
                </div>
            </div>
       