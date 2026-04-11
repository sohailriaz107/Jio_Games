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

<title> Jio games | ONLINE MATKA PLAY APP	</title>
<meta name="title" content="Jio games | PLAY ONLINE MATKA | SATTA MATKA PLAY">
<meta name="description" content="Jio games App Experience with new Online Matka Play App website and Jio games in Satta Matka Play online matka Industry 2024 with Jio games.">
<link rel="canonical" href="https://jiogames.app" />
<?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

<?php
if(isset($_SESSION['usr_id'])!="" && 0 ) {
$usr_id = $_SESSION['usr_id'];
// Check if location data already exists
$query = "SELECT lat, lon FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $usr_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $lat, $lon);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (empty($lat) || empty($lon)) {
    // Redirect to location page if data is missing
    echo "<script>window.location.href = 'get_location.php';</script>";
    exit;
}
}
?>
            
            
            <?php if(0){?>
            <div id="scroll-container" class="noticebr"><div id="scroll-text" style="white-space: nowrap;"><?php echo get_SettingValue('app_notice');?></div></div>
            <div class="container text-center " >    
            <div class="tb-10">
                  <div class="row">
                    <div class="col-6">
                      <a href="starline-play.php" class="home-sl-box">Mumbai Starline</a>
                    </div>
                    <div class="col-6"> 
                      <a href="#" target="_blank" class="home-sl-box">Download App</a>
                    </div>
                  </div>
            </div>
            </div>
            
            <div class="container text-center" >  
            <div class="tb-10">
                  <div class="row">
                    
                    <div class="col-4" style="padding-right:5px;padding-left:5px;"> 
                      <a href="add-fund.php" class="home-sl2-box"> <i class="fa fa-money"></i> Add Money</a>
                    </div>
                    <div class="col-4" style="padding-left:5px;"> 
                      <a href="withdraw.php" class="home-sl2-box"> <i class="fa fa-credit-card"></i> Withdraw</a>
                    </div>
                    <div class="col-4" style="padding-right:5px;">
                      <a href="support.php" class="home-sl2-box"><i class="fa fa-comments"></i> Support</a>
                    </div>
                    
                  </div>
            </div>
            </div>
            <?php } ?>
            
			
			
			
			

            <!-- Custom Styles for Index -->
            <style>
                /* Hero Slider - Enhanced Fade Transition */
                .hero-slider-wrapper { border-radius: 0 0 24px 24px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); margin-top: -10px; overflow: hidden; position: relative; }
                .hero-slider { position: relative; height: 190px; width: 100%; background: #f0f4f8; }
                .hero-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1s ease-in-out; display: block !important; }
                .hero-slide.active { opacity: 1; z-index: 2; }
                .hero-slide img { height: 100%; width: 100%; object-fit: cover; }
                
                /* Notice Marquee Styling */
                .notice-marquee { background: #fff; padding: 12px 15px; margin: 20px 15px 15px; border-radius: 12px; display: flex; align-items: center; box-shadow: var(--card-shadow); border-left: 4px solid var(--primary-blue); opacity: 0.95; }
                .notice-marquee i { color: var(--primary-blue); font-size: 18px; margin-right: 12px; }
                .notice-marquee marquee { font-size: 13px; font-weight: 600; color: #333; }

                /* Winner Ticker - Keep but make it subtle below quick grid */
                .winner-ticker-subtle { background: rgba(0,68,187,0.03); padding: 8px 15px; margin: 0 15px 15px; border-radius: 50px; display: flex; align-items: center; }
                .winner-ticker-subtle i { color: var(--accent-gold); font-size: 14px; margin-right: 10px; }
                .winner-ticker-subtle marquee { font-size: 11px; font-weight: 500; color: #666; }
                .winner-ticker-subtle span { margin-right: 25px; }

                .quick-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; padding: 10px 15px; margin-bottom: 10px; }
                .grid-item { text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; }
                .grid-icon { width: 48px; height: 48px; border-radius: 14px; background: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0,0,0,0.04); margin-bottom: 8px; transition: transform 0.2s; border: 1px solid rgba(0,0,0,0.02); }
                .grid-item:active .grid-icon { transform: scale(0.92); }
                .grid-icon i { font-size: 20px; color: var(--primary-blue); }
                .grid-item span { font-size: 11px; font-weight: 600; color: #555; }

                .starline-banner-premium { background: var(--primary-gradient); padding: 30px 20px; border-radius: 24px; margin: 15px; color: white; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(0,68,187,0.2); text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; }
                .starline-banner-premium::after { content: ''; position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; }
                .starline-head h4 { margin: 0; font-size: 22px; font-weight: 800; letter-spacing: 0.5px; text-align: center !important; }
                .starline-head p { margin: 8px 0 0; font-size: 13px; opacity: 0.95; line-height: 1.4; text-align: center !important; }
                .btn-starline-play { background: #fff !important; color: var(--primary-blue) !important; padding: 12px 30px !important; border-radius: 50px !important; font-weight: 700 !important; font-size: 14px !important; display: inline-block !important; margin-top: 20px !important; box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important; text-decoration: none !important; transition: transform 0.2s !important; }
                .btn-starline-play:active { transform: scale(0.95); }

                .game-section-title { padding: 10px 20px; font-size: 12px; font-weight: 800; color: #8e8e93; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 5px; text-align: left; }

                .game-cards-grid { display: flex !important; flex-wrap: wrap !important; gap: 10px !important; padding: 0 10px 10px !important; justify-content: space-between !important; align-items: stretch !important; }
                
                .premium-game-card { background: #fff !important; border-radius: 18px !important; padding: 15px 10px !important; box-shadow: var(--card-shadow) !important; border: 1px solid rgba(0,0,0,0.015) !important; display: flex !important; flex-direction: column !important; align-items: center !important; text-align: center !important; flex: 0 0 calc(50% - 5px) !important; width: calc(50% - 5px) !important; margin: 5px 0 !important; }
                .card-top { width: 100% !important; margin-bottom: 5px !important; display: flex !important; flex-direction: column !important; align-items: center !important; min-height: 55px !important; justify-content: center !important; }
                .game-name { font-size: 11px !important; font-weight: 800 !important; color: #222 !important; margin: 0 0 4px !important; text-transform: uppercase !important; text-align: center !important; line-height: 1.2 !important; min-height: 28px !important; display: flex !important; align-items: center !important; justify-content: center !important; }
                .status-badge { font-size: 8px !important; font-weight: 700 !important; padding: 2px 6px !important; border-radius: 50px !important; text-transform: uppercase !important; display: inline-block !important; margin: 0 auto !important; }
                .status-running { background: rgba(46, 204, 113, 0.1) !important; color: #2ecc71 !important; }
                .status-closed { background: rgba(231, 76, 60, 0.1) !important; color: #e74c3c !important; }
                
                .card-visual { width: 50px !important; height: 50px !important; margin-bottom: 8px !important; background: #fff8eb !important; border-radius: 12px !important; display: flex !important; align-items: center !important; justify-content: center !important; }
                .card-visual i { font-size: 24px !important; color: #d4af37 !important; }
                
                .result-box { width: 100% !important; padding: 6px 0 !important; background: #fbfdff !important; border-radius: 10px !important; margin-bottom: 10px !important; display: flex !important; justify-content: center !important; align-items: center !important; flex-grow: 1 !important; }
                .result-numbers { font-size: 15px !important; font-weight: 900 !important; color: var(--primary-blue) !important; letter-spacing: 1px !important; text-align: center !important; }
                
                .card-actions { width: 100% !important; display: flex !important; flex-direction: column !important; gap: 6px !important; margin-top: auto !important; }
                .btn-timing { background: #f0f4f8 !important; color: #666 !important; padding: 6px !important; border-radius: 10px !important; font-size: 10px !important; font-weight: 600 !important; text-align: center !important; text-decoration: none !important; margin-top: 2px !important; }
                .btn-play-game { background: var(--primary-blue) !important; color: #fff !important; padding: 8px !important; border-radius: 10px !important; font-size: 11px !important; font-weight: 700 !important; text-align: center !important; text-decoration: none !important; box-shadow: none !important; }
                .btn-play-game.disabled { background: #eef2f6 !important; color: #b0bac9 !important; box-shadow: none !important; pointer-events: none !important; }
                .btn-timing { background: #f0f4f8; color: #666; padding: 6px; border-radius: 10px; font-size: 11px; font-weight: 600; text-align: center; }
                .btn-play-game { background: var(--primary-blue); color: #fff; padding: 8px; border-radius: 10px; font-size: 11px; font-weight: 700; text-align: center; box-shadow: 0 4px 10px rgba(0,68,187,0.15); }
                .btn-play-game.disabled { background: #eef2f6; color: #b0bac9; box-shadow: none; pointer-events: none; }
            </style>

            <!-- Hero Image Slider -->
            <div class="hero-slider-wrapper">
                <div class="hero-slider" id="heroSlider">
                    <div class="hero-slide active">
                        <img src="assets/img/banner-1.jpg" alt="Banner 1">
                    </div>
                    <div class="hero-slide">
                        <img src="assets/img/banner-2.jpg" alt="Banner 2">
                    </div>
                    <div class="hero-slide">
                        <img src="assets/img/banner-3.jpg" alt="Banner 3">
                    </div>
                </div>
                <!-- Prev / Next Buttons -->
                <button class="slider-btn slider-prev" onclick="heroSliderPrev()">&#10094;</button>
                <button class="slider-btn slider-next" onclick="heroSliderNext()">&#10095;</button>
                <!-- Dots -->
                <div class="slider-dots" id="sliderDots">
                    <span class="dot active" onclick="heroSliderGoTo(0)"></span>
                    <span class="dot" onclick="heroSliderGoTo(1)"></span>
                    <span class="dot" onclick="heroSliderGoTo(2)"></span>
                </div>
            </div>

            <!-- Dynamic Notice Marquee -->
            <div class="notice-marquee">
                <i class="fa fa-bullhorn"></i>
                <marquee scrollamount="5"><?php echo get_SettingValue('app_notice');?></marquee>
            </div>

            <!-- Quick Action Grid -->
            <div class="quick-grid">
                <a href="add-fund.php" class="grid-item">
                    <div class="grid-icon"><i class="fa fa-plus-circle"></i></div>
                    <span>Add Fund</span>
                </a>
                <a href="withdraw.php" class="grid-item">
                    <div class="grid-icon"><i class="fa fa-bank"></i></div>
                    <span>Withdraw</span>
                </a>
                <a href="game-rates.php" class="grid-item">
                    <div class="grid-icon"><i class="fa fa-list-alt"></i></div>
                    <span>Rates</span>
                </a>
                <a href="support.php" class="grid-item">
                    <div class="grid-icon"><i class="fa fa-headphones"></i></div>
                    <span>Support</span>
                </a>
                <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" class="grid-item">
                    <div class="grid-icon" style="color: #25D366;"><i class="fa fa-whatsapp"></i></div>
                    <span>WhatsApp</span>
                </a>
                <a href="<?php echo TELEGRAM_URL;?>" class="grid-item">
                    <div class="grid-icon" style="color: #0088cc;"><i class="fa fa-send"></i></div>
                    <span>Telegram</span>
                </a>
                <a href="starline-play.php" class="grid-item">
                    <div class="grid-icon"><i class="fa fa-star" style="color: #f1c40f;"></i></div>
                    <span>Starline</span>
                </a>
                <a href="my-profile.php" class="grid-item">
                    <div class="grid-icon"><i class="fa fa-user-circle"></i></div>
                    <span>Profile</span>
                </a>
            </div>

            <!-- Winner Ticker (Secondary) -->
            <div class="winner-ticker-subtle">
                <i class="fa fa-trophy"></i>
                <marquee scrollamount="3">
                    <span><b>Rohan K.</b> won ₹2,450!</span>
                    <span><b>Amit S.</b> won ₹5,000!</span>
                    <span><b>Sunny P.</b> won ₹1,200!</span>
                    <span><b>Priya G.</b> won ₹3,500!</span>
                    <span><b>Deepak M.</b> won ₹4,100!</span>
                </marquee>
            </div>

            <!-- Starline Premium Banner -->
            <div class="starline-banner-premium">
                <div class="starline-content">
                    <div class="starline-head">
                        <h4>MUMBAI STARLINE</h4>
                        <p>Play every hour and win big with Mumbai's most trusted market.</p>
                    </div>
                    <a href="starline-play.php" class="btn-starline-play">
                        <i class="fa fa-play"></i> Play Starline
                    </a>
                </div>
            </div>

            <div class="game-section-title">Verified Matka Markets</div>
            <div class="game-cards-grid">
                <?php
                $games_list_qry =  "SELECT * FROM `parent_games` WHERE status=1 order by order_of_display";
                $games = mysqli_query($con, $games_list_qry);
                while ($row = mysqli_fetch_array($games)){
                    $game_id = $row['id'];
                    $game_name = $row['name'];
                    $open_time = date("h:i A", strtotime($row['open_time']));
                    $close_time = date("h:i A", strtotime($row['close_time']));
                    
                    $day = strtolower(date('D'));
                    $game_days = explode(",", $row['open_days']);
                    
                    $betting_open_time = strtotime(date('Y-m-d').' '.$row['open_time']);
                    $betting_close_time = strtotime(date('Y-m-d').' '.$row['close_time']);
                    
                    if(in_array($day, $game_days) && time() < $betting_close_time){
                        $bidding_status = 1;
                        $msg = 'Betting is Running';
                    } else {
                        $bidding_status = 0;
                        $msg = 'Closed for Today';
                    }
                    
                    $open_result = GetOpneResultByid($row['child_open_id']);
                    $close_result = GetCloseResultByid($row['child_close_id']);
                    $result = ($open_result ? $open_result : '***') . '-' . ($close_result ? $close_result : '***');
                    $game_title_slug = strtolower(str_replace(" ","-",$game_name));
                ?>    
                    
                    <div class="premium-game-card">
                        <div class="card-top">
                            <h3 class="game-name"><?php echo $game_name;?></h3>
                            <?php if($bidding_status){ ?>
                                <span class="status-badge status-running">Running</span>
                            <?php }else{?>
                                <span class="status-badge status-closed">Closed</span>
                            <?php } ?>
                        </div>

                        <div class="card-visual">
                            <i class="fa fa-cubes"></i>
                        </div>
                        
                        <div class="result-box">
                            <span class="result-numbers"><?php echo $result;?></span>
                        </div>
                        
                        <div class="card-actions">
                            <a href="game-dashboard.php?game=<?php echo $game_title_slug;?>&gid=<?php echo $game_id;?>" class="btn-play-game <?php echo ($bidding_status) ? '' : 'disabled'; ?>">
                                <i class="fa fa-play-circle"></i> Play Game
                            </a>
                            <a href="#" class="btn-timing" data-toggle="modal" data-target="#gameTimeModal<?php echo $game_id;?>">
                                <i class="fa fa-clock-o"></i> Timings
                            </a>
                        </div>
                    </div> 

                    <!-- Timing Modal -->
                    <div class="modal fade" id="gameTimeModal<?php echo $game_id;?>" tabindex="-1">
                      <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title font-weight-bold"><?php echo $game_name;?> Timings</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body p-0">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between text-sm"><span>Open Bid Ends</span> <b><?php echo $open_time;?></b></div>
                                <div class="list-group-item d-flex justify-content-between text-sm"><span>Close Bid Ends</span> <b><?php echo $close_time;?></b></div>
                                <div class="list-group-item d-flex justify-content-between text-sm"><span>Open Result</span> <b><?php echo date("h:i A", strtotime($row['result_open_time']));?></b></div>
                                <div class="list-group-item d-flex justify-content-between text-sm"><span>Close Result</span> <b><?php echo date("h:i A", strtotime($row['result_close_time']));?></b></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php } ?>
            </div>
            <div style="height: 10px;"></div>
            <?php if(0){?>
            <div class="container hometext">
			<h1 style="font-size:14px;font-weight: 300;">Jio games: ONLINE MATKA PLAY</h1>
			<p>Jio games App Experience with new online Matka Play website and matkabooking in Satta Matka Play online matka Industry 2023. We provide the best online matka satta play experience , 500 deposit full rate real time support.</p>
			
			
			<h2 style="font-size:12px;font-weight: 300;">India's No1 Most Trusted Online Matka Play Site</h2>
            <p >Welcome to Jio games, your premier destination for online matka play. As the domain name suggests, Jio games offers a seamless platform for enthusiasts to indulge in the thrill of satta matka. Our commitment to a secure and swift gaming experience sets us apart—we ensure a minimum deposit of 500, instant withdrawals, and 24/7 customer support for any queries. With a reputation for being the top online matka play website, we take pride in delivering full rates and, above all, guaranteeing the safety of our users' money. Join us for an unparalleled journey into the world of matka, where excitement meets reliability.</p>
			
			
			
			<h3 style="font-size:12px;font-weight: 300;">Popular Online Matka Game</h3>
            <p >Online Matka, a digital variation of the traditional Indian gambling game, has become inceasing popularity in the online gaming landscape. Originating from the Mumbai textile industry, this casual game involves betting on numbers to win big prizes. The online matka matka provides the perfect platform for those who are keen to leave their home to join in the fun. Players can participate in matka markets and enjoy the thrill of winning by guessing the right number. The digital transformation has not only preserved the essence of the game but has made it more accessible, creating a vibrant online community of Matka exprts</p>

            
            </div>
            <?php } ?>
            
        </div>
    </div>
	
	<style>
	#noticeboard.modal {
	  padding: 0 !important;
	}
	#noticeboard .modal-dialog {
	  margin: 0;
	  top: 50%;
	  left: 50%;
	  transform: translate(-50%, -50%) !important;
	  position: absolute;
	  width: 90%;
	  max-width: 500px;
	}
	</style>

	<?php if(1){?>
	<div class="modal" id="noticeboard">
      <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2);">
    
          <!-- Modal Header -->
          <div class="modal-header" style="background: linear-gradient(45deg, #0d6efd, #0044bb); color: white; border: none; padding: 15px 20px;">
            <p class="modal-title" style="font-weight: 800; font-size: 16px; margin: 0; text-transform: uppercase; letter-spacing: 1px;">GET ANDROID APPLICATION</p>
            <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1; text-shadow: none;">&times;</button>
          </div>
    
          <!-- Modal body -->
          <div class="modal-body" style="padding: 25px;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="assets/img/app-home.webp" style="width: 140px; height: auto; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
                <div>
                    <p style="font-size: 20px; font-weight: 900; color: #b73800; margin-bottom: 8px;">DOWNLOAD OUR APP</p>
                    <p style="line-height: 1.5; font-size: 14px; color: #4b5563; margin-bottom: 20px;">Enjoy advanced features and options by downloading our Android app. Access all the exciting features anytime, anywhere!</p>
                    <a href="https://jiogames.app/apk/JioGames_V102.apk" 
                       style="display: inline-block; background: linear-gradient(to right, #b73800, #ff4c00); color: white; padding: 12px 24px; border: none; border-radius: 10px; cursor: pointer; text-decoration: none; font-weight: 700; box-shadow: 0 4px 15px rgba(183, 56, 0, 0.3);">
                        <i class="fa fa-download"></i> Download Now
                    </a>
                </div>
            </div>
          </div>
    
        </div>
      </div>
    </div>
	</div>
	<?php } ?>
						
    
    <?php include("include/bottom-nav.php"); ?>
    <?php include("include/footer.php"); ?>
	<?php if(0){?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/64d1d76acc26a871b02dee5c/1h79r2uj8';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
	<?php } ?>
	
<div class="wts-flt-btn">

<?php
// Function to read configuration from conf.txt
function getConfig() {
    $configFilePath = 'conf.txt';
    $config = ['whatsapp_enabled' => 0, 'telegram_enabled' => 0]; // Default values
    
    if (file_exists($configFilePath)) {
        $lines = file($configFilePath, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            list($key, $value) = explode('=', $line);
            if ($key === 'whatsapp_enabled' || $key === 'telegram_enabled') {
                $config[$key] = intval($value);
            }
        }
    }
    
    return $config;
}

// Example usage: Display WhatsApp and Telegram icons based on configuration
$config = getConfig();

$whatsapp_on_home = $config['whatsapp_enabled'];
$telegram_on_home = $config['telegram_enabled'];
?>
<?php if($whatsapp_on_home){?>
<a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" ><i class="fa fa-whatsapp"></i> 
<?php }elseif($telegram_on_home){ ?>
<a href="<?php echo TELEGRAM_URL;?>" ><i class="fa fa-telegram"></i> 
<?php } ?>

</div>


<script type="text/javascript">
    $(document).ready(function() {
        // Check if the cookie exists and has a value of 'seen'
        if (document.cookie.indexOf('popup_seen') === -1) {
            // If the cookie doesn't exist, show the popup
            $('#noticeboard').modal('show');
        }

        // Set a cookie to indicate that the user has seen the popup
        $('#noticeboard').on('hidden.bs.modal', function () {
            var date = new Date();
            date.setTime(date.getTime() + (3 * 60 * 60 * 1000));
            document.cookie = 'popup_seen=true; expires=' + date.toUTCString() + '; path=/';
        });
    });
</script>

<script>
    // Custom Hero Slider (Fade version)
    var heroCurrentSlide = 0;
    var heroSlides = document.querySelectorAll('.hero-slide');
    var heroDots = document.querySelectorAll('.dot');
    var heroTimer;

    function heroSliderGoTo(n) {
        if (heroSlides.length === 0) return;
        
        // Remove active from current
        heroSlides[heroCurrentSlide].classList.remove('active');
        heroDots[heroCurrentSlide].classList.remove('active');
        
        // Update index
        heroCurrentSlide = (n + heroSlides.length) % heroSlides.length;
        
        // Add active to new
        heroSlides[heroCurrentSlide].classList.add('active');
        heroDots[heroCurrentSlide].classList.add('active');
    }

    function heroSliderNext() {
        heroSliderGoTo(heroCurrentSlide + 1);
        resetHeroTimer();
    }

    function heroSliderPrev() {
        heroSliderGoTo(heroCurrentSlide - 1);
        resetHeroTimer();
    }

    function resetHeroTimer() {
        clearInterval(heroTimer);
        heroTimer = setInterval(function() { heroSliderGoTo(heroCurrentSlide + 1); }, 4000);
    }

    // Auto start
    if (heroSlides.length > 0) {
        heroTimer = setInterval(function() { heroSliderGoTo(heroCurrentSlide + 1); }, 4000);
    }
</script>



</body>

</html>