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
    
    $user_id = filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT);
    $game_id = filter_var($_POST['game_id'], FILTER_SANITIZE_NUMBER_INT);
    $open_digit = filter_var($_POST['open_digit'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $close_digit = filter_var($_POST['close_digit'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
    
    $child_game_id = filter_var($_POST['gid'], FILTER_SANITIZE_NUMBER_INT);
    $parent_game_id = filter_var($_POST['pgid'], FILTER_SANITIZE_NUMBER_INT);
    $default_game = filter_var($_POST['dgame'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    
    $get_parameters = "gid=$child_game_id&pgid=$parent_game_id&dgame=$default_game";
    
    $date = date('Y-m-d');
    $time = date('h:i:s A');
    
    $game_time = get_gameTimeById($game_id);
    $date_time = $date . " " . $game_time;
    $market_time = strtotime($date_time);
    
    if (get_lastBalance($user_id) < $amount) {
        echo "<script>window.location = 'full-sangam.php?insufficientbalance&" . $get_parameters . "';</script>";
    } elseif (time() >= $market_time) {
        echo "<script>window.location = 'full-sangam.php?invalid_date&" . $get_parameters . "';</script>";
    } else {
        $fs_digit = $open_digit . '-' . $close_digit;
        if ($amount >= 5 && strlen($open_digit) == 3 && strlen($close_digit) == 3) {
            $balance = get_lastBalance($user_id);
            if ($balance >= $amount) {
                $new_balance = $balance - $amount;
                $stmt = $con->prepare("INSERT INTO user_transaction (user_id, game_id, game_type, digit, date, time, amount, type, debit_credit, balance) VALUES (?, ?, 'full_sangam', ?, ?, ?, ?, 'bid', 'debit', ?)");
                $stmt->bind_param("iissssi", $user_id, $game_id, $fs_digit, $date, $time, $amount, $new_balance);
                $stmt->execute();
                $stmt->close();
                UpdateBalanceInUserTable($user_id, $new_balance);
                
                $sql = "UPDATE users SET last_bid_placed_on = ? WHERE id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $date, $user_id);
                $stmt->execute();
                $stmt->close();
                
                echo "<script>window.location = 'full-sangam.php?bidplacedsuccessfully&" . $get_parameters . "';</script>";
                exit;
            }
        }
        echo "<script>window.location = 'full-sangam.php?bidfailed&" . $get_parameters . "';</script>";
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

    <title>Full Sangam - Jio Games</title>
    
    <?php include("include/head.php"); ?>
    <style>
        /* Modern Premium Styles */
        .market-hero-card { background: var(--primary-gradient); padding: 25px 20px; border-radius: 20px; margin: 10px 0 20px; color: white; text-align: center; box-shadow: 0 8px 20px rgba(0,68,187,0.15); position: relative; overflow: hidden; }
        .market-hero-card::after { content: ''; position: absolute; right: -15px; top: -15px; width: 80px; height: 80px; background: rgba(255,255,255,0.08); border-radius: 50%; }
        .market-name { font-size: 20px; font-weight: 800; margin: 0 0 8px; text-transform: uppercase; color: #fff !important; }
        .market-date { font-size: 11px; opacity: 0.9; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        .section-label { font-size: 13px; font-weight: 800; color: #2d3748; margin: 25px 0 15px; text-transform: uppercase; display: block; border-left: 4px solid var(--primary-blue); padding-left: 10px; }

        .form-section { background: #fff; border-radius: 18px; padding: 25px 20px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); }
        
        .input-group-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .input-box { display: flex; flex-direction: column; }
        .input-box.full-width { grid-column: span 2; }
        .input-box label { font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control-modern { border: 2px solid #f1f5f9; background: #f8fafc; border-radius: 14px; padding: 14px 15px; font-size: 14px; font-weight: 700; color: #2d3748; outline: none; width: 100%; transition: all 0.2s; }
        .form-control-modern:focus { border-color: var(--primary-blue); background: #fff; box-shadow: 0 0 0 4px rgba(0,68,187,0.05); }

        .market-dropdown { width: 100%; padding: 14px 15px; border-radius: 14px; border: 2px solid #edf2f7; font-size: 14px; font-weight: 700; color: #2d3748; background-color: #fff; margin-bottom: 20px; }

        .action-row { display: grid; grid-template-columns: 1fr 2fr; gap: 12px; margin-top: 10px; }
        .btn-reset { background: #f1f5f9; color: #64748b; font-weight: 700; padding: 16px; border-radius: 16px; border: none; font-size: 14px; }
        .btn-submit { background: var(--primary-gradient); color: white; font-weight: 800; padding: 16px; border-radius: 16px; border: none; font-size: 14px; box-shadow: 0 4px 15px rgba(0,68,187,0.2); }
    </style>
</head>

<body>

    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container pb-4">  
                <?php
                $games_list_qry = "SELECT * FROM `parent_games` WHERE id=? AND status=1";
				$stmt = $con->prepare($games_list_qry);
				$stmt->bind_param("i", $parent_game_id);
				$stmt->execute();
				$games = $stmt->get_result();

				if($row = $games->fetch_assoc()) {
                            $open_time =  $row['open_time'];
                            $day = strtolower(date('D'));
                            $game_days = explode(",", $row['open_days']);
                            $betting_open_time = strtotime(date('Y-m-d').' '.$open_time);
                             if(in_array($day, $game_days) && time() < $betting_open_time){
							   $bidding_status = 1;
                             }else{
							   $bidding_status = 0;
                             }
                            $game_name = $row['name'];
                            $child_open = $row['child_open_id'];
                ?>
                
                <!-- Market Hero -->
                <div class="market-hero-card">
                    <h1 class="market-name"><?php echo $game_name;?></h1>
                    <p class="market-date"><?php echo date('d M Y');?> • Full Sangam</p>
                </div>

                <form action="" method="POST" id="bidForm" autocomplete="off">
                    <input type="hidden" name="gid" value="<?php echo $child_game_id;?>">
                    <input type="hidden" name="pgid" value="<?php echo $parent_game_id;?>">
                    <input type="hidden" name="dgame" value="<?php echo $default_game;?>">

                    <?php if($bidding_status){?>
                        <span class="section-label">Session Selection</span>
                        <select class="market-dropdown" name="game_id">
                            <option value="<?php echo $child_open;?>">Full Sangam Session</option>
                        </select>

                        <span class="section-label">Fill Your Bid Details</span>
                        
                        <div class="form-section">
                            <div class="input-group-row">
                                <div class="input-box">
                                    <label>Open Patti</label>
                                    <input type="number" name="open_digit" min="000" max="999" placeholder="000-999" class="form-control-modern" required>
                                </div>
                                <div class="input-box">
                                    <label>Close Patti</label>
                                    <input type="number" name="close_digit" min="000" max="999" placeholder="000-999" class="form-control-modern" required>
                                </div>
                                <div class="input-box full-width">
                                    <label>Bid Amount</label>
                                    <input type="number" name="amount" min="5" placeholder="Enter amount (min ₹5)" class="form-control-modern" required>
                                </div>
                            </div>
                        </div>

                        <div class="action-row">
                            <button type="reset" class="btn-reset">Reset</button>
                            <button type="submit" name="single_submit" class="btn-submit">Submit Full Sangam</button>
                        </div>

                    <?php } else { ?>
                        <div class="closed-message-card">
                            <div class="closed-icon"><i class="fa fa-lock"></i></div>
                            <h2 class="closed-title">Bidding Closed</h2>
                            <p class="closed-text">Bidding for Full Sangam is currently closed. Please check back tomorrow!</p>
                        </div>
                    <?php } ?>
                </form>
                
                <?php } $stmt->close(); ?>
            </div>
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>
</body>

</html>