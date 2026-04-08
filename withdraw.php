<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");

if (isset($_POST['withdraw']) && isset($_SESSION['usr_id'])!="") {
    $user_id = filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT);
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
    $date = date('Y-m-d');
    $time = date('h:i:s A');

    $query = "SELECT SUM(win) as winning_amount FROM user_transaction WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $winningAmount = $row['winning_amount'];
        if ($winningAmount <= 0) {
            echo "<script>alert('You Dont have Any Winning Amount. You can only withdraw Winning Amount.')</script>";
            echo "<script>window.location = 'withdraw.php?invalidrequest';</script>";
            mysqli_close($con);
            exit;
        }
    } else {
        echo "<script>alert('You Dont have Any Winning Amount. You can only withdraw Winning Amount.')</script>";
        echo "<script>window.location = 'withdraw.php?invalidrequest';</script>";
        mysqli_close($con);
        exit;
    }
    
    if($amount > get_lastBalance($user_id)) {
        echo "<script>window.location = 'withdraw.php?insufficientbalance';</script>";
    } elseif ($amount < 1000) {
        echo "<script>window.location = 'withdraw.php?invalidrequest';</script>";
    } else {
        $balance = get_lastBalance($user_id);
        $new_balance = $balance - $amount;
        UpdateBalanceInUserTable($user_id, $new_balance);
        
        $stmt = $con->prepare("INSERT INTO user_transaction(user_id,game_id,game_type,digit,date,time,amount,type,debit_credit,balance,status,api_response) 
                                VALUES(?, '', 'withdraw', '', ?, ?, ?, 'withdraw', 'debit', ?, '1', 'from Website mobi')");
        $stmt->bind_param("issss", $user_id, $date, $time, $amount, $new_balance);
        $res = $stmt->execute();

        if ($res) {
            $sql_total_withdrawal = "UPDATE users SET total_withdrawal = (total_withdrawal + ?) WHERE id=?";
            $stmt_total_withdrawal = $con->prepare($sql_total_withdrawal);
            $stmt_total_withdrawal->bind_param("ii", $amount, $user_id);
            $stmt_total_withdrawal->execute();
            echo "<script>window.location = 'withdraw.php?detailupdated';</script>";
        } else {
            echo "<script>window.location = 'withdraw.php?notupdated';</script>";
        }
    }
    mysqli_close($con);
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Withdraw Fund - <?php echo $site_title;?></title>
    
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
                    $user_id = filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT);
                    $qry = "SELECT * FROM users WHERE id='".$user_id."'";
                    $user_info = mysqli_query($con, $qry);
                    
                    if (mysqli_num_rows($user_info) > 0) {
                        while($row = mysqli_fetch_array($user_info)){
                            $account_holder_name = $row['account_holder_name'];
                            $account_number = $row['account_number'];
                            $ifsc = $row['ifsc'];
                            $bank_name = $row['bank_name'];
                    
                            if($row['status'] == 0){
                                // User is blocked, log them out
                                session_unset();
                                session_destroy();
                                setcookie("usr_id", "", time() - 3600, "/"); // Expire the cookie
                                setcookie("usr_name", "", time() - 3600, "/");
                                setcookie("usr_mobile", "", time() - 3600, "/");
                                setcookie("api_access_token", "", time() - 3600, "/");
                    
                                // Redirect to the login page
                                $return_url = "logout.php";
                                echo "<script>window.location = 'logout.php';</script>";
                                exit;
                            }
                        }
                    } else {
                        // Redirect to the login page
                                $return_url = "logout.php";
                                echo "<script>window.location = 'logout.php';</script>";
                                exit;
                    }
                    ?>


                <div class="text-center tb-10">
                    <h3>Withdraw Fund</h3>
                    <span>Send money to your bank account.</span>
                </div>
                
                <div class="tbmar-20 text-center">
                    <p>Withdrawal requests may take up to 24 hours. <br> Your funds will be credited to your bank account within 24 hours. 
                    Please rest assured that your money is always safe with us.</p>
                    
                    <p style="color:red">Note: Sunday withdrawals are off</p>
                </div>

                
                 <form action="" method="POST" autocomplete="off">
                  
                  <?php if($account_number =='' || $account_number == NULL){?>
                   <p style="color:red" class="text-center"> NOTE: Kindly update your bank details first. then you can withdraw amount </p>
                  <?php }else{ ?>
                  <div class="form-group">
                    <input type="number" class="form-control" name="amount" value="" min="1000" max="10000" placeholder="Enter Amount" autocomplete="off" required>
                  </div>
                 
                  
                  <input type="hidden" name="api_acess_token" value="<?php echo $_SESSION['api_acess_token'];?>">
                  <button type="submit" name="withdraw" class="btn btn-theme btn-login">Submit</button>
                  <?php } ?>
                </form> 
                
                <div class="text-center tbmar-20">
                    <p>Unable to Withdraw Fund?</p>
                    <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" class="btn btn-outline btn-login">Contact Admin</a>
                </div>

            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>