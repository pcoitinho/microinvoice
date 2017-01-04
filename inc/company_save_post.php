<?php

/**
*
*/

function mi_company_save_post( $post_id, $post) {

  // check post type
  if ( get_post_type( $post_id ) !== 'company' ) {
    return;
  }

  // ignore on new posts
  if ( get_current_screen()->action == 'add') {
    return;
  }

  // check nonce
  check_admin_referer( 'save_company', 'mi_save_company_address' );

  // get a list of address items, by input name and post meta slug
  $address_elements = array(
    'mi_address_line_1'     => 'company_addres_line_1',
    'mi_address_line_2'     => 'company_address_line_2',
    'mi_address_line_3'     => 'company_address_line_3',
    'mi_address_postalcode' => 'company_address_postalcode',
    'mi_address_city'       => 'company_address_city',
    'mi_address_country'    => 'company_address_country'
  );

  // keep track of address as array
  $address = array();

  // save each element available to address array, using slugs
  foreach ( $address_elements as $name => $slug ) {
    if ( isset( $_POST[ $name ] ) && ! empty( $_POST[ $name  ] ) ) {
      $address[ $slug ] = sanitize_text_field( $_POST[ $name ] );
    }
  }

  update_post_meta( $post_id, 'company_address', $address);

}
