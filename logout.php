<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete cookies by setting their expiration time to the past
setcookie("usr_id", "", time() - 3600, "/");
setcookie("usr_name", "", time() - 3600, "/");
setcookie("usr_mobile", "", time() - 3600, "/");
setcookie("api_access_token", "", time() - 3600, "/");

// Redirect to the login page or any other desired page
header("Location: login.php");
exit;
?>