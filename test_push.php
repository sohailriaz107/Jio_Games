<?php
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors',1);
error_reporting(E_ALL);

include('include/connect.php');
include("include/functions.php");

$title = 'Good Evening';
$description= 'Hope you Doing Well';
$date = date('Y-m-d');
$time = date('h:i:s');
$redirection = 0;
$game_id = 0;
$url = $home_url.'notifications.php';
  $data = array(
                "to" => "/topics/main_notification", 
                "priority"=> "high",
                "data" => array(
                    "title" => $title, 
                    "description" => $description, 
                    "date" => $date, 
                    "time" => $time, 
                    "icon" => $home_url.'img/icon.png',
					"redirection" => $redirection,
					"redirection_to" => 'notification_page',
					"game_id" => $game_id,
                    "url" => $url)
                ); 
    
            $data_string = json_encode($data); 
            $headers = array ( 'Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json' ); 
            $ch = curl_init(); curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' ); 
            curl_setopt( $ch,CURLOPT_POST, true ); 
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers ); 
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true ); 
            curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string); 
            $result = curl_exec($ch); 
            curl_close ($ch); 
            
            print($result);
            
            ?>