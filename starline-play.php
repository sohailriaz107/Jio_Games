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

    <title>Starline - Play and Win </title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            <div id="scroll-container" class="noticebr"><div id="scroll-text"><?php echo get_SettingValue('app_notice');?></div></div>
            
            <div class="container text-center " >    
            <div class="tb-10">
                  <div class="row">
                    <div class="col-6">
                      <a href="#" class="home-sl-box">Play Big & Win Big <br> <span>Har Ghante Jeeto</span></a>
                    </div>
                    <div class="col-6"> 
                      <a href="starline-chart-history.php" class="home-sl-box">Starline Chart <br> <span> View Old Record</span></a>
                    </div>
                  </div>
            </div>
            </div>
            

            
            <div class="container text-center" > 
            <div class="tb-10">
            
                <?php
                $games_list_qry =  "SELECT * FROM starline where 1";
				$games = mysqli_query($con, $games_list_qry);
                         while ($row = mysqli_fetch_array($games)){
                            $game_id = $row['id'];
                            $game_name = $row['name'];
                            $result = get_StarlineResult($game_id);
                            
                            $print_result = $result;
                            
                            $startline_time = strtotime(date('Y-m-d').' '.$row['time']);
                ?>    
                        
                        <div class="row game-list-inner">
                                <div class="col-4">
                                  <span class="sgameName"> <?php echo $game_name;?> </span>
                                </div>
                                <div class="col-4"> 
                                      <span class="sgameResut"> <?php echo $print_result;?> </span>
                                </div>
                                <div class="col-4 splaydiv"> 
                                <?php if(time() < $startline_time){ ?>
                                  <a href="starline-dashboard.php?game=<?php echo $game_name;?>&gid=<?php echo $game_id;?>" class="sgame-play"> Play</a>
                                <?php }else{?>
                                 <!--<a class="game-play gray"> <i class="fa fa-play-circle"></i><br>Play Game</a>-->
                                <?php } ?>
                                </div>
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