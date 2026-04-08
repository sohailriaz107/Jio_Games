<?php

function sanitize_input($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}


function get_userNameById($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT name FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->name : null;
}

function get_userMobileById($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT mobile FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->mobile : null;
}

function get_userDevice_infoById($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT device_info FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->device_info : null;
}

function get_userDeviceTokenById($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT device_token FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->device_token : null;
}

function get_userDeviceIDById($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT device_id FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->device_id : null;
}

function UpdateDeviceTokenUserTable($user_id, $device_token) {
    global $con;
    $stmt = $con->prepare("UPDATE users SET device_token=? WHERE id=? LIMIT 1");
    $stmt->bind_param("si", $device_token, $user_id);
    $stmt->execute();
    $stmt->close();
}

	
function get_MpinByPhone_no($phone) {
    global $con;
    $phone = '+91' . $phone;
    $stmt = $con->prepare("SELECT mpin FROM users WHERE mobile=? LIMIT 1");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->mpin : null;
}

function UpdateDeviceIDUserTable($user_id, $device_id) {
    global $con;
    $stmt = $con->prepare("UPDATE users SET device_id=? WHERE id=?");
    $stmt->bind_param("si", $device_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

function UpdateDeviceInfoUserTable($user_id, $device_info) {
    global $con;
    $stmt = $con->prepare("UPDATE users SET device_info=? WHERE id=?");
    $stmt->bind_param("si", $device_info, $user_id);
    $stmt->execute();
    $stmt->close();
}

function get_username1ById($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT username FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->username : null;
}

function checkUserId($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT id FROM users WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->id : null;
}

function UpdateBalanceInUserTable($user_id, $balance) {
    global $con;
    $stmt = $con->prepare("UPDATE users SET balance=? WHERE id=?");
    $stmt->bind_param("di", $balance, $user_id);
    $stmt->execute();
    $stmt->close();
}

function get_gameNameById($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT name FROM games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->name : null;
}

function check_late_night($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT late_night FROM games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->late_night : null;
}

function get_gameTimeById($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT lottery_time FROM games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->lottery_time : null;
}

function get_parentGameById($id) {
    global $con;
    $stmt = $con->prepare("SELECT name FROM parent_games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->name : null;
}

function get_parentIdById($id) {
    global $con;
    $stmt = $con->prepare("SELECT parent_game FROM games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    return $value ? $value->parent_game : null;
}

function GetLastOpneResultByid($game_id, $temp_Date) {
    global $con;
    if (substr(date('h:i:s'), 0, 2) < 10 && date('A') == 'AM') {
        $sql = "SELECT digit FROM result WHERE game_id=? AND game_type='single_patti' ORDER BY date DESC LIMIT 1";
    } else {
        $sql = "SELECT digit FROM result WHERE game_id=? AND game_type='single_patti' AND date=? LIMIT 1";
    }
    $stmt = $con->prepare($sql);
    if (substr(date('h:i:s'), 0, 2) < 10 && date('A') == 'AM') {
        $stmt->bind_param("i", $game_id);
    } else {
        $stmt->bind_param("is", $game_id, $temp_Date);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
    if ($value) {
        $panna = $value->digit;
        $ank = 0;
        for ($i = 0; $i < strlen($panna); $i++) {
            $ank += $panna[$i];
        }
        $ank = substr($ank, -1);
        return $panna . '-' . $ank;
    } else {
        return '***-*';
    }
}

function GetLastCloseResultByid($game_id, $temp_Date) {
    global $con;
    $sql = "";
    if (substr(date('h:i:s'), 0, 2) < 10 && date('A') == 'AM') {
        $sql = "SELECT digit FROM result WHERE game_id=? AND game_type='single_patti' ORDER BY date DESC LIMIT 1";
    } else {
        $sql = "SELECT digit FROM result WHERE game_id=? AND game_type='single_patti' AND date=? LIMIT 1";
    }
    $stmt = $con->prepare($sql);
    if (substr(date('h:i:s'), 0, 2) < 10 && date('A') == 'AM') {
        $stmt->bind_param("i", $game_id);
    } else {
        $stmt->bind_param("is", $game_id, $temp_Date);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    if ($value) {
        $panna = $value->digit;
        $ank = 0;
        for ($i = 0; $i < strlen($panna); $i++) {
            $ank += $panna[$i];
        }
        $ank = substr($ank, -1);
        return $ank . '-' . $panna;
    } else {
        return '*-***';
    }
}

function get_ChildOpen($id) {
    global $con;
    $stmt = $con->prepare("SELECT id FROM games WHERE parent_game=? AND type='open' LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->id : null;
}

function get_StarlineResult($id) {
    global $con;
    $ank =0;
    $today = date('Y-m-d');
    $stmt = $con->prepare("SELECT digit FROM starline_result WHERE game_id=? AND date=? LIMIT 1");
    $stmt->bind_param("is", $id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();
    
        if($value){
		$panna = $value->digit;
		for ($i = 0; $i < strlen($panna); $i++){ 
			$ank += $panna[$i]; 
		}
		$ank =substr($ank,-1);
			if($panna !='' && $ank !='')
			{
			return $panna.'-'.$ank;
			}else{
				return '***-*';
			}
		}
}

function get_Starlinetime($id) {
    global $con;
    $stmt = $con->prepare("SELECT time FROM starline WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->time : null;
}

function get_Jackpottime($id) {
    global $con;
    $stmt = $con->prepare("SELECT lottery_time FROM jackpot_games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? date("g:i A", strtotime($value->lottery_time)) : null;
}

function get_JackpotName($id) {
    global $con;
    $stmt = $con->prepare("SELECT name FROM jackpot_games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->name : null;
}

function get_ChildClose($id) {
    global $con;
    $stmt = $con->prepare("SELECT id FROM games WHERE parent_game=? AND type='close' LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->id : null;
}

function get_GameTypeById($id) {
    global $con;
    $stmt = $con->prepare("SELECT type FROM games WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->type : null;
}

function get_RateSingle() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=1 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}
function get_RateJodi() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=2 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_RateSinglePatti() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=3 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_RateDoublePatti() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=4 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_RateTriplePatti() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=5 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_RateHalfSangam() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=6 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_RateFullSangam() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM game_rate WHERE id=7 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_StarlineSingle() {
    global $con;
    $stmt = $con->prepare("SELECT srate FROM game_rate WHERE id=1 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->srate : null;
}

function get_StarlineSinglePatti() {
    global $con;
    $stmt = $con->prepare("SELECT srate FROM game_rate WHERE id=3 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->srate : null;
}

function get_StarlineDoublePatti() {
    global $con;
    $stmt = $con->prepare("SELECT srate FROM game_rate WHERE id=4 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->srate : null;
}

function get_StarlineTriplePatti() {
    global $con;
    $stmt = $con->prepare("SELECT srate FROM game_rate WHERE id=5 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->srate : null;
}

function get_JackpotOpenRate() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM jackpot_rate WHERE id=1 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_JackpotCloseRate() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM jackpot_rate WHERE id=2 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}

function get_JackpotJodiRate() {
    global $con;
    $stmt = $con->prepare("SELECT rate FROM jackpot_rate WHERE id=3 LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? $value->rate : null;
}
	
function get_lastBalance($user_id) {
    global $con;
    $stmt = $con->prepare("SELECT balance FROM users WHERE id=? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value ? floor($value->balance) : 0;
}

function UpdateUserBalance($user_id, $amount) {
    global $con;
    $stmt = $con->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    $stmt->bind_param("di", $amount, $user_id);
    $stmt->execute();
    $stmt->close();
}

function GetPannaType($digit) {
    global $con;
    $sp = array();
    $dp = array();
    $tp = array();

    // Get single patti 
    $qry11 =  "SELECT * FROM sp";
    $result11 = mysqli_query($con, $qry11);
    $i = 0;
    while ($row11 = mysqli_fetch_array($result11)) {
        $sp[$i] = $row11['num'];
        $i++;
    }

    // Get double patti
    $qry12 =  "SELECT * FROM dp";
    $result12 = mysqli_query($con, $qry12);
    $i = 0;
    while ($row12 = mysqli_fetch_array($result12)) {
        $dp[$i] = $row12['num'];
        $i++;
    }

    // Get Tripple patti
    $qry13 =  "SELECT * FROM tp";
    $result13 = mysqli_query($con, $qry13);
    $i = 0;
    while ($row13 = mysqli_fetch_array($result13)) {
        $tp[$i] = $row13['num'];
        $i++;
    }

    $digit_type = '';

    if (in_array($digit, $sp)) {
        $digit_type = 'single_patti';
    } elseif (in_array($digit, $dp)) {
        $digit_type = 'double_patti';
    } elseif (in_array($digit, $tp)) {
        $digit_type = 'triple_patti';
    }

    return $digit_type;
}

function IsDeviceBlocked($device_id) {
    global $con; 
    $stmt = $con->prepare("SELECT COUNT(*) as num FROM blocked_devices WHERE device_id = ?");
    $stmt->bind_param("s", $device_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->num;
}

function allUserBalance() {
    global $con;
    $sql = "SELECT SUM(balance) as all_user_balance FROM users";
    $result = mysqli_query($con, $sql);
    $value = mysqli_fetch_object($result);
    return $value->all_user_balance;
}

function TodayPlayed($date) {
    global $con;
    $stmt = $con->prepare("SELECT SUM(amount) as total_played FROM user_transaction WHERE date = ? AND type = 'bid' AND starline != '1'");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->total_played;
}

function TodayWin($date) {
    global $con;
    $stmt = $con->prepare("SELECT SUM(amount) as total_win FROM user_transaction WHERE date = ? AND type = 'win' AND starline != '1'");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->total_win > 0 ? $value->total_win : 0;
}
function TodayPlayed_starline($date) {
    global $con;
    $stmt = $con->prepare("SELECT SUM(amount) as total_played FROM user_transaction WHERE date = ? AND type = 'bid' AND starline = '1'");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->total_played;
}

function TodayWin_starline($date) {
    global $con;
    $stmt = $con->prepare("SELECT SUM(amount) as total_win FROM user_transaction WHERE date = ? AND type = 'win' AND starline = '1'");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->total_win > 0 ? $value->total_win : 0;
}

function TodayCredit($date) {
    global $con;
    $stmt = $con->prepare("SELECT SUM(amount) as today_credit FROM user_transaction WHERE date = ? AND type = 'deposit' AND debit_credit = 'credit' AND user_id NOT IN (3, 4)");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->today_credit;
}

function TodayDebit($date) {
    global $con;
    $stmt = $con->prepare("SELECT SUM(amount) as today_debit FROM user_transaction WHERE date = ? AND (type = 'withdraw' OR type = 'deposit') AND debit_credit = 'debit' AND user_id NOT IN (3, 4)");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = $result->fetch_object();
    $stmt->close();

    return $value->today_debit;
}

function GetParentOpenTime($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT lottery_time FROM games WHERE parent_game = ? AND type = 'open'");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $open_time = '';
    while ($child_row = $result->fetch_array()) {
        $open_time = date("g:i A", strtotime($child_row['lottery_time']));
    }
    $stmt->close();

    return $open_time;
}

function GetParentCloseTime($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT lottery_time FROM games WHERE parent_game = ? AND type = 'close'");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $close_time = '';
    while ($child_row = $result->fetch_array()) {
        $close_time = date("g:i A", strtotime($child_row['lottery_time']));
    }
    $stmt->close();

    return $close_time;
}

function GetParentOpenResultTime($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT result_time FROM games WHERE parent_game = ? AND type = 'open'");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $open_result_time = '';
    while ($child_row = $result->fetch_array()) {
        $open_result_time = date("g:i A", strtotime($child_row['result_time']));
    }
    $stmt->close();

    return $open_result_time;
}

function GetParentCloseResultTime($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT result_time FROM games WHERE parent_game = ? AND type = 'close'");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $close_result_time = '';
    while ($child_row = $result->fetch_array()) {
        $close_result_time = date("g:i A", strtotime($child_row['result_time']));
    }
    $stmt->close();

    return $close_result_time;
}

function GetParentOpendays($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT open_days FROM games WHERE parent_game = ? AND type = 'open'");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $open_days = '';
    while ($child_row = $result->fetch_array()) {
        $open_days = $child_row['open_days'];
    }
    $stmt->close();

    return $open_days;
}
function GetOpneResultByid($game_id) {
    global $con;
    $today = '';
    // Show back date result before morning 9
    if (substr(date('H:i:s'), 0, 2) < '8' && date('A') == 'AM') {
        $today = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
    } else {
        $today = date('Y-m-d');
    }

    $stmt = $con->prepare("SELECT digit FROM result WHERE game_id = ? AND date = ? AND game_type = 'single_patti' LIMIT 1");
    $stmt->bind_param("is", $game_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $panna = '';
    while ($value = $result->fetch_object()) {
        $panna = $value->digit;
    }
    $stmt->close();

    if ($panna != '') {
        $ank = 0;
        for ($i = 0; $i < strlen($panna); $i++) {
            $ank += $panna[$i];
        }
        $ank = substr($ank, -1);
        return $panna . '-' . $ank;
    } else {
        return '***-*';
    }
}

function GetCloseResultByid($game_id) {
    global $con;
    $today = '';
    // Show back date result before morning 9
    if (substr(date('H:i:s'), 0, 2) < '8' && date('A') == 'AM') {
        $today = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
    } else {
        $today = date('Y-m-d');
    }

    $stmt = $con->prepare("SELECT digit FROM result WHERE game_id = ? AND date = ? AND game_type = 'single_patti' LIMIT 1");
    $stmt->bind_param("is", $game_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $panna = '';
    while ($value = $result->fetch_object()) {
        $panna = $value->digit;
    }
    $stmt->close();

    if ($panna != '') {
        $ank = 0;
        for ($i = 0; $i < strlen($panna); $i++) {
            $ank += $panna[$i];
        }
        $ank = substr($ank, -1);
        return $ank . '-' . $panna;
    } else {
        return '*-***';
    }
}

function GetStrlineResultByid($game_id) {
    global $con;
    $today = date('Y-m-d');
    $stmt = $con->prepare("SELECT digit FROM starline_result WHERE game_id = ? AND date = ? AND game_type = 'single_patti' LIMIT 1");
    $stmt->bind_param("is", $game_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $panna = '';
    while ($value = $result->fetch_object()) {
        $panna = $value->digit;
    }
    $stmt->close();

    if ($panna != '') {
        $ank = 0;
        for ($i = 0; $i < strlen($panna); $i++) {
            $ank += $panna[$i];
        }
        $ank = substr($ank, -1);
        return $panna . '-' . $ank;
    } else {
        return '***-*';
    }
}

function GetStrlineResultByDate($game_id, $date) {
    global $con;
    $today = $date;
    $stmt = $con->prepare("SELECT digit FROM starline_result WHERE game_id = ? AND date = ? AND game_type = 'single_patti' LIMIT 1");
    $stmt->bind_param("is", $game_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $panna = '';
    while ($value = $result->fetch_object()) {
        $panna = $value->digit;
    }
    $stmt->close();

    if ($panna != '') {
        $ank = 0;
        for ($i = 0; $i < strlen($panna); $i++) {
            $ank += $panna[$i];
        }
        $ank = substr($ank, -1);
        return $panna . '-' . $ank;
    } else {
        return '***-*';
    }
}

function GetJackpotResultByid($game_id) {
    global $con;
    $today = date('Y-m-d');
    $stmt = $con->prepare("SELECT digit FROM jackpot_result WHERE game_id = ? AND date = ? AND game_type = 'jodi' LIMIT 1");
    $stmt->bind_param("is", $game_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $jodi = '';
    while ($value = $result->fetch_object()) {
        $jodi = $value->digit;
    }
    $stmt->close();

    if ($jodi != '') {
        return $jodi;
    } else {
        return '**';
    }
}

function GetJackpotResultByDate($game_id, $date) {
    global $con;
    $today = $date;
    $stmt = $con->prepare("SELECT digit FROM jackpot_result WHERE game_id = ? AND date = ? AND game_type = 'jodi' LIMIT 1");
    $stmt->bind_param("is", $game_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $jodi = '';
    while ($value = $result->fetch_object()) {
        $jodi = $value->digit;
    }
    $stmt->close();

    if ($jodi != '') {
        return $jodi;
    }else{
            return '**';
        }
}
function get_SettingValue($name) {
    global $con;
    $stmt = $con->prepare("SELECT value FROM settings WHERE name = ? LIMIT 1");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = '';
    while ($row = $result->fetch_object()) {
        $value = $row->value;
    }
    $stmt->close();
    return $value;
}

function get_GamePlayDates($game_id) {
    global $con;
    $stmt = $con->prepare("SELECT open_days FROM games WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = '';
    while ($row = $result->fetch_object()) {
        $open_days = $row->open_days;
        $game_days = explode(",", $open_days);
        $dates = array();
        $count = 0;

        for ($i = 0; $i <= 5; $i++) {
            $date = date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $i . ' day'));
            $day = strtolower(date('D', strtotime($date)));
            if (in_array($day, $game_days)) {
                $dates[$count] = $date;
                $count++;
            }
        }

        $value = $dates;
    }
    $stmt->close();
    return $value;
}


function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	
	
function randomOTP($length) {
			$random= "";
			srand((double)microtime()*1000000);
			$data = "123456789";
			
			for($i = 0; $i < $length; $i++) {
				$random .= substr($data, (rand()%(strlen($data))), 1);
			}
			return $random;
		}
		
function sendRequest($param){
			$url = $param['url'];
			$postData = $param['postData'];

			$ch = curl_init();
			curl_setopt_array($ch, array(
			    CURLOPT_URL => $url,
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_POST => true,
			    CURLOPT_POSTFIELDS => $postData
			    //,CURLOPT_FOLLOWLOCATION => true
			));

			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			//get response
			$output = curl_exec($ch);

			//Print error if any
			if(curl_errno($ch)) {
			    return curl_error($ch);
			}
			curl_close($ch);
			return $output;
		}
		
		
function sendPushNotification($to,$title,$description,$action_url){
            $data = array(
                "to" => $to,  
                "priority"=> "high",
                
                "data" => array(
                    "title" => $title, 
                    "description" => $description, 
                    "date" => date('y-m-d'), 
                    "time" => date('h:i A'),
					"redirection" => 0,
					"redirection_to" => 'home_page',
					"game_id" => 0,
                    "icon" => $home_url.'img/icon.png',
                    "url" => $action_url)
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
}




// Function to create a base64 URL-encoded string
function base64UrlEncode($data) {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

function sendPushNotificationFCM($topic,$token,$title,$description,$action_url,$redirection,$redirection_to,$game_id){
	
	$date = date('Y-m-d');
	$time = date('h:i:s');
	
$serviceAccountPath = SERVICE_ACCOUNT_KEY_FCM; // Update this path in connect.php file
$serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);

// Set the required values
$privateKey = $serviceAccount['private_key'];
$clientEmail = $serviceAccount['client_email'];
$projectId = $serviceAccount['project_id'];

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

if($topic !=''){
$message = [
    "message" => [
        "topic" => $topic,
        "data" => [
            "title" => $title,
            "description" => $description,
            "date" => $date,
            "time" => $time,
            "icon" => $home_url.'img/icon.png',
            "redirection" => $redirection,
			"redirection_to" => $redirection_to,
			"game_id" => $game_id,
			"url" => $action_url
        ]
    ]
]; 

}else{
$message = [
    "message" => [
        "token" => $token,
        "data" => [
            "title" => $title,
            "description" => $description,
            "date" => $date,
            "time" => $time,
            "icon" => $home_url.'img/icon.png',
            "redirection" => $redirection,
			"redirection_to" => $redirection_to,
			"game_id" => $game_id,
			"url" => $action_url
        ]
    ]
]; 	
}

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

return $result;
}
	
function sendPushNotification_oneSignal($title,$description){
    if(0){
	$content = array("en" => $description);    
    $heading = array("en" => $title);
	$priority = 10;
    $fields = array(
        'app_id' => "279dcf96-3362-447a-93c5-00000",
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'priority' => $priority,
        'contents' => $content,
        'headings' => $heading
    );

    $fields = json_encode($fields);
//print("\nJSON sent:\n");
//print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic 1111111'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);
    }
    return 0;
}


function isWithinRadius($lat1, $lon1, $lat2, $lon2, $radius = 100) {
    $earthRadius = 6371; // Earth's radius in km

    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Haversine formula
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;

    $a = sin($dlat / 2) * sin($dlat / 2) +
         cos($lat1) * cos($lat2) *
         sin($dlon / 2) * sin($dlon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c;

    return $distance <= $radius;
}

?>
