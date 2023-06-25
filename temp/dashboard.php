<?php
if (  is_supplier_user() ) {
  ?>
 <!--=== Boxicons CSS ===-->
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
<nav class="sidebar sideebar close">
	
    <header>
        
        <div class="image-text">
            <span class="image">
        <img src="http://training.uaestore.ae/wp-content/uploads/2022/06/eelogo-transparent-big-1.jpg" alt="" />
      </span>

           
        </div>
<i class="bx bx-chevron-right-circle toggle"></i>
        
        
    </header>

    <div class="menu-bar">
        <div class="menu">
           
            <ul class="menu-links">
<li class="nav-link">
<a href="#" >
 <i class="bx bx-store icon"></i>
  <span class="text nav-text">Stock</span>
</a>
</li>

<li class="nav-link">
<a href="#">
       <i class="bx bx-package icon"></i>
  <span class="text nav-text">Delivery Note</span>
</a>
</li>

<li class="nav-link">
<a href="#">
  <i class="bx bx-dollar-circle icon"></i>
  <span class="text nav-text">payments</span>
</a>
</li>

<li class="nav-link">
<a href="#">
  <i class="bx bx-file icon"></i>
  <span class="text nav-text">Documentation</span>
</a>
</li>
</ul>

        </div>

        <div class="bottom-content">
            <li class="">
                <a href="#">
                    <i class="bx bx-log-out icon"></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>

            <li class="mode">
                <div class="sun-moon">
                    <i class="bx bx-moon icon moon"></i>
                    <i class="bx bx-sun icon sun"></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>
        </div>
    </div>
</nav>

<section class="home">

    <div class="text">Dashboard Sidebar</div>
</section>




<?php


} elseif ( ! is_user_logged_in() ) {

// Redirect to login page using JavaScript
echo '<script>window.location.href = "' . home_url( '/nlogin/' ) . '";</script>';
} else {
// Display error message
echo '<p>Sorry, you are not allowed to access this page..</p>';

}
?>
