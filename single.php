<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");
	
	$child_game_id = filter_var($_GET['gid'], FILTER_SANITIZE_NUMBER_INT);
	$parent_game_id = filter_var($_GET['pgid'], FILTER_SANITIZE_NUMBER_INT);
	$default_game = filter_var($_GET['dgame'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	
if (isset($_POST['single_submit']) && isset($_SESSION['usr_id']) && $_SESSION['usr_id'] != "") {
    
    if (get_SettingValue('pause_main_market_bidding_website')) {
        echo "<script>alert('Bidding are Stopped Temporarily !!!')</script>";
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }
    
    if (0) {
        echo "<script>alert('Kindly use our Android App for bidding. Thanks for more info Contact Admin sir.')</script>";
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }
    
    $user_id = filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT);
    $game_id = filter_var($_POST['game_id'], FILTER_SANITIZE_NUMBER_INT);
    $total_point = filter_var($_POST['total_point'], FILTER_SANITIZE_NUMBER_INT);
    
    $child_game_id = filter_var($_POST['gid'], FILTER_SANITIZE_NUMBER_INT);
    $parent_game_id = filter_var($_POST['pgid'], FILTER_SANITIZE_NUMBER_INT);
    $default_game = filter_var($_POST['dgame'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    
    $get_parameters = "gid=$child_game_id&pgid=$parent_game_id&dgame=$default_game";
    
    $date = date('Y-m-d');
    $time = date('h:i:s A');
    
    $game_time = get_gameTimeById($game_id);
    $date_time = $date . " " . $game_time;
    $market_time = strtotime($date_time);
    
    if (get_lastBalance($user_id) < $total_point) {
        echo "<script>window.location = 'single.php?insufficientbalance&" . $get_parameters . "';</script>";
    } elseif (time() >= $market_time) {
        echo "<script>window.location = 'single.php?invalid_date&" . $get_parameters . "';</script>";
    } else {
        for ($i = 0; $i <= 9; $i++) {
            $amount = filter_var($_POST['single' . $i], FILTER_SANITIZE_NUMBER_INT);
            if ($amount >= 5) {
                $balance = get_lastBalance($user_id);
                if ($balance >= $amount) {
                    $new_balance = $balance - $amount;
                    
                     $game_type = 'single';
                     $type = 'bid';
                     $debit_credit = 'debit';
                    $stmt = $con->prepare("INSERT INTO user_transaction (user_id, game_id, game_type, digit, date, time, amount, type, debit_credit, balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("iissssisdi", $user_id, $game_id, $game_type, $i, $date, $time, $amount, $type, $debit_credit, $new_balance);
                    $stmt->execute();
                    $stmt->close();
                    UpdateBalanceInUserTable($user_id, $new_balance);
                    
                }
            }
        }
		
		$sql = "UPDATE users SET last_bid_placed_on = ? WHERE id = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("si", $date, $user_id);
                    $stmt->execute();
                    $stmt->close();
		
        
        if ($stmt) {
            echo "<script>window.location = 'single.php?bidplacedsuccessfully&" . $get_parameters . "';</script>";
            exit;
        } else {
            echo "<script>window.location = 'single.php?bidfailed&" . $get_parameters . "';</script>";
            exit;
        }
    }
}


	
	
	if($child_game_id =='' || $parent_game_id =='' || $default_game ==''){
	    echo "<script>window.location = '404.php';</script>";
	    exit;
	}
	
	
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Single Ank Matka Play Dashboard</title>
    
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
                $games_list_qry = "SELECT * FROM `parent_games` WHERE id=? AND status=1";
				$stmt = $con->prepare($games_list_qry);
				$stmt->bind_param("i", $parent_game_id);
				$stmt->execute();
				$games = $stmt->get_result();

				while ($row = $games->fetch_assoc()) {
                            $open_time =  $row['open_time'];
                            $close_time = $row['close_time'];
                            $result_open_time = $row['result_open_time'];
                            $result_close_time = $row['result_close_time'];
                            $open_days = $row['open_days'];
                            $game_days = explode(",", $open_days);
                            
                            $day = strtolower(date('D', strtotime(date('Y-m-d'))));
                             
                             $betting_open_time =strtotime(date('Y-m-d').' '.$open_time);
                             $betting_close_time =strtotime(date('Y-m-d').' '.$close_time);
                             if(in_array($day, $game_days) && time() < $betting_open_time){
							   $bidding_status = 1;
                               $msg = 'Betting is Running Now';
                               $default_bidding_date ='today';
                               $default_bidding_game ='open';
                             }elseif(in_array($day, $game_days) && time() < $betting_close_time){
							   $bidding_status = 1;
                               $msg = 'Betting is Running For Close';
                               $default_bidding_date ='today';
                               $default_bidding_game ='close';
                             }else{
							   $bidding_status = 0;
                               $msg = 'Betting is Closed for Today';
                               $default_bidding_date ='next_date';
                               $default_bidding_game ='';
                             }
                             
                             
                             $child_open = $row['child_open_id'];
                             $child_close = $row['child_close_id'];
                             //$open_result = GetOpneResultByid($child_open);
                             //$close_result = GetCloseResultByid($child_close);
                             
                            $game_id = $row['id'];
                            $game_name = $row['name'];
                            $open_time = $open_time;
                            $close_time = $close_time;
                            $result_open_time = $result_open_time;
                            $result_close_time = $result_close_time;
                            //$result = $open_result.''.$close_result;
							$bidding_status = $bidding_status;
                            $msg =  $msg;
                            $default_bidding_date = $default_bidding_date;
                            $default_bidding_game = $default_bidding_game;
                            $status = $row['status'];
                            //$game_title = strtolower(str_replace(" ","-",$game_name));

                    ?>
                <form action="" method="POST" class="myform">
                <?php if($default_bidding_game =='open'){ ?>
                
                <div class="row bidoptions-list tb-10">
                                <div class="col-6">
                                  <a class="dateGameIDbox">
                                      <p><?php echo date('d/m/Y');?></p>
                                  </a>
                                </div>
                                
                                <div class="col-6">
                                    <select class="dateGameIDbox" name="game_id">
                                        <option value="<?php echo $child_open;?>"> <?php echo get_gameNameById($child_open);?></option>
                                        <option value="<?php echo $child_close;?>"> <?php echo get_gameNameById($child_close);?></option>
                                    </select>
                                </div>
                                
                </div>
                
                <?php }elseif($default_bidding_game =='close'){ ?>
                
                <div class="row bidoptions-list tb-10">
                                <div class="col-6">
                                  <a class="dateGameIDbox">
                                      <p><?php echo date('d/m/Y');?></p>
                                  </a>
                                </div>
                                
                                <div class="col-6">
                                    <select class="dateGameIDbox" name="game_id">
                                        <option value="<?php echo $child_close;?>"> <?php echo get_gameNameById($child_close);?></option>
                                    </select>
                                </div>
                                
                </div>
                
                <?php }else{ ?>
                
                <div class="tbmar-40 text-center">
                    <p>Sorry! Bidding is Close for <?php echo $game_name;?>. <br> Try again Tomorrow.</p>
                </div>
                
                <?php } ?>
                
                
                <?php if($bidding_status){?>
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
                
                <input type="hidden" name="gid" value="<?php echo $child_game_id;?>">
                <input type="hidden" name="pgid" value="<?php echo $parent_game_id;?>">
                <input type="hidden" name="dgame" value="<?php echo $default_game;?>">
                
                
                
                
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
                
                <?php } ?>
                
                </form>
                <?php 
				} 
				$stmt->close();
				?>
                        

            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>