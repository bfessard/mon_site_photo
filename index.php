<!DOCTYPE html>
<head>
    <?php error_reporting(E_ALL);
include('const.inc.php');
include('fcts_bdd.php');
$bdd= BDD::appelBDD();
$tableauGPS=BDD::selectallBDD($bdd);
?>
<script>

   var monTableauJs = <?=json_encode($tableauGPS);?>;
   var API_KEY = <?=json_encode(API_KEY);?>;
   var data=[];
   var n=0;
    while(n<monTableauJs.length){
        data.push(
            {
                id: monTableauJs[n][0],
                country:monTableauJs[n][3],
                city:monTableauJs[n][4],
                lat:parseFloat(monTableauJs[n][1]),
                lng: parseFloat(monTableauJs[n][2]),
                endroit: monTableauJs[n][5],
                description: monTableauJs[n][6],
                image: monTableauJs[n][7]
            }
        );
        n++;

    }

</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="assets/css/leaflet/leaflet.css" />
    <script src="assets/JS/leaflet/leaflet.js"></script>


</head>
<body>
<div id="mapid" style=""></div>
<script>
    var place=[];
    var mymap = L.map('mapid').setView([49.4157, 1.3667], 13);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        style:'mapbox://styles/bfessard/cjgqjrwst00092snqp54v38t5',
        accessToken: 'pk.eyJ1IjoiYmZlc3NhcmQiLCJhIjoiY2pncWhueGk2MDA0YjJ3cGU0b291eTB6aiJ9.J2PzC5Qmbpya0MmTZ5ezAw'
    }).addTo(mymap);

    var blueIcon= L.icon({
        iconUrl:'pictures/leaflet/marker-icon.png',

        iconSize: [25,41]
    });
    for(var i=0; i<data.length; i++)
    place=data[i];
    features =[];
    features.push({
        position
    })
    var marker = L.marker([place.lat,place.lng],{icon: blueIcon}).addTo(mymap);
    marker.bindPopup("<b>Hello!</b><br> je suis un popup sur un marker.");



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

<script src="assets/JS/GoogleMapsAPI/markerclusterer.js">
</script>

<script type="text/javascript" src="assets/JS/AJAX/libs/Jquery/3.3.1/JQuery.min.js"> </script>
<script type='text/javascript' src='//blog.chibi-nah.fr/images/map/markers.json'></script>
<script type='text/javascript' src='//blog.chibi-nah.fr/images/map/leafScript.js'></script>
<script src="featherlight-1.7.12/release/featherlight.min.js" type="text/javascript"></script>


</body>
</html>

