<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");


if(isset($_GET['add_fund'])) {
    // Form fields processing
    
    
$user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$api_access_token = filter_var($_GET['api_access_token'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

$query = "SELECT * FROM users WHERE api_access_token = ? AND id = ? AND status = '1'";
$stmt = $con->prepare($query);

$stmt->bind_param("si", $api_access_token, $user_id);

$stmt->execute();

$result_api = $stmt->get_result();

if ($row_api = $result_api->fetch_array()) {
    // Valid user, now fetch the state
} else {
    echo "<script>window.location = 'logout.php';</script>";
    exit;
}
$stmt->close();

    // Get the selected payment method
    $paymentMethod = $_GET['payment_method'];

    // Your other form processing logic

    // Redirect based on the selected payment method
    if ($paymentMethod === "add_fund_rudra") {
        header("Location: add_fund_rudra/index.php?" . http_build_query($_GET));
        exit();
    } else if ($paymentMethod === "add_fund_new12") {
        header("Location: add_fund_new12/index.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "paymor_upi_qr") {
        header("Location: add_fund_pymore/index.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "app_download") {
        header("Location: download-app-fund-issue.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "add_fund_mpay") {
        header("Location: add_fund_mpay/index.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "add_fund_poxford") {
        header("Location: add_fund_poxford/index.php?" . http_build_query($_GET));
        exit();
    }
    
    
    
    
}


// Fetch the user's district from the database using the existing query
$user_id = $_SESSION['usr_id'];
$query = "SELECT district FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_district);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Add Fund - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" >  
            <?php 
            // Array of allowed states
            $not_allowed__states = ["Rajasthan", "Karnataka", "Tamil Nadu", "West Bengal"]; // Add your allowed states here
            $not_allowed_district = ["Pali", "Bikaner"]; // Add your allowed states here
            
            // Check if the user's state is in the allowed list
            if (in_array($user_district, $not_allowed_district)) {?>
            
            
            <div class="card tb-10">
                
                <div class="text-center tb-10">
                    <h3>Sorry, Add Fund Issue</h3>
                    <span>We are facing some issue in bank side, Please Try again after some time.</span>
                </div>

            </div>
            

            <?php 
                
            }else { ?>
               

            <div class="card tb-10">
                <?php 
                
                $user_id = $_SESSION['usr_id'];
                ?>
                <div class="text-center tb-10">
                    <h3>Add Fund via UPI</h3>
                    <span>Add points to your wallet.</span>
                </div>
                
                <div class="tbmar-20 text-center">
                    <p>Payment add krne ke 5 minute ke andar aapke wallet me points add ho jayenge.<br> Dont worry Wait kriye. <br>Your money is always safe with <?php echo $site_title;?> </p>
                    
                </div>

                <div class="tb-10"><hr class="devider"></div>
				
				<h3 class="subheading">Enter Amount</h3>
                 <form action="" method="GET" autocomplete="off">
                  <div class="form-group">
                    <input type="number" id="add_fund_amount" class="form-control" name="amount" value="" min="400" max="50000" placeholder="Enter Amount" autocomplete="off" required>
                  </div>
                <div class="row bidoptions-list tb-10">
                                <div class="col-3">
                                  <a class="addFundamtbox" id="amount_400" data="400">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 400</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="addFundamtbox" id="amount_500" data="500">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 500</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="addFundamtbox" id="amount_1000" data="1000">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 1000</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="addFundamtbox" id="amount_5000" data="5000">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 5000</p>
                                  </a>
                                </div>
                                
                </div>
				  
				  <div class="form-group">
                    <select class="form-control" name="payment_method" autocomplete="off" required>
						<option value="<?php echo get_SettingValue('web_version_payment_link');?>">Direct UPI</option>
						
						
					</select>
                  </div>
                 <?php // <option value="upi_indi">UPI Pay (IND)</option> ?>
                  
                  <input type="hidden" name="package_name" value="website">
				  <input type="hidden" name="version" value="5.0.0">
				  <input type="hidden" name="api_access_token" value="<?php echo $_SESSION['api_access_token'];?>">
                  <input type="hidden" name="id" value="<?php echo $_SESSION['usr_id'];?>">
                  
                  
                  
                  <button type="submit" name="add_fund" class="btn btn-theme btn-login">Add Points</button>
                  
                </form> 
                
                <div class="text-center tbmar-20">
                    <p>Unable to Add Fund?</p>
                    <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp1');?>" class="btn btn-outline btn-login">Contact Admin for help</a>
                </div>

            </div>
            
            <?php } ?>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>