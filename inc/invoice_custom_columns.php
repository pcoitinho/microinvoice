<?php

function mi_manage_edit_invoice_columns( $columns ) {

	$columns[ 'invoice_total' ] = __( 'Invoice Total', 'mi' );

	return $columns;
}

function mi_manage_invoice_post_custom_column( $column, $post_id ) {
  switch ( $column ) {
    case 'invoice_total':
      // get the invoice meta
      $items = get_post_meta( $post_id, 'invoice_items', true );

      if ( empty( $items ) ) {
        echo __( 'No items', 'mi' );
      } else {

        // sum up total
        $total = 0.0;
        foreach ( $items as $item ) {
          $total += ( $item[ 'quantity' ] ) * floatval( $item[ 'value' ]);
        }

        echo apply_filters( 'invoice_currency', '$') . number_format( $total, 2);
      }

      break;
  }
}
