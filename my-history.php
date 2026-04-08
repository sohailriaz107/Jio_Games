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
                
                <div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="fund-history.php" class="mplist" ><i class="fa fa-money"></i> Fund History</a>
                                </div>
                </div>

                
                <div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="bidding-history.php" class="mplist" ><i class="fa fa-list-alt"></i> Main Bidding History</a>
                                </div>
                </div>
                
                <div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="bidding-history-starline.php" class="mplist" ><i class="fa fa-list"></i>Starline Bidding History</a>
                                </div>
                </div>
                
                <div class="row game-list-inner">
                                <div class="col-12">
                                  <a href="transaction-history.php" class="mplist" ><i class="fa fa-list-alt"></i>Transaction History</a>
                                </div>
                </div>

                        
            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>