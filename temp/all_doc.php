<?php

if (!current_user_can("manage_options")) {
    wp_die("You do not have sufficient permissions to access this page.");
}

global $wpdb;
$table_name = $wpdb->prefix . "documentations";
$docs = $wpdb->get_results("SELECT * FROM $table_name");

 $table_suppliers = $wpdb->prefix . 'suppliers';
 $results = $wpdb->get_results("SELECT * FROM $table_suppliers");

   ?>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

 <div class="container">
     
     
       
            <div class="container mt-4">
                <div class="page-header">
                    <div class="page-title">
                    <h4>Documents List</h4>
                  
                    </div>
                    <div class="page-btn">
                        <a href="<?php echo admin_url('admin.php?page=add-document');?>" class="btn btn-added">
                            <i class="bi bi-plus-lg"></i> Add New Documents
                        </a>
                        </div>
                    </div>
    <div class="table-responsive">
            <table id="example" class="table  mt-5  ">
                <thead class="table-light">

                    <tr>
                   
                          <th scope="col">Supplier</th>
                        <th class="tabel-th">Documentations Name</th>
                         <th class="tabel-th">image</th>
                         <th class="tabel-th">Expiry date</th>
                         <th scope="col"> Actions</th></tr>
                    </thead>
    <tbody>
   <?php foreach ($docs as $doc) {
    
      
      ?>
      <tr>
       <?php
         echo '<td>' . get_userdata($doc->supplier_id)->display_name . '</td>';?>
          <td><?php echo $doc->document_type; ?></td>
          
          <td><?php if ($doc->image_id) : 
          $image_ids = explode(',', $doc->image_id); 
          foreach ($image_ids as $image_id) {
            echo '<img width="50" height="50" src="' . wp_get_attachment_url($image_id) . '">';
          }
        ?>
      <?php endif; ?>
    </td>
 <td><?php echo $doc->expiry_date; ?></td>
         <?php    echo '<td><a href=' . admin_url( 'admin.php?page=edit-documents&doc_id=' . $doc->id ) . '" > <button type="button" class="btn">
                                        <span class="bi bi-pencil text-warning"></span></a> <a href=' . admin_url( 'admin.php?page=delete-documents&doc_id=' . $doc->id ) . '" > <button type="button" class="btn">
                                        <span class="bi bi-trash text-danger"></span></a></td>';
        echo '</tr>';?>
      </tr>
 <?php   }
    echo "</tbody>";
    echo "</table>";
    ?>
     </div>
            </div>
       