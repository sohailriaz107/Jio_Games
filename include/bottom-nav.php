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


</style>

<div class="bottom-nav">
    <a href="index.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
        <i class="fa fa-home"></i>
        <span>Home</span>
    </a>
    <a href="notifications.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'notifications.php') ? 'active' : ''; ?>">
        <i class="fa fa-bell"></i>
        <span>Notifications</span>
    </a>
    <a href="bidding-history.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'bidding-history.php' || basename($_SERVER['PHP_SELF']) == 'bidding-history-starline.php') ? 'active' : ''; ?>">
        <i class="fa fa-history"></i>
        <span>Bids</span>
    </a>
    <a href="my-profile.php" class="bottom-nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'my-profile.php') ? 'active' : ''; ?>">
        <i class="fa fa-user-circle"></i>
        <span>Profile</span>
    </a>
</div>

<script>
    // Add class to body to prevent content from being hidden behind nav
    document.body.classList.add('has-bottom-nav');
</script>
