<?php
if (!current_user_can("manage_options")) {
    wp_die("You do not have sufficient permissions to access this page.");
}

global $wpdb;
$table_name = $wpdb->prefix . "suppliers";
$results = $wpdb->get_results("SELECT * FROM $table_name");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<body style="margin:20px auto">
    <div class="container">
     
     
       
            <div class="container">
                <div class="page-header">
                    <div class="page-title">
                    <h4>Suppliers List</h4>
                  
                    </div>
                    <div class="page-btn">
                        <a href="<?php echo admin_url(
                            "admin.php?page=add_supplier"
                        ); ?>" class="btn btn-added">
                            <i class="bi bi-plus-lg"></i>
 Add Supplier
                        </a>
                        </div>
                    </div>
             
 <div class="table-responsive">
                    <table id="example"class="table  mt-5  ">
                        <thead class="table-light">
                         
                            <tr>
                               <th scope="col">product</th>
<th scope="col"> Name</th>
<th scope="col">commission</th>
<th scope="col"> Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result) {
                                echo "<tr>"; ?>
         
                <?php
                echo "<td>" . get_the_title($result->product_id) . "</td>";
                echo "<td>" .
                    get_userdata($result->supplier_id)->display_name .
                    "</td>";
                echo "<td>" . $result->commission . "</td>";

                echo "<td><a href=" .
                    admin_url(
                        "admin.php?page=edit-supplier&supplier_id=" .
                            $result->id
                    ) .
                    '" > <button type="button" class="btn">
                                       <span class="bi bi-pencil text-warning"></span></a> <a href=' .
                    admin_url(
                        "admin.php?page=delete-supplier&supplier_id=" .
                            $result->id
                    ) .
                    '" > <button type="button" class="btn">
                                        <span class="bi bi-trash text-danger"></span></a></td>';
                echo "</tr>";

                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
       

