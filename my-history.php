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

    <title>My profile - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" > 
            <div class="tb-10">
                
                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px;">
                     <a href="fund-history.php" class="mplist" style="text-decoration:none; color:#2d3748; font-weight:600; display:flex; align-items:center; width:100%;"><i class="fa fa-money" style="margin-right:15px; color:var(--primary-light); font-size:22px;"></i> Fund History</a>
                </div>

                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px;">
                     <a href="bidding-history.php" class="mplist" style="text-decoration:none; color:#2d3748; font-weight:600; display:flex; align-items:center; width:100%;"><i class="fa fa-list-alt" style="margin-right:15px; color:var(--primary-light); font-size:22px;"></i> Main Bidding History</a>
                </div>
                
                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px;">
                    <a href="bidding-history-starline.php" class="mplist" style="text-decoration:none; color:#2d3748; font-weight:600; display:flex; align-items:center; width:100%;"><i class="fa fa-list" style="margin-right:15px; color:var(--primary-light); font-size:22px;"></i> Starline Bidding History</a>
                </div>
                
                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px;">
                    <a href="transaction-history.php" class="mplist" style="text-decoration:none; color:#2d3748; font-weight:600; display:flex; align-items:center; width:100%;"><i class="fa fa-exchange" style="margin-right:15px; color:var(--primary-light); font-size:22px;"></i> Transaction History</a>
                </div>

                        
            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>