<?php

/**
* Register Metaboxes
*/
function mi_company_add_meta_boxes() {

  // Address
  add_meta_box(
      'mi_company_address_meta_box',
      __( 'Address', 'mi' ),
      'mi_company_address_meta_box',
      'company'
  );

}


/**
* Address metabox
*/

function mi_company_address_meta_box() {
    // get current meta
    global $post;
    $address = get_post_meta( $post->ID, 'company_address', true );



  ?>

  <?php wp_nonce_field( 'save_company', 'mi_save_company_address' ); ?>

  <div>
    <div>
      <label style="display: inline-block; width: 10em;"><?php _e( 'Address Line 1', 'mi' ); ?></label>
      <input type="text" name="mi_address_line_1" value="<?php echo $address[ 'company_addres_line_1' ]; ?>">
    </div>
    <div>
      <label style="display: inline-block; width: 10em;"><?php _e( 'Address Line 2', 'mi' ); ?></label>
      <input type="text" name="mi_address_line_2" value="<?php echo $address[ 'company_address_line_2' ]; ?>">
    </div>
    <div>
      <label style="display: inline-block; width: 10em;"><?php _e( 'Address Line 3', 'mi' ); ?></label>
      <input type="text" name="mi_address_line_3" value="<?php echo $address[ 'company_address_line_3' ]; ?>">
    </div>
    <div>
      <label style="display: inline-block; width: 10em;"><?php _e( 'Postal Code', 'mi' ); ?></label>
      <input type="text" name="mi_address_postalcode" value="<?php echo $address[ 'company_address_postalcode' ]; ?>">
    </div>
    <div>
      <label style="display: inline-block; width: 10em;"><?php _e( 'City', 'mi' ); ?></label>
      <input type="text" name="mi_address_city" value="<?php echo $address[ 'company_address_city' ]; ?>">
    </div>
    <div>
      <label style="display: inline-block; width: 10em;"><?php _e( 'Country', 'mi' ); ?></label>
      <input type="text" name="mi_address_country" value="<?php echo $address[ 'company_address_country' ]; ?>">
    </div>
  </div>

<?php }
