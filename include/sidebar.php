<!-- Sidebar  -->
        <nav id="sidebar">
            <div id="dismiss">
                <i class="fa fa-arrow-left"></i>
            </div>

            <div class="sidebar-header">
                <?php
                    if(isset($_SESSION['usr_id'])!="") {
                ?>
                <span class="Uname"><?php echo $_SESSION['usr_name'];?></span>
                <span class="Umobile"><?php echo str_replace("+91","",$_SESSION['usr_mobile']);?></span>
                <?php }else{ ?>
                <span class="Uname">Hello User</span>
                <span class="Umobile">Welcome Back</span>
                <?php } ?>
            </div>

            <ul class="list-unstyled components sideMenu">
                <li><a href="<?php echo SITEURL;?>"> <i class="fa fa-home"></i> <span>Home</span></a></li>
                <li><a href="transaction-history.php"> <i class="fa fa-list-alt"></i> <span>Transaction History</span></a></li>
                <li><a href="bidding-history.php"> <i class="fa fa-list"></i> <span>Bidding History</span></a></li>
                <li><a href="bidding-history-starline.php"> <i class="fa fa-list"></i> <span>Starline Bid History</span></a></li>
                <li><a href="fund-history.php"> <i class="fa fa-money"></i> <span>Fund History</span></a></li>
                <li><a href="notifications.php"> <i class="fa fa-bell"></i> <span>Notifications</span></a></li>
                <li><a href="top-winner-list.php"> <i class="fa fa-trophy"></i> <span>Top Winners</span></a></li>
                <li><a href="top-winner-list-starline.php"> <i class="fa fa-trophy"></i> <span>Starline Winners</span></a></li>
                <li><a href="game-rates.php"> <i class="fa fa-tasks"></i> <span>Game Rates</span></a></li>
				<li><a href="download-application.php"> <i class="fa fa-mobile"></i> <span>Download App</span></a></li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="my-profile.php" class="download">My Profile</a>
                </li>
                <li>
                    <a href="logout.php" class="article">Logout</a>
                </li>
            </ul>
        </nav>