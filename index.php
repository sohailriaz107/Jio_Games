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
            
			
			
			
			
            <div class="container text-center" >  
            <div class="tb-10">
                  <div class="row">
                    <div class="col-3" style="padding-left:5px;padding-right:5px;"> 
                      <a href="add-fund.php" class="home-sl2-box"> <i class="fa fa-money"></i> <br> <span>Add Fund</span></a>
                    </div>
                    <div class="col-3" style="padding-left:5px;padding-right:5px;"> 
                      <a href="withdraw.php" class="home-sl2-box"> <i class="fa fa-credit-card"></i> <br> <span>Withdraw</span></a>
                    </div>
                    
                    <div class="col-3" style="padding-left:5px;padding-right:5px;">
                      <a href="support.php" class="home-sl2-box"><i class="fa fa-comments"></i> <br> <span>Help</span></a>
                    </div>
                    
                    <div class="col-3" style="padding-left:5px;padding-right:5px;">
                      <a href="https://jiogames.app/apk/JioGames_V102.apk" class="home-sl2-box"><i class="fa fa-download"></i> <br> <span>Download App</span></a>
                    </div>

                  </div>
            </div>
            </div>
            <div id="scroll-container" class="noticebr"><div id="scroll-text" style="white-space: nowrap;"><?php echo get_SettingValue('app_notice');?></div></div>
            
            <div class="container text-center" > 
            <div class="tb-10">
                
                <div class="row game-list-inner" style="background: #1f1f1f;color: #ffe301;">
                                <div class="col-3">
                                  <i class="fa fa-star" style="font-size: 25px;padding-top: 13px;"></i>
                                </div>
                                <div class="col-6"> 
                                  <div class="game-list-box">
                                      <span class="gameName"> MUMBAI STARLINE </span>
                                      
                                      <span class="gameResult" style="color: white;font-size: 12px;padding-top: 10px;">Play and Win Hourly</span>
                                  </div>
                                </div>
                                <div class="col-3"> 
                                 <a href="starline-play.php" class="game-play"> <i class="fa fa-play-circle" style="color: white;"></i><br>Play Starline</a>
                                </div>
        
                        </div> 
                        <h3 class="gdash3" style="font-size: 16px;">WORLD KA SABSE TRUSTED MATKA PLAY</h3>
            
                <?php
                $games_list_qry =  "SELECT * FROM `parent_games` WHERE status=1 order by order_of_display";
				$games = mysqli_query($con, $games_list_qry);
                         while ($row = mysqli_fetch_array($games)){
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
                               $default_bidding_game ='open';
                             }
                             
                             
                             $child_open = $row['child_open_id'];
                             $child_close = $row['child_close_id'];
                             $open_result = GetOpneResultByid($child_open);
                             $close_result = GetCloseResultByid($child_close);
                             
                            $game_id = $row['id'];
                            $game_name = $row['name'];
                            $open_time = date("h:i A", strtotime($open_time));
                            $close_time = date("h:i A", strtotime($close_time));
                            $result_open_time = date("h:i A", strtotime($result_open_time));
                            $result_close_time = date("h:i A", strtotime($result_close_time));
                            $result = $open_result.''.$close_result;
							$bidding_status = $bidding_status;
                            $msg =  $msg;
                            $default_bidding_date = $default_bidding_date;
                            $default_bidding_game = $default_bidding_game;
                            $status = $row['status'];
                            $game_title = strtolower(str_replace(" ","-",$game_name));

                    ?>    
                        
                        <div class="row game-list-inner">
                                <div class="col-3">
                                  <a href="#" class="game-time" data-toggle="modal" data-target="#gameTimeModal<?php echo $game_id;?>"><i class="fa fa-clock-o"></i> <br>Game Time</a>
                                </div>
                                <div class="col-6"> 
                                  <div class="game-list-box">
                                      <span class="gameName"> <?php echo $game_name;?> </span>
                                      <?php if($bidding_status){ ?>
                                      <p class="gameon"><?php echo $msg;?></p>
                                      <?php }else{?>
                                      <p class="gameoff"><?php echo $msg;?></p>
                                      <?php } ?>
                                      <span class="gameResult"><?php echo $result;?></span>
                                  </div>
                                </div>
                                <div class="col-3"> 
                                <?php if($bidding_status){ ?>
                                  <a href="game-dashboard.php?game=<?php echo $game_title;?>&gid=<?php echo $game_id;?>" class="game-play"> <i class="fa fa-play-circle"></i><br>Play Game</a>
                                <?php }else{?>
                                 <a href="#" class="game-play gray"> <i class="fa fa-play-circle"></i><br>Play Game</a>
                                <?php } ?>
                                </div>
        
                        </div> 
                        <div class="modal" id="gameTimeModal<?php echo $game_id;?>">
                          <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <p class="modal-title"><?php echo $game_name;?></p>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
                                <div class="HomegameTimetable">
                                    <div><i class="fa fa-clock-o"></i> <span>Open Bid Ends</span> <span class="timeR"><?php echo $open_time;?></span></div>
                                    <div><i class="fa fa-clock-o"></i> <span>Close Bid Ends</span> <span class="timeR"><?php echo $close_time;?></span></div>
                                    <div><i class="fa fa-clock-o"></i> <span>Open Result</span> <span class="timeR"><?php echo $result_open_time;?></span></div>
                                    <div><i class="fa fa-clock-o"></i> <span>Close Result</span> <span class="timeR"><?php echo $result_close_time;?></span></div>
                                </div>
                              </div>
                        
                              <!-- Modal footer -->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
                              </div>
                        
                            </div>
                          </div>
                        </div>
                        
                        
                   <?php } ?>

                
            </div>      
            </div>
            <br><br><br>
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
	
	<?php if(1){?>
	<div class="modal" id="noticeboard">
                          <div class="modal-dialog">
                            <div class="modal-content">
                        
                              <!-- Modal Header -->
                              <div class="modal-header">
                                <p class="modal-title">GET ANDROID APPLICATION</p>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                        
                              <!-- Modal body -->
                              <div class="modal-body">
							  <div style="display: flex; align-items: center;">
									<img src="assets/img/app-home.webp" style="width: 150px; height: auto; margin-right: 10px;">
									<div>
										<p style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">DOWNLOAD OUR APP</p>
										
										<p style="line-height: 22px;
    font-size: 16px;">Enjoy advanced features and options by downloading our Android app. access all the exciting features anytime, anywhere!</p>
										<a href="https://jiogames.app/apk/JioGames_V102.apk" style="background-color: #b73800; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;text-decoration:none;"> <i class="fa fa-download"></i> Download Now</a>
									</div>
								</div>

                        
                              <!--
                              <div class="modal-footer">
                                <button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
                              </div> -->
                        
                            </div>
                          </div>
    </div>
	</div>
	<?php } ?>
						
    
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
            date.setTime(date.getTime() + (3 * 60 * 60 * 1000)); // Set the cookie to expire in 6 hours
            document.cookie = 'popup_seen=true; expires=' + date.toUTCString() + '; path=/';
        });
    });
</script>



</body>

</html>