( function( $ ) {

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
