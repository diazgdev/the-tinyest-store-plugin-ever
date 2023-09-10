<?php

function agregar_boton_comprar($content) {
  // $checkout_page_id = get_option('realizar_pedido_page_id'); TO-DO: Is this needed?

  // Check if we are on a single product page
  if (get_post_type() === 'producto' && is_singular()) {
      $pagina_pedido_id = get_option('realizar_pedido_page_id');

      $link = get_permalink($pagina_pedido_id) . '?producto_id=' . get_the_ID();
      $boton = '<a href="' . $link . '" class="btn-comprar">Comprar</a>';
      $content .= $boton;
  }
  return $content;
}
add_filter('the_content', 'agregar_boton_comprar');

function mostrar_formulario_pedido($content) {
  static $formulario_agregado = false;

  if ($formulario_agregado) {
      return $content;
  }

  $checkout_page_id = get_option('realizar_pedido_page_id');

  if (is_page($checkout_page_id)) {
      $producto_id = isset($_GET['producto_id']) ? intval($_GET['producto_id']) : null;
      $nombre_producto = get_the_title($producto_id);

      $formulario = '<h2>Realizar pedido para: ' . esc_html($nombre_producto) . '</h2>';
      $formulario .= '<form id="nombre_form" action="' . get_the_permalink() . '" method="post">
          <label for="nombre_cliente_id">Nombre:</label>
          <input type="text" id="nombre_cliente_id" name="nombre_cliente" required><br>
          <input type="hidden" name="producto_id" value="' . $producto_id . '">
          <input type="submit" value="Continuar">
      </form>';

      $content .= $formulario;

      $formulario_agregado = true;
  }

  return $content;
}
add_filter('the_content', 'mostrar_formulario_pedido');

function procesar_nombre() {
  if(isset($_POST['nombre_cliente'])) {
      session_start();
      $_SESSION['nombre_cliente'] = sanitize_text_field($_POST['nombre_cliente']);

      echo json_encode(array('success' => true));
  } else {
      echo json_encode(array('success' => false));
  }
  wp_die();
}
add_action('wp_ajax_procesar_nombre', 'procesar_nombre');
add_action('wp_ajax_nopriv_procesar_nombre', 'procesar_nombre');

function mostrar_mapa($content) {
  static $mapa_agregado = false;
  if ($mapa_agregado) return $content;
  $location_page_id = get_option('location_page_id');

  // Check if we are on the "Location" page
  if (is_page($location_page_id)) {
      $mapa = '<h2>Seleccione su ubicación:</h2>';

      // Address field
      $mapa .= '<label for="address">Dirección:</label>';
      $mapa .= '<input type="text" id="address" name="address" placeholder="Ingrese o ajuste su dirección"><br><br>';

      // Map container
      $mapa .= '<div id="mapa" style="width:100%; height:400px;"></div>';
      $mapa .= '<input type="hidden" id="hidden_calle" name="hidden_calle">';
      $mapa .= '<input type="hidden" id="hidden_colonia" name="hidden_colonia">';
      $mapa .= '<input type="hidden" id="hidden_ciudad" name="hidden_ciudad">';
      $mapa .= '<input type="hidden" id="hidden_estado" name="hidden_estado">';
      $mapa .= '<input type="hidden" id="hidden_codigo_postal" name="hidden_codigo_postal">';

      $mapa .= '<button id="continueButton">Continuar</button>';

      $content .= $mapa;
      $mapa_agregado = true;
  }
  return $content;
}
add_filter('the_content', 'mostrar_mapa');

function google_map() {
  $location_page_id = get_option('location_page_id');
  $google_maps_api_key = $_ENV['GOOGLE_MAPS_API_KEY'];

  if (is_page(get_option('location_page_id'))) {
      wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $google_maps_api_key . '&libraries=places', array(), null, true);
      wp_enqueue_script('my-maps-script', plugin_dir_url(__FILE__) . 'maps.js', array('google-maps-api'), '1.0.0', true);
  }
}
add_action('wp_enqueue_scripts', 'google_map');

function enqueue_custom_scripts() {
  if (is_page(get_option('realizar_pedido_page_id'))) {
      wp_enqueue_script('form-interaction-script', plugin_dir_url(__FILE__) . 'form-interaction.js', array('jquery'), '1.0.0', true);
  }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function guardar_direccion() {
  session_start();
  $_SESSION['direccion_completa'] = $_POST['direccion'];
  $_SESSION['calle'] = $_POST['calle'];
  $_SESSION['colonia'] = $_POST['colonia'];
  $_SESSION['ciudad'] = $_POST['ciudad'];
  $_SESSION['estado'] = $_POST['estado'];
  $_SESSION['codigo_postal'] = $_POST['codigo_postal'];

  wp_send_json_success(array('message' => 'Dirección guardada con éxito.'));
}
add_action('wp_ajax_guardar_direccion', 'guardar_direccion');

function mostrar_formulario_confirmacion($content) {
  $confirm_page_id = get_option('confirm_page_id');
  // Check if we're on the "Confirm" page
  if (is_page($confirm_page_id)) {
      session_start();

      $nombre = isset($_SESSION['nombre_cliente']) ? $_SESSION['nombre_cliente'] : '';
      $direccion = isset($_SESSION['direccion_completa']) ? $_SESSION['direccion_completa'] : '';
      $calle = isset($_SESSION['calle']) ? $_SESSION['calle'] : '';
      $colonia = isset($_SESSION['colonia']) ? $_SESSION['colonia'] : '';
      $ciudad = isset($_SESSION['ciudad']) ? $_SESSION['ciudad'] : '';
      $estado = isset($_SESSION['estado']) ? $_SESSION['estado'] : '';
      $codigo_postal = isset($_SESSION['codigo_postal']) ? $_SESSION['codigo_postal'] : '';

      $formulario = '<h2>Confirma tus datos:</h2>';
      $formulario .= '<form id="confirm_form" action="' . get_the_permalink() . '" method="post">
          <label for="nombre_cliente_id">Nombre:</label>
          <input type="text" id="nombre_cliente_id" name="nombre_cliente" value="' . esc_attr($nombre) . '" readonly><br>
          <label for="address">Dirección completa:</label>
          <input type="text" id="address" name="address" value="' . esc_attr($direccion) . '" readonly><br>
          <label for="calle">Calle:</label>
          <input type="text" id="calle" name="calle" value="' . esc_attr($calle) . '" readonly><br>
          <label for="colonia">Colonia:</label>
          <input type="text" id="colonia" name="colonia" value="' . esc_attr($colonia) . '" readonly><br>
          <label for="ciudad">Ciudad:</label>
          <input type="text" id="ciudad" name="ciudad" value="' . esc_attr($ciudad) . '" readonly><br>
          <label for="estado">Estado:</label>
          <input type="text" id="estado" name="estado" value="' . esc_attr($estado) . '" readonly><br>
          <label for="codigo_postal">Código Postal:</label>
          <input type="text" id="codigo_postal" name="codigo_postal" value="' . esc_attr($codigo_postal) . '" readonly><br>
          <input type="submit" value="Confirmar Pedido">
      </form>';

      $content .= $formulario;
  }
  return $content;
}
add_filter('the_content', 'mostrar_formulario_confirmacion');

?>
