<nav class="navbar top-app-bar" style="background: var(--primary-light); padding: 12px 15px; position: sticky; top: 0; z-index: 1040; box-shadow: 0 3px 15px rgba(0,0,0,0.08);">
    <div class="container-fluid d-flex justify-content-between align-items-center" style="position: relative;">
        
        <!-- Left: App Brand -->
        <div class="d-flex align-items-center" style="z-index: 2;">
            <a href="<?php echo defined('SITEURL') ? SITEURL : 'index.php'; ?>" class="app-brand" style="color: white; font-weight: 700; font-size: 21px; text-decoration: none; letter-spacing: 0.5px;">
                RATAN777
            </a>
        </div>
        
        <!-- Right: Wallet / Login Block -->
        <div class="d-flex align-items-center" style="z-index: 2;">
            <?php if(isset($_SESSION['usr_id'])!="") { ?>
            <a href="add-fund.php" class="btn" style="background: #ffffff; color: var(--primary-light); border-radius: 20px; padding: 6px 14px; font-weight: 700; font-size: 13px; text-decoration: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                Wallet : <i class="fa fa-inr" style="font-size: 12px;"></i> <?php echo get_lastBalance($_SESSION['usr_id']); ?>
            </a>
            <?php }else{ ?>
            <a href="login.php" class="btn" style="background: #ffffff; color: var(--primary-light); border-radius: 20px; padding: 6px 18px; font-weight: 700; font-size: 13px; text-decoration: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <i class="fa fa-sign-in"></i> Login
            </a>
            <?php } ?>
        </div>
    </div>
</nav>