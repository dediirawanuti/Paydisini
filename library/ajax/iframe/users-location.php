<?php
require '../../../connect.php';
require _DIR_('library/session/session');

if(isset($data_user) && isset($_GET['__v'])) {
    $stype = $_GET['__v'];
    if(!isset($_SESSION['user'])) exit('No direct script access allowed!');
    if(!in_array($stype,['1','2','3'])) exit('No direct script access allowed!');
    $var_locations = '';
    $var_setViews = '[-0.789275, 113.921327], 5';
    
    if($stype == 1) {
        $search_location = $call->query("SELECT * FROM users_location");
        if($search_location->num_rows > 0) {
            while($data_location = $search_location->fetch_assoc()) {
                $var_locations .= '["'.$data_location['user'].'<br>'.$data_location['ud'].'<br>'.$data_location['dev'].'<br>'.$data_location['ip'].' ('.$data_location['loc'].')", '.$data_location['lat'].', '.$data_location['lon'].'],';
            }
        } else {
            exit('Location not found!');
        }
    } else if($stype == 2 && isset($_GET['u']) && $data_user['level'] == 'Admin') {
        $search_location = $call->query("SELECT * FROM users_location WHERE user = '".filter($_GET['u'])."'");
        if($search_location->num_rows > 0) {
            while($data_location = $search_location->fetch_assoc()) {
                $var_locations .= '["'.$data_location['ud'].'<br>'.$data_location['dev'].'<br>'.$data_location['ip'].' ('.$data_location['loc'].')", '.$data_location['lat'].', '.$data_location['lon'].'],';
            }
        } else {
            exit('User not found!');
        }
    } else if($stype == 3 && isset($_GET['u']) && isset($_GET['c'])) {
        $search_location = $call->query("SELECT * FROM users_cookie WHERE cookie = '".filter($_GET['c'])."' AND username = '$sess_username'");
        if($_GET['u'] <> $sess_username) {
            exit('What do you want?!');
        } else if($search_location->num_rows > 0) {
            $data_location = $search_location->fetch_assoc();
            $data_coor = explode(', ', $data_location['coor']);
            if(!isset($data_coor[1])) {
                exit('Location not found!');
            } else {
                $var_locations .= '["'.$data_location['ud'].'<br>'.$data_location['dev'].'<br>'.$data_location['ip'].' ('.$data_location['loc'].')", '.$data_location['coor'].'],';
                $var_setViews = '['.$data_location['coor'].'], 16';
            }
        } else {
            exit('SignIn Access not found!');
        }
    } else {
        exit('No direct script access allowed!');
    }
?>
<html>
    <head>
        <style>body, html { height: 100%; } #map { width: 100%; height: 100%;}</style>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="map" class="height-400"></div>
        <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
        <script type="text/javascript">
            var locations = [<?= $var_locations ?>];
            var map = L.map('map').setView(<?= $var_setViews ?>);
            mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; ' + mapLink + ' Contributors',maxZoom: 18,}).addTo(map);
            for (var i = 0; i < locations.length; i++) {
                marker = new L.marker([locations[i][1], locations[i][2]]).bindPopup(locations[i][0]).addTo(map);
            }
        </script>
    </body>
</html>
<?
} else {
	exit('No direct script access allowed!');
}