<?php

/**
* List clients through ajax
*/

function mi_ajax_list_clients() {

  // get iniial client name
  $name = strtolower( sanitize_text_field( $_POST[ 'company' ] ) );

  // dont search without name
  if ( empty( $name ) ) {
    echo  __( 'Please provide a company name to search', 'mi' );
    wp_die();
  }

  // query
  global $wpdb;
  $query = $wpdb->get_results(
    "
    SELECT * FROM $wpdb->posts
    WHERE post_title LIKE '$name%'
    AND post_type = 'company'
    AND post_status = 'publish'
    LIMIT 5;
    "
  );

  // parse results
  $results = array();
  if ( $query ) {
     foreach ( $query as $post ) {

         // include in results
         $results[] = array(
           'label'   => $post->post_title,
           'value'   => $post->ID
         );

     }

    // return array
    echo json_encode( $results );
  } else {
    printf( __( 'No results found for %s', 'mi' ), $name );
  }



  // stop excecuting script
  wp_die();

}
