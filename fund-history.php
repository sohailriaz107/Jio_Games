<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");


if (isset($_GET['page']) && $_GET['page'] > 0)
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
            
            <div class="container" style="padding-top: 20px;">
                <div class="tb-10" style="text-align:center; margin-bottom: 30px;">
                    <h1 class="gdash3" style="font-size:24px; font-weight: 800; margin-bottom: 5px;">Fund History</h1>
                    <p style="font-size:14px; color: #718096; margin-bottom: 0;">Deposit and Withdraw History</p>
                </div>

                <div class="history-list-container">
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
                                if($row['status'] ==1) { $status = 'Pending'; }
                                elseif($row['status'] ==2) { $status = 'Approved'; }
                                else { $status = 'Canceled'; }
                            }

                            $status_bar_class = ($row['debit_credit'] == 'debit') ? 'debit' : 'credit';
                            $status_tag_class = 'outcome-pending';
                            if ($status == 'Approved' || $status == 'Success') $status_tag_class = 'outcome-won';
                            elseif ($status == 'Canceled') $status_tag_class = 'outcome-lose';
                            ?>
                            
                            <div class="premium-history-card">
                                <div class="history-card-status-bar status-bar-<?php echo $status_bar_class; ?>"></div>
                                <div class="history-card-header">
                                    <span class="game-name"><?php echo $narration;?></span>
                                    <span class="type-badge" style="background: <?php echo ($row['debit_credit'] == 'debit') ? '#fff5f5' : '#e6ffed'; ?>; color: <?php echo ($row['debit_credit'] == 'debit') ? '#c53030' : '#1e7e34'; ?>;">
                                        <?php echo ucfirst($row['debit_credit']);?>
                                    </span>
                                </div>
                                <div class="history-card-body">
                                    <div class="history-detail-row">
                                        <div class="detail-item">
                                            <i class="fa fa-money"></i>
                                            <span class="label">Amount:</span> <span style="font-weight: 700; color: <?php echo ($row['debit_credit'] == 'debit') ? '#c53030' : '#1e7e34'; ?>;"><?php echo number_format($row['amount'],2);?></span>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fa fa-hashtag"></i>
                                            <span class="label">Ref ID:</span> <?php echo $row['id'];?>
                                        </div>
                                        <div class="detail-item" style="flex: 1 1 100%;">
                                            <i class="fa fa-info-circle"></i>
                                            <span class="label">Status:</span> 
                                            <span class="outcome-banner <?php echo $status_tag_class; ?>" style="display: inline-block; width: auto; padding: 2px 10px; font-size: 12px; margin-left: 5px; vertical-align: middle;">
                                                <?php echo $status;?>
                                            </span>
                                        </div>
                                    </div>
                                    <div style="font-size: 11px; color: #a0aec0; margin-top: 10px;">
                                        <span><i class="fa fa-calendar"></i> <?php echo date('d/m/Y h:i A',strtotime($row['timestamp']));?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="pagination-container">
                            <a href="?page=<?php echo $page-1;?>" class="btn btn-theme btn-pill <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <i class="fa fa-chevron-left"></i> Previous
                            </a> 
                            <span style="font-weight: 700; color: #4a5568;">Page <?php echo $page; ?> of <?php echo $totoalPages; ?></span>
                            <a href="?page=<?php echo $page+1;?>" class="btn btn-theme btn-pill <?php echo ($page >= $totoalPages) ? 'disabled' : ''; ?>">
                                Next <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>
                    <?php }else{ ?>
                        <div class="empty-state">
                            <i class="fa fa-bank"></i>
                            <p>No fund transaction records found yet.</p>
                        </div>
                    <?php } ?>    
                </div>
            </div>

            
            <br><br><br>
            </div>
      
            
        </div>
    </div>
    
    <?php include("include/footer.php"); ?>

</body>

</html>