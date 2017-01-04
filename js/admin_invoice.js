( function( $ ) {


  // get template
  var template = $( '#mi_invoice_template ');

  // get table
  var items = $( '#mi_invoice_items' );

  // add spinners all around
  $( '.mi_spinner' ).spinner();

  // add item
  $( '#mi_add_item' ).click( function() {
    var newItem = $( template.html() );
    newItem.find( '.mi_spinner' ).spinner();
    items.append( newItem );
  })

  // update total
  $( '#mi_invoice_items' ).on( 'spinchange', '.mi_spinner', function( evt ) {
    // get this row's quantity and value
    var row = $( evt.target ).parents( '.mi_item' ),
        qnt = row.find( '.mi_qnt' ).val(),
        val = row.find( '.mi_val' ).val(),
        tot = qnt * val;

    row.find( '.mi_tot' ).html( tot.toFixed(2) );

  } );

  // remove item
  $( '#mi_invoice_items' ).on( 'click', '.mi_remove_item', function( evt ) {
    $( event.target ).parents( '.mi_item' ).remove();
  } );
} ( jQuery ) );
