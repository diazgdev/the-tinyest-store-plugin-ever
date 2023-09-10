<?php

function crear_metaboxes_pedido() {
  add_meta_box('metabox-detalles-cliente', 'Detalles del Cliente', 'mostrar_metabox_detalles_cliente', 'pedido', 'normal', 'high');
  add_meta_box('metabox-producto-comprado', 'Producto Comprado', 'mostrar_metabox_producto_comprado', 'pedido', 'normal', 'high');
}
add_action('add_meta_boxes', 'crear_metaboxes_pedido');

// Show the client details in the metabox
function mostrar_metabox_detalles_cliente($post) {
  $nombre_cliente = get_post_meta($post->ID, 'nombre_cliente', true);
  $calle = get_post_meta($post->ID, 'calle', true);
  $colonia = get_post_meta($post->ID, 'colonia', true);
  $ciudad = get_post_meta($post->ID, 'ciudad', true);
  $estado = get_post_meta($post->ID, 'estado', true);
  $codigo_postal = get_post_meta($post->ID, 'codigo_postal', true);
  $telefono = get_post_meta($post->ID, 'telefono', true);
  $email_cliente = get_post_meta($post->ID, 'email_cliente', true);

  echo '<p><strong>Nombre:</strong> ' . esc_html($nombre_cliente) . '</p>';
  echo '<p><strong>Calle y número:</strong> ' . esc_html($calle) . '</p>';
  echo '<p><strong>Colonia:</strong> ' . esc_html($colonia) . '</p>';
  echo '<p><strong>Ciudad:</strong> ' . esc_html($ciudad) . '</p>';
  echo '<p><strong>Estado:</strong> ' . esc_html($estado) . '</p>';
  echo '<p><strong>Código Postal:</strong> ' . esc_html($codigo_postal) . '</p>';
  echo '<p><strong>Teléfono:</strong> ' . esc_html($telefono) . '</p>';
  echo '<p><strong>Email:</strong> ' . esc_html($email_cliente) . '</p>';
}

// Show the purchased product in the metabox
function mostrar_metabox_producto_comprado($post) {
  // Only the product name for now
  $producto_id = get_post_meta($post->ID, 'producto_id', true);
  $nombre_producto = get_the_title($producto_id);

  echo '<p><strong>Producto:</strong> ' . esc_html($nombre_producto) . '</p>';
}

function mostrar_mensaje_agradecimiento($content) {
  $pagina_agradecimiento_id = get_option('gracias_por_tu_compra_page_id');

  if (is_page($pagina_agradecimiento_id)) {
      $nombre = isset($_GET['nombre']) ? sanitize_text_field(urldecode($_GET['nombre'])) : '';
      $producto_id = isset($_GET['producto_id']) ? intval($_GET['producto_id']) : 0;

      // Get the product from its ID
      $nombre_producto = $producto_id ? get_the_title($producto_id) : '';

      $mensaje = "<div class='mensaje-agradecimiento'>";
      $mensaje .= "<p>Hola " . esc_html($nombre) . ",</p>";
      $mensaje .= "<p>Realizaste correctamente tu pedido de " . esc_html($nombre_producto) . "</p>";
      $mensaje .= "<p>Sigue las siguientes instrucciones para terminar tu compra:</p>";
      $mensaje .= "</div>";

      $content .= $mensaje;
  }
  return $content;
}
add_filter('the_content', 'mostrar_mensaje_agradecimiento', 20);

?>
