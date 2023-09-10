<?php
function create_plugin_pages() {
  // Create the required pages when the plugin is activated
  $realizar_pedido_page_id = wp_insert_post(
      array(
          'post_title'     => 'Realizar pedido',
          'post_content'   => 'Custom content...',
          'post_status'    => 'publish',
          'post_type'      => 'page',
      )
  );

  $gracias_por_tu_compra_page_id = wp_insert_post(
      array(
          'post_title'     => 'Gracias por tu compra',
          'post_content'   => 'Custom content...',
          'post_status'    => 'publish',
          'post_type'      => 'page',
      )
  );

  $confirm_page_id = wp_insert_post(
      array(
          'post_title'     => 'Confirm',
          'post_content'   => 'Custom content...',
          'post_status'    => 'publish',
          'post_type'      => 'page',
      )
  );

  $location_page_id = wp_insert_post(
    array(
        'post_title'     => 'Location',
        'post_content'   => 'Custom content...',
        'post_status'    => 'publish',
        'post_type'      => 'page',
    )
  );

  // Save the page IDs for later use
  update_option('realizar_pedido_page_id', $realizar_pedido_page_id);
  update_option('gracias_por_tu_compra_page_id', $gracias_por_tu_compra_page_id);
  update_option('confirm_page_id', $confirm_page_id);
  update_option('location_page_id', $location_page_id);
}

register_activation_hook( __FILE__, 'create_plugin_pages' );

?>
