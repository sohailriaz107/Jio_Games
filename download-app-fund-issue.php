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

<title>Download Mobile application - <?php echo $site_title;?></title>
<meta name="description" content="Download Mobile application and stay connected with us.">
<?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            
            <div class="container" >    
            <div class="tb-10">
                  <div class="row">
                    <div class="col-12"> 
                      <div style="display: flex; align-items: center;">
									<img src="assets/img/app-home.webp" style="width: 150px; height: auto; margin-right: 20px;">
									<div>
										<p style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">DOWNLOAD OUR APP</p>
										<p>Add Fund Issue is Fixed on our Android Application. Downlaod and Enjoy.</p>
										<a href="https://jiogames.app/apk/JioGames_V102.apk" style="background-color: #b73800; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;text-decoration:none;"> <i class="fa fa-download"></i> Download Now</a>
									</div>
								</div>
                    </div>
                  </div>
            </div>
            </div> 
        </div>
    </div>
	
	
<?php include("include/footer.php"); ?>


</body>

</html>