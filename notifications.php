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

    <title>Notifications - <?php echo $site_title;?></title>
    <meta name="description" content="Latest Notification list of <?php echo $site_title;?>">
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" style="padding-top: 20px;">
                <div class="tb-10" style="text-align:center; margin-bottom: 30px;">
                    <h1 class="gdash3" style="font-size:24px; font-weight: 800; margin-bottom: 5px;">Notifications</h1>
                    <p style="font-size:14px; color: #718096; margin-bottom: 0;">Stay updated with latest news and alerts</p>
                </div>
            
                <div class="notif-list-container">
                    <?php
                    $today_date = date('Y-m-d');
                    $result = mysqli_query($con,"SELECT * FROM notification order by id DESC limit 50");
                    if(mysqli_num_rows($result)>0){
                        while ($row = mysqli_fetch_array($result)){
                        ?> 
                        <div class="notification-card">
                            <div class="notif-icon-circle">
                                <i class="fa fa-bell-o"></i>
                            </div>
                            <div class="notif-content">
                                <h3 class="notif-title"><?php echo $row['title'];?></h3>
                                <p class="notif-desc"><?php echo $row['description'];?></p>
                                <span class="notif-time"><i class="fa fa-clock-o"></i> <?php echo date('M d, Y h:i A',strtotime($row['date'].' '.$row['time']));?></span>
                            </div>
                        </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="empty-state">
                            <i class="fa fa-bell-slash-o"></i>
                            <p>No notifications found. You're all caught up!</p>
                        </div>
                    <?php } ?>    
                </div>
            </div>

      
        <br><br><br>  
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>