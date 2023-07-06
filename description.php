<?php
require_once('config.php');
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo $e->getMessage();
}

if (isset($_COOKIE["gps"]) && isset($_COOKIE["capital"]) && isset($_COOKIE["weather"]) && isset($_COOKIE["ip"]) &&
    isset($_COOKIE["dateTime"]) && isset($_COOKIE["countryCode"])){
    $gpsCookie = $_COOKIE["gps"];
    $capitalCookie = $_COOKIE["capital"];
    $countryCodeCookie = $_COOKIE["countryCode"];
    $weatherCookie = $_COOKIE["weather"];
    $ipCookie = $_COOKIE["ip"];
    $dateCookie = $_COOKIE["dateTime"];
}

$lat = null;
$lng = null;
$country = null;
$userAddress = null;

function parseGPS() {
    global $gpsCookie, $lat, $lng, $country, $userAddress;

    if ($gpsCookie == null)
        return false;

    $gpsData = json_decode($gpsCookie);
    if ($gpsData == null)
        return false;

    $lat = $gpsData->results[0]->geometry->location->lat;
    $lng = $gpsData->results[0]->geometry->location->lng;
    $userAddress = $gpsData->results[0]->formatted_address;

    $tmpArr = explode(' ', $gpsData->results[0]->formatted_address);

    $country = $tmpArr[count($tmpArr) - 1];

    return true;
}
$capitalCity = null;
$countryCode = null;
function parseCapital() {
    global $capitalCookie, $capitalCity;
    if ($capitalCookie == null)
        return false;

    $capitalCity = $capitalCookie;
    return true;
}

function parseCountryCode() {
    global $countryCodeCookie, $countryCode;
    if ($countryCodeCookie == null)
        return false;
    $countryCode = $countryCodeCookie;
    return true;
}

$kelvin = 273.15;
$weatherDesc = null;
$tempGeneral = null;
$tempFeel = null;
$tempMin = null;
$tempMax = null;
$pressure = null;

function parseWeather(){
    global $weatherCookie, $weatherDesc, $tempGeneral, $tempFeel, $tempMin, $tempMax ,$pressure, $kelvin;

    if ($weatherCookie == null)
        return false;

    $weatherData = json_decode($weatherCookie);
    if ($weatherData == null)
        return false;

    $weatherDesc = $weatherData->weather[0]->description;
    $tempGeneral = round($weatherData->main->temp - $kelvin, 2) . "°C";
    $tempFeel = round($weatherData->main->feels_like - $kelvin, 2) . "°C";
    $tempMin = round($weatherData->main->temp_min - $kelvin, 2) . "°C";
    $tempMax = round($weatherData->main->temp_max - $kelvin, 2) . "°C";
    $pressure = $weatherData->main->pressure . "hPa";

    return true;
}

$ip = null;
function parseIP(){
    global $ipCookie, $ip;

    if ($ipCookie == null)
        return false;
    $ip = $ipCookie;
    return true;
}

$formatted_datetime = null;
function parseDateTime(){
    global $dateCookie, $formatted_datetime;

    if ($dateCookie == null)
        return false;

    $datetime = DateTime::createFromFormat("d. m. Y H:i:s", $dateCookie);
    $formatted_datetime = $datetime->format("Y-m-d H:i:s");

    return true;
}

$dateNow = date("Y-m-d");

$sql = "SELECT ip_address FROM users WHERE date_time LIKE '%$dateNow%' AND ip_address LIKE '%$ip%'";
$stmt = $db->prepare($sql);
$stmt->execute();
$stmt->fetchAll(PDO::FETCH_ASSOC);



if (parseGPS() && parseCapital() && parseCountryCode() && parseWeather() && parseIP() && parseDateTime() && $stmt->rowCount() == 0){

    $sql = "INSERT INTO users (ip_address,user_address, country,country_code,lat,lng, date_time) VALUES (?,?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $success = $stmt->execute([$ip, $userAddress, $country,$countryCode ,$lat,$lng, $formatted_datetime]);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
            integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style/style.css" />

    <title>Zadanie4</title>
</head>
<body>


<div class="d-flex pt-2 justify-content-center"><h1>Zadanie 4</h1></div>

<header class="mb-3 mt-2">
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="description.php">Popis údajov adresy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="visitor.php">Návštevníci Portálu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container-sm p-2 border rounded mb-3">
    <h3>Informácie</h3>
    <hr>
    <h5>GPS súradnice adresy: <span id="coords"><?php echo $lat . ", " . $lng?></span></h5>
    <h5>Štát mesta: <span id="country"><?php echo $country?></span></h5>
    <h5>Hlavné mesto: <span id="capital"><?php echo $capitalCity?></span></h5>
</div>

<div class="container-sm p-2 border rounded mb-3">
    <h3>Počasie</h3>
    <hr>
    <h5>Stav počasia: <span id="temp-desc" class="fst-italic"><?php echo $weatherDesc?></span></h5>
    <h5>Teplota: <span id="temp"><?php echo $tempGeneral?></span></h5>
    <h5>Pocitová teplota: <span id="temp-feel"><?php echo $tempFeel?></span></h5>
    <h5>Minimálna teplota: <span id="temp-min"><?php echo $tempMin?></span></h5>
    <h5>Maximálna teplota: <span id="temp-max"><?php echo $tempMax?></span></h5>
    <h5>Tlak: <span id="pressure"><?php echo $pressure?></span></h5>
</div>

<footer class="d-flex justify-content-center py-3 my-4 mt-4 border-top border-dark-subtle">
    <span class="text-muted">© 2023 Marián Figula</span>
</footer>

</body>
</html>

