<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");
	
if (isset($_POST['update_bank_details']) && isset($_SESSION['usr_id'])!="") {
    $user_id = $_SESSION['usr_id'];
    $api_acess_token = filter_var($_POST['api_acess_token'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    
    if ($_SESSION['api_acess_token'] != $api_acess_token) {
        echo "<script>window.location = 'update-bank-details.php?invalidrequest';</script>";
        exit;
    }
    
    $stmt_check_account = $con->prepare("SELECT account_number FROM users WHERE id = ?");
    $stmt_check_account->bind_param("i", $user_id);
    $stmt_check_account->execute();
    $stmt_check_account->store_result();
    
    if ($stmt_check_account->num_rows > 0) {
        $stmt_check_account->bind_result($account_number);
        $stmt_check_account->fetch();
        if (!empty($account_number)) {
            echo "<script>alert('Contact Admin to Update Details');</script>";
            echo "<script>window.location = 'update-bank-details.php?invalidrequest';</script>";
            exit;
        }
    }
    
    $account_number = filter_var($_POST['account_number'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $ifsc = filter_var($_POST['ifsc'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $bank_name = filter_var($_POST['bank_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $account_holder_name = filter_var($_POST['account_holder_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    
    $stmt_check_duplicate_account = $con->prepare("SELECT id FROM users WHERE account_number = ?");
    $stmt_check_duplicate_account->bind_param("s", $account_number);
    $stmt_check_duplicate_account->execute();
    $stmt_check_duplicate_account->store_result();
    
    if ($stmt_check_duplicate_account->num_rows > 0) {
        echo "<script>alert('Account Number Already Exists.');</script>";
        echo "<script>window.location = 'update-bank-details.php?invalidrequest';</script>";
        exit;
    }
    
    $sql = "UPDATE users SET account_number = ?, ifsc = ?, bank_name = ?, account_holder_name = ? WHERE id = ?";
    $stmt_update_details = $con->prepare($sql);
    $stmt_update_details->bind_param("ssssi", $account_number, $ifsc, $bank_name, $account_holder_name, $user_id);
    $res = $stmt_update_details->execute();
    
    if ($res) {
        echo "<script>window.location = 'update-bank-details.php?detailupdated';</script>";
    } else {
        echo "<script>window.location = 'update-bank-details.php?notupdated';</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Bank Details - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" >  
            <div class="card tb-10">
                <?php 
                
                $user_id = $_SESSION['usr_id'];
                $qry =  "SELECT * FROM users where id='".$user_id."'";
                $user_info = mysqli_query($con, $qry);
                while($row = mysqli_fetch_array($user_info)){
                $account_holder_name = $row['account_holder_name'];
                $account_number = $row['account_number'];
                $ifsc = $row['ifsc'];
                $bank_name = $row['bank_name'];
                }
                ?>
                <div class="text-center tb-10">
                    <h3>Bank Details</h3>
                    <span>Provide Valid Bank Details</span>
                </div>
                 <form action="" method="POST" autocomplete="off">
                  <div class="form-group">
                    <label for="name">A/c Holder Name:</label>
                    <input type="text" class="form-control" name="account_holder_name" value="<?php echo $account_holder_name;?>" maxlength="50" minlength="4" placeholder="Beneficiary name" id="account_holder_name" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="username">Bank Account Number:</label>
                    <input type="text" class="form-control" name="account_number" value="<?php echo $account_number;?>" maxlength="25" minlength="4" placeholder="950000124587" id="account_number" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="mobile">IFSC Code:</label>
                    <input type="text" class="form-control" name="ifsc" value="<?php echo $ifsc;?>" maxlength="11" minlength="11" placeholder="HDFC0000139" id="ifsc" autocomplete="off" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="mobile">Bank Name:</label>
                    <input type="text" class="form-control" name="bank_name" value="<?php echo $bank_name;?>" maxlength="25" minlength="3" placeholder="HDFC/SBI/Bank of india" id="bank_name" autocomplete="off" required>
                  </div>
                  
                  <input type="hidden" name="api_acess_token" value="<?php echo $_SESSION['api_acess_token'];?>">
                  <?php 
                  if($account_holder_name =='' || $account_holder_name ==NULL){
                  ?>        
                  
                  <button type="submit" name="update_bank_details" class="btn btn-theme btn-login">Submit</button>
                  <?php }else{?>
                  <button type="button" name="bank_details" class="btn btn-theme btn-login">Already Updated</button>
                  <?php } ?>
                </form> 
                
                <div class="text-center tbmar-20">
                    <p>Unable to update?</p>
                    <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" class="btn btn-outline btn-login">Contact Admin</a>
                </div>

            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>