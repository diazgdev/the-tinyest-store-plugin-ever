<?php

function registrar_cpt_productos() {
  $labels = array(
      'name'                  => _x('Productos', 'Post type general name', 'custom-store-plugin'),
      'singular_name'         => _x('Producto', 'Post type singular name', 'custom-store-plugin'),
      'menu_name'             => _x('Productos', 'Admin Menu text', 'custom-store-plugin'),
      'name_admin_bar'        => _x('Producto', 'Add New on Toolbar', 'custom-store-plugin'),
      'add_new'               => __('Añadir nuevo', 'custom-store-plugin'),
      'add_new_item'          => __('Añadir nuevo producto', 'custom-store-plugin'),
      'new_item'              => __('Nuevo producto', 'custom-store-plugin'),
      'edit_item'             => __('Editar producto', 'custom-store-plugin'),
      'view_item'             => __('Ver producto', 'custom-store-plugin'),
      'all_items'             => __('Todos los productos', 'custom-store-plugin'),
      'search_items'          => __('Buscar productos', 'custom-store-plugin'),
      'parent_item_colon'     => __('Productos padres:', 'custom-store-plugin'),
      'not_found'             => __('No se encontraron productos.', 'custom-store-plugin'),
      'not_found_in_trash'    => __('No se encontraron productos en la papelera.', 'custom-store-plugin'),
      'featured_image'        => _x('Imagen destacada del producto', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'custom-store-plugin'),
      'set_featured_image'    => _x('Establecer imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'custom-store-plugin'),
      'remove_featured_image' => _x('Quitar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'custom-store-plugin'),
      'use_featured_image'    => _x('Usar como imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'custom-store-plugin'),
      'archives'              => _x('Archivo de productos', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'custom-store-plugin'),
      'insert_into_item'      => _x('Insertar en producto', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'custom-store-plugin'),
      'uploaded_to_this_item' => _x('Subido a este producto', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'custom-store-plugin'),
      'filter_items_list'     => _x('Filtrar lista de productos', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'custom-store-plugin'),
      'items_list_navigation' => _x('Navegación de lista de productos', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'custom-store-plugin'),
      'items_list'            => _x('Lista de productos', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'custom-store-plugin'),
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'producto'),
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => 5,
      'supports'           => array('title', 'editor', 'thumbnail'),
      'menu_icon'          => 'dashicons-cart',
      'show_in_rest'       => true,
  );

  register_post_type('producto', $args);
}

add_action('init', 'registrar_cpt_productos');

function registrar_cpt_pedido() {
  $labels = array(
      'name'                  => _x('Pedidos', 'Post type general name', 'custom-store-plugin'),
      'singular_name'         => _x('Pedido', 'Post type singular name', 'custom-store-plugin'),
      'menu_name'             => _x('Pedidos', 'Admin Menu text', 'custom-store-plugin'),
      'name_admin_bar'        => _x('Pedido', 'Add New on Toolbar', 'custom-store-plugin'),
      'add_new'               => __('Añadir nuevo', 'custom-store-plugin'),
      'add_new_item'          => __('Añadir nuevo pedido', 'custom-store-plugin'),
      'new_item'              => __('Nuevo pedido', 'custom-store-plugin'),
      'edit_item'             => __('Editar pedido', 'custom-store-plugin'),
      'view_item'             => __('Ver pedido', 'custom-store-plugin'),
      'all_items'             => __('Todos los pedidos', 'custom-store-plugin'),
      'search_items'          => __('Buscar pedidos', 'custom-store-plugin'),
      'parent_item_colon'     => __('Pedidos padres:', 'custom-store-plugin'),
      'not_found'             => __('No se encontraron pedidos.', 'custom-store-plugin'),
      'not_found_in_trash'    => __('No se encontraron pedidos en la papelera.', 'custom-store-plugin'),
      'archives'              => _x('Archivo de pedidos', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'custom-store-plugin'),
      'items_list'            => _x('Lista de pedidos', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'custom-store-plugin'),
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array('slug' => 'pedido'),
      'capability_type'    => 'post',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => 6,
      'supports'           => array('title'),
      'menu_icon'          => 'dashicons-list-view',
  );

  register_post_type('pedido', $args);
}

add_action('init', 'registrar_cpt_pedido');

?>
