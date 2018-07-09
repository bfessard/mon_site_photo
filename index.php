<!DOCTYPE html>
<head>
    <?php error_reporting(E_ALL);
include('const.inc.php');
include('fcts_bdd.php');
$bdd= BDD::appelBDD();
$tableauGPS=BDD::selectallBDD($bdd);
    for ($i=0;$i< count($tableauGPS);$i++){

        $reponse = BDD::findMiniature($bdd,$tableauGPS[$i][4]);
        while($donnnes = $reponse ->fetch()){

            $image[] = array($donnnes['image']);
        }
    }
?>
<script>
    var monTableauJs= [];
    var imageMiniature =[];
   monTableauJs = <?=json_encode($tableauGPS);?>;
   imageMiniature = <?= json_encode($image);?>;
   var API_KEY = <?=json_encode(API_KEY);?>;
   var data=[];
   var n=0;
    while(n<monTableauJs.length){
        data.push(
            {

                country:monTableauJs[n][2],
                city:monTableauJs[n][3],
                lat:parseFloat(monTableauJs[n][0]),
                lng: parseFloat(monTableauJs[n][1]),
                endroit: monTableauJs[n][4],
                description: monTableauJs[n][5],
                image: imageMiniature[n][0]
            }
        );
        n++;

    }


</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="assets/css/map/world_map_css.css">
    <link rel="stylesheet" href="assets/css/leaflet/leaflet.css" />
    <link rel="stylesheet" href="assets/css/leaflet/MarkerCluster.css" />
    <link rel="stylesheet" href="assets/css/leaflet/MarkerCluster.Default.css" />

    <script src="assets/JS/leaflet/leaflet.js"></script>
    <script src="assets/JS/leaflet/leaflet.markercluster.js"></script>

</head>
<body>
<div id="mapid" style=""></div>
<script>
    var place=[];
    var mymap = L.map('mapid').setView([49.4157, 1.3667], 3);

    L.tileLayer('https://api.mapbox.com/styles/v1/bfessard/cjgqjrwst00092snqp54v38t5/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYmZlc3NhcmQiLCJhIjoiY2pncWhueGk2MDA0YjJ3cGU0b291eTB6aiJ9.J2PzC5Qmbpya0MmTZ5ezAw', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        minZoom: 3,
        maxZoom: 18,
        id: 'mapbox.streets',
        style:'mapbox://styles/bfessard/cjgqjrwst00092snqp54v38t5',
        accessToken: 'pk.eyJ1IjoiYmZlc3NhcmQiLCJhIjoiY2pncWhueGk2MDA0YjJ3cGU0b291eTB6aiJ9.J2PzC5Qmbpya0MmTZ5ezAw'
    }).addTo(mymap);

    var blueIcon= L.icon({
        iconUrl:'pictures/leaflet/marker-icon.png',

        iconSize: [25,41]
    });



    var markers = L.markerClusterGroup({spiderfyOnMaxZoom: false, showCoverageOnHover: false,disableClusteringAtZoom: 15 , zoomToBoundsOnClick: true});
    function CreateMarkerGroup (){
        for(var i = 0; i < data.length; i++){
            place = data[i];
            console.log(data);
            function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
                return machaine.replace(new RegExp(chaineARemaplacer, 'g'),chaineDeRemplacement);
            }
            var machaine = place.endroit;

            machaine = machaine.replace('_',' ');
            var m = L.marker([place.lat,place.lng],{icon: blueIcon});
            var contenuInfoBulle = '<h1 class=leaflet-infoWindow-Tittle>'+ replaceAll(machaine,'_',' ')+'</h1>'+
                '<img id="lettrineImage" src="pictures/' + place.country + '/' + place.city +'/'+ place.image +'"  title="'+place.endroit+'" />'
                +'<p class="propertyWindow">'+ place.description +'</p>' + '<button href="#" data-featherlight="diapo.php?variable='+place.endroit+'">Voir les photos</button>';
            m.bindPopup(contenuInfoBulle);
            markers.addLayer(m);
        }

    }
    markers.on('clusterclick', function (a) {
        a.layer.zoomToBounds();
    });
    CreateMarkerGroup();
    mymap.addLayer(markers);


   /* var myLatLng;
    var place=[];
    function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
            'zoom': 3,
            'zoomControl': false,
            'minZoom': 3,
            'maxZoom': 16,
            'center': {lat: 49.4167, lng: 1.3667}

        });
        var placeMarkerList = {};


        for (var i = 0; i < data.length; i++) {

            place = data[i];
            features = [];
            var latLng = new google.maps.LatLng(place.lat, place.lng);
            features.push({
                position: latLng
            });

            features.forEach(function (feature) {
                var marker = new google.maps.Marker({
                    position: feature.position,
                    map: map,
                    title: place.endroit
                });
                function replaceAll(machaine, chaineARemaplacer, chaineDeRemplacement) {
                    return machaine.replace(new RegExp(chaineARemaplacer, 'g'),chaineDeRemplacement);
                }
                var machaine = place.endroit;

                machaine = machaine.replace('_',' ');

                var contenuInfoBulle ='<h1>'+ replaceAll(machaine,'_',' ')+ "</h1>" +
                '<img id="lettrineImage" src="pictures/' + place.country + '/' + place.city +'/'+ place.image +'"  title="'+place.endroit+'" />'
                    +'<p class="propertyWindow">'+ place.description +'</p>' + '<button href="#" data-featherlight="diapo.php?variable='+place.endroit+'">Voir les photos</button>';

                var infowindow = new google.maps.InfoWindow({
                    content: contenuInfoBulle
                });

                marker.addListener('click', function() {
                    infowindow.open(map,marker);
                });

                if (!placeMarkerList.hasOwnProperty(place.country)) {
                    placeMarkerList[place.country] = [];
                }
                placeMarkerList[place.country].push(marker);
            });

        }
        for (var country in placeMarkerList) {
            if (placeMarkerList.hasOwnProperty(country)) {
                var markerCluster = new MarkerClusterer(map, placeMarkerList[country], {
                    maxZoom: 14,
                    imagePath: 'https://googlemaps.github.io/js-marker-clusterer/images/m'
                });
            }
        }
    }


*/
</script>

<script type="text/javascript" src="assets/JS/AJAX/libs/Jquery/3.3.1/JQuery.min.js"> </script>
<script src="featherlight-1.7.12/release/featherlight.min.js" type="text/javascript"></script>
<script src="featherlight-1.7.12/release/featherlight.gallery.min.js" type="text/javascript"></script>





</body>
</html>

