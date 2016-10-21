/**
 * 
 */

function convert2json() {
    jQuery.post( Postdata.ajax_url, jQuery( "#jkl-lsov-input" ).serialize(),
    function( response ) {
        console.log( Postdata.test );
        console.log( JSON.stringify( Postdata.test, null, 4 ));
        // alert( JSON.stringify( Postdata.test, null, 4 ) );
        
        console.log( "Response" );
        console.log( response );
        console.log( Inputdata );
        
        // https://jsonformatter.curiousconcept.com/
        
        jQuery( "#jkl-lsov-jsobj" ).html( response );
    });
}

function textAreaAdjust( area ) {
    area.style.height = "1px";
    area.style.height = ( 25 + area.scrollHeight ) + "px";
}