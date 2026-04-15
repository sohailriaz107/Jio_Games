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
        echo "<script>window.location = 'triple-patti.php?insufficientbalance&" . $get_parameters . "';</script>";
    } elseif (time() >= $market_time) {
        echo "<script>window.location = 'triple-patti.php?invalid_date&" . $get_parameters . "';</script>";
    } else {
        $all_triple_patti = array('000', '111', '222', '333', '444', '555', '666', '777', '888', '999');
        
        foreach ($all_triple_patti as $digit) {
            $amount = filter_var($_POST['triple_patti' . $digit], FILTER_SANITIZE_NUMBER_INT);
            if ($amount >= 5) {
                $balance = get_lastBalance($user_id);
                if ($balance >= $amount) {
                    $new_balance = $balance - $amount;
                    $game_type = 'triple_patti';
                    $type = 'bid';
                    $debit_credit = 'debit';
                    $stmt = $con->prepare("INSERT INTO user_transaction (user_id, game_id, game_type, digit, date, time, amount, type, debit_credit, balance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("iissssisdi", $user_id, $game_id, $game_type, $digit, $date, $time, $amount, $type, $debit_credit, $new_balance);
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
		
        echo "<script>window.location = 'triple-patti.php?bidplacedsuccessfully&" . $get_parameters . "';</script>";
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

    <title>Triple Patti - Jio Games</title>
    
    <?php include("include/head.php"); ?>
    <style>
        /* Modern Premium Styles */
        .market-hero-card { background: var(--primary-gradient); padding: 25px 20px; border-radius: 20px; margin: 10px 0 20px; color: white; text-align: center; box-shadow: 0 8px 20px rgba(0,68,187,0.15); position: relative; overflow: hidden; }
        .market-hero-card::after { content: ''; position: absolute; right: -15px; top: -15px; width: 80px; height: 80px; background: rgba(255,255,255,0.08); border-radius: 50%; }
        .market-name { font-size: 20px; font-weight: 800; margin: 0 0 8px; text-transform: uppercase; color: #fff !important; }
        .market-date { font-size: 11px; opacity: 0.9; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        .section-label { font-size: 13px; font-weight: 800; color: #2d3748; margin: 25px 0 15px; text-transform: uppercase; display: block; border-left: 4px solid var(--primary-blue); padding-left: 10px; }

        .amt-selector-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 25px; }
        .amt-card { background: #fff; border-radius: 12px; padding: 12px 5px; text-align: center; border: 2px solid transparent; box-shadow: 0 2px 6px rgba(0,0,0,0.04); cursor: pointer; transition: all 0.2s; }
        .amt-card.active { border-color: var(--primary-blue); background: #f0f7ff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,68,187,0.1); }
        .amt-card p { margin: 0; font-size: 12px; font-weight: 800; color: #2d3748; }
        .amt-card.active p { color: var(--primary-blue); }

        .digit-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; padding-bottom: 20px; }
        .digit-input-box { background: #fff; border-radius: 18px; padding: 15px 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); }
        .digit-label { display: block; font-size: 16px; font-weight: 900; color: #1a202c; margin-bottom: 8px; text-align: center; }
        .numeric-input { width: 100%; border: 1px solid #edf2f7; background: #f8fafc; border-radius: 10px; padding: 8px; font-size: 12px; font-weight: 700; text-align: center; color: var(--primary-blue); outline: none; }

        .summary-card { background: #fff; border-radius: 20px; padding: 25px 20px; margin-top: 10px; box-shadow: 0 -5px 20px rgba(0,0,0,0.05); text-align: center; border-top: 1px solid #edf2f7; }
        .total-info { font-size: 14px; font-weight: 700; color: #4a5568; margin-bottom: 15px; }
        .total-val { font-size: 24px; font-weight: 900; color: var(--primary-blue); margin-left: 5px; }

        .action-row { display: grid; grid-template-columns: 1fr 2fr; gap: 12px; }
        .btn-reset { background: #f1f5f9; color: #64748b; font-weight: 700; padding: 14px; border-radius: 14px; border: none; font-size: 14px; }
        .btn-submit { background: var(--primary-gradient); color: white; font-weight: 800; padding: 14px; border-radius: 14px; border: none; font-size: 14px; box-shadow: 0 4px 15px rgba(0,68,187,0.2); }

        .market-dropdown { width: 100%; padding: 12px 15px; border-radius: 12px; border: 2px solid #edf2f7; font-size: 14px; font-weight: 700; color: #2d3748; background-color: #fff; margin-bottom: 20px; }
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
                            $close_time = $row['close_time'];
                            $day = strtolower(date('D'));
                            $game_days = explode(",", $row['open_days']);
                            
                            $betting_open_time = strtotime(date('Y-m-d').' '.$open_time);
                            $betting_close_time = strtotime(date('Y-m-d').' '.$close_time);
                             if(in_array($day, $game_days) && time() < $betting_open_time){
							   $bidding_status = 1;
                               $default_bidding_game ='open';
                             }elseif(in_array($day, $game_days) && time() < $betting_close_time){
							   $bidding_status = 1;
                               $default_bidding_game ='close';
                             }else{
							   $bidding_status = 0;
                               $default_bidding_game ='';
                             }
                            
                            $game_name = $row['name'];
                            $child_open = $row['child_open_id'];
                            $child_close = $row['child_close_id'];
                ?>
                
                <!-- Market Hero -->
                <div class="market-hero-card">
                    <h1 class="market-name"><?php echo $game_name;?></h1>
                    <p class="market-date"><?php echo date('d M Y');?> • Triple Patti</p>
                </div>

                <form action="" method="POST" id="bidForm">
                    <input type="hidden" name="gid" value="<?php echo $child_game_id;?>">
                    <input type="hidden" name="pgid" value="<?php echo $parent_game_id;?>">
                    <input type="hidden" name="dgame" value="<?php echo $default_game;?>">
                    <input type="hidden" id="total_point" name="total_point" value="0">
                    <input type="hidden" id="selected_amount" value="">

                    <?php if($bidding_status){?>
                        <span class="section-label">Session Selection</span>
                        <select class="market-dropdown" name="game_id">
                            <?php if($default_bidding_game == 'open'){ ?>
                                <option value="<?php echo $child_open;?>">Open Session</option>
                                <option value="<?php echo $child_close;?>">Close Session</option>
                            <?php } else { ?>
                                <option value="<?php echo $child_close;?>">Close Session</option>
                            <?php } ?>
                        </select>

                        <span class="section-label">1. Select Points</span>
                        <div class="amt-selector-grid">
                            <?php $amts = [5, 10, 50, 100, 200, 500, 1000, 5000]; 
                            foreach($amts as $a){ ?>
                                <div class="amt-card" data-val="<?php echo $a;?>">
                                    <p>₹<?php echo $a;?></p>
                                </div>
                            <?php } ?>
                        </div>

                        <span class="section-label">2. Tap Digits to Place Bid</span>
                        <div class="digit-grid">
                            <?php 
                            $all_triple_patti = array('000', '111', '222', '333', '444', '555', '666', '777', '888', '999');
                            foreach($all_triple_patti as $d){ ?>
                                <div class="digit-input-box digit-box-clickable" data-digit="<?php echo $d;?>">
                                    <span class="digit-label"><?php echo $d;?></span>
                                    <input type="text" class="numeric-input" id="triple_patti<?php echo $d;?>" name="triple_patti<?php echo $d;?>" value="" readonly>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="summary-card">
                            <div class="total-info">Total Points: <span class="total-val" id="total_display">0</span></div>
                            <div class="action-row">
                                <button type="reset" class="btn-reset" onclick="resetBids()">Reset</button>
                                <button type="submit" name="single_submit" class="btn-submit">Submit Bid</button>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="closed-message-card">
                            <div class="closed-icon"><i class="fa fa-lock"></i></div>
                            <h2 class="closed-title">Bidding Closed</h2>
                            <p class="closed-text">Bidding for Triple Patti is currently closed. Please check back tomorrow!</p>
                        </div>
                    <?php } ?>
                </form>
                
                <?php } $stmt->close(); ?>
            </div>
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

    <script>
        document.querySelectorAll('.amt-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.amt-card').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('selected_amount').value = this.getAttribute('data-val');
            });
        });

        document.querySelectorAll('.digit-box-clickable').forEach(box => {
            box.addEventListener('click', function() {
                const amt = document.getElementById('selected_amount').value;
                if(!amt) {
                    Swal.fire({ icon: 'warning', title: 'Select Points', text: 'Please tap a point value first.', confirmButtonColor: '#0044bb' });
                    return;
                }
                const digit = this.getAttribute('data-digit');
                const input = document.getElementById('triple_patti' + digit);
                input.value = (parseInt(input.value) || 0) + parseInt(amt);
                calculateTotal();
            });
        });

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.numeric-input').forEach(input => {
                const val = parseInt(input.value) || 0;
                total += val;
            });
            document.getElementById('total_point').value = total;
            document.getElementById('total_display').innerText = total;
        }

        function resetBids() {
            document.querySelectorAll('.numeric-input').forEach(input => input.value = "");
            document.querySelectorAll('.amt-card').forEach(c => c.classList.remove('active'));
            document.getElementById('selected_amount').value = "";
            calculateTotal();
        }
    </script>
</body>

</html>