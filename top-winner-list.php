<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
include("include/connect.php");
include("include/functions.php");

// Session/Cookie handling (standard across app)
if (!isset($_SESSION['usr_id']) || !isset($_SESSION['usr_name']) || !isset($_SESSION['usr_mobile']) || !isset($_SESSION['api_access_token'])) {
	if (isset($_COOKIE['usr_id']) && isset($_COOKIE['usr_name']) && isset($_COOKIE['usr_mobile']) && isset($_COOKIE['api_access_token'])) {
		$cookie_user_id = intval($_COOKIE['usr_id']);
		$cookie_api_access_token = mysqli_real_escape_string($con, $_COOKIE['api_access_token']);
		$result = mysqli_query($con, "SELECT id FROM users WHERE id = '" . $cookie_user_id. "' and api_access_token = '" . $cookie_api_access_token . "'");
		if ($row = mysqli_fetch_array($result)){
			$_SESSION['usr_id'] = $cookie_user_id;
			$_SESSION['usr_name'] = $_COOKIE['usr_name'];
			$_SESSION['usr_mobile'] = $_COOKIE['usr_mobile'];
			$_SESSION['api_access_token'] = $cookie_api_access_token;
		} else {
			echo "<script>window.location = 'logout.php';</script>";
			exit;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Top Winners List - <?php echo $site_title;?></title>
    <meta name="description" content="Check out the list of todays top winners and lucky winners.">
    <?php include("include/head.php"); ?>
    <style>
        .winner-rank {
            position: absolute;
            top: -10px;
            right: 15px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 5;
        }
        .rank-1 { background: linear-gradient(135deg, #FFD700, #DAA520); }
        .rank-2 { background: linear-gradient(135deg, #C0C0C0, #A9A9A9); }
        .rank-3 { background: linear-gradient(135deg, #CD7F32, #8B4513); }
        .rank-n { background: #e2e8f0; color: #4a5568 !important; }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            <!-- Hero Section -->
            <div class="premium-hero-banner">
                <div class="wallet-display text-center">
                    <i class="fa fa-trophy mb-2" style="font-size: 40px; color: #FFD700; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"></i>
                    <h2 class="brand-text">Top Winners Today</h2>
                    <p class="greeting">Celebrated Champions of RATAN777</p>
                </div>
            </div>

            <div class="container py-4">
                <?php
                $today_date = date('Y-m-d');
                $qry = "SELECT * FROM user_transaction where date='$today_date' and type='win' and starline='0' order by amount+0 DESC limit 10";
                $upi_transactions = mysqli_query($con, $qry);
                $ranking = 1;
                
                if (mysqli_num_rows($upi_transactions) > 0) {
                    while($row = mysqli_fetch_array($upi_transactions)){
                        // Masking logic
                        $user_name = get_userNameById($row['user_id']);
                        $length = strlen($user_name);
                        $visibleLength = min(2, floor($length / 2));
                        $masked_username = substr($user_name, 0, $visibleLength) . str_repeat('*', max(3, $length - ($visibleLength * 2))) . substr($user_name, -$visibleLength);
                        
                        $rankClass = ($ranking <= 3) ? "rank-".$ranking : "rank-n";
                ?>
                    <div class="premium-history-card position-relative" style="margin-bottom: 25px;">
                        <div class="winner-rank <?php echo $rankClass; ?>">
                            <?php echo $ranking; ?>
                        </div>
                        
                        <div class="history-card-header">
                            <span class="game-name"><?php echo $masked_username;?></span>
                            <span class="type-badge" style="background: #e6ffed; color: #1e7e34;">WON</span>
                        </div>
                        
                        <div class="history-card-body">
                            <div class="history-detail-row">
                                <div class="detail-item">
                                    <i class="fa fa-money"></i>
                                    <span class="label">Amount:</span>
                                    <span style="font-weight: 700; color: var(--primary-light); font-size: 16px;">
                                        <i class="fa fa-inr"></i> <?php echo number_format($row['amount']*40); ?>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <i class="fa fa-gamepad"></i>
                                    <span class="label">Game:</span>
                                    <span><?php echo get_gameNameById($row['game_id']); ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fa fa-bullseye"></i>
                                    <span class="label">Digit:</span>
                                    <span class="badge badge-light" style="font-size: 13px; font-weight: 700; color: #2d3748;"><?php echo $row['digit'];?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fa fa-clock-o"></i>
                                    <span class="label">Time:</span>
                                    <span style="font-size: 11px;"><?php echo date('h:i A', strtotime($row['time']));?></span>
                                </div>
                            </div>
                        </div>
                        <div class="history-card-status-bar status-bar-won"></div>
                    </div>
                <?php 
                        $ranking++;
                    } 
                } else { ?>
                    <div class="empty-state">
                        <i class="fa fa-star-o"></i>
                        <p>No winners announced yet for today. Be the first one!</p>
                    </div>
                <?php } ?>
            </div>
            <br><br>
        </div>
    </div>
    <?php include("include/footer.php"); ?>
</body>
</html>