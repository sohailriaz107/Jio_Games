<?php
// Check if PHP session is not already set
if (!isset($_SESSION['usr_id']) || !isset($_SESSION['usr_name']) || !isset($_SESSION['usr_mobile']) || !isset($_SESSION['api_access_token'])) {
	
	// Refresh session variables from cookies if available
	if (isset($_COOKIE['usr_id'], $_COOKIE['usr_name'], $_COOKIE['usr_mobile'], $_COOKIE['api_access_token'])) {
		
		// Sanitize and validate cookie data
		$cookie_user_id = filter_var($_COOKIE['usr_id'], FILTER_SANITIZE_NUMBER_INT);
		$cookie_usr_name = filter_var($_COOKIE['usr_name'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$cookie_usr_mobile = filter_var($_COOKIE['usr_mobile'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$cookie_api_access_token = filter_var($_COOKIE['api_access_token'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		
		if ($cookie_user_id !== false && $cookie_usr_name !== false && $cookie_usr_mobile !== false && $cookie_api_access_token !== false) {
			// Prepare the statement
			$stmt = mysqli_prepare($con, "SELECT id FROM users WHERE id = ? AND api_access_token = ? AND status = '1'");
			mysqli_stmt_bind_param($stmt, "is", $cookie_user_id, $cookie_api_access_token);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			
			// Check if a row was found
			if (mysqli_stmt_num_rows($stmt) == 1) {
				mysqli_stmt_bind_result($stmt, $user_id);
				mysqli_stmt_fetch($stmt);
				
				$_SESSION['usr_id'] = $user_id;
				$_SESSION['usr_name'] = $cookie_usr_name;
				$_SESSION['usr_mobile'] = $cookie_usr_mobile;
				$_SESSION['api_access_token'] = $cookie_api_access_token;
			} else {
				// No matching row found, logout
				echo "<script>window.location = 'logout.php';</script>";
				exit;
			}
			
			// Close the statement
			mysqli_stmt_close($stmt);
		} else {
			// Invalid cookie data, logout
			echo "<script>window.location = 'logout.php';</script>";
			exit;
		}
	}
}

$current_page = basename($_SERVER['PHP_SELF']);

if($current_page =='index.php' || $current_page =='starline-play.php' || $current_page =='download-app.php' || $current_page =='game-rates.php' || $current_page =='login.php' || $current_page =='register.php' || $current_page =='top-winner-list.php' || $current_page =='top-winner-list-starline.php')
{
		// do nothing
}else{
	// Check if the user is logged in
	if (isset($_SESSION['usr_id'])) {
		// User is logged in, do nothing
	} else {
		$actual_url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$actual_url = mysqli_real_escape_string($con, $actual_url);
		$return_url = "login.php?return_url=".base64_encode($actual_url);
		header("Location: ".$return_url);
		exit;
	}
}
?>