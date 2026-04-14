<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
include("include/connect.php");
include("include/session.php");
include("include/functions.php");

$user_id = isset($_SESSION['usr_id']) ? filter_var($_SESSION['usr_id'], FILTER_SANITIZE_NUMBER_INT) : '';

if (empty($user_id)) {
    echo "<script>window.location = 'login.php';</script>";
    exit;
}

// Get user info and check status
$qry = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($qry);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_info = $stmt->get_result();

if ($row = $user_info->fetch_assoc()) {
    $account_holder_name = $row['account_holder_name'];
    $account_number = $row['account_number'];
    $ifsc = $row['ifsc'];
    $bank_name = $row['bank_name'];
    $current_balance = $row['balance'];

    if ($row['status'] == 0) {
        session_unset();
        session_destroy();
        setcookie("usr_id", "", time() - 3600, "/");
        echo "<script>window.location = 'logout.php';</script>";
        exit;
    }
} else {
    echo "<script>window.location = 'logout.php';</script>";
    exit;
}

// Calculate Winning Amount
$query_win = "SELECT SUM(amount) as winning_amount FROM user_transaction WHERE user_id = ? AND type = 'win'";
$stmt_win = $con->prepare($query_win);
$stmt_win->bind_param("i", $user_id);
$stmt_win->execute();
$res_win = $stmt_win->get_result();
$win_row = $res_win->fetch_assoc();
$winningAmount = $win_row['winning_amount'] ?? 0;

// Calculate already withdrawn or pending withdraws to get net winning balance
$query_withdrawn = "SELECT SUM(amount) as withdrawn_amount FROM user_transaction WHERE user_id = ? AND type = 'withdraw'";
$stmt_withdrawn = $con->prepare($query_withdrawn);
$stmt_withdrawn->bind_param("i", $user_id);
$stmt_withdrawn->execute();
$res_withdrawn = $stmt_withdrawn->get_result();
$withdrawn_row = $res_withdrawn->fetch_assoc();
$withdrawnAmount = $withdrawn_row['withdrawn_amount'] ?? 0;

$netWinningBalance = $current_balance;

// Handle Withdrawal Request
if (isset($_POST['withdraw'])) {
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
    $date = date('Y-m-d');
    $time = date('h:i:s A');

    if ($current_balance <= 0) {
        echo "<script>alert('You do not have sufficient balance in your wallet.'); window.location = 'withdraw.php?invalidrequest';</script>";
        exit;
    }
    
    if ($amount > $current_balance) {
        echo "<script>window.location = 'withdraw.php?insufficientbalance';</script>";
    } elseif ($amount < 1000) {
        echo "<script>alert('Minimum withdrawal amount is 1000'); window.location = 'withdraw.php?invalidrequest';</script>";
    } else {
        $new_balance = $current_balance - $amount;
        UpdateBalanceInUserTable($user_id, $new_balance);
        
        $stmt_ins = $con->prepare("INSERT INTO user_transaction(user_id, game_id, game_type, digit, date, time, amount, type, debit_credit, balance, status, api_response) 
                                VALUES(?, '', 'withdraw', '', ?, ?, ?, 'withdraw', 'debit', ?, '1', 'from Website mobi')");
        $stmt_ins->bind_param("issss", $user_id, $date, $time, $amount, $new_balance);
        $res = $stmt_ins->execute();

        if ($res) {
            $sql_total_withdrawal = "UPDATE users SET total_withdrawal = (total_withdrawal + ?) WHERE id=?";
            $stmt_total_withdrawal = $con->prepare($sql_total_withdrawal);
            $stmt_total_withdrawal->bind_param("ii", $amount, $user_id);
            $stmt_total_withdrawal->execute();
            echo "<script>window.location = 'withdraw.php?detailupdated';</script>";
        } else {
            echo "<script>window.location = 'withdraw.php?notupdated';</script>";
        }
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Withdraw Fund - <?php echo $site_title;?></title>
    <?php include("include/head.php"); ?>
</head>
<body>
    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            <!-- Hero Section -->
            <div class="premium-hero-banner">
                <div class="wallet-display">
                    <p class="greeting">Available for Withdrawal</p>
                    <h2 class="brand-text"><i class="fa fa-inr"></i> <?php echo number_format($current_balance, 2); ?></h2>
                    <small style="opacity: 0.8;">Wallet Balance</small>
                </div>
            </div>

            <div class="container" style="margin-top: 20px;">
                <div class="premium-auth-card">
                    <div class="text-center mb-4">
                        <i class="fa fa-university" style="font-size: 40px; color: var(--primary-light); margin-bottom: 15px;"></i>
                        <h3 class="mt-2">Withdraw Fund</h3>
                        <p class="text-muted">Fast & Secure Bank Transfers</p>
                    </div>

                    <?php if(empty($account_number)) { ?>
                        <div class="alert alert-warning text-center" style="border-radius: 12px; border: 1px dashed #f39c12; background: #fffdf7; padding: 20px;">
                            <i class="fa fa-exclamation-triangle" style="font-size: 30px; color: #f39c12; margin-bottom: 10px; display: block;"></i>
                            <p style="font-weight: 600; color: #856404; margin-bottom: 15px;">Bank Details Missing!</p>
                            <p style="font-size: 13px; color: #856404; margin-bottom: 20px;">Kindly update your bank details first so we can process your withdrawal.</p>
                            <a href="update-bank-details.php" class="btn-theme" style="padding: 10px 20px; text-decoration: none; border-radius: 30px; font-weight: 600; display: inline-block;">Update Bank Details</a>
                        </div>
                    <?php } else { ?>
                        <!-- Quick Info Cards -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div style="background: #f8faff; border: 1px solid #eef2ff; border-radius: 12px; padding: 15px;">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa fa-bank text-primary mr-2" style="color: var(--primary-light);"></i>
                                        <span style="font-weight: 700; color: #2d3748; font-size: 14px;">Receiving Account</span>
                                    </div>
                                    <p class="mb-0" style="font-size: 13px; color: #4a5568;">
                                        <strong><?php echo $bank_name; ?></strong><br>
                                        Acc: <?php echo substr($account_number, 0, 4) . '****' . substr($account_number, -4); ?> (<?php echo $account_holder_name; ?>)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="" method="POST" autocomplete="off">
                            <div class="form-group mb-4">
                                <label><i class="fa fa-money"></i> Withdrawal Amount</label>
                                <input type="number" class="form-control" name="amount" min="1000" placeholder="Enter Amount (Min. 1000)" required>
                                <small class="text-muted mt-1">Maximum withdrawal per request: 10,000</small>
                            </div>

                            <button type="submit" name="withdraw" class="btn-theme btn-login" style="margin-top: 10px;">
                                Request Withdrawal <i class="fa fa-arrow-right ml-1"></i>
                            </button>
                        </form>
                    <?php } ?>

                    <!-- Processing Info -->
                    <div class="mt-4 p-3" style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px;">
                        <div class="d-flex align-items-start mb-2">
                            <i class="fa fa-info-circle text-info mr-2" style="margin-top: 3px;"></i>
                            <div style="font-size: 12px; color: #718096; line-height: 1.5; padding-left: 10px;">
                                <p class="mb-2"><strong>Processing Time:</strong> It may take up to 24 hours to credit funds to your account.</p>
                                <p class="mb-0 text-danger"><strong>Note:</strong> Withdrawals are not processed on Sundays.</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p style="font-size: 13px; color: #718096;">Need help with your withdrawal?</p>
                        <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp2');?>" class="btn-outline" style="padding: 10px 20px; font-size: 14px;">
                           <i class="fa fa-whatsapp"></i> Chat with Support
                        </a>
                    </div>
                </div>
            </div>
            <br><br>
        </div>
    </div>
    <?php include("include/footer.php"); ?>
</body>
</html>