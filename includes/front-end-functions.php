<?php

function agregar_boton_comprar($content) {
  // $checkout_page_id = get_option('realizar_pedido_page_id'); TO-DO: ¿Esto es necesario?

  // Comprobar que es un 'producto' y que estamos en la vista singular
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

  $checkout_page_id = get_option( 'realizar_pedido_page_id' );

  // Comprobar que estamos en la página correcta
  if (is_page($checkout_page_id)) {
      $producto_id = isset($_GET['producto_id']) ? intval($_GET['producto_id']) : null;
      $nombre_producto = get_the_title($producto_id);

      $formulario = '<h2>Realizar pedido para: ' . esc_html($nombre_producto) . '</h2>';
      $formulario .= '<form action="' . get_the_permalink() . '" method="post">
          <label for="nombre_cliente_id">Nombre:</label>
          <input type="text" id="nombre_cliente_id" name="nombre_cliente" required><br>
          <label for="calle_id">Calle y número:</label>
          <input type="text" id="calle_id" name="calle" required><br>
          <label for="colonia_id">Colonia:</label>
          <input type="text" id="colonia_id" name="colonia" required><br>
          <label for="ciudad_id">Ciudad:</label>
          <input type="text" id="ciudad_id" name="ciudad" required><br>
          <label for="estado_id">Estado:</label>
          <input type="text" id="estado_id" name="estado" required><br>
          <label for="codigo_postal_id">Código Postal:</label>
          <input type="text" id="codigo_postal_id" name="codigo_postal" required><br>
          <label for="telefono_id">Teléfono:</label>
          <input type="text" id="telefono_id" name="telefono" required><br>
          <label for="email_cliente_id">Email:</label>
          <input type="email" id="email_cliente_id" name="email_cliente" required><br>
          <input type="hidden" name="producto_id" value="' . $producto_id . '">
          <input type="submit" value="Realizar pedido">
      </form>';

      $formulario .= '<div id="mapa" style="width:100%; height:400px;"></div>';

      $content .= $formulario;
  }
  return $content;
}
add_filter('the_content', 'mostrar_formulario_pedido');

function google_map() {
  if (is_page(get_option('realizar_pedido_page_id'))) {
      wp_enqueue_script('google-maps-api', '', array(), null, true);
      wp_enqueue_script('my-maps-script', plugin_dir_url(__FILE__) . 'maps.js', array('google-maps-api'), '1.0.0', true);
  }
}
add_action('wp_enqueue_scripts', 'google_map');

?>
