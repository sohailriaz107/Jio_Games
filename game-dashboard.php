<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");
	
	$game_title = filter_var($_GET['game'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$game_id = filter_var($_GET['gid'], FILTER_SANITIZE_NUMBER_INT);
	$game_title = ucfirst(str_replace("-"," ",$game_title));
	
	if($game_id ==''){
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

    <title>Game Dashboard - <?php echo $game_title ;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <style>
                /* Page Specific Styles */
                .market-hero-card { 
                    background: var(--primary-gradient); 
                    padding: 30px 20px; 
                    border-radius: 24px; 
                    margin: 15px 0 25px; 
                    color: white; 
                    text-align: center; 
                    box-shadow: 0 10px 25px rgba(0,68,187,0.2); 
                    position: relative; 
                    overflow: hidden; 
                    border: none;
                }
                .market-hero-card::after { 
                    content: ''; 
                    position: absolute; 
                    right: -20px; 
                    top: -20px; 
                    width: 100px; 
                    height: 100px; 
                    background: rgba(255,255,255,0.1); 
                    border-radius: 50%; 
                }
                .market-name { 
                    font-size: 24px; 
                    font-weight: 800; 
                    margin: 0 0 10px; 
                    text-transform: uppercase; 
                    letter-spacing: 1px; 
                    color: #fff !important;
                }
                .market-status-badge { 
                    display: inline-block; 
                    padding: 6px 15px; 
                    border-radius: 50px; 
                    font-size: 11px; 
                    font-weight: 700; 
                    text-transform: uppercase; 
                    background: rgba(255,255,255,0.2); 
                    backdrop-filter: blur(5px); 
                    border: 1px solid rgba(255,255,255,0.3);
                }
                .status-running-accent { background: rgba(46, 204, 113, 0.4) !important; color: #fff !important; }
                .status-closed-accent { background: rgba(231, 76, 60, 0.4) !important; color: #fff !important; }

                .bidding-grid { 
                    display: grid; 
                    grid-template-columns: repeat(3, 1fr); 
                    gap: 15px; 
                    padding: 10px 0 30px; 
                }
                .bidding-option-card { 
                    background: #fff; 
                    border-radius: 20px; 
                    padding: 18px 10px; 
                    text-align: center; 
                    text-decoration: none !important; 
                    display: flex; 
                    flex-direction: column; 
                    align-items: center; 
                    box-shadow: var(--card-shadow); 
                    border: 1px solid rgba(0,0,0,0.03); 
                    transition: all 0.2s ease; 
                }
                .bidding-option-card:active { 
                    transform: scale(0.95); 
                    box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
                }
                
                .option-icon-box { 
                    width: 50px; 
                    height: 50px; 
                    margin-bottom: 12px; 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    background: #f8fafc; 
                    border-radius: 14px; 
                }
                .option-icon-box img { 
                    width: 32px; 
                    height: 32px; 
                    object-fit: contain; 
                }
                
                .option-label { 
                    font-size: 11px; 
                    font-weight: 700; 
                    color: #2d3748; 
                    margin: 0; 
                    line-height: 1.2; 
                }

                .note-banner { 
                    background: #fff; 
                    border-radius: 18px; 
                    padding: 18px; 
                    text-align: center; 
                    border-left: 5px solid var(--primary-blue); 
                    margin: 20px 0 40px; 
                    box-shadow: var(--card-shadow); 
                }
                .note-banner p { 
                    margin: 0; 
                    font-size: 13px; 
                    font-weight: 600; 
                    color: #4a5568; 
                    line-height: 1.5; 
                }
                .note-banner strong { color: var(--primary-blue); font-weight: 800; }

                .closed-message-card { 
                    background: #fff; 
                    border-radius: 24px; 
                    padding: 60px 20px; 
                    text-align: center; 
                    box-shadow: var(--card-shadow); 
                    margin: 40px 0; 
                }
                .closed-icon { font-size: 60px; color: #cbd5e0; margin-bottom: 25px; }
                .closed-title { font-size: 20px; font-weight: 800; color: #2d3748; margin-bottom: 15px; }
                .closed-text { font-size: 15px; color: #718096; line-height: 1.6; }
            </style>

            <div class="container pb-4">  
                <?php
                $games_list_qry = "SELECT * FROM `parent_games` WHERE id=? AND status=1";
				$stmt = $con->prepare($games_list_qry);
				$stmt->bind_param("i", $game_id);
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
                               $msg = 'Betting is currently <strong>Running</strong> for all slots.';
                               $default_bidding_game ='open';
                            }elseif(in_array($day, $game_days) && time() < $betting_close_time){
							   $bidding_status = 1;
                               $msg = 'Betting is <strong>Running For Close</strong> results.';
                               $default_bidding_game ='close';
                            }else{
							   $bidding_status = 0;
                               $msg = 'Betting is Closed for Today';
                               $default_bidding_game ='';
                            }
                            
                            $child_open = $row['child_open_id'];
                            $child_close = $row['child_close_id'];
                            $game_name = $row['name'];
                ?>
                
                <!-- Market Hero Header -->
                <div class="market-hero-card">
                    <h1 class="market-name"><?php echo $game_name;?></h1>
                    <div class="market-status-badge <?php echo ($bidding_status) ? 'status-running-accent' : 'status-closed-accent'; ?>">
                        <?php echo ($bidding_status) ? 'Market Running' : 'Market Closed'; ?>
                    </div>
                </div>

                <?php if($default_bidding_game =='open'){ ?>
                <div class="bidding-grid">
                    <a href="single.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/single.png" alt="Single"></div>
                        <p class="option-label">Single Ank</p>
                    </a>
                    
                    <a href="jodi.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/jodi.png" alt="Jodi"></div>
                        <p class="option-label">Jodi</p>
                    </a>
                    
                    <a href="single-patti.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/single_patti.png" alt="Single Patti"></div>
                        <p class="option-label">Single Patti</p>
                    </a>

                    <a href="double-patti.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/double_patti.png" alt="Double Patti"></div>
                        <p class="option-label">Double Patti</p>
                    </a>
                    
                    <a href="triple-patti.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/triple_patti.png" alt="Triple Patti"></div>
                        <p class="option-label">Triple Patti</p>
                    </a>
                    
                    <a href="half-sangam.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/half_sangam.png" alt="Half Sangam"></div>
                        <p class="option-label">Half Sangam</p>
                    </a>

                    <div style="opacity: 0; pointer-events: none;"></div> <!-- Spacer -->
                    <a href="full-sangam.php?gid=<?php echo $child_open;?>&pgid=<?php echo $game_id;?>&dgame=open" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/full_sangam.png" alt="Full Sangam"></div>
                        <p class="option-label">Full Sangam</p>
                    </a>
                    <div style="opacity: 0; pointer-events: none;"></div> <!-- Spacer -->
                </div>
                
                <div class="note-banner">
                    <p>Note: <?php echo $msg;?> </p>
                </div>
                
                <?php }elseif($default_bidding_game =='close'){ ?>
                
                <div class="bidding-grid">
                    <a href="single.php?gid=<?php echo $child_close;?>&pgid=<?php echo $game_id;?>&dgame=close" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/single.png" alt="Single"></div>
                        <p class="option-label">Single Ank</p>
                    </a>

                    <a href="single-patti.php?gid=<?php echo $child_close;?>&pgid=<?php echo $game_id;?>&dgame=close" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/single_patti.png" alt="Single Patti"></div>
                        <p class="option-label">Single Patti</p>
                    </a>

                    <a href="double-patti.php?gid=<?php echo $child_close;?>&pgid=<?php echo $game_id;?>&dgame=close" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/double_patti.png" alt="Double Patti"></div>
                        <p class="option-label">Double Patti</p>
                    </a>

                    <div></div> <!-- Spacer -->
                    <a href="triple-patti.php?gid=<?php echo $child_close;?>&pgid=<?php echo $game_id;?>&dgame=close" class="bidding-option-card">
                        <div class="option-icon-box"><img src="assets/img/triple_patti.png" alt="Triple Patti"></div>
                        <p class="option-label">Triple Patti</p>
                    </a>
                    <div></div> <!-- Spacer -->
                </div>
                
                <div class="note-banner">
                    <p>Note: <?php echo $msg;?> </p>
                </div>
                
                <?php } else { ?>
                
                <div class="closed-message-card">
                    <div class="closed-icon"><i class="fa fa-lock"></i></div>
                    <h2 class="closed-title">Bidding Closed</h2>
                    <p class="closed-text">Sorry! Bidding is currently closed for <strong><?php echo $game_name;?></strong>.<br>Please check back tomorrow to place your bids.</p>
                </div>
                
                <?php } ?>
                
                <?php } $stmt->close(); ?>
            </div>
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>