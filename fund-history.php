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

    <title>Fund History - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" > 
            
            <div class="text-center tb-10">
                    <h3 class="gdash3">Fund History</h3>
                    <span style="font-size:12px;">Deposit and Withdraw History</span>
            </div>
            <div class="tb-10">
            <?php
			
			$limit = 10;
            $offset = ($page-1)*$limit;
            $user_id = filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT);
			
			// Count of all records
            $query   = "SELECT COUNT(id) as rowNum FROM user_transaction where user_id='".$user_id."' and (type='deposit' or type='withdraw')";
            $res  = mysqli_query($con,$query); 
            $res1 = mysqli_fetch_assoc($res);
            $allRecrods= $res1['rowNum'];
            $totoalPages = ceil($allRecrods / $limit);
			

             $qry = "SELECT * from user_transaction WHERE (type='deposit' or type='withdraw') and user_id='".$user_id."' order by id DESC LIMIT $offset,$limit";
             $result = mysqli_query($con,$qry);
             $data["records"]=array();
             if(mysqli_num_rows($result)>0){
                 
                 while ($row = mysqli_fetch_array($result)){
                     
		            
		            if($row['type'] =='deposit' && $row['title'] =='Debited By Admin'){
                    $narration = 'Credited By Admin';
                    $status = 'Success';
                    }
                    		            
                    if($row['type'] =='deposit' && $row['title'] =='upi'){
                    $narration = 'Credited By UPI';
                    $status = 'Success';
                    }
                    		            
                    if($row['type'] =='deposit' && $row['title'] ==''){
                    $narration = 'Credited By Other';
                    $status = 'Success';
                    }
		            
		            if($row['type'] =='withdraw'){
		            $narration = 'Withdraw';
		                if($row['status'] ==1)
                         {$status = 'Pending';
                         }elseif($row['status'] ==2)
                         {$status = 'Approved';
                         }else{$status = 'Canceled';}
    		        }
		            
					
             
                $data_item=array(
                    "id" => $row['id'],
                    "narration" => $narration,
                    "trans_type" => ucfirst($row['debit_credit']),
                    "amount" => number_format($row['amount'],2)
                );
                array_push($data["records"], $data_item);
                
                
                ?>
                <div class="history-list-box">
                    <?php if($row['debit_credit']=='debit'){ ?>
                        <div class="fixed-debit"><?php echo ucfirst($row['debit_credit']);?></div>
                    <?php }else{ ?>
                        <div class="fixed-credit"><?php echo ucfirst($row['debit_credit']);?></div>
                    <?php } ?>
                    
                    
                    
                    
                    <div class="row bid-row">
                        <div class="col-12 gm-name"><?php echo $narration;?></div>
                    </div>
                    
                    <div class="row bid-row">
                        <div class="col-4"> <span class="dark">Amount:</span> <?php echo number_format($row['amount'],2);?></div>
                        <div class="col-4"> <span class="dark">Ref ID:</span> <?php echo $row['id'];?></div>
                        <div class="col-4"> <span class="dark">Status:</span> <?php echo $status;?></div>
                        
                    </div>
                    
                    <p class="bid-time"> <i class="fa fa-calendar-times-o" aria-hidden="true"></i> <?php echo date('d/m/Y h:i A',strtotime($row['timestamp']));?> </p>
                   
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