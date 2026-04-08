<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL);
include("include/connect.php");
//include("include/functions.php");
if(0){
$topic = '';
							$token = 'eXNJVdB1Tt6i3lgUfqahWR:APA91bEM0ktXQ2R6ZNEQvFkrVj9u6SWrH6Jo_bJFFAC14cayPHG7GgCbTroNBmdt8ns_tXHJP58lJTIfsqEc2hOK20TV2YE7uxyAl31E-pPV8LF4VGENOmnFOS5KzGDAER46wI0lDTwn';
							$title ='New Message '.date('h:i');
							$description ='this is msg for shubham';
							$action_url='';
							$redirection='0';
							$redirection_to='home_page';
							
							//sendPushNotification($topic,$title,$description,'');
							echo sendPushNotificationFCM($topic,$token,$title,$description,$action_url,$redirection,$redirection_to,'0');

							
exit;							
}							
							

date_default_timezone_set('Asia/Kolkata'); 
// Load the service account key file
$serviceAccountPath = '/home/Jio games/public_html/include/paytm-matka-firebase-adminsdk-jagch-b57b29b03d.json'; // Update this path
$serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);

// Set the required values
$privateKey = $serviceAccount['private_key'];
$clientEmail = $serviceAccount['client_email'];
$projectId = $serviceAccount['project_id'];

// Function to create a base64 URL-encoded string
function base64UrlEncode($data) {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

// Create a JWT for authentication
$now = time();
$expires = $now + 3600; // Token valid for 1 hour

$header = [
    'alg' => 'RS256',
    'typ' => 'JWT'
];

$payload = [
    'iss' => $clientEmail,
    'sub' => $clientEmail,
    'aud' => 'https://oauth2.googleapis.com/token',
    'iat' => $now,
    'exp' => $expires,
    'scope' => 'https://www.googleapis.com/auth/firebase.messaging'
];

// Encode the header and payload
$base64UrlHeader = base64UrlEncode(json_encode($header));
$base64UrlPayload = base64UrlEncode(json_encode($payload));

// Create the signature
$signature = '';
openssl_sign($base64UrlHeader . '.' . $base64UrlPayload, $signature, $privateKey, 'SHA256');
$base64UrlSignature = base64UrlEncode($signature);

// Create the JWT
$jwt = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;

// Get an OAuth2 access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion' => $jwt
]));

$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result, true);
$accessToken = $data['access_token'];

// Prepare the notification message
$title = 'Good Afternoon '.date('h:i:s');
$description = 'Hope you Doing Well';
$date = date('Y-m-d');
$time = date('h:i:s');
$redirection = 0;
$game_id = 0;
$home_url = 'https://jiogames.app/';
$url = $home_url . 'notifications.php';
$url=0;

$message = [
    "message" => [
        "topic" => "main_notification",
        "notification" => [
            "title" => $title,
            "body" => $description
        ],
        "data" => [
            "title" => $title,
            "description" => $description,
            "date" => $date,
            "time" => $time,
			"icon" => 'icon',
			"redirection" => '0',
			"redirection_to" => 'notification_page',
			"game_id" => '100'
        ]
    ]
];



// Send the notification
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/$projectId/messages:send");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

$result = curl_exec($ch);
curl_close($ch);

echo $result;
