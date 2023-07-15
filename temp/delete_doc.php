<?php
 
    require_once ABSPATH . 'wp-load.php';

global $wpdb;
    $doc_id = intval( $_GET['doc_id'] );
  $table_name = $wpdb->prefix . 'documentations';
  $where = array(
    'id' => $doc_id
  );
  $wpdb->delete($table_name, $where);

wp_redirect(admin_url('admin.php?page=documents') );
exit;