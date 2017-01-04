<?php

/**
* Register Metaboxes
*/
function mi_invoice_add_meta_boxes() {

  // Items
  add_meta_box(
      'mi_invoice_items_meta_box',
      __( 'Invoice Items', 'mi' ),
      'mi_invoice_items_meta_box',
      'invoice'
  );

  // TODO: Add status metabox
  add_meta_box(
      'mi_invoice_status',
      __( 'Invoice Status', 'mi' ),
      'mi_invoice_status_meta_box',
      'invoice',
      'side'
  );

  // TODO: Add company metabox
  add_meta_box(
    'mi_invoice_company',
    __( 'Company', 'mi' ),
    'mi_invoice_company_meta_box',
    'invoice',
    'side'
  );

}

/**
* Items metabox
*/

function mi_invoice_items_meta_box() {
    // get current meta
    global $post;
    $items = get_post_meta( $post->ID, 'invoice_items', true );

  ?>

  <?php wp_nonce_field( 'save_invoice', 'mi_save_invoice_item' ); ?>

  <script type="text/template" id="mi_invoice_template">
    <tr class="mi_item">
      <td><input type="text" name="mi_invoice_item_item[]"></td>
      <td><input type="text" class="mi_spinner mi_qnt" name="mi_invoice_item_qnt[]" value="1"></td>
      <td><?php echo apply_filters( 'invoice_currency', '$'); ?> <input type="text" class="mi_val" name="mi_invoice_item_val[]" value="0.00"></td>
      <td><?php echo apply_filters( 'invoice_currency', '$'); ?> <span class="mi_tot">0.00</span></td>
      <td><button type="button" class="button mi_remove_item"><?php _e( 'Remove', 'mi'); ?></button></td>
    </tr>
  </script>

  <style>
    .mi_item { width: 100%; }
    .mi_val { width: 80%; }
  </style>

  <table width="100%">
    <thead>
      <tr>
        <th width="40%"><?php _e( 'Item', 'mi'); ?></th>
        <th width="15%"><?php _e( 'Qnt.', 'mi'); ?></th>
        <th width="15%"><?php _e( 'Val', 'mi'); ?></th>
        <th width="15%"><?php _e( 'Total', 'mi'); ?></th>
        <th width="15%">&nbsp;</th>
      </tr>
    </thead>
    <tbody id="mi_invoice_items">
      <?php
        $invoice_total = 0.0;
        if ( ! empty( $items ) ) : foreach ($items as $item ) :
          $subtotal = intval( $item[ 'quantity' ] ) * floatval( $item[ 'value' ] );
          $invoice_total += $subtotal;
        ?>
        <tr class="mi_item">
          <td><input type="text" class="mi_item" name="mi_invoice_item_item[]" value="<?php echo $item[ 'item' ] ?>"></td>
          <td><input type="text" class="mi_spinner mi_qnt" name="mi_invoice_item_qnt[]" value="<?php echo $item[ 'quantity' ] ?>"></td>
          <td><?php echo apply_filters( 'invoice_currency', '$'); ?> <input type="text" class="mi_val" name="mi_invoice_item_val[]" value="<?php echo $item[ 'value' ] ?>"></td>
          <td><?php echo apply_filters( 'invoice_currency', '$'); ?><span class="mi_tot"><?php echo number_format( $subtotal, 2) ?> </span></td>
          <td><button type="button" class="button mi_remove_item"><?php _e( 'Remove', 'mi'); ?></button></td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3"><?php _e( 'Total', 'mi' ); ?>:</th>
        <th><?php
          global $invoice_total;
          echo apply_filters( 'invoice_currency', '$') . number_format( $invoice_total, 2 );
        ?></th>
        <th>&nbsp;</th>
      </tr>
    </tfoot>
  </table>

  <hr>

  <button type="button" class="button-primary" id="mi_add_item"><?php _e( 'Add New Item', 'mi' ); ?></button>

<?php }

/**
* Company metabox
*/

function mi_invoice_company_meta_box() {
  global $post;
  $company_name = '';
  $company_id = intval( get_post_meta( $post->ID, 'invoice_company_id', true) );
  if ( ! empty( $company_id ) ) {
    $company_name = get_the_title( $company_id );
  }

?>


  <input type="text" name="mi_company" id="mi_company" value="<?php echo $company_name; ?>" >
  <button type="button" name="button"></button>
  <input type="hidden" name="mi_company_id" id="mi_company_id" value="<?php echo $company_id; ?>">

<?php }

/**
* Status metabox
*/

function mi_invoice_status_meta_box() {
  global $post;
  // get current status and date
  $status = get_post_meta( $post->ID, 'invoice_status', true );
  $date = get_post_meta( $post->ID, 'invoice_date', true );
  ?>

  <label for="mi_date"><?php _e( 'Due date', 'mi' ); ?></label>
  <input type="text" name="mi_date" id="mi_date" value="<?php if ( ! empty( $date ) ) { echo $date; } else { echo date('Y-m-d', time() + (7 * 24 * 60 * 60) ); } ?>">

  <hr>

  <label for="mi_status">Status</label>
  <select name="mi_status">
    <option value="canceled" <?php if( $status == 'canceled' ) { echo 'selected="selected"'; } ?>><?php _e( 'Canceled', 'mi' ); ?></option>
    <option value="pending" <?php if( empty( $status) || $status == 'pending' ) { echo 'selected="selected"'; } ?>><?php _e( 'Pending', 'mi' ); ?></option>
    <option value="complete" <?php if( $status == 'complete' ) { echo 'selected="selected"'; } ?>><?php _e( 'Complete', 'mi' ); ?></option>
  </select>

<?php }
