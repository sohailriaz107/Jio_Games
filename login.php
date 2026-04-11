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

if(isset($_POST['login'])){
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
    $return_url = isset($_POST['return_url']) ? filter_var($_POST['return_url'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    $mobile = isset($_POST['mobile']) ? filter_var($_POST['mobile'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';
    $password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES) : '';

    // Hash password
    $password_hash = md5($password);

    // Prepare statement
    $query = "SELECT * FROM users WHERE mobile = ? AND password = ?";
    $stmt = mysqli_prepare($con, $query);
    
    // Bind parameters
    $mobile = '+91' . $mobile;
    mysqli_stmt_bind_param($stmt, "ss", $mobile, $password_hash);
    
    // Execute statement
    mysqli_stmt_execute($stmt);
    
    // Store result
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_array($result)){
        if($row['status'] == 0){
            echo '<center><br><br><br><br>Contact admin</center>';
            exit;
        } else {
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
            
            // Redirect based on return_url
            if(empty($return_url)){
                echo "<script>window.location = 'index.php';</script>";
            } else {
                echo "<script>window.location = '".base64_decode($return_url)."';</script>";
            }
            exit;
        }
    } else {
        $show_error_msg = 1;
        echo "<script>alert('Invalid Mobile No or Password')</script>";
        echo "<script>window.location = 'login.php?success_alert1';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Login - <?php echo $site_title;?></title>
    <meta name="description" content="login and access play option for satta matka online and win big money, india's largest and trusted satta matka play application, Fastest withdrawal and full rate">
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            
            <div class="container" >  
            <div class="premium-auth-card">
                
                <center><img src="assets/img/logo-fill.png" style="min-height: 100px;height: 100px;margin: auto;margin-bottom: auto;border-radius: 10px;margin-bottom: 10px;" ></center>
                
                <div class="text-center tb-10">
                    <h3>Welcome</h3>
                    <span>Sign in to Continue</span>
                </div>
                 <form action="" method="POST">
                  <div class="form-group">
                    <label for="mobile">Mobile Number:</label>
                    <input type="text" class="form-control" name="mobile" maxlength="10" minlength="10" placeholder="Enter 10 Digit Phone Number" id="mobile" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password" id="pwd" autocomplete="off" required>
                  </div>
                  <button type="submit" class="btn btn-theme btn-login" name="login">Submit</button>
                  <input type="hidden" name="return_url" value="<?php echo isset($_GET['return_url']) ? htmlspecialchars($_GET['return_url']) : ''; ?>">
                </form> 
                
                <div class="text-center tbmar-20">
                    <p>Dont have an account?</p>
                    <a href="register.php" class="btn btn-login">Create Account Now</a>
                </div>

            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>