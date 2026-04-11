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

    <title>Bidding History Main Markets - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>
            
            <div class="container" style="padding-top: 20px;">
                <div class="tb-10" style="text-align:center; margin-bottom: 30px;">
                    <h1 class="gdash3" style="font-size:24px; font-weight: 800; margin-bottom: 5px;">Bidding History</h1>
                    <p style="font-size:14px; color: #718096; margin-bottom: 0;">Main markets bidding records</p>
                </div>

                <div class="history-list-container">
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
                    
                    if(mysqli_num_rows($result)>0){
                        while ($row = mysqli_fetch_array($result)){
                            $status_class = 'pending';
                            if($row['win'] == '0') $status_class = 'lose';
                            elseif($row['win'] != '' && $row['win'] != 'NULL') $status_class = 'won';
                            ?>
                            
                            <div class="premium-history-card">
                                <div class="history-card-status-bar status-bar-<?php echo $status_class; ?>"></div>
                                <div class="history-card-header">
                                    <span class="game-name"><?php echo $row['game_name'];?></span>
                                    <span class="type-badge"><?php echo $row['game_type'];?></span>
                                </div>
                                <div class="history-card-body">
                                    <div class="history-detail-row">
                                        <div class="detail-item">
                                            <i class="fa fa-calendar"></i>
                                            <span class="label">Date:</span> <?php echo date('d/m/Y',strtotime($row['date']));?>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fa fa-dot-circle-o"></i>
                                            <span class="label">Digit:</span> <?php echo $row['digit'];?>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fa fa-money"></i>
                                            <span class="label">Points:</span> <?php echo number_format($row['amount'],2);?>
                                        </div>
                                        <div class="detail-item">
                                            <i class="fa fa-ticket"></i>
                                            <span class="label">Bid ID:</span> <?php echo $row['id'];?>
                                        </div>
                                    </div>
                                    <div style="font-size: 11px; color: #a0aec0; margin-top: 10px; display: flex; justify-content: space-between;">
                                        <span><i class="fa fa-clock-o"></i> Time: <?php echo date('d/m/Y h:i A',strtotime($row['timestamp']));?></span>
                                        <span><i class="fa fa-info-circle"></i> <?php echo date('l', strtotime($row['timestamp']));?></span>
                                    </div>
                                </div>
                                <div class="history-card-footer">
                                    <?php if($row['win']=='' || $row['win']=='NULL'){?>
                                        <div class="outcome-banner outcome-pending">
                                            <i class="fa fa-hourglass-start"></i> Pending, Wait for Result
                                        </div>
                                    <?php }elseif($row['win']=='0'){ ?>
                                        <div class="outcome-banner outcome-lose">
                                            <i class="fa fa-frown-o"></i> Lose, Better luck next time
                                        </div>
                                    <?php }else{ ?>
                                        <div class="outcome-banner outcome-won">
                                            <i class="fa fa-trophy"></i> Congratulations, you won!
                                        </div>
                                    <?php } ?>
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
                            <i class="fa fa-history"></i>
                            <p>No bidding records found yet.</p>
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