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


    <link rel="stylesheet" href="CSS/map/world_map_css.css" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="featherlight-1.7.12/release/featherlight.min.css" type="text/css" rel="stylesheet"/>
    <title>Mes voyages !!</title>
    <style>

        #map {
            height: 100%;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="map"></div>
<script>
    var myLatLng;
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
                console.log(place.endroit);
                var contenuInfoBulle ="<h1>"+ replaceAll(machaine,'_',' ')+ "</h1>" +
                '<img id="lettrineImage" src="pictures/' + place.country + '/' + place.city +'/'+ place.image +'"  title="'+place.endroit+'" />'
                    +'<p align="justify" class="propertyWindow">'+ place.description +'</p>' + '<button href="#" data-featherlight="diapo.php?variable='+place.endroit+'">Voir les photos</button>';

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



</script>

<script src="JS/GoogleMapsAPI/markerclusterer.js">
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?=API_KEY?>&callback=initMap">
</script>
<script type="text/javascript" src="JS/AJAX/libs/Jquery/3.3.1/JQuery.min.js"> </script>


<script src="featherlight-1.7.12/release/featherlight.min.js" type="text/javascript"></script>


</body>
</html>

