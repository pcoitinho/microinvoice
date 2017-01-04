<?php

function mi_manage_edit_invoice_columns( $columns ) {
	
	$columns[ 'invoice_total' ] = __( 'Invoice Total', 'mi' );
	$columns[ 'invoice_status' ] = __( 'Status', 'mi' );

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
		case 'invoice_status' :
			// get status
			$status = get_post_meta( $post_id, 'invoice_status', true);

			if ( empty( $status ) ) { $status = 'pending'; }

			// echo status
			printf( '<span class="mi_status mi_status_%1s">%2s</span>', $status, __( ucwords( $status ), 'mi' ) );

			break;

  }
}
