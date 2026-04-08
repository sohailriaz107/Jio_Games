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
	
	$user_id = $_SESSION['usr_id'];
	
	// Validate and sanitize input
	$game_id = filter_var($_POST['game_id'], FILTER_SANITIZE_NUMBER_INT);
	$total_point = filter_var($_POST['total_point'], FILTER_SANITIZE_NUMBER_INT);
	$child_game_id = filter_var($_POST['gid'], FILTER_SANITIZE_NUMBER_INT);
	$parent_game_id = filter_var($_POST['pgid'], FILTER_SANITIZE_NUMBER_INT);
	$default_game = filter_var($_POST['dgame'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	
	// Check if inputs are valid
	if ($game_id === false || $total_point === false || $child_game_id === false || $parent_game_id === false || $default_game === false) {
	    echo "<script>window.location = 'double-patti.php?invalid_input';</script>";
	    exit;
	}
	
	$get_parameters = "gid=$child_game_id&pgid=$parent_game_id&dgame=$default_game";
	
	$date = date('Y-m-d');
	$time = date('h:i:s A');
	
	$game_time = get_gameTimeById($game_id);
	$date_time = $date . " " . $game_time;
	$market_time = strtotime($date_time);
	
	if (get_lastBalance($user_id) < $total_point) {
	    echo "<script>window.location = 'double-patti.php?insufficientbalance&$get_parameters';</script>";
	    exit;
	} elseif (time() >= $market_time) {
	    echo "<script>window.location = 'double-patti.php?invalid_date&$get_parameters';</script>";
	    exit;
	} else {
	    $all_double_patti = array(118,226,244,299,334,488,550,668,677,100,119,155,227,335,344,399,588,669,110,200,228,255,336,499,660,688,778,166,229,300,337,355,445,599,779,788,112,220,266,338,400,446,455,699,770,113,122,177,339,366,447,500,799,889,114,277,330,448,466,556,600,880,899,115,133,188,223,377,449,557,566,700,116,224,233,288,440,477,558,800,990,117,144,199,225,388,559,577,667,900);  
	    
	    foreach ($all_double_patti as $digit) {
	        $amount = filter_var($_POST['double_patti' . $digit], FILTER_SANITIZE_NUMBER_INT);
	        
	        if ($amount === false || $amount < 5) {
	            continue; // Skip if amount is not valid or less than 5
	        }
	        
	        $balance = get_lastBalance($user_id);
	        
	        if ($balance < $amount) {
	            break; // Stop bidding if balance is insufficient
	        }
	        
	        $new_balance = $balance - $amount;

                    
	        // Prepare and execute the statement to insert transaction
	        $stmt = mysqli_prepare($con, "INSERT INTO user_transaction (user_id, game_id, game_type, digit, date, time, amount, type, debit_credit, balance) VALUES (?, ?, 'double_patti', ?, ?, ?, ?, 'bid', 'debit', ?)");
	        mysqli_stmt_bind_param($stmt, "iissssi", $user_id, $game_id, $digit, $date, $time, $amount, $new_balance);
	        mysqli_stmt_execute($stmt);
	        
	        if (mysqli_stmt_affected_rows($stmt) > 0) {
	            UpdateBalanceInUserTable($user_id, $new_balance);
	        }
	        
	        // Close the statement
	        mysqli_stmt_close($stmt);
	    }
	    
	    // Update last_bid_placed_on for the user
	    $stmt_update = mysqli_prepare($con, "UPDATE users SET last_bid_placed_on = ? WHERE id = ?");
	    mysqli_stmt_bind_param($stmt_update, "si", $date, $user_id);
	    mysqli_stmt_execute($stmt_update);
	    mysqli_stmt_close($stmt_update);
	    
	    echo "<script>window.location = 'double-patti.php?bidplacedsuccessfully&$get_parameters';</script>";
	    exit;
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

    <title>Double Patti Matka Play Dashboard</title>
    
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
                <?php if($default_bidding_game =='open'){?>
                
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
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 0</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_0 = array(118,226,244,299,334,488,550,668,677);
                    
                    foreach($double_patti_0 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 1</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_1 = array(100,119,155,227,335,344,399,588,669);
                    
                    foreach($double_patti_1 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 2</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_2 = array(110,200,228,255,336,499,660,688,778);
                    
                    foreach($double_patti_2 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 3</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_3 = array(166,229,300,337,355,445,599,779,788);
                    
                    foreach($double_patti_3 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 4</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                   $double_patti_4 = array(112,220,266,338,400,446,455,699,770);
                    
                    foreach($double_patti_4 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 5</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_5 = array(113,122,177,339,366,447,500,799,889);
                    
                    foreach($double_patti_5 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 6</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_6 = array(114,277,330,448,466,556,600,880,899);
                    
                    foreach($double_patti_6 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 7</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_7 = array(115,133,188,223,377,449,557,566,700);
                    
                    foreach($double_patti_7 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 8</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_8 = array(116,224,233,288,440,477,558,800,990);
                    
                    foreach($double_patti_8 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
                                    </div>
                        </div>
                                
                    <?php } ?>

                </div>
                
                <div class="tb-10"><hr class="devider"></div>
                <h3 class="subheading">Panna of ank 9</h3>
                <div class="row bidoptions-list tb-10">
                    
                    <?php 
                    $double_patti_9 = array(117,144,199,225,388,559,577,667,900);
                    
                    foreach($double_patti_9 as $digit){?>
                        
                        <div class="col-3">
                                    <div class="bidinputdiv">
                                        <lable><?php echo $digit;?></lable>
                                        <input type="text" value="" class="pointinputbox" id="double_patti<?php echo $digit;?>" name="double_patti<?php echo $digit;?>" readonly>
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
                        
            <br><br><br><br><br><br>
            </div> 
            </div>
            
            
        </div><br><br><br>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>