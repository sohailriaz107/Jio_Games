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
    <title>Starline Chart History - <?php echo $site_title;?></title>
    <?php include("include/head.php"); ?>
    <style>
        .chart-container-card {
            background: #fff;
            border-radius: 16px;
            padding: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border: 1px solid #edf2f7;
            overflow: hidden;
        }
        .sl-history-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 11px;
        }
        .sl-history-table thead th {
            background: #f8fafc;
            color: #4a5568;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            padding: 12px 5px;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }
        .sl-history-table tbody td {
            padding: 10px 5px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
            color: #2d3748;
        }
        .date-cell {
            background: #f1f5f9;
            font-weight: 700 !important;
            color: var(--primary-light) !important;
            position: sticky;
            left: 0;
            z-index: 2;
        }
        .result-cell {
            line-height: 1.4;
        }
        .panna-txt { font-weight: 600; color: #4a5568; display: block; margin-bottom: 2px; }
        .ank-txt { 
            display: inline-block;
            background: #ebf4ff;
            color: #3182ce;
            padding: 1px 6px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 12px;
        }
        .day-txt { font-size: 9px; color: #718096; text-transform: uppercase; }
        
        .table-responsive {
            scrollbar-width: thin;
            scrollbar-color: var(--primary-light) #f1f5f9;
        }
        .table-responsive::-webkit-scrollbar { height: 6px; }
        .table-responsive::-webkit-scrollbar-thumb { background: var(--primary-light); border-radius: 10px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            <!-- Hero Section -->
            <div class="premium-hero-banner" style="background: linear-gradient(135deg, #2d3748, #4a5568);">
                <div class="wallet-display text-center">
                    <i class="fa fa-line-chart mb-2" style="font-size: 36px; color: #48bb78; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"></i>
                    <h2 class="brand-text">Chart History</h2>
                    <p class="greeting">Mumbai Starline Panel Records</p>
                </div>
            </div>

            <div class="container py-4">
                <div class="chart-container-card">
                    <div class="table-responsive">
                        <table class="sl-history-table">
                            <thead>
                                <tr>
                                    <th class="date-cell">Date</th>
                                    <th>09 AM</th>
                                    <th>10 AM</th>
                                    <th>11 AM</th>
                                    <th>12 PM</th>
                                    <th>01 PM</th>
                                    <th>02 PM</th>
                                    <th>03 PM</th>
                                    <th>04 PM</th>
                                    <th>05 PM</th>
                                    <th>06 PM</th>
                                    <th>07 PM</th>
                                    <th>08 PM</th>
                                </tr>
                            </thead>
                            <tbody>					
                                <?php 
                                $result = mysqli_query($con, "SELECT * FROM `starline_chart` WHERE date >= '2024-03-28' ORDER BY date DESC");
                                while($objRs = mysqli_fetch_object($result)) {
                                    echo '<tr>';
                                    echo '<td class="date-cell">'.date('d/m/y', strtotime($objRs->date)).'<br><span class="day-txt">'.date('D', strtotime($objRs->date)).'</span></td>';
                                    
                                    for($i=1; $i<=12; $i++) {
                                        $field = "value".$i;
                                        $val = $objRs->$field;
                                        if(!empty($val)) {
                                            $panna = substr($val, 0, 3);
                                            $ank = substr($val, -1);
                                            echo '<td class="result-cell"><span class="panna-txt">'.$panna.'</span><span class="ank-txt">'.$ank.'</span></td>';
                                        } else {
                                            echo '<td>-</td>';
                                        }
                                    }
                                    echo '</tr>';
                                }
                                ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br><br>
        </div>
    </div>
    <?php include("include/footer.php"); ?>
</body>
</html>