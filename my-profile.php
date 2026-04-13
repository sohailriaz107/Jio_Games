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
                
                <div class="premium-auth-card" style="text-align: center; padding: 25px 15px; margin-bottom: 25px;">
                    <i class="fa fa-user-circle" style="font-size: 60px; color: var(--primary-light); margin-bottom: 10px;"></i>
                    <h3 style="margin-bottom: 5px; font-size: 20px; font-weight: 700; color: #2d3748;"><?php echo isset($_SESSION['usr_name']) ? $_SESSION['usr_name'] : 'Guest'; ?></h3>
                    <p style="color: #718096; font-size: 14px; font-weight: 500; margin: 0;"><i class="fa fa-phone"></i> <?php echo isset($_SESSION['usr_mobile']) ? str_replace("+91","",$_SESSION['usr_mobile']) : 'N/A'; ?></p>
                </div>

                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px;">
                     <a href="update-bank-details.php" class="mplist" style="text-decoration:none; color:#2d3748; font-weight:600; display:flex; align-items:center; width:100%;"><i class="fa fa-university" style="margin-right:15px; color:var(--primary-light); font-size:22px;"></i> Bank Details</a>
                </div>
                
                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px;">
                     <a href="change-password.php" class="mplist" style="text-decoration:none; color:#2d3748; font-weight:600; display:flex; align-items:center; width:100%;"><i class="fa fa-key" style="margin-right:15px; color:var(--primary-light); font-size:22px;"></i> Change Password</a>
                </div>

                <div class="premium-game-card" style="width: 100%; padding: 15px; margin-bottom: 20px; border-left: 4px solid #f5365c;">
                     <a href="logout.php" class="mplist" style="text-decoration:none; color:#f5365c; font-weight:700; display:flex; align-items:center; width:100%;"><i class="fa fa-sign-out" style="margin-right:15px; color:#f5365c; font-size:22px;"></i> Logout Account</a>
                </div>
                        
            </div>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>