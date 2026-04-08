<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
include("include/connect.php");
include("include/session.php");
include("include/functions.php");

if(isset($_SESSION['usr_id'])!=""){
    echo "<script>window.location = 'index.php';</script>";
    exit;
}

if (isset($_POST['signup'])) {
    
    if (0) {
    echo "<script>alert('Opps... Kindly contact Admin')</script>";
    echo "<script>window.location = 'register.php';</script>";
    exit;
  }
  
  
    // Allow 5 attempts per minute
    $timeFrame = 60;
    $maxAttempts = 5;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $key = 'rate_limit_' . $ip;

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['attempts' => 1, 'time' => time()];
    } else {
        $elapsedTime = time() - $_SESSION[$key]['time'];

        if ($elapsedTime < $timeFrame) {
            $_SESSION[$key]['attempts']++;

            if ($_SESSION[$key]['attempts'] > $maxAttempts) {
                // Implement your action, like blocking the IP or introducing a delay.
                echo 'Invalid Activity Found';
                exit;
            }
        } else {
            $_SESSION[$key] = ['attempts' => 1, 'time' => time()];
        }
    }

    // Sanitize input data
    $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    $username = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    $mobile = isset($_POST['mobile']) ? filter_var($_POST['mobile'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    $password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    $confirmpassword = isset($_POST['confirmpassword']) ? filter_var($_POST['confirmpassword'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    
    

    // Allow only letters and spaces, and require at least 2 characters
    if (!preg_match('/^[a-zA-Z ]{2,}$/', $name)) {
        echo "<script>alert('Invalid name. Only letters and spaces allowed')</script>";
        echo "<script>window.location = 'register.php';</script>";
        exit;
    }

    

    // Validate mobile number
    if (!preg_match('/^\d{10}$/', $mobile)) {
        echo "<script>alert('Invalid mobile number. Please enter a 10-digit number')</script>";
        echo "<script>window.location = 'register.php';</script>";
        exit;
    }

    // Validate password
    if ($password != $confirmpassword) {
        echo "<script>alert('Password does not match')</script>";
        echo "<script>window.location = 'register.php';</script>";
        exit;
    }


    $password_hash = md5($password);
    $api_access_token = generateRandomString();
    $date_created = date("Y-m-d");
    $mobile = '+91'.$mobile;

    // Check if mobile number already exists
    $sql = "SELECT * FROM users WHERE mobile=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $mobile);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $phone_check = mysqli_num_rows($result);
    mysqli_stmt_close($stmt);

    if ($phone_check > 0) {
        echo "<script>alert('Mobile Number Already Exists.')</script>";
        echo "<script>window.location = 'register.php';</script>";
        exit;
    }

    // Insert user data into database
    $refer_id = strtoupper(substr($username,0,2)).rand(1000,9999);
    $sql = "INSERT INTO users (name, username, mobile, password, status, date_created, role, refer_id, refer_by, package_name, api_access_token)
            VALUES (?, ?, ?, ?, '1', ?, 'user', ?, '', 'website', ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $username, $mobile, $password_hash, $date_created, $refer_id, $api_access_token);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $last_id = mysqli_insert_id($con);
        // Fetch user data after registration
        $sql = "SELECT * FROM users WHERE id=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $last_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        mysqli_stmt_close($stmt);

        // Set cookies
        setcookie("usr_id", $row['id'], time() + 30 * 24 * 60 * 60, "/");
        setcookie("usr_name", $row['username'], time() + 30 * 24 * 60 * 60, "/");
        setcookie("usr_mobile", $row['mobile'], time() + 30 * 24 * 60 * 60, "/");
        setcookie("api_access_token", $row['api_access_token'], time() + 30 * 24 * 60 * 60, "/");
        
        // Set session variables
        $_SESSION['usr_id'] = $row['id'];
        $_SESSION['status'] = $row['status'];
        $_SESSION['usr_name'] = $row['username'];
        $_SESSION['usr_mobile'] = $row['mobile'];
        $_SESSION['api_access_token'] = $row['api_access_token'];

        echo "<script>window.location = 'index.php?success_alert1';</script>";
    } else {
        echo "<script>alert('Sorry! Try Again')</script>";
        echo "<script>window.location = 'register.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Signup - <?php echo $site_title;?></title>
    <meta name="description" content="Create account by register with online matka play. india's largest and trusted satta matka play application, Fastest withdrawal and full rate">
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
                    <h3>Sign Up</h3>
                    <span>Create Your Account</span>
                </div>
                 <form action="" method="POST" autocomplete="off">
                  <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" class="form-control" name="name" maxlength="50" minlength="4" placeholder="Enter Full Name" id="name" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" maxlength="25" minlength="4" placeholder="Unique Username" id="username" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="mobile">Mobile Number:</label>
                    <input type="text" class="form-control" name="mobile" maxlength="10" minlength="10" placeholder="Enter 10 Digit Phone Number" id="mobile" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password" id="pwd" autocomplete="off" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="cnpwd">Confirm Password:</label>
                    <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm password" id="cnpwd" autocomplete="off" required>
                  </div>
                  
                  <button type="submit" name="signup" class="btn btn-theme btn-login">Submit</button>
                </form> 
                
                <div class="text-center tbmar-20">
                    <p>Already have an account?</p>
                    <a href="login.php" class="btn btn-outline btn-login">Login Here</a>
                </div>

            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>