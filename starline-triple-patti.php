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
        echo "<script>window.location = 'starline-triple-patti.php?insufficientbalance&" . $get_parameters . "';</script>";
    } elseif (time() >= $market_time) {
        echo "<script>window.location = 'starline-triple-patti.php?invalid_date&" . $get_parameters . "';</script>";
    } else {
        $all_triple_patti = array('000', '111', '222', '333', '444', '555', '666', '777', '888', '999');

        foreach ($all_triple_patti as $digit) {
            $amount = filter_var($_POST['triple_patti' . $digit], FILTER_SANITIZE_NUMBER_INT);
            if ($amount !== false && $amount >= 5) {
                $stmt = $con->prepare("INSERT INTO user_transaction(user_id,game_id,game_type,digit,date,time,amount,type,debit_credit,balance,starline) 
                            VALUES(?, ?, 'triple_patti', ?, ?, ?, ?, 'bid', 'debit', ?, '1')");
                $stmt->bind_param("iissssi", $user_id, $game_id, $digit, $date, $time, $amount, $new_balance);

                $balance = get_lastBalance($user_id);
                if ($balance >= $amount) {
                    $new_balance = $balance - $amount;
                    if ($stmt->execute()) {
                        UpdateBalanceInUserTable($user_id, $new_balance);
                    } else {
                        echo "<script>window.location = 'starline-triple-patti.php?bidfailed&" . $get_parameters . "';</script>";
                        exit;
                    }
                }
            }
        }
		
		$stmt = $con->prepare("UPDATE users SET last_bid_placed_on = ? WHERE id = ?");
                        $stmt->bind_param("si", $date, $user_id);
                        $stmt->execute();

        // Redirect if bidding is successful
        echo "<script>window.location = 'starline-triple-patti.php?bidplacedsuccessfully&" . $get_parameters . "';</script>";
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

    <title>Starling Triple Patti Play Dashboard</title>
    
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
                <!-- PREMIUM GAME HEADER INFO -->
                <div class="premium-game-header mb-3 mt-2">
                    <div class="header-stat">
                        <i class="fa fa-calendar-o"></i> <?php echo date('d/M/Y');?>
                    </div>
                    <div class="header-stat primary">
                        <i class="fa fa-gamepad"></i> <?php echo $game_name;?>
                    </div>
                </div>

                <?php if(time() < $startline_time){?>
                <div class="tb-10"><hr class="devider"></div>
                
                <h3 class="premium-subheading mb-3"><i class="fa fa-inr" style="color: var(--primary-light);"></i> Select Amount</h3>
                
                <!-- PREMIUM CHIP SELECTORS -->
                <div class="premium-chip-group mb-4">
                    <a class="bidamtbox premium-chip" id="amount_5" data="5">₹ 5</a>
                    <a class="bidamtbox premium-chip" id="amount_10" data="10">₹ 10</a>
                    <a class="bidamtbox premium-chip" id="amount_50" data="50">₹ 50</a>
                    <a class="bidamtbox premium-chip" id="amount_100" data="100">₹ 100</a>
                    <a class="bidamtbox premium-chip" id="amount_200" data="200">₹ 200</a>
                    <a class="bidamtbox premium-chip" id="amount_500" data="500">₹ 500</a>
                    <a class="bidamtbox premium-chip" id="amount_1000" data="1000">₹ 1K</a>
                    <a class="bidamtbox premium-chip" id="amount_5000" data="5000">₹ 5K</a>
                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="premium-subheading mb-3"><i class="fa fa-th-list" style="color: var(--primary-light);"></i> Select Triple Panna Digits</h3>
                
                <div class="row" style="margin: 0 -5px;">
                    <?php 
                    $all_triple_patti = array('000', '111', '222', '333', '444', '555', '666', '777', '888', '999');
                    foreach($all_triple_patti as $digit){?>
                        <div class="col-3 mb-3" style="padding: 0 5px;">
                            <div class="premium-panna-card">
                                <div class="digit-badge"><?php echo $digit;?></div>
                                <div class="input-wrapper">
                                    <span class="currency-symbol">₹</span>
                                    <input type="number" 
                                           class="pointinputbox premium-input" 
                                           id="triple_patti<?php echo $digit;?>" 
                                           name="triple_patti<?php echo $digit;?>" 
                                           value="" 
                                           placeholder="0" 
                                           readonly>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                
                <input type="hidden" id="total_point" name="total_point" value="">
                <input type="hidden" id="selected_amount" value="">
                <input type="hidden" name="game_id" value="<?php echo $game_id;?>">
                
                <!-- PREMIUM CHECKOUT BLOCK -->
                <div class="premium-checkout-block mt-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="total-label">Total Points</span>
                        <span class="total-value">₹ <span id="total_point2">0</span></span>
                    </div>
                    
                    <div class="row">
                        <div class="col-6" style="padding-right: 5px;"> 
                            <button class="btn btn-outline-danger premium-btn-streched" onclick="resetjsvar();" type="reset">
                                <i class="fa fa-refresh"></i> Reset
                            </button>
                        </div>
                        <div class="col-6" style="padding-left: 5px;">
                            <button class="btn btn-blue premium-btn-streched" type="submit" name="single_submit">
                                <i class="fa fa-check-circle"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                
                <?php }else{ ?>
                <div class="tbmar-40 text-center">
                    <span>Sorry! Bidding is Close for <?php echo $game_name;?>. <br> Play for Next One.</span>
                </div>
                <?php } ?>
                
                </form>
                <?php } ?>
                        
            <br><br><br><br><br><br>
            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>