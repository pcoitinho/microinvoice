<?php

/**
* Draw extra user info
*/

function mi_show_user_profile( $user ) {

  $company_id = intval( get_user_meta( $user->ID, 'company_id', true ) );
  $company_name = get_the_title( $company_id );

  $company_role = get_user_meta( $user->ID, 'company_role', true );

  ?>

  <h3>Company information</h3>

  <table class="form-table">
 	 <tr>
 		 <th><label for=""><?php _e( 'Company', 'mi' ); ?></label></th>
 		 <td>
   		 <input type="text" name="mi_company" id="mi_company" value="<?php echo $company_name; ?>">
   		 <input type="hidden" name="mi_company_id" id="mi_company_id" value="<?php echo $company_id; ?>">
     </td>
 	 </tr>
   <tr>
 		 <th><label for=""><?php _e( 'Role', 'mi' ); ?></label></th>
     <td><input type="text" name="mi_company_role" value="<?php echo $company_role; ?>"></td>
 	 </tr>
  </table>
<?php }

/**
* save extra user info
*/

function mi_save_profile_fields( $user_id ) {

    // check user priviledges
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
     	return false;
    }

    // update company id
    if ( isset( $_POST[ 'mi_company_id' ] ) &&  ! empty( $_POST[ 'mi_company_id' ] ) ) {
      update_usermeta( $user_id, 'company_id', intval( $_POST[ 'mi_company_id' ] ) );
    }

    // update role
    if ( isset( $_POST[ 'mi_company_role' ] ) &&  ! empty( $_POST[ 'mi_company_role' ] ) ) {
      update_usermeta( $user_id, 'company_role', sanitize_text_field( $_POST[ 'mi_company_role' ] ) );
    }
}
