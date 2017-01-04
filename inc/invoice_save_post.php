<?php

function mi_invoice_save_post_item( $post_id, $post) {

  // check post type
  if ( get_post_type( $post_id ) !== 'invoice' ) {
      return;
  }

  // ignore on new posts
  if ( get_current_screen()->action == 'add') {
    return;
  }

  // check nonce
  check_admin_referer( 'save_invoice', 'mi_save_invoice_item' );

  // check date
  if ( isset( $_POST[ 'mi_date' ] ) && ! empty( $_POST[ 'mi_date' ] ) ) {
    update_post_meta( $post_id, 'invoice_date', sanitize_text_field( $_POST[ 'mi_date' ] ) );
  }

  // check Status
  if ( isset( $_POST[ 'mi_status' ] ) && ! empty( $_POST[ 'mi_status' ] ) ) {
    update_post_meta( $post_id, 'invoice_status', sanitize_text_field( $_POST[ 'mi_status' ] ) );
  }

  // check entries
  if ( isset( $_POST[ 'mi_invoice_item_item'] ) && ! empty( $_POST[ 'mi_invoice_item_item' ] ) ) {

      // update entries
      $items = array();

      // save information
      for ( $i = 0; $i < count( $_POST[ 'mi_invoice_item_item' ] ); $i++ ) {

        // only save if item has a description

        $item = $_POST[ 'mi_invoice_item_item' ][ $i ];
        if ( ! empty( $item )) {

          $items[] = array(
            'item'      => sanitize_text_field( $item ),
            'quantity'  => sanitize_text_field( $_POST[ 'mi_invoice_item_qnt' ][ $i ] ),
            'value'     => sanitize_text_field( $_POST[ 'mi_invoice_item_val' ][ $i ] )
          );

        }
      }

      error_log( print_r( $items, true) );

      // update the post meta
      update_post_meta( $post_id, 'invoice_items', $items );
  }

}
