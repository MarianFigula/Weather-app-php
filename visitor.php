<?php
require_once('config.php');
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo $e->getMessage();
}

$sql = "SELECT country_code, COUNT(*) AS count_code FROM users GROUP BY country_code";
$stmt = $db->prepare($sql);
$stmt->execute();
$visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump($visitors);

$sql2 = "SELECT user_address, COUNT(*) AS count_address FROM users GROUP BY user_address";
$stmt2 = $db->prepare($sql2);
$stmt2->execute();
$visitorsCountry = $stmt2->fetchAll(PDO::FETCH_ASSOC);

//var_dump($visitorsCountry);

$dateNow = date("Y-m-d");

$sql3 = "SELECT date_time FROM users WHERE date_time LIKE '%$dateNow%'";
$stmt3 = $db->prepare($sql3);
$stmt3->execute();
$visitorsTime = $stmt3->fetchAll(PDO::FETCH_ASSOC);
//var_dump($visitorsTime);
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
    <link rel="stylesheet" type="text/css" href="style/visitors.css" />
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="scripts/tables.js"></script>

    <title>Návštevnosť portálu</title>
</head>
<body>


<div class="d-flex pt-2 justify-content-center"><h1>Návštevnosť portálu</h1></div>

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
                        <a class="nav-link" aria-current="page" href="index.php">Domov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="description.php">Popis údajov adresy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="visitor.php">Návštevníci Portálu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>



<div class="container-md table-responsive border border-dark rounded pt-2 pb-2 mb-5">
    <form action="#" method="post" onsubmit="return false;">
        <h3 class="text-center mt-2 mb-3">Návštevníci a ich krajiny</h3>
        <hr>
        <table class="table table-bordered table-striped" id="website-visitors">
            <thead>
            <tr>
                <th>POČET NÁVŠTEVNÍKOV</th>
                <th>ŠTÁT</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($visitors as $visitor) {
                $country_code = $visitor['country_code'];
                echo "<tr><td class='fs-6'>" . $visitor["count_code"] . "</td><td><a href='visitor-country.php?code=$country_code' id='$country_code'><img src='https://flagsapi.com/$country_code/shiny/64.png' width='33' height='33' alt='".$visitor['country_code']."'></a></td></tr>";
            }
            ?>

        </tbody>
    </table>
    </form>
</div>

<div class="container-md table-responsive border border-dark rounded pt-2 pb-2 mb-4">
    <h3 class="text-center mt-2 mb-3">Počet návštev stránky v priebehu jednéh dňa</h3>
    <hr>
    <table class="table table-bordered table-striped" id="visitors-time">
        <thead>
        <tr>
            <th>6:00-15:00</th>
            <th>15:00-21:00</th>
            <th>21:00-23:00</th>
            <th>00:00-6:00</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count1 = 0;
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        foreach ($visitorsTime as $visitor) {

            $datetime_str = $visitor["date_time"];

            $datetime = new DateTime($datetime_str);
            $hours_str = $datetime->format('H');

            $hours = intval($hours_str);

            if ($hours == 0){
                $hours = 24;
            }

            if ($hours > 6 && $hours <= 15){
                $count1++;
            } else if ($hours > 15 && $hours <= 21){
                $count2++;
            } else if ($hours > 21 && $hours <= 23){
                $count3++;
            } else if ($hours >= 0 && $hours <= 6){
                $count4++;
            }
        }
        ?>
            <tr>
                <td><?php echo $count1?></td>
                <td><?php echo $count2?></td>
                <td><?php echo $count3?></td>
                <td><?php echo $count4?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="container-md border border-dark rounded pt-4 pb-4 mb-4">
    <h3 class="text-center mb-3">Zobrazenie návštevníkov portálu</h3>
    <hr>
    <div id="map" class="center-content rounded pb-2"></div>
</div>

<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
    ({key: "AIzaSyBPxCp1fTlpVPHqv0Cwce4R7r8pbn0LUz8", v: "beta"});</script>


<footer class="d-flex justify-content-center py-3 my-4 mt-4 border-top border-dark-subtle">
    <span class="text-muted">© 2023 Marián Figula</span>
</footer>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

<?php

$sql3 = "SELECT lat,lng FROM users";
$stmt3 = $db->prepare($sql3);
$stmt3->execute();
$markers = $stmt3->fetchAll(PDO::FETCH_ASSOC);

?>

<script>
    let map;

    var users = <?php echo json_encode($markers); ?>;

    console.log(users[0])

    async function initMap() {
        const map_position = {lat: 31.9188, lng: 32.866287};
        // Request needed libraries.
        //@ts-ignore
        const {Map} = await google.maps.importLibrary('maps');
        const {PinView} = await google.maps.importLibrary('marker');

        map = new Map(document.getElementById('map'), {
            zoom: 2,
            center: map_position,
            mapId: 'DEMO_MAP_ID',
        });

        for (let i = 0; i < users.length; i++) {
            let lat = parseFloat(users[i].lat);
            let lng = parseFloat(users[i].lng);
            const marker = new google.maps.Marker({
                map: map,
                position: {lat: lat, lng: lng},
                icon: {
                    url: 'icons/geo-alt-fill.svg',
                    scaledSize: new google.maps.Size(50, 20), // Set the size of the marker image
                },
            });
        }
    }
    initMap();
</script>
</body>
</html>

