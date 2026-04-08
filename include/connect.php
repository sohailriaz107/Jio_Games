<?php
$site_title = 'Jio games';
$home_url = 'https://matkaresul.com/asim_work/';    //url of home page
$site_url = 'https://matkaresul.com/asim_work/admin/'; //backend url
$admin_folder_name = 'admin';

$package_name = 'com.PaytmMatka.web';

define("PAYZLAND_PAYIN_URL","https://checkout.upiintent.com/api/v1/payment");
define("PAYZLAND_PAYOUT_URL","https://payout.upiintent.com/api/v1/payout");
define("PAYZLAND_MERCHANT_ID","9df54057-6c3c-43ca-a377-ba33355304249262");
define("PAYZLAND_API_KEY","3773C7962B4A2632DEE90BCFFAF03BBD81E06B2A935535ED0E0CB4F06EEF3C393A8F7");

define("PAYZLAND_MERCHANT_ID_APPONLY","9df54057-6c3c-43ca-a377-ba33035354249262");
define("PAYZLAND_API_KEY_APPONLY","3773C7962B4A2632DEE90BCFFAF03BBD81E06B2A9353ED0E0CB4F06EEF3C393A8F7");


define("PAYZLAND_PAYOUT_PREFIX","POXPTM");
define("PAYZLAND_PAYIN_PREFIX","ORDPTM");
define("PAYZLAND_SELF_PREFIX","POPTM");


$payment_api_key  = '';$payment_salt = '';
$snappay_upi_api_kay  = '';$snappay_upi_payment_salt = '';
$payg_authentication_key = '';$payg_authentication_token ='';$payg_secure_hash_key ='';$payg_merchant_id = '';
$ippopay_publicKey = '';$ippopay_secretKey = '';



$con = mysqli_connect("localhost", "root", "", "matkaresul_play");
if (!$con) {
    error_log("Database connection failed: " . mysqli_connect_error());
    exit('Database error. Please try again later.');
}


define("SITEURL","https://matkaresul.com/asim_work/");
define("SITEDOMAIN","jiogames.app");
define('SMS_AUTH_KEY','328462Az42bWvHbS5eee314cP1');
define('SMS_SENDER_ID','MBOOKI');

define('LIVE_CHAT_URL','#'); //tawk.to url
define('TELEGRAM_URL','https://telegram.me/JIOYASHI09'); // telegram direct chat url

$service_json = realpath('/app/html/include/jiogames-b6826-firebase-adminsdk-fbsvc-eda2df76dd.json'); // Update this path with service json file
define('SERVICE_ACCOUNT_KEY_FCM', $service_json);


//push notificaiton API ACCESS KEY
define('API_ACCESS_KEY', 'AAAA-aEjXwk:APA91bGbrPwzFSzJCqbT2sVmzTS_GjJ7eTp5V5J3yiPELowaX8FG0bIUIsdwXeoLk8URkP0twPNPHCFxEk5WX6a7Du1ZKe3Z1ZaFDYiIfBgcN3C5pN9NC-QIBGeMrplcAc68KOTJoZcG');

date_default_timezone_set('Asia/Kolkata');



if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ip = trim($ipList[0]); // Take the first IP from the list
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if(0){ 
// Build API URL
$api_url = "http://ip-api.com/json/{$ip}?fields=status,regionName";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 seconds timeout

$response = curl_exec($ch);
curl_close($ch);

// Decode response
$data = @json_decode($response, true);

// Block users from Maharashtra
if ($data && $data['status'] === 'success' && $data['regionName'] === 'Maharashtra') {
    echo "<p>Loading...</p>";
    exit;
}

// Block users from Maharashtra
if ($data && $data['status'] === 'success' && $data['regionName'] === 'Bengaluru') {
    echo "<p>Loading...</p>";
    exit;
}

// Block users from Maharashtra
if ($data && $data['status'] === 'success' && $data['regionName'] === 'Bangalore') {
    echo "<p>Loading...</p>";
    exit;
}
}