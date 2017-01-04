<?php

function mi_manage_edit_invoice_columns( $columns ) {

	unset( $columns[ 'date' ] );
	$columns[ 'invoice_client' ] = __( 'Client', 'mi' );
	$columns[ 'invoice_total' ] = __( 'Invoice Total', 'mi' );
	$columns[ 'invoice_date']	= __( 'Payment date', 'mi' );
	$columns[ 'invoice_status' ] = __( 'Status', 'mi' );

	return $columns;
}

function mi_manage_invoice_post_custom_column( $column, $post_id ) {
  switch ( $column ) {
		case 'invoice_client' :

			$company_id = intval( get_post_meta( $post_id, 'invoice_company_id', true ) );

			if ( ! empty( $company_id ) ) {
				echo get_the_title( $company_id );
			} else {
				echo __( 'No client', 'mi' );
			}

			break;
		case 'invoice_date' :
			$date = get_post_meta( $post_id, 'invoice_date', true );

			if ( empty( $date ) ) {
				echo __( 'No date set', 'mi' );
			} else {
				echo $date;
			}

			break;
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
