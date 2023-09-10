document.addEventListener('DOMContentLoaded', function() {
  initMap();
});

function initMap() {
  // Default to Mexico City
  var defaultLatLng = {lat: 19.4326, lng: -99.1332};

  var map = new google.maps.Map(document.getElementById('mapa'), {
      center: defaultLatLng,
      zoom: 15
  });

  var marker = new google.maps.Marker({
      position: map.getCenter(),
      draggable: true,
      map: map
  });

  var autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('address'), {
          types: ['geocode']
      });
  autocomplete.bindTo('bounds', map);
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    console.log("Place: ", place);
    if (!place.geometry) {
        console.log("Autocomplete's returned place contains no geometry");
        return;
    }
    marker.setPosition(place.geometry.location);
    map.setCenter(place.geometry.location);

    setPlaceComponents(place);
  });

  google.maps.event.addListener(marker, 'dragend', function() {
    var position = marker.getPosition();

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'latLng': position}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                console.log("Geocoder results:", results);

                setPlaceComponents(results[0]);

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

function setPlaceComponents(place) {
  var components = getPlaceComponents(place);
  document.getElementById('hidden_calle').value = components.calle;
  document.getElementById('hidden_colonia').value = components.colonia;
  document.getElementById('hidden_ciudad').value = components.ciudad;
  document.getElementById('hidden_estado').value = components.estado;
  document.getElementById('hidden_codigo_postal').value = components.codigo_postal;
  document.getElementById('address').value = place.formatted_address;
}

function getPlaceComponents(place) {
  let calleNombre = '';
  let calleNumero = '';
  let colonia = '';
  let ciudad = '';
  let estado = '';
  let codigo_postal = '';

  if (place.address_components) {
      for (let i = 0; i < place.address_components.length; i++) {
          let addr = place.address_components[i];
          console.log("Address component:", addr);
          if (addr.types.includes('route')) {
              calleNombre = addr.long_name;
          } else if (addr.types.includes('street_number')) {
              calleNumero = '#' + addr.long_name;
          } else if (addr.types.includes('sublocality')) {
              colonia += addr.long_name + ' ';
          } else if (addr.types.includes('locality')) {
              ciudad += addr.long_name + ' ';
          } else if (addr.types.includes('administrative_area_level_1')) {
              estado += addr.long_name + ' ';
          } else if (addr.types.includes('postal_code')) {
              codigo_postal = addr.long_name;
          }
      }
  }

  let calle = calleNombre + ' ' + calleNumero;

  return {
      calle: calle.trim(),
      colonia: colonia.trim(),
      ciudad: ciudad.trim(),
      estado: estado.trim(),
      codigo_postal: codigo_postal
  };
}

document.querySelector("#continueButton").addEventListener('click', function() {
  var direccion = document.querySelector("#address").value;
  var calle = document.querySelector("#hidden_calle").value;
  var colonia = document.querySelector("#hidden_colonia").value;
  var ciudad = document.querySelector("#hidden_ciudad").value;
  var estado = document.querySelector("#hidden_estado").value;
  var codigo_postal = document.querySelector("#hidden_codigo_postal").value;

  fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: new URLSearchParams({
          'action': 'guardar_direccion',
          'direccion': direccion,
          'calle': calle,
          'colonia': colonia,
          'ciudad': ciudad,
          'estado': estado,
          'codigo_postal': codigo_postal,
      }),
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      }
  })
  .then(response => response.json())
  .then(data => {
      console.log("Data:", data);
      if(data.success) {
          window.location.href = "/confirm";
      }
  });
});
