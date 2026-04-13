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

    <title>Game Rates - Jio Games</title>
    
    <?php include("include/head.php"); ?>
    <style>
        .page-header { background: var(--primary-gradient); padding: 30px 20px; border-radius: 0 0 30px 30px; text-align: center; color: white; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,68,187,0.1); }
        .page-header h1 { font-size: 24px; font-weight: 800; margin: 0; color: #fff !important; }
        .page-header p { font-size: 14px; margin-top: 8px; font-weight: 700; color: #FFD700 !important; letter-spacing: 0.5px; text-shadow: 0 1px 3px rgba(0,0,0,0.2); }

        .section-title-wrapper { margin-bottom: 15px; padding: 0 10px; text-align: center; }
        .section-title { font-size: 16px; font-weight: 800; color: #1a202c; display: inline-block; position: relative; padding-bottom: 8px; text-align: center; }
        .section-title::after { content: ''; position: absolute; left: 50%; transform: translateX(-50%); bottom: 0; width: 40px; height: 3px; background: var(--primary-blue); border-radius: 2px; }

        .rates-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 40px; padding: 0 10px; }

        .rate-card { background: #fff; border-radius: 15px; padding: 15px 10px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05); transition: transform 0.2s; }
        .rate-card:active { transform: scale(0.98); }

        .icon-container { width: 40px; height: 40px; background: #f0f7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; color: var(--primary-blue); font-size: 18px; }
        
        .rate-name { font-size: 13px; font-weight: 800; color: #2d3748; margin-bottom: 4px; }
        .rate-value { font-size: 11px; font-weight: 600; color: #718096; letter-spacing: 0.5px; }

        @media (min-width: 768px) {
            .rates-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; }
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="page-header">
                <h1>Game Rate List</h1>
                <p>We Offer Best Rate in Market</p>
            </div>

            <div class="container pb-5">
                
                <div class="section-title-wrapper">
                    <h2 class="section-title">Main Games Win Ratio</h2>
                </div>

                <div class="rates-grid">
                    <?php 
                    $main_rates = [
                        ['Single Ank', '10 ka 95', 'fa-dot-circle-o'],
                        ['Jodi', '10 ka 950', 'fa-link'],
                        ['Single Panna', '10 ka 1400', 'fa-th-large'],
                        ['Double Panna', '10 ka 2800', 'fa-th'],
                        ['Triple Panna', '10 ka 6,000', 'fa-cubes'],
                        ['Half Sangam', '10 ka 10,000', 'fa-puzzle-piece'],
                        ['Full Sangam', '10 ka 1,00,000', 'fa-trophy']
                    ];
                    foreach($main_rates as $rate) { ?>
                        <div class="rate-card">
                            <div class="icon-container">
                                <i class="fa <?php echo $rate[2]; ?>"></i>
                            </div>
                            <h3 class="rate-name"><?php echo $rate[0]; ?></h3>
                            <p class="rate-value"><?php echo $rate[1]; ?></p>
                        </div>
                    <?php } ?>
                </div>

                <div class="section-title-wrapper">
                    <h2 class="section-title">Starline Games Win Ratio</h2>
                </div>

                <div class="rates-grid">
                    <?php 
                    $starline_rates = [
                        ['Single Ank', '10 ka 100', 'fa-star'],
                        ['Single Panna', '10 ka 1600', 'fa-th-large'],
                        ['Double Panna', '10 ka 3,000', 'fa-th'],
                        ['Triple Panna', '10 ka 10,000', 'fa-cubes']
                    ];
                    foreach($starline_rates as $rate) { ?>
                        <div class="rate-card">
                            <div class="icon-container">
                                <i class="fa <?php echo $rate[2]; ?>"></i>
                            </div>
                            <h3 class="rate-name"><?php echo $rate[0]; ?></h3>
                            <p class="rate-value"><?php echo $rate[1]; ?></p>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>
</body>

</html>