<?php
/*
Plugin Name: The tinyest store plugin ever
Plugin URI: https://web.com/
Description: Custom Store
Version: 1.0
Author:
Author URI: https://web.com/
License: GPL2
Text Domain: the-tinyest-store-plugin-ever
*/

require __DIR__ . '/vendor/autoload.php';

include_once plugin_dir_path(__FILE__) . 'includes/setup.php';
include_once plugin_dir_path(__FILE__) . 'includes/custom-post-types.php';
include_once plugin_dir_path(__FILE__) . 'includes/front-end-functions.php';
include_once plugin_dir_path(__FILE__) . 'includes/order-processing.php';
include_once plugin_dir_path(__FILE__) . 'includes/admin-functions.php';
include_once plugin_dir_path(__FILE__) . 'includes/deactivation.php';

// Registra el hook de activación
register_activation_hook(plugin_basename(__FILE__), 'create_plugin_pages');

// Registra el hook de desactivación
register_deactivation_hook(plugin_basename(__FILE__), 'delete_plugin_pages');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$api_key = getenv('API_KEY');


// Eliminar CPTs (solo para pruebas). TO-DO: Eliminar antes de subir
// function eliminar_cpt() {
//   unregister_post_type('pedido');
//   unregister_post_type('producto');
// }
// add_action('init', 'eliminar_cpt');
