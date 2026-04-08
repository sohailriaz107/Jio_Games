<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");
	
	$game_id = filter_var($_GET['gid'], FILTER_SANITIZE_NUMBER_INT);
	
if (isset($_POST['single_submit']) && isset($_SESSION['usr_id']) != "") {
    if (get_SettingValue('pause_starline_market_bidding')) {
        echo "<script>alert('Bidding are Stopped Temporary !!!')</script>";
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }
    
    if (0) {
        echo "<script>alert('Kindly use our Android App for bidding. Thanks for more info Contact Admin sir.')</script>";
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }

    $user_id = $_SESSION['usr_id'];

    // Filter and validate input
    $game_id = filter_var($_POST['game_id'], FILTER_SANITIZE_NUMBER_INT);
    $total_point = filter_var($_POST['total_point'], FILTER_SANITIZE_NUMBER_INT);

    if ($game_id === false || $total_point === false) {
        // Invalid input, handle accordingly
        echo "<script>alert('Invalid input data')</script>";
        exit;
    }

    $get_parameters = "gid=$game_id";

    $date = date('Y-m-d');
    $time = date('h:i:s A');

    $game_time = get_Starlinetime($game_id);
    $date_time = $date . " " . $game_time;
    $market_time = strtotime($date_time);

    if (get_lastBalance($user_id) < $total_point) {
        echo "<script>window.location = 'starline-single.php?insufficientbalance&" . $get_parameters . "';</script>";
    } elseif (time() >= $market_time) {
        echo "<script>window.location = 'starline-single.php?invalid_date&" . $get_parameters . "';</script>";
    } else {
        for ($i = 0; $i <= 9; $i++) {
            $amount = filter_var($_POST['single' . $i], FILTER_SANITIZE_NUMBER_INT);
            if ($amount !== false && $amount >= 5) {
                $stmt = $con->prepare("INSERT INTO user_transaction(user_id,game_id,game_type,digit,date,time,amount,type,debit_credit,balance,starline) 
                            VALUES(?, ?, 'single', ?, ?, ?, ?, 'bid', 'debit', ?, '1')");
                $stmt->bind_param("iisssii", $user_id, $game_id, $i, $date, $time, $amount, $new_balance);

                $balance = get_lastBalance($user_id);
                if ($balance >= $amount) {
                    $new_balance = $balance - $amount;
                    if ($stmt->execute()) {
                        UpdateBalanceInUserTable($user_id, $new_balance);
                    } else {
                        echo "<script>window.location = 'starline-single.php?bidfailed&" . $get_parameters . "';</script>";
                        exit;
                    }
                }
            }
        }
		$stmt = $con->prepare("UPDATE users SET last_bid_placed_on = ? WHERE id = ?");
                        $stmt->bind_param("si", $date, $user_id);
                        $stmt->execute();

        // Redirect if bidding is successful
        echo "<script>window.location = 'starline-single.php?bidplacedsuccessfully&" . $get_parameters . "';</script>";
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

    <title>Starling Single Ank Play Dashboard</title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            
            <div class="container" >  
            <div class="card-full-page tb-10">
                
                <?php
                $games_list_qry =  "SELECT * FROM `starline` WHERE id='$game_id' and status=1";
				$games = mysqli_query($con, $games_list_qry);
                         while ($row = mysqli_fetch_array($games)){
                             
                            $startline_time = strtotime(date('Y-m-d').' '.$row['time']);
                            $game_id = $row['id'];
                            $game_name = $row['name']; 
                    ?>
                <form action="" method="POST" class="myform">
                <div class="row bidoptions-list tb-10">
                                <div class="col-6">
                                  <a class="dateGameIDbox">
                                      <p><?php echo date('d/m/Y');?></p>
                                  </a>
                                </div>
                                
                                <div class="col-6">
                                    <a class="dateGameIDbox">
                                      <p><?php echo $game_name;?></p>
                                  </a>
                                </div>
                                
                </div>

                
                <?php if(time() < $startline_time){?>
                <div class="tb-10"><hr class="devider"></div>
                
                <h3 class="subheading">Select Amount</h3>
                <div class="row bidoptions-list tb-10">
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_5" data="5">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 5</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_10" data="10">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 10</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_50" data="50">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 50</p>
                                  </a>
                                </div>
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_100" data="100">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 100</p>
                                  </a>
                                </div>
                </div>
                
                
               
                
                <div class="row bidoptions-list tb-10">
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_200" data="200">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 200</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_500" data="500">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 500</p>
                                  </a>
                                </div>
                                
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_1000" data="1000">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 1000</p>
                                  </a>
                                </div>
                                <div class="col-3">
                                  <a class="bidamtbox" id="amount_5000" data="5000">
                                      <p><i class="fa fa-inr" aria-hidden="true"></i> 5000</p>
                                  </a>
                                </div>
                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Select Digits</h3>
                
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $single_digits = array('0','1','2','3','4','5','6','7','8','9');
                    
                    foreach($single_digits as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="single<?php echo $digit;?>" name="single<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>
                    
                               
                                

                </div>
                <input type="hidden" id="total_point" name="total_point" value="">
                <input type="hidden" id="selected_amount" value="">
                
                <input type="hidden" name="game_id" value="<?php echo $game_id;?>">
                
                <div class="tbmar-20 text-center">
                    <p>Total Points : <a id="total_point2">0</a></p>
                </div>
                
                <div class="row bidoptions-list tb-10">
                                <div class="col-6"> 
                                  <button class="btn btn-light btn-streched" onclick = "resetjsvar();" type="reset">Reset</button>
                                </div>
                                
                                <div class="col-6">
                                <button class="btn btn-theme btn-streched" type="submit" name="single_submit">Submit</button>
                                </div>
                                
                </div>
                
                <?php }else{ ?>
                <div class="tbmar-40 text-center">
                    <span>Sorry! Bidding is Close for <?php echo $game_name;?>. <br> Play for Next One.</span>
                </div>
                <?php } ?>
                
                </form>
                <?php } ?>
                        

            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>