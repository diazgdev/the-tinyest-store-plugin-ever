document.addEventListener('DOMContentLoaded', function() {
  initMap();
});

function initMap() {
  // Coordenadas de Ciudad de México
  var defaultLatLng = {lat: 19.4326, lng: -99.1332};

  var map = new google.maps.Map(document.getElementById('mapa'), {
      center: defaultLatLng,
      zoom: 15
  });

  // Crea un marcador arrastrable y lo coloca en el centro del mapa
  var marker = new google.maps.Marker({
      position: map.getCenter(),
      draggable: true,
      map: map
  });

  // Crea el objeto Autocomplete
  var autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('calle_id'), {
          types: ['geocode']
      });
  autocomplete.bindTo('bounds', map);
  autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      console.log("Place: ", place)
      if (!place.geometry) {
          console.log("Autocomplete's returned place contains no geometry");
          return;
      }
      marker.setPosition(place.geometry.location);
      map.setCenter(place.geometry.location);

      // Establece el valor del campo de texto al resultado obtenido
      document.getElementById('calle_id').value = place.formatted_address;
  });

  // Agrega un listener al marcador para detectar cuando ha sido arrastrado y soltado
  google.maps.event.addListener(marker, 'dragend', function() {
    var position = marker.getPosition();

    // Usa la API de Geocoding para obtener la dirección basada en la posición del marcador
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'latLng': position}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                // Establece el valor del campo de texto al resultado obtenido
                document.getElementById('calle_id').value = results[0].formatted_address;

                // Ahora, usa el servicio PlacesService para obtener información detallada del lugar
                var service = new google.maps.places.PlacesService(map);
                service.getDetails({
                    placeId: results[0].place_id,
                    fields: ['name', 'formatted_address', 'place_id', 'geometry', 'photos']
                }, function(place, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        console.log("Place:", place);
                    }
                });

            } else {
                alert('No se encontraron resultados');
            }
        } else {
            alert('El geocodificador falló debido a: ' + status);
        }
    });
  });
}
