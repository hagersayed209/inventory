<?php
    require_once ABSPATH . 'wp-load.php';


global $wpdb;
    $supplier_id = intval( $_GET['supplier_id'] );
 
  $table_name = $wpdb->prefix . 'suppliers';
  $where = array(
    'id' => $supplier_id
  );
  $wpdb->delete($table_name, $where);

wp_redirect(admin_url('admin.php?page=inventory') );
exit;






