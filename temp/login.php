<?php

// Load WordPress
define("WP_USE_THEMES", false);
require "./wp-load.php";

if (isset($_GET["login"]) && $_GET["login"] == "failed") {
    $error = "Invalid username or password. Please try again";
}

// Output the login form
?>
 <div class="login-wrapper">
   <div class="login-content">
      <div class="login-userset">
         <div class="login-logo logo-normal">
      <img src="http://training.uaestore.ae/wp-content/uploads/2022/06/eelogo-transparent-big-1.jpg" alt="img">

         </div>
         <a href="index.html" class="login-logo logo-white">
    <img src="http://training.uaestore.ae/wp-content/uploads/2022/06/eelogo-transparent-big-1.jpg" alt>
         </a>
         <div class="login-userheading">
            <h3>Sign In</h3>
          
            <p class="text-center">
		
<?php if (isset($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>
         </div>
<?php $args = [
    "echo" => true,
    "redirect" => home_url("/dashboard/"),
    "form_id" => "loginform",
    "label_username" => __("Email"),
    "label_password" => __("Password"),
    "label_log_in" => __("Sign In"),
    "id_username" => "user_login",
    "id_password" => "user_pass",
    "id_submit" => "wp-submit",
    "remember" => true,
    "value_remember" => false,
]; ?>



<div class="form-login">
<?php wp_login_form($args); ?>

    </div>
</div>
</div>
<div class="login-img">
      <img src="https://dreamspos.dreamguystech.com/html/template/assets/img/login.jpg" alt="img">
   </div>

