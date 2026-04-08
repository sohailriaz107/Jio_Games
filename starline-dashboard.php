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
            <div class="card-full-page tb-10">
                
                <div class="text-center tb-10">
                    <h3 class="gdash3">Starline <?php echo $game_title;?> Dashboard</h3>
                    <span>Select Bidding Option</span>
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
                <div class="row bidoptions-list tb-10">
                                <div class="col-4">
                                  <a href="starline-single.php?gid=<?php echo $game_id;?>" class="bidtypebox">
                                      <img src="assets/img/single.png">
                                      <p>Single Ank</p>
                                  </a>
                                </div>
                                
                                
                                <div class="col-4">
                                  <a href="starline-single-patti.php?gid=<?php echo $game_id;?>" class="bidtypebox">
                                      <img src="assets/img/single_patti.png">
                                      <p>Single Patti</p>
                                  </a>
                                </div>
                                
                                <div class="col-4">
                                  <a href="starline-double-patti.php?gid=<?php echo $game_id;?>" class="bidtypebox">
                                      <img src="assets/img/double_patti.png">
                                      <p>Double Patti</p>
                                  </a>
                                </div>

        
                </div>
                
                <div class="row bidoptions-list tb-10">
                                
                                
                                <div class="col-4">
                                  <a href="starline-triple-patti.php?gid=<?php echo $game_id;?>" class="bidtypebox">
                                      <img src="assets/img/triple_patti.png">
                                      <p>Triple Patti</p>
                                  </a>
                                </div>

        
                </div>

                
                <div class="tbmar-40 text-center">
                    <span>Khelo and Jeeto Har Ghante. </span>

                </div>
                
                
                
                <?php }else{ ?>
                
                <div class="tbmar-40 text-center">
                    <span>Sorry! Bidding is Close for <?php echo $game_title;?>. <br> Play for Next One.</span>

        
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