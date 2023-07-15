<?php 
$user = wp_get_current_user();
$name = $user->display_name;
$email = $user->user_email;
$address = get_user_meta( $user->ID, 'address', true );
$image_url = get_user_meta( $user->ID, 'profile_image', true );
$phone = get_user_meta($user->ID, 'phone', true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['submit'])) {
    if (isset($_FILES['profile_picture'])) {
        $upload_dir = wp_upload_dir();
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $file_size = $_FILES['profile_picture']['size'];
        $file_type = $_FILES['profile_picture']['type'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($file_ext, $allowed_exts)) {
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir['path'] . '/' . $new_file_name;

            if (move_uploaded_file($file_tmp_name, $upload_path)) {
                update_user_meta($user->ID, 'profile_image', $upload_dir['url'] . '/' . $new_file_name);
                $image_url = get_user_meta($user->ID, 'profile_image', true);
            } else {
                // handle file upload error
            }
        } else {
            // handle file type not allowed error
        }
    }
	 // Update phone number
    if (isset($_POST['phone'])) {
        $phone = sanitize_text_field($_POST['phone']);
        update_user_meta($user->ID, 'phone', $phone);
    }

    // Update email
    if (isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        wp_update_user(array('ID' => $user->ID, 'user_email' => $email));
    }

    // Update address
    if (isset($_POST['address'])) {
        $address = sanitize_text_field($_POST['address']);
        update_user_meta($user->ID, 'address', $address);
    }
}
?>
<style>
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
  content: 'Select Image';
  display: inline-block;
    background: #FF9F43;
  border-color: #FF9F43 !important;
  border-radius: 3px;
    padding: 12px;
  outline: none;
 
  -webkit-user-select: none;
  cursor: pointer;
 
  font-weight: 700;
  -webkit-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    transition: all 0.5s ease;
    margin-top: 15px;
    color: #fff;
}
	
.custom-file-input:hover::before,.custom-file-input:active::before {
 box-shadow: 0 50px #fff inset !important;
    color: #ff9f43
}
	
 
</style>
 <div id="resign-widget" class="container bg-light">
      <div class="row m-5 p-5">
		   <div class="col-lg-5">
          <div class="card h-100 border-0">
            <img src="<?php echo $image_url; ?>" width="300" class="card-img-top " alt="...">
            <div class="card-body">
              <form method="post" enctype="multipart/form-data">
            <input class="custom-file-input"type="file" name="profile_picture">
            <input type="submit"name="submit" value="Upload"class="btn btn-secondary">
        </form>
            </div>
          </div>
        </div>
        <div id="user-data" class="col-lg-7">
          <div class="card h-100 border-0">
            <div class="card-body"> 
			  
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $name; ?></p>
              </div>
            </div>
			    <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $email; ?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php if ($phone) {
  echo ': ' . esc_html($phone);
} else {
  echo ': N/A';
}?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $address; ?></p>
              </div>
            </div>

          </div>
			    <button id="edit-button"class="btn btn-lg btn-primary mb-3" > edit</button>
          </div>
        </div>
         
<div id="user-form"class="col-lg-7" style="display:none">
	 <div class="card h-100 border-0">
		 <form method="post">
            <div class="card-body"> 
    
   
  <div class="row mb-3">
    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
    <div class="col-sm-10">
      <input type="number" name="phone"class="form-control" id="phone" value="<?php echo esc_attr(get_user_meta($user->ID, 'phone', true)); ?>">
    </div>
  </div>
  
  <div class="row mb-3">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" name="email"class="form-control" id="inputEmail3" value="<?php echo esc_attr($email); ?>">
    </div>
  </div>

 
  <div class="row mb-3">
    <label for="address" class="col-sm-2 col-form-label">Address</label>
    <div class="col-sm-10">
      <input type="text"name="address" class="form-control" id="address" value="<?php echo esc_attr($address); ?>">
    </div>
  </div>

    
    </div>
			  <button type="submit" class="btn btn-lg btn-primary mb-3">Sign in</button>
    <button id="cancel-button"class="btn btn-lg btn-primary mb-3"> cancel</button>
			 </form>   
      </div>
    </div>
 </div>
 </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>// Get the Clear button element
const editButton = document.getElementById('edit-button');
const cancelButton = document.getElementById('cancel-button');
const userForm = document.getElementById('user-form');
const userData = document.getElementById('user-data');

editButton.addEventListener('click', () => {
  userForm.style.display = 'block';
  userData.style.display = 'none';
});

cancelButton.addEventListener('click', () => {
  userForm.style.display = 'none';
  userData.style.display = 'block';
});

</script>
