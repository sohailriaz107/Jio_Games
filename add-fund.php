<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days in seconds
session_start(); 
	include("include/connect.php");
    include("include/session.php");
	include("include/functions.php");


if(isset($_GET['add_fund'])) {
    
$user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$api_access_token = filter_var($_GET['api_access_token'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

$query = "SELECT * FROM users WHERE api_access_token = ? AND id = ? AND status = '1'";
$stmt = $con->prepare($query);
$stmt->bind_param("si", $api_access_token, $user_id);
$stmt->execute();
$result_api = $stmt->get_result();

if ($row_api = $result_api->fetch_array()) {
    // Valid user
} else {
    echo "<script>window.location = 'logout.php';</script>";
    exit;
}
$stmt->close();

    $paymentMethod = $_GET['payment_method'];

    if ($paymentMethod === "add_fund_rudra") {
        header("Location: add_fund_rudra/index.php?" . http_build_query($_GET));
        exit();
    } else if ($paymentMethod === "add_fund_new12") {
        header("Location: add_fund_new12/index.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "paymor_upi_qr") {
        header("Location: add_fund_pymore/index.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "app_download") {
        header("Location: download-app-fund-issue.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "add_fund_mpay") {
        header("Location: add_fund_mpay/index.php?" . http_build_query($_GET));
        exit();
    }else if ($paymentMethod === "add_fund_poxford") {
        header("Location: add_fund_poxford/index.php?" . http_build_query($_GET));
        exit();
    }
}

$user_id = $_SESSION['usr_id'];
$query = "SELECT district FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_district);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Fund - <?php echo $site_title;?></title>
    <?php include("include/head.php"); ?>
    <style>
        .addfund-hero {
            background: linear-gradient(135deg, var(--primary-light), #0044bb);
            color: white;
            padding: 25px 20px 50px;
            border-radius: 0 0 30px 30px;
            margin-top: -10px;
            box-shadow: 0 6px 20px rgba(13,110,253,0.25);
        }
        .addfund-hero h2 {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 4px 0;
            color: white;
        }
        .addfund-hero p {
            margin: 0;
            font-size: 13px;
            opacity: 0.85;
            color: white;
        }
        .addfund-hero .wallet-pill {
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            color: white;
        }
        .addfund-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(13,110,253,0.08);
            padding: 25px 20px;
            margin: -30px 15px 20px;
            position: relative;
            z-index: 10;
        }
        .addfund-section-label {
            font-size: 12px;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        .amount-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .amount-chip {
            flex: 1 1 calc(25% - 10px);
            background: #f0f4ff;
            border: 1.5px solid #dbe4ff;
            border-radius: 10px;
            text-align: center;
            padding: 10px 5px;
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-light);
            cursor: pointer;
            transition: all 0.2s;
        }
        .amount-chip:hover,
        .amount-chip.selected {
            background: var(--primary-light);
            color: white;
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(13,110,253,0.25);
        }
        .addfund-input {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 15px;
            width: 100%;
            background: #f8faff;
            font-weight: 600;
            color: #2d3748;
            outline: none;
            transition: border 0.2s;
            box-sizing: border-box;
        }
        .addfund-input:focus {
            border-color: var(--primary-light);
            background: white;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
        }
        .addfund-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            width: 100%;
            background: #f8faff;
            font-weight: 600;
            color: #2d3748;
            outline: none;
            -webkit-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            box-sizing: border-box;
        }
        .addfund-select:focus {
            border-color: var(--primary-light);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
        }
        .addfund-submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-light), #0044bb);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(13,110,253,0.3);
            transition: filter 0.2s, transform 0.1s;
            margin-top: 10px;
            text-transform: uppercase;
        }
        .addfund-submit-btn:hover { filter: brightness(1.07); transform: translateY(-1px); }
        .addfund-submit-btn:active { transform: scale(0.98); }
        .info-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #f0f8ff;
            border-left: 4px solid var(--primary-light);
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #4a5568;
        }
        .info-note i { color: var(--primary-light); font-size: 16px; margin-top: 1px; }
        .help-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff8f0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-top: 15px;
            border: 1px solid #ffe4cc;
        }
        .help-row span { font-size: 13px; color: #4a5568; font-weight: 500; }
        .help-btn {
            background: #25D366;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .help-btn:hover { color: white; text-decoration: none; filter: brightness(1.1); }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include("include/sidebar.php"); ?>
        <div id="content">
            <?php include("include/nav.php"); ?>

            <?php 
            $not_allowed_district = ["Pali", "Bikaner"];
            if (in_array($user_district, $not_allowed_district)) { ?>

                <div class="addfund-hero text-center">
                    <h2><i class="fa fa-lock"></i> Service Unavailable</h2>
                    <p>Add Fund is not available in your area.</p>
                </div>
                <div class="addfund-card text-center">
                    <i class="fa fa-exclamation-circle" style="font-size:48px; color:#e53e3e; margin-bottom:12px; display:block;"></i>
                    <h4 style="color:#2d3748; font-weight:700;">Sorry, Add Fund Issue</h4>
                    <p style="color:#6c757d; font-size:14px; margin-top:8px;">We are facing some issue on bank side. Please try again after some time.</p>
                </div>

            <?php } else { ?>

                <!-- Hero Banner -->
                <div class="addfund-hero">
                    <h2><i class="fa fa-plus-circle"></i> Add Funds</h2>
                    <p>Top up your wallet instantly via UPI</p>
                    <!-- <div class="wallet-pill">
                        <i class="fa fa-inr"></i>
                        Balance: <?php echo get_lastBalance($_SESSION['usr_id']); ?>
                    </div> -->
                </div>

                <!-- Main Card -->
                <div class="addfund-card">

                    <div class="info-note">
                        <i class="fa fa-info-circle"></i>
                        <div>Payment add krne ke <strong>5 minute</strong> ke andar aapke wallet me points add ho jayenge. Your money is always safe with <strong><?php echo $site_title; ?></strong>.</div>
                    </div>

                    <form action="" method="GET" autocomplete="off">

                        <div class="addfund-section-label">Select or Enter Amount</div>
                        <div class="amount-chips">
                            <div class="amount-chip" onclick="setAmount(400, this)">&#8377;400</div>
                            <div class="amount-chip" onclick="setAmount(500, this)">&#8377;500</div>
                            <div class="amount-chip" onclick="setAmount(1000, this)">&#8377;1000</div>
                            <div class="amount-chip" onclick="setAmount(5000, this)">&#8377;5000</div>
                        </div>

                        <div class="form-group mb-4">
                            <input type="number" id="add_fund_amount" class="addfund-input" name="amount" min="400" max="50000" placeholder="Min: 400  |  Max: 50,000" required>
                        </div>

                        <div class="addfund-section-label">Payment Method</div>
                        <div class="form-group mb-4">
                            <select class="addfund-select" name="payment_method" required>
                                <option value="<?php echo get_SettingValue('web_version_payment_link');?>">Direct UPI (Automatic)</option>
                            </select>
                        </div>

                        <input type="hidden" name="package_name" value="website">
                        <input type="hidden" name="version" value="5.0.0">
                        <input type="hidden" name="api_access_token" value="<?php echo $_SESSION['api_access_token'] ?? '';?>">
                        <input type="hidden" name="id" value="<?php echo $_SESSION['usr_id'];?>">

                        <button type="submit" name="add_fund" class="addfund-submit-btn">
                            <i class="fa fa-bolt"></i> &nbsp; Add Points Now
                        </button>
                    </form>

                    <div class="help-row">
                        <span>Unable to Add Fund?</span>
                        <a href="https://wa.me/<?php echo get_SettingValue('PWA_whatsapp1');?>" class="help-btn">
                            <i class="fa fa-whatsapp"></i> Contact Admin
                        </a>
                    </div>

                </div>

            <?php } ?>

        </div>
    </div>

    <?php include("include/footer.php"); ?>

    <script>
        function setAmount(val, el) {
            document.getElementById('add_fund_amount').value = val;
            document.querySelectorAll('.amount-chip').forEach(function(c) { c.classList.remove('selected'); });
            el.classList.add('selected');
        }
    </script>
</body>
</html>