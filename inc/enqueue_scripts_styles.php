<?php
function mi_enqueue_admin_scripts_styles( $hook ) {
  global $typenow;
  global $plugindir;
  if ( $hook == 'post.php' && $typenow == 'invoice') {
    //wp_enqueue_style( 'mi_admin_jquery_ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/base/jquery-ui.css', false, false, false );
    wp_enqueue_script( 'mi_admin_invoice_js', $plugindir . '/js/admin_invoice.js', array( 'jquery', 'jquery-ui-spinner' ), false, true );
  }
}
