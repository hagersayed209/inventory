<?php
/*
Plugin Name: test  Plugin

Description: Adds a custom role .
Version: 1.1
Author: Hager Sayed
*/


// Define constants for file paths
define( 'MCL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MCL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function my_custom_admin_styles($hook_suffix) {
 $my_admin_pages = array(
    'toplevel_page_inventory',
    'inventory_page_delivery-note',
 
  );
  
  global $pagenow;

  if (in_array($hook_suffix, $my_admin_pages) ||  $pagenow === 'admin.php' && isset( $_GET['page'] ) && ( $_GET['page'] === 'edit-supplier' || $_GET['page'] === 'add_supplier' || $_GET['page'] === 'add-delivery-note'|| $_GET['page'] === 'edit-delivery-note') ) {
  
   
    wp_enqueue_style(
        "bootstrap",
        MCL_PLUGIN_URL . "asset/css/bootstrap.min.css"
    );
   
     wp_enqueue_style(
        " dataTables-bootstrap5",
        MCL_PLUGIN_URL . "asset/css/dataTablesbootstrap5.min.css"
    );
     wp_enqueue_style(
        "select2",
        MCL_PLUGIN_URL . "asset/css/select2.min.css"
    );
  wp_enqueue_style(
        "mcl-custom",
        MCL_PLUGIN_URL . "asset/css/index.css"
    );

  
   //wp_enqueue_script( 'jquery' );
   
     wp_enqueue_script(
        " bootstrap",
        MCL_PLUGIN_URL . "asset/js/bootstrap.min.js",
        array("jquery"),
        "4.1.3",
        true
    );
  
     
    wp_enqueue_script(
        "datatables-jquery",
        MCL_PLUGIN_URL . "asset/js/jquery.dataTables.min.js",
        array("jquery"),
        "1.13.4",
        true
    );
        wp_enqueue_script(
        "datatables-bootstrap5",
        MCL_PLUGIN_URL . "asset/js/dataTables.bootstrap5.min.js",
        array("jquery"),
        "1.13.4",
        true
    );
     
     wp_enqueue_script(
        " select2",
        MCL_PLUGIN_URL . "asset/js/select2.min.js",
        array("jquery"),
        "4.1.0",
        true
    );
     wp_enqueue_script(
        "custom-js",
        MCL_PLUGIN_URL . "asset/js/index.js",
        array("jquery"),
        "1.0.0",
        true
    );
  }
}
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');
function mcl_enqueue_assets()
{
    wp_enqueue_style(
        "bootstrap",
        "https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css",
        [],
        "4.1.3"
    );

    wp_enqueue_style(
        "mcl-custom",
        MCL_PLUGIN_URL . "asset/css/login.css"
    );
   
	

    wp_enqueue_style(
        "dashboard",
        MCL_PLUGIN_URL . "asset/css/dashboard.css"
    );
   
   wp_enqueue_style(
        "test",
        MCL_PLUGIN_URL . "asset/css/test.css"
    );
	

    wp_enqueue_script(
        "custom-js",
        MCL_PLUGIN_URL . "asset/js/script.js",
        [],
        "1.0.0",
        true
    );
}
add_action( 'wp_enqueue_scripts', "mcl_enqueue_assets");

//page for admin
function add_inventory_menu()
{
    add_menu_page(
        __("Inventory", "textdomain"),
        "Inventory",
        "manage_options",
        "inventory",
        "inventory_page_callback",
        "dashicons-store",
        6
    );
    add_submenu_page(
       null,
        "add_supplier",
        "add_supplier",
        "manage_options",
        "add_supplier",
        "add_supplier_page_callback"
    );
	add_submenu_page(
       null,
        'Edit Supplier', 
        'Edit Supplier ', 
        'manage_options', 
        'edit-supplier', 
        'edit_supplier_callback' 
    );
     add_submenu_page(
       null,
        'delete Supplier', 
        'delete Supplier ', 
        'manage_options', 
        'delete-supplier', 
        'delete_supplier_callback' 
    );
   add_submenu_page(
    'inventory',
    __( 'Delivery Note', 'textdomain' ),
    __( 'Delivery Note', 'textdomain' ),
    'manage_options',
    'delivery-note',
    'delivery_note_page_callback'
  );
   add_submenu_page(
          null,
        "Add Delivery Note",
        "Add Delivery Note",
        "manage_options",
        "add-delivery-note",
        "add_delivery_note_page_callback"
    );
    add_submenu_page(
       null,
        ' Delete Delivery Note', 
        'Delete Delivery Note ', 
        'manage_options', 
        'delete-delivery-note', 
        'delete_delivery_note_callback' 
    );
     add_submenu_page(
      null,
        'Edit Delivery Note', 
        'Edit Delivery Note ', 
        'manage_options', 
        'edit-delivery-note', 
        'edit_delivery_note_callback'
    ); 
}
add_action("admin_menu", "add_inventory_menu");
function inventory_page_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/all_supplier.php";
}
function add_supplier_page_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/add_supplier.php";
}
function edit_supplier_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/edit_supplier.php";
}
function delete_supplier_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/delete_supplier.php";
}
function delivery_note_page_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/all-delivery_note.php";
   
}
function add_delivery_note_page_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/add_delivery_note.php";
   
}

function delete_delivery_note_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/delete_delivery_note.php";
}
function edit_delivery_note_callback()
{
    require_once MCL_PLUGIN_DIR . "temp/edit_delivery_note.php";
}
// // Create a new user role for suppliers

$customer_caps = get_role( 'customer' )->capabilities;
add_role( 'supplier', __('Supplier', 'textdomain'), $customer_caps );
// Create suppliers table
function create_suppliers_table() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'suppliers';
  
  $charset_collate = $wpdb->get_charset_collate();
  
  $sql = "CREATE TABLE $table_name (
   id INT NOT NULL AUTO_INCREMENT,
product_id INT NOT NULL,
supplier_id INT NOT NULL,
commission DECIMAL(10,2),
PRIMARY KEY (id)
)$charset_collate;";
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_suppliers_table');

// Create delivery table
function create_delivery_table() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'delivery_notes';
  
  $charset_collate = $wpdb->get_charset_collate();
  
  $sql = "CREATE TABLE $table_name (
     id mediumint(9) NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL,
    supplier_id INT NOT NULL,
    note text NOT NULL,
    qty mediumint(9) NOT NULL,
    date DATE NOT NULL,
    image_id mediumint(9) NOT NULL,
    PRIMARY KEY (id)
  ) $charset_collate;";
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_delivery_table');

// Delete tables when plugin is deactivated
function delete_tables_on_deactivation() {
  global $wpdb;
  $table_names = array(
    $wpdb->prefix . 'suppliers',
    $wpdb->prefix . 'delivery_notes'
  );
  
  foreach ($table_names as $table_name) {
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);
  }
}
register_deactivation_hook(__FILE__, 'delete_tables_on_deactivation');
// Load login template
  function mcl_load_login_template() {
    ob_start();
    include( MCL_PLUGIN_DIR . 'temp/login.php' );
    return ob_get_clean();
  }
  add_shortcode( 'mcl_login', 'mcl_load_login_template' );
  
  // Load dashboard template
  function mcl_load_dashboard_template() {
  
  ob_start();
  include( MCL_PLUGIN_DIR . 'temp/dashboard.php' );
  return ob_get_clean();
  }
  
  add_shortcode( 'mcl_dashboard', 'mcl_load_dashboard_template' );
  

  function my_profile_shortcode() {
     ob_start();
  include( MCL_PLUGIN_DIR . 'temp/profile.php' );
  return ob_get_clean();
}
add_shortcode( 'my_profilmme', 'my_profile_shortcode' );


    // Check if user is logged in && Check if user has supplier role
  function is_supplier_user() {
  
  if ( ! is_user_logged_in() ) {
    return false;
  }

 
  $user_id = get_current_user_id();

 
  if ( ! $user_id ) {
    return false;
  }

  $has_supplier_role = get_transient( 'is_supplier_user_' . $user_id );

  if ( false === $has_supplier_role ) {
    $user = get_userdata( $user_id );
    $has_supplier_role = in_array( 'supplier', (array) $user->roles );
    set_transient( 'is_supplier_user_' . $user_id, $has_supplier_role, DAY_IN_SECONDS );
  }

  return $has_supplier_role;
}
// to redirect users to a custom login page if their login attempt fails.
function custom_login_fail()
{
    $login_page_2 = home_url("/nlogin/"); 

    if (isset($_SERVER["HTTP_REFERER"])) {
        $referrer = $_SERVER["HTTP_REFERER"];
        if ($referrer == $login_page_1 || $referrer == $login_page_2) {
            $redirect_to = home_url("/nlogin/"); 
            wp_redirect($redirect_to . "?login=failed");
            exit();
        }
    }
}
add_action("wp_login_failed", "custom_login_fail");
