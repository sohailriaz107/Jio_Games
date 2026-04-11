<style>
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 65px;
    background: #ffffff;
    display: flex;
    justify-content: space-around;
    align-items: center;
    box-shadow: 0 -5px 25px rgba(0,0,0,0.06);
    z-index: 1040;
    padding-bottom: env(safe-area-inset-bottom);
}

.bottom-nav-item {
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #8e8e93;
    font-size: 11px;
    font-weight: 500;
    transition: all 0.2s ease;
    flex: 1;
}

.bottom-nav-item i {
    font-size: 20px;
    margin-bottom: 4px;
}

.bottom-nav-item.active {
    color: var(--primary-blue);
}

.bottom-nav-item.active i {
    color: var(--primary-blue);
}

/* Specific styling for a center action button if needed */
.bottom-nav-item.center-action {
    position: relative;
    top: -15px;
}

.bottom-nav-item.center-action .icon-circle {
    width: 50px;
    height: 50px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    box-shadow: 0 8px 20px rgba(0,68,187,0.3);
}

.bottom-nav-item.center-action i {
    margin-bottom: 0;
    font-size: 22px;
}
</style>

<div class="bottom-nav">
    <a href="index.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
        <i class="fa fa-home"></i>
        <span>Home</span>
    </a>
    <a href="fund-history.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'fund-history.php') ? 'active' : ''; ?>">
        <i class="fa fa-history"></i>
        <span>History</span>
    </a>
    <a href="add-fund.php" class="bottom-nav-item center-action">
        <div class="icon-circle">
            <i class="fa fa-plus"></i>
        </div>
        <span style="margin-top: 5px;">Add Fund</span>
    </a>
    <a href="bidding-history.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bidding-history.php') ? 'active' : ''; ?>">
        <i class="fa fa-trophy"></i>
        <span>Bids</span>
    </a>
    <a href="my-profile.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'my-profile.php') ? 'active' : ''; ?>">
        <i class="fa fa-user"></i>
        <span>Account</span>
    </a>
</div>

<script>
    // Add class to body to prevent content from being hidden behind nav
    document.body.classList.add('has-bottom-nav');
</script>
