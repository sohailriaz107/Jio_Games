<!-- More Menu Modal -->
<div class="modal fade" id="moreMenuModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-left" role="document">
    <div class="modal-content premium-menu-content">
      
      <!-- Premium Header -->
      <div class="premium-menu-header">
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 15px; top: 15px; text-shadow: none; opacity: 0.9;">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="user-info-wrapper">
            <div class="user-avatar text-white">
                <i class="fa fa-user-circle"></i>
            </div>
            <div class="user-details">
                <?php if(isset($_SESSION['usr_id'])!=""){ ?>
                <h5 class="text-white" style="font-weight: 700; font-size: 18px; margin-bottom: 2px; margin-top: 1px;"><?php echo $_SESSION['usr_name'];?></h5>
                <small style="color: rgba(255,255,255,0.85); font-weight: 500; font-size: 13px; line-height: 1;"><i class="fa fa-phone"></i> <?php echo str_replace("+91","",$_SESSION['usr_mobile']);?></small>
                <?php }else{ ?>
                <h5 class="text-white" style="font-weight: 700; font-size: 18px; margin-bottom: 2px; margin-top: 1px;">Welcome Guest</h5>
                <small style="color: rgba(255,255,255,0.85); font-weight: 500; font-size: 13px; line-height: 1;">Please login</small>
                <?php } ?>
            </div>
        </div>
      </div>

      <!-- Menu List -->
      <div class="modal-body p-0">
        <div class="premium-menu-list">
            <?php $active_pg = basename($_SERVER['PHP_SELF']); ?>
            <a href="notifications.php" class="premium-menu-item <?php echo ($active_pg == 'notifications.php') ? 'active' : ''; ?>"><i class="fa fa-bell"></i> <span>Notifications</span></a>
            <a href="top-winner-list.php" class="premium-menu-item <?php echo ($active_pg == 'top-winner-list.php') ? 'active' : ''; ?>"><i class="fa fa-trophy"></i> <span>Top Winners</span></a>
            <a href="top-winner-list-starline.php" class="premium-menu-item <?php echo ($active_pg == 'top-winner-list-starline.php') ? 'active' : ''; ?>"><i class="fa fa-trophy"></i> <span>Starline Winners</span></a>
            <a href="game-rates.php" class="premium-menu-item <?php echo ($active_pg == 'game-rates.php') ? 'active' : ''; ?>"><i class="fa fa-tasks"></i> <span>Game Rates</span></a>
            <a href="support.php" class="premium-menu-item <?php echo ($active_pg == 'support.php') ? 'active' : ''; ?>"><i class="fa fa-comments"></i> <span>Help</span></a>
            <a href="download-application.php" class="premium-menu-item <?php echo ($active_pg == 'download-application.php') ? 'active' : ''; ?>"><i class="fa fa-mobile-phone" style="font-size: 22px;"></i> <span>Download App</span></a>
            
            <?php if(isset($_SESSION['usr_id'])!=""){ ?>
            <a href="logout.php" class="premium-menu-item text-danger"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
            <?php } ?>
        </div>
      </div>

    </div>
  </div>
</div>