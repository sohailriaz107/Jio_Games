<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    //include("include/session.php");
	include("include/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Starline Chart History - <?php echo $site_title;?></title>
    
    <?php include("include/head.php"); ?>
</head>

<body>

    <div class="wrapper">
        
        <?php //include("include/sidebar.php"); ?>
        <div id="content">
            <?php //include("include/nav.php"); ?>
            
            <div class="container" > 
            
            <div class="text-center tb-10">
                    <h3 class="gdash3">Starline Chart History</h3>
                    <span style="font-size:12px;">Milan Starline Panel Chart</span>
            </div>
            <div class="tb-10">
			<div class="table-responsive">
            <table class="table table-striped starline-chart-table">
                	<thead>
                	<tr>
                		<th class="text-center">Date</th>
                		<th class="text-center">09 AM</th>
                		<th class="text-center">10 AM</th>
                		<th class="text-center">11 PM</th>
                		<th class="text-center">12 PM</th>
                		<th class="text-center">01 PM</th>
						<th class="text-center">02 PM</th>
						<th class="text-center">03 PM</th>
						<th class="text-center">04 PM</th>
						<th class="text-center">05 PM</th>
						<th class="text-center">06 PM</th>
						<th class="text-center">07 PM</th>
						<th class="text-center">08 PM</th>

						
                	</tr>
                	</thead> 
					<tbody>					
						<?php 
						$result = mysqli_query($con,"SELECT * FROM `starline_chart` WHERE date >= '2023-02-01' ");
						while($objRs = mysqli_fetch_object($result)) {
						echo '<tr><td class="f">
						'.date('d/m/y', strtotime($objRs->date)).'<br>'.date('D', strtotime($objRs->date)).
						'</td><td >'.substr($objRs->value1,0,3).'<br>'.substr($objRs->value1,-1).
						'</td><td >'.substr($objRs->value2,0,3).'<br>'.substr($objRs->value2,-1).
						'</td><td >'.substr($objRs->value3,0,3).'<br>'.substr($objRs->value3,-1).
						'</td><td >'.substr($objRs->value4,0,3).'<br>'.substr($objRs->value4,-1).
						'</td><td >'.substr($objRs->value5,0,3).'<br>'.substr($objRs->value5,-1).
						'</td><td >'.substr($objRs->value6,0,3).'<br>'.substr($objRs->value6,-1).
						'</td><td >'.substr($objRs->value7,0,3).'<br>'.substr($objRs->value7,-1).
						'</td><td >'.substr($objRs->value8,0,3).'<br>'.substr($objRs->value8,-1).
						'</td><td >'.substr($objRs->value9,0,3).'<br>'.substr($objRs->value9,-1).
						'</td><td >'.substr($objRs->value10,0,3).'<br>'.substr($objRs->value10,-1).
						'</td><td >'.substr($objRs->value11,0,3).'<br>'.substr($objRs->value11,-1).
						'</td><td >'.substr($objRs->value12,0,3).'<br>'.substr($objRs->value12,-1).
						'</td></tr>';

						}

						?> 
					</tbody>
					</table>

         
            </div>
			</div>
            
            <br><br><br>
            </div>
      
            
        </div>
    </div>
    
    <?php //include("include/footer.php"); ?>

</body>

</html>