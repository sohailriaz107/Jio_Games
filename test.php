<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lat']) && isset($_POST['lng'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];

    $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$lng&zoom=10&addressdetails=1";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "MyLocationApp/1.0"); // Required by Nominatim
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    $data = json_decode($response, true);
    $address = $data['address'] ?? [];

    $district = $address['county'] ?? $address['state_district'] ?? $address['region'] ?? 'N/A';
    $city = $address['city'] ?? $address['town'] ?? $address['village'] ?? $address['municipality'] ?? 'N/A';

    echo "District: $district, City: $city";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Get Location</title>
</head>
<body>
  <button onclick="getLocation()">Get My Location</button>
  <p id="location"></p>

  <script>
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, error);
      } else {
        document.getElementById("location").innerText = "Geolocation not supported.";
      }
    }

    function success(position) {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      document.getElementById("location").innerText = "Latitude: " + lat + " | Longitude: " + lng;

      fetch(window.location.href, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'lat=' + lat + '&lng=' + lng
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById("location").innerText += "\n" + data;
      });
    }

    function error(err) {
      console.warn(`ERROR(${err.code}): ${err.message}`);
      document.getElementById("location").innerText = "Unable to retrieve location.";
    }
  </script>
</body>
</html>
