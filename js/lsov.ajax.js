/**
 * 
 */

//function convert2json() {
//    jQuery.post( Postdata.ajax_url, jQuery( "#jkl-lsov-input" ).serialize(),
//    function( response ) {
//        // console.log( Postdata.test );                               // Console log the Object
//        // console.log( JSON.stringify( Postdata.test, null, 4 ) );    // Console log the String (pretty print)
//        
//        // console.log( "Response" );                                  // Console log the input
//        // console.log( response );
//        
//        // https://jsonformatter.curiousconcept.com/
//        jQuery( "#jkl-lsov-jsobj" ).html( Postdata.ajax_url );
//    });
//}

function textAreaAdjust( area ) {
    area.style.height = "1px";
    area.style.height = ( 25 + area.scrollHeight ) + "px";
}

jQuery(document).ready( function( $ ) {
    $( '#jkl-lsov-submit' ).click( function( e ) {
        e.preventDefault();
        console.log( Postdata.test );
        var Inputdata = jQuery( '#jkl-lsov-input' ).val();
        $.ajax({
            url:    Postdata.ajax_url,
            type:   'post',
            data:   {
                action: 'jkl_lsov_ajax',
                nonce: Postdata.nonce,
                jkl_lsov_data: Inputdata
            },
            success: function( response ) {
                // alert( Responsedata.result );
                jQuery( '#jkl-lsov-jsobj' ).html( response );
            }
        });
//        var data = {
//            action: 'jkl_lsov_ajax',
//            nonce: Postdata.nonce
//        };
//        $.post( Postdata.url, data, function( response ) {
//            $( '#jkl-lsov-jsobj' ).html( response.data );
//        });
    });
});