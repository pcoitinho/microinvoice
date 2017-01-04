<?php

/**
* Register Metaboxes
*/
function mi_add_meta_boxes() {

  // Items
  add_meta_box(
      'mi_invoice_items_meta_box',
      __( 'Invoice Items', 'mi' ),
      'mi_invoice_items_meta_box',
      'invoice'
  );

  // TODO: Add status metabox
  /*
  add_meta_box(
      'mi_invoice_status',
      __( 'Invoice Status', 'mi' ),
      'mi_invoice_status_meta_box',
      'invoice',
      'side'
  );
  */

  // TODO: Add company metabox
  /*
  add_meta_box(
    'mi_invoice_company',
    __( 'Company', 'mi' ),
    'mi_invoice_company_meta_box',
    'invoice',
    'side'
  );
  */

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
        foreach ($items as $item ) :
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
      <?php endforeach; ?>
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

function mi_invoice_company_meta_box() { ?>

  <input type="text" name="mi_company">

<?php }

/**
* Status metabox
*/

function mi_invoice_status_meta_box() { ?>

  <select name="mi_status">
    <option value="canceled"><?php _e( 'Canceled', 'mi' ); ?></option>
    <option value="pending"><?php _e( 'Pending', 'mi' ); ?></option>
    <option value="complete"><?php _e( 'Complete', 'mi' ); ?></option>
  </select>

<?php }