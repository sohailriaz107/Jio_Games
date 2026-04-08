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
            
            <div class="container" > 
            <div class="tb-10">
            
                
        <?php
        $today_date = date('Y-m-d');
        $result = mysqli_query($con,"SELECT * FROM notification order by id DESC limit 50");
		if(mysqli_num_rows($result)>0){
                 
            while ($row = mysqli_fetch_array($result)){
            ?> 
            <div class="row game-list-inner">
                                <div class="col-12 notifications">
                                  <p class="t"><?php echo $row['title'];?></span></p>
                                  <p class="d"><?php echo $row['description'];?></p>
                                  <p class="time"><?php echo date('M d, Y h:i A',strtotime($row['date'].' '.$row['time']));?></p>
                                  
                                </div>
            </div>
            <?php } ?>
            
        <?php }else{ ?>
             
            <div class="tbmar-40 text-center">
                <p>No record found</p>
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