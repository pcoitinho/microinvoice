( function( $ ) {

  // get template
  var template = $( '#mi_invoice_template ');

  // get table
  var items = $( '#mi_invoice_items' );

  // add spinners all around
  $( '.mi_spinner' ).spinner();

  // add datepicker
  $( '#mi_date' ).datepicker({
    'dateFormat': 'yy-mm-dd'
  });

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

  // company autocomplete
  var company_id = $( '#mi_company_id' ),
      company_name = $( '#mi_company')
  company_name.autocomplete({
    source: function( request, response ) {
      $.post(
        ajaxurl,
        {
            'action':   'invoice_list_companies',
            'company':  request.term
        },
        function( data ){
          response( JSON.parse(data) );
        }
      );
    }, select: function( event, ui ) {
      company_name.val( ui.item.label );
      company_id.val( ui.item.value );

      return false;
    }
  });
} ( jQuery ) );
