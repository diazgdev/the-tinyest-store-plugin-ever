document.querySelector("#nombre_form").addEventListener('submit', function(e) {
  e.preventDefault();

  var nombre = document.querySelector("#nombre_cliente_id").value;

  fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: new URLSearchParams({
          'action': 'procesar_nombre',
          'nombre_cliente': nombre
      }),
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      }
  })
  .then(response => response.json())
  .then(data => {
      if(data.success) {
          window.location.href = "/location";
      }
  });
});
