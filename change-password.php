<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");
	
if (isset($_POST['update_bank_details']) && isset($_SESSION['usr_id']) && $_SESSION['usr_id'] != "") {
	
    $user_id = $_SESSION['usr_id'];
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
	$confirm_new_password = $_POST['confirm_new_password'];
	$api_access_token = $_POST['api_access_token'];
	
	// Validate and sanitize input
	$old_password = filter_var($old_password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$new_password = filter_var($new_password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$confirm_new_password = filter_var($confirm_new_password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$api_access_token = filter_var($api_access_token, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	
	// Verify if the API access token matches the session token
	if ($_SESSION['api_access_token'] !== $api_access_token) {
	    echo "<script>window.location = 'update-bank-details.php?invalidrequest';</script>";
	    exit;
	}
	
	// Hash the new password
	$new_password_hash = md5($new_password);
	
	// Prepare and execute the statement to check old password
	$stmt = mysqli_prepare($con, "SELECT * FROM users WHERE id=? AND password=?");
	mysqli_stmt_bind_param($stmt, "is", $user_id, md5($old_password));
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	
	// Check if old password matches
	if ($row = mysqli_fetch_array($result)) {
	    // Prepare and execute the statement to update password
	    $stmt = mysqli_prepare($con, "UPDATE users SET password=? WHERE id=?");
	    mysqli_stmt_bind_param($stmt, "si", $new_password_hash, $user_id);
	    mysqli_stmt_execute($stmt);
	    
	    echo "<script>window.location = 'change-password.php?detailupdated';</script>";
	} else {
	    echo "<script>window.location = 'change-password.php?notupdated';</script>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Update Password - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" >  
            <div class="card tb-10">

                <div class="text-center tb-10">
                    <h3>Change Password</h3>
                    <span>Update Your Profile Password</span>
                </div>
                 <form action="" method="POST" autocomplete="off">
                  <div class="form-group">
                    <label for="name">Old Password:</label>
                    <input type="text" class="form-control" name="old_password"  minlength="3" maxlength="50" placeholder="Existing Password" id="old_password" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="username">New Password:</label>
                    <input type="text" class="form-control" name="new_password"  minlength="3" maxlength="50" placeholder="Enter New Password" id="new_password" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="mobile">Confirm Password:</label>
                    <input type="text" class="form-control" name="confirm_new_password" minlength="3" maxlength="50" placeholder="Confirm Password" id="confirm_new_password" autocomplete="off" required>
                  </div>
                  
                  <input type="hidden" name="api_acess_token" value="<?php echo $_SESSION['api_acess_token'];?>">
                  <button type="submit" name="change_password" class="btn btn-theme btn-login">Submit</button>

                </form> 


            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>