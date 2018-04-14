$(document).ready(function () {
        //initMap();
        initMap();
    }
);

function initMap() {
    var ciudad = ($('#map').data('ciudad'));
    var direccion = ($('#map').data('direccion'));
    var nombre = ($('#map').data('name'));
    var latitud = ($('#map').data('lat'));
    var longitud = ($('#map').data('long'));
    var uluru = {lat: Number(latitud), lng: Number(longitud)};

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: uluru
    });


    var infowindow = new google.maps.InfoWindow({});

    var marker = new google.maps.Marker({
        position: uluru,
        map: map,
        title: "Latitud: " + latitud + " Longitud: " + longitud,
        name: nombre,
        ciudad: ciudad,
        direccion: direccion
    });


    marker.addListener('click', function () {
        var datos =
            '<h1 id="firstHeading" class="firstHeading titulo">' + this.name + '</h1>' +
            '<div id="bodyContent">' +
            '<p>' + this.ciudad + '</p>' +
            '<p>' + this.direccion + '</p>' +
            '</div>'
        infowindow.setContent(datos);
        infowindow.open(map, marker);

        //infowindow.open(map, marker);
    });
}

