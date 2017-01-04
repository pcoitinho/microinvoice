<?php
function mi_register_post_type() {

  // register invoices CPT
  $invoice_labels = array(
    'name'            => __( 'Invoices', 'mi' ),
    'singular_name'   => __( 'Invoice', 'mi' ),
    'add_new_item'    => __( 'Add New Invoice', 'mi' ),
    'edit_item'       => __( 'Edit Invoice', 'mi' )
  );
  $invoice = array(
    'labels'          => $invoice_labels,
    'public'          => false,
    'show_ui'         => true
  );

  register_post_type( 'invoice', $invoice );

  // register company taxonmy
  $company_labels = array(
    'name'            => __( 'Companies', 'mi' ),
    'singular_name'   => __( 'Company', 'mi' )
  );
  $company = array(
    'labels'          => $company_labels,
    'public'          => false,
    'show_ui'         => true,
    'hierarchical'    => true
  );

  register_post_type( 'company', $company );


}
