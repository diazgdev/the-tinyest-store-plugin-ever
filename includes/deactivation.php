<?php

function delete_plugin_pages() {
    $pages_to_delete = array(
        'Realizar pedido',
        'Gracias por tu compra',
        'Confirm',
        'Location'
    );

    foreach ($pages_to_delete as $title) {
        $existing_page = get_page_by_title($title);

        if ($existing_page) {
            wp_delete_post($existing_page->ID, true); // true: Bypass the Trash
        }
    }

    // TO-DO: Maybe delete them by ID instead of title?

    delete_option('realizar_pedido_page_id');
    delete_option('gracias_por_tu_compra_page_id');
    delete_option('confirm_page_id');
    delete_option('location_page_id');
}

register_deactivation_hook( __FILE__, 'delete_plugin_pages' );
