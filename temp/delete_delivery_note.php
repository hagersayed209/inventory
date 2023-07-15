<?php
 
    require_once ABSPATH . 'wp-load.php';

global $wpdb;
    $delivery_note_id = intval( $_GET['delivery_note_id'] );
 // Delete row from custom database table
  $table_name = $wpdb->prefix . 'delivery_notes';
  $where = array(
    'id' => $delivery_note_id
  );
  $wpdb->delete($table_name, $where);

wp_redirect(admin_url('admin.php?page=delivery-note') );
exit;