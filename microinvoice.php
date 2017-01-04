<?php

/*

Plugin Name: MicroInvoice
Description: Minimal invoice control and CRM sistem

*/

$plugindir = plugin_dir_url( __FILE__ );

/**
* Register Custom post types
*/

include( 'inc/custom_post_types.php' );

add_action( 'init', 'mi_register_post_type' );



/**
* Enqueue admin scripts
*/

include( 'inc/enqueue_scripts_styles.php' );

add_action( 'admin_enqueue_scripts', 'mi_enqueue_admin_scripts_styles' );

/**
* Register metaboxes
*/

include( 'inc/invoice_metaboxes.php' );
include( 'inc/company_metaboxes.php');

add_action( 'add_meta_boxes', 'mi_invoice_add_meta_boxes' );
add_action( 'add_meta_boxes', 'mi_company_add_meta_boxes' );

/**
* Post save behaviour
*/

include( 'inc/invoice_save_post.php' );
include( 'inc/company_save_post.php' );

add_action( 'save_post', 'mi_invoice_save_post_item', 10, 2 );
add_action( 'save_post', 'mi_company_save_post', 10, 2 );

/**
* Register custom columns
*/

include( 'inc/invoice_custom_columns.php' );

add_filter( 'manage_edit-invoice_columns', 'mi_manage_edit_invoice_columns' );
add_action( 'manage_invoice_posts_custom_column', 'mi_manage_invoice_post_custom_column', 5, 2 );

/**
* Register ajax actions
*/

include ( 'inc/ajax.php' );

add_action( 'wp_ajax_invoice_list_companies', 'mi_ajax_list_clients' );
