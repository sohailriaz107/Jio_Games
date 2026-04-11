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
            
            <div class="container" style="padding-top: 20px;">
                <div class="tb-10" style="text-align:center; margin-bottom: 30px;">
                    <h1 class="gdash3" style="font-size:24px; font-weight: 800; margin-bottom: 5px;">Game Rate List</h1>
                    <p style="font-size:14px; color: #718096; margin-bottom: 0;">We Offer Best Rate in market - Full rate</p>
                </div>

                <!-- Main Games Card -->
                <div class="premium-rate-card">
                    <div class="rate-card-header">
                        <i class="fa fa-trophy"></i>
                        <h2>Main Games Win Ratio</h2>
                    </div>
                    <ul class="rate-list">
                        <li class="rate-item">
                            <span class="label">Single Ank</span>
                            <span class="value">10 ka 95</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Jodi</span>
                            <span class="value">10 ka 950</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Single Panna</span>
                            <span class="value">10 ka 1400</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Double Panna</span>
                            <span class="value">10 ka 2800</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Triple Panna</span>
                            <span class="value">10 ka 6,000</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Half Sangam</span>
                            <span class="value">10 ka 10,000</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Full Sangam</span>
                            <span class="value">10 ka 1,00,000</span>
                        </li>
                    </ul>
                </div>

                <!-- Starline Games Card -->
                <div class="premium-rate-card">
                    <div class="rate-card-header">
                        <i class="fa fa-star"></i>
                        <h2>Starline Games Win Ratio</h2>
                    </div>
                    <ul class="rate-list">
                        <li class="rate-item">
                            <span class="label">Single Ank</span>
                            <span class="value">10 ka 100</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Single Panna</span>
                            <span class="value">10 ka 1600</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Double Panna</span>
                            <span class="value">10 ka 3,000</span>
                        </li>
                        <li class="rate-item">
                            <span class="label">Triple Panna</span>
                            <span class="value">10 ka 10,000</span>
                        </li>
                    </ul>
                </div>
            </div>

      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>