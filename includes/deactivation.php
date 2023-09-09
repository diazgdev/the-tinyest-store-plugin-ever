<?php

function delete_plugin_pages() {
    $pages_to_delete = array(
        'Realizar pedido',
        'Gracias por tu compra',
        'Confirm',
        'Location'
    );

    foreach ($pages_to_delete as $title) {
        // Obtener la página por título
        $existing_page = get_page_by_title($title);

        if ($existing_page) {
            // Si la página existe, eliminarla
            wp_delete_post($existing_page->ID, true); // El segundo parámetro 'true' hace que se elimine de forma permanente (no se moverá a la papelera)
        }
    }

    // Opcionalmente, puedes eliminar las opciones relacionadas con estas páginas
    delete_option('realizar_pedido_page_id');
    delete_option('gracias_por_tu_compra_page_id');
    delete_option('confirm_page_id');
    delete_option('location_page_id');
}

register_deactivation_hook( __FILE__, 'delete_plugin_pages' );
