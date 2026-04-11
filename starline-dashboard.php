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

    <title>Starline Dashboard - <?php echo $game_title ;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            
            <div class="container" >  
            <div class="card-full-page tb-10" style="background: transparent !important; box-shadow: none !important; border: none !important;">
                
                <!-- PREMIUM HERO SECTION -->
                <div class="starline-hero-banner text-center">
                    <h3 class="hero-title">Starline <?php echo $game_title;?></h3>
                    <span class="hero-subtitle">Select Bidding Option</span>
                </div>
                
                <div class="tb-10">&nbsp;</div>
                
                <?php		 
				$games_list_qry = "SELECT * FROM `starline` WHERE id=? AND status=1";
				$stmt = $con->prepare($games_list_qry);
				$stmt->bind_param("i", $game_id);
				$stmt->execute();
				$games = $stmt->get_result();

				while ($row = $games->fetch_assoc()) {
                             
                            $startline_time = strtotime(date('Y-m-d').' '.$row['time']);
                            

                    ?>
                
                <?php if(time() < $startline_time){ ?>
                
                <!-- PREMIUM 2x2 GRID -->
                <div class="row bidoptions-list">
                    <div class="col-6 mb-3" style="padding-bottom: 12px;">
                        <a href="starline-single.php?gid=<?php echo $game_id;?>" class="premium-game-card">
                            <div class="icon-wrapper"><img src="assets/img/single.png"></div>
                            <p>Single Ank</p>
                        </a>
                    </div>
                    
                    <div class="col-6 mb-3" style="padding-bottom: 12px;">
                        <a href="starline-single-patti.php?gid=<?php echo $game_id;?>" class="premium-game-card">
                            <div class="icon-wrapper"><img src="assets/img/single_patti.png"></div>
                            <p>Single Patti</p>
                        </a>
                    </div>
                    
                    <div class="col-6 mb-3" style="padding-bottom: 12px;">
                        <a href="starline-double-patti.php?gid=<?php echo $game_id;?>" class="premium-game-card">
                            <div class="icon-wrapper"><img src="assets/img/double_patti.png"></div>
                            <p>Double Patti</p>
                        </a>
                    </div>

                    <div class="col-6 mb-3" style="padding-bottom: 12px;">
                        <a href="starline-triple-patti.php?gid=<?php echo $game_id;?>" class="premium-game-card">
                            <div class="icon-wrapper"><img src="assets/img/triple_patti.png"></div>
                            <p>Triple Patti</p>
                        </a>
                    </div>
                </div>
                
                <div class="hero-alert-box text-center mt-2">
                    <i class="fa fa-info-circle"></i> <span>Khelo and Jeeto Har Ghante.</span>
                </div>
                
                <?php }else{ ?>
                
                <!-- CLOSED VIEW -->
                <div class="hero-alert-box danger text-center mt-3">
                    <i class="fa fa-clock-o" style="font-size: 38px; margin-bottom: 12px; display: block; opacity: 0.8;"></i>
                    <span style="font-size: 16px;"><strong>Sorry! Bidding is Closed</strong><br>for <?php echo $game_title;?>.<br><span style="font-size: 14px; font-weight: 500;">Please play for the next one.</span></span>
                </div>
                
                <?php } ?>
                
                
                <?php } $stmt->close();?>
                        
                

            </div>
            </div>
            
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>