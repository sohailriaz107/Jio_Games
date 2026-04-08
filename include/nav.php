<nav class="navbar navbar-expand-lg">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn menu-btn" title="Menu">
                        <i class="fa fa-align-left" style="-webkit-text-stroke: 2px var(--primary-light);"></i>
                        <span>&nbsp</span> 
                    </button> 
                    
                    <span style="font-weight:700;color:white;">Jio games</span>
                    <?php
                        if(isset($_SESSION['usr_id'])!="") {
                    ?>
                    <a href="add-fund.php" class="btn btn-white d-inline-block ml-auto" type="button" >
                        <span class="walletamt"><i class="fa fa-inr" aria-hidden="true"></i>  <?php echo get_lastBalance($_SESSION['usr_id']); ?></span>
                    </a>
                    
                    <?php }else{ ?>
                    <a href="login.php" class="btn btn-white d-inline-block ml-auto" type="button" >
                        <i class="fa fa-sign-in"></i>&nbsp;&nbsp;<span>Login</span>
                    </a>
                    <?php } ?>


                </div>
            </nav>