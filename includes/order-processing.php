<?php
function procesar_pedido() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_cliente']) && isset($_POST['email_cliente'])) {
      $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
      $calle = sanitize_text_field($_POST['calle']);
      $colonia = sanitize_text_field($_POST['colonia']);
      $ciudad = sanitize_text_field($_POST['ciudad']);
      $estado = sanitize_text_field($_POST['estado']);
      $codigo_postal = sanitize_text_field($_POST['codigo_postal']);
      $telefono = sanitize_text_field($_POST['telefono']);
      $email_cliente = sanitize_email($_POST['email_cliente']);

      $pedido = array(
          'post_title'    => 'Pedido de ' . $nombre_cliente,
          'post_status'   => 'publish',
          'post_type'     => 'pedido',
      );

      $pedido_id = wp_insert_post($pedido);
      $producto_id = sanitize_text_field($_POST['producto_id']);
      $nombre_producto = get_the_title($producto_id);

      add_post_meta($pedido_id, 'producto_id', $producto_id);

      add_post_meta($pedido_id, 'nombre_cliente', $nombre_cliente);
      add_post_meta($pedido_id, 'calle', $calle);
      add_post_meta($pedido_id, 'colonia', $colonia);
      add_post_meta($pedido_id, 'ciudad', $ciudad);
      add_post_meta($pedido_id, 'estado', $estado);
      add_post_meta($pedido_id, 'codigo_postal', $codigo_postal);
      add_post_meta($pedido_id, 'telefono', $telefono);
      add_post_meta($pedido_id, 'email_cliente', $email_cliente);

      $pagina_agradecimiento_id = get_option('gracias_por_tu_compra_page_id');

      $url_agradecimiento = add_query_arg(array(
        'nombre' => urlencode($nombre_cliente),
        'producto_id' => $producto_id
    ), get_permalink($pagina_agradecimiento_id));

      wp_redirect($url_agradecimiento, 303);
      exit;
  }
}
add_action('template_redirect', 'procesar_pedido');
?>
