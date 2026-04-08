<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");


if($_GET['page'] >0)
    {
		$page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);
    }else{
        $page =1;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Bidding History Main Markets - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" > 
            
            <div class="text-center tb-10">
                    <h3 class="gdash3">Bidding History</h3>
                    <span style="font-size:12px;">Main markets bidding records</span>
            </div>
            <div class="tb-10">
            <?php
            
            $limit = 10;
            $offset = ($page-1)*$limit;
            $user_id = filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT);
            // Count of all records
            $query   = "SELECT COUNT(id) as rowNum FROM user_transaction where user_id='".$user_id."' and type='bid' and starline='0'";
            $res  = mysqli_query($con,$query); 
            $res1 = mysqli_fetch_assoc($res);
            $allRecrods= $res1['rowNum'];
            $totoalPages = ceil($allRecrods / $limit);
            
            
            
             $qry = "SELECT user_transaction.*, games.name as game_name FROM user_transaction INNER JOIN games ON user_transaction.game_id = games.id WHERE user_id='".$user_id."' AND user_transaction.type='bid' AND user_transaction.starline='0' order by id DESC LIMIT $offset,$limit";
             $result = mysqli_query($con,$qry);
             $data["records"]=array();
             if(mysqli_num_rows($result)>0){
                 
                 while ($row = mysqli_fetch_array($result)){
		            
		         
		         if($row['win']=='' || $row['win']=='NULL'){
		              $game_result = 'Pending';
		          }elseif($row['win']=='0')
		          {
		              $game_result = 'LOSE';
		          }else{
		              $game_result = $row['win'];
		          }
                
                
                ?>
                <div class="history-list-box">
                    <div class="fixed"><?php echo $row['game_type'];?></div>
                    
                    
                    
                    <div class="row bid-row">
                        <div class="col-12 gm-name"><?php echo $row['game_name'];?></div>
                    </div>
                    
                    <div class="row bid-row">
                        <div class="col-6"> <span class="dark">Play On:</span> <?php echo date('d/m/Y',strtotime($row['timestamp'])).'('.date('l', strtotime($row['timestamp'])).')';?></div>
                        <div class="col-6"> <span class="dark">Play for:</span> <?php echo date('d/m/Y',strtotime($row['date'])).'('.date('l', strtotime($row['date'])).')';?></div>
                    </div>
                    
                    
                    <div class="row bid-row">
                        <div class="col-6"> <span class="dark">Digit:</span> <?php echo $row['digit'];?></div>
                        <div class="col-6"> <span class="dark">Points:</span> <?php echo number_format($row['amount'],2);?></div>
                    </div>
                    
                    
                    
                    <div class="row bid-row">
                        <div class="col-6"> <span class="dark">Bid ID:</span> <?php echo $row['id'];?></div>
                        <div class="col-6"> <span class="dark">Bid Time:</span> <?php echo date('d/m/Y h:i A',strtotime($row['timestamp']));?></div>
                    </div>
                    
                    <?php if($row['win']=='' || $row['win']=='NULL'){?>
                            <p class="bid-pending"> Pending, Wait for Result <i class="fa fa-hourglass-start" aria-hidden="true"></i> </p>
                            <?php }elseif($row['win']=='0'){ ?>
                           <p class="bid-lose"> Lose, Please try again. <i class="fa fa-frown-o" aria-hidden="true"></i> </p>
                            
                            <?php }else{ ?>
                            <p class="bid-won"> Congratulations, you won! <i class="fa fa-trophy" aria-hidden="true"></i></p>
                    <?php } ?>
                    </div>
                    
                    
            <?php  } ?>
            
            <?php if($page == 1){?>
            <a href="?page=<?php echo $page-1;?>" class="btn btn-theme disabled" style="float: left;"><< Previous</a> 
            <?php }else{?> 
            <a href="?page=<?php echo $page-1;?>" class="btn btn-theme" style="float: left;"><< Previous</a> 
            <?php } ?>
           
            
            <?php if($page == $totoalPages){?>
            <a href="?page=<?php echo $page+1;?>" class="btn btn-theme disabled" style="float: right;">Next >></a>
            <?php }else{?>
            
            <a href="?page=<?php echo $page+1;?>" class="btn btn-theme" style="float: right;">Next >></a>
            <?php } ?>
            
            <br><br>
            <?php }else{?>
             
                <div class="tbmar-40 text-center">
                    <p>No Record Found.</p>
                </div>
                
             <?php } ?>
         
            </div>
            
            <br><br><br>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>