<?php
ini_set('session.cookie_lifetime', 2592000);  // 30 days
session_start();
include("include/connect.php");
include("include/functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lat']) && isset($_POST['lon'])) {
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $usr_id = $_SESSION['usr_id'];

    // Reverse geocoding with OpenStreetMap (using curl)
    $url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=$lat&lon=$lon";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Required
    $response = curl_exec($ch);
    curl_close($ch);

    // Check if curl call was successful
    if (!$response) {
        die("Curl failed: " . curl_error($ch));
    }

    // Decode response
    $location = json_decode($response, true);
    

    $district = $location['address']['state_district'] ?? '';
    $state = $location['address']['state'] ?? '';
    $country = $location['address']['country'] ?? '';
    
    if($country == 'India'){}else{die("Sorry Only indians are allowed.");}
    


    // Prepare query to update location
    $stmt = mysqli_prepare($con, "UPDATE users SET lat = ?, lon = ?, district = ?, state = ? WHERE id = ?");
    
    // Check for query preparation errors
    if (!$stmt) {
        die("Query failed: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "ssssi", $lat, $lon, $district, $state, $usr_id);

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        // Log MySQL errors if the query execution fails
        error_log("Error executing query: " . mysqli_error($con));
        echo "error";
    }

    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Your Country - <?php echo $site_title; ?></title>
  <meta name="description" content="Download Mobile application and stay connected with us.">
  <?php include("include/head.php"); ?>
</head>
<body>
  <div class="wrapper">
    <?php include("include/sidebar.php"); ?>
    <div id="content">
      <?php include("include/nav.php"); ?>
      <div class="container">
        <div class="tb-10">
          <div class="row">
            <div class="col-12">
              <div class="text-center tbmar-20">
                <p>Kindly Verify your Country</p>
                <button onclick="getLocation()" class="btn btn-outline btn-login" id="locBtn">Yes, I am Indian</button>
                <p id="statusMsg" style="margin-top:10px;"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("include/footer.php"); ?>

  <script>
    function getLocation() {
      const status = document.getElementById("statusMsg");
      const button = document.getElementById("locBtn");
      button.disabled = true;
      status.innerText = "Getting location...";

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, error, {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0
        });
      } else {
        status.innerText = "Geolocation is not supported by this browser.";
        button.disabled = false;
      }

      function success(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        fetch("get_location.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "lat=" + lat + "&lon=" + lon
        })
        .then(res => res.text())
        .then(data => {
          console.log(data);  // Log the server response
          if (data.trim() === "success") {
            status.innerText = "Successfully Verified. Redirecting...";
            setTimeout(() => {
              window.location.href = "index.php";
            }, 1500);
          } else {
            status.innerText = "Error Verifying location. Please try again.";
            button.disabled = false;
          }
        });
      }

      function error(err) {
        status.innerText = "Failed to Verify: " + err.message;
        button.disabled = false;
      }
    }
  </script>
</body>
</html>
