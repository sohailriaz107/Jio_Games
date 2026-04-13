<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
include("include/connect.php");
include("include/session.php");
include("include/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Starline - Play and Win - <?php echo $site_title;?></title>
    <?php include("include/head.php"); ?>
    <style>
        .sl-action-card {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            transition: transform 0.2s;
            border: 1px solid #edf2f7;
        }
        .sl-action-card:active { transform: scale(0.95); }
        .sl-card-title { font-weight: 700; color: #2d3748; font-size: 14px; margin-bottom: 4px; }
        .sl-card-sub { font-size: 11px; color: #718096; }
        .sl-icon { font-size: 24px; margin-bottom: 8px; color: var(--primary-light); }

        .starline-game-card {
            background: #fff;
            border-radius: 16px;
            margin-bottom: 15px;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-left: 5px solid var(--primary-light);
        }
        .sl-game-info { flex: 1; }
        .sl-name { display: block; font-weight: 700; color: #2d3748; font-size: 15px; }
        .sl-time { font-size: 12px; color: #718096; }
        .sl-result { flex: 1; text-align: center; }
        .result-badge { 
            background: #f1f5f9; 
            padding: 5px 12px; 
            border-radius: 20px; 
            font-weight: 700; 
            color: var(--primary-light); 
            font-size: 16px; 
            letter-spacing: 1px;
        }
        .sl-action { flex: 0 0 80px; text-align: right; }
        .btn-play-sl {
            background: linear-gradient(135deg, var(--primary-light), #004ecc);
            color: #fff !important;
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            <!-- Hero Section -->
            <div class="premium-hero-banner" style="background: linear-gradient(135deg, #4299e1, #3182ce);">
                <div class="wallet-display text-center">
                    <i class="fa fa-star mb-2" style="font-size: 36px; color: #FFD700; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"></i>
                    <h2 class="brand-text">Mumbai Starline</h2>
                    <p class="greeting">Play Every Hour, Win Every Time!</p>
                </div>
            </div>

            <div id="scroll-container" class="noticebr"><div id="scroll-text"><?php echo get_SettingValue('app_notice');?></div></div>

            <div class="container py-3">
                <div class="row mb-4">
                    <div class="col-6">
                        <a href="#" class="sl-action-card">
                            <i class="fa fa-rocket sl-icon"></i>
                            <span class="sl-card-title">Play Big</span>
                            <span class="sl-card-sub">Har Ghante Jeeto</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="starline-chart-history.php" class="sl-action-card">
                            <i class="fa fa-line-chart sl-icon" style="color: #48bb78;"></i>
                            <span class="sl-card-title">View Chart</span>
                            <span class="sl-card-sub">Check Records</span>
                        </a>
                    </div>
                </div>

                <div class="section-title mb-3" style="font-weight: 700; color: #4a5568; font-size: 16px;">
                    <i class="fa fa-clock-o text-primary mr-1"></i> Today's Schedule
                </div>

                <?php
                $games_list_qry = "SELECT * FROM starline order by STR_TO_DATE(time, '%h:%i %p') ASC";
                $games = mysqli_query($con, $games_list_qry);
                while ($row = mysqli_fetch_array($games)){
                    $game_id = $row['id'];
                    $game_name = $row['name'];
                    $result = get_StarlineResult($game_id);
                    $startline_time = strtotime(date('Y-m-d').' '.$row['time']);
                ?>    
                    <div class="starline-game-card">
                        <div class="sl-game-info">
                            <span class="sl-name"><?php echo $game_name;?></span>
                            <span class="sl-time"><i class="fa fa-clock-o mr-1"></i> <?php echo date('h:i A', strtotime($row['time'])); ?></span>
                        </div>
                        <div class="sl-result">
                            <span class="result-badge"><?php echo $result;?></span>
                        </div>
                        <div class="sl-action">
                            <?php if(time() < $startline_time){ ?>
                                <a href="starline-dashboard.php?game=<?php echo $game_name;?>&gid=<?php echo $game_id;?>" class="btn-play-sl">PLAY</a>
                            <?php } else { ?>
                                <span style="font-size: 11px; color: #cbd5e0; font-weight: 600;">CLOSED</span>
                            <?php } ?>
                        </div>
                    </div> 
                <?php } ?>
            </div>
            <br><br>
        </div>
    </div>
    <?php include("include/footer.php"); ?>
</body>
</html>