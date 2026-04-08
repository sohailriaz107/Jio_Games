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

    <title>Game Rate | Winning Ratio | <?php echo $site_title;?></title>
    <meta name="description" content="Explore our exciting game rates and win big!. Single ank jodi, single panna, double patti, triple patti, half sangam, full sangam, Our rates are competitive and offer great value for your money. Whether you're a seasoned player or new to the game, there's something for everyone. Check out our game rate page now and start your winning streak today!">
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" > 
            <div class="tb-10" style="text-align:center;">
                <h1 class="gdash3" style="font-size:22px;"> Game Rate List</h1>
                <span style="font-size:12px;">We Offer Best Rate in market - Full rate</span>
                <div class="row game-list-inner">
                                <div class="col-12 game-rates">
                                  <h2 style="font-size:16px; color:var(--primary-light);">Main Games Win Ratio</h2>
                                  <p>Single ank : <span>10 ka 95</span></p>
                                  <p>jodi : <span>10 ka 950</span></p>
                                  <p>Single Panna : <span>10 ka 1400</span></p>
                                  <p>Double Panna : <span>10 ka 2800</span></p>
                                  <p>Triple Panna : <span>10 ka 6,000</span></p>
                                  <p>half Sangam : <span>10 ka 10,000</span></p>
                                  <p>Full Sangam : <span>10 ka 1,00,000</span></p>
                                </div>
                </div>
                
                <div class="row game-list-inner">
                                <div class="col-12 game-rates">
                                  <h2 style="font-size:16px; color:var(--primary-light);">Starline Games Win Ratio</h2>
                                  <p>Single ank : <span>10 ka 100</span></p>
                                  <p>Single Panna : <span>10 ka 1600</span></p>
                                  <p>Double Panna : <span>10 ka 3,000</span></p>
                                  <p>Triple Panna : <span>10 ka 10,000</span></p>
                                  
                                </div>
                </div>

                        
            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>