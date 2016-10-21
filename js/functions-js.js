var submit  = document.getElementById( 'jkl-lsov-submit' );
var input   = document.getElementById( 'jkl-lsov-textarea' );
var result  = document.getElementById( 'jkl-lsov-jsobj' );

function convert2Json( e ) {
    // e.preventDefault();
    result.innerHTML = "Hello";
    getRequest(
        'ajax.php',
        outputResult,
        handleError
    );
    return false;
}

function getRequest( url, success, error ) {
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch( e ) {
        // IE
        try {
            req = new ActiveXObject( "Msxml2.XMLHTTP" );
        } catch( e ) {
            // try an older version
            try {
                req = new ActiveXObject( "Microsoft.XMLHTTP" );
            } catch( e ) {
                return false;
            }
        }
    }
    if( !req ) return false;
    if( typeof success != 'function' ) success = function() {};
    if( typeof error != 'function' ) error = function() {};
    req.onreadystatechange = function() {
        if( req.readyState == 4 ) {
            return req.status === 200 ?
                success( req.response ) : error( req.status );
        }
    }
    req.open( "GET", url, true );
    req.send( null );
    return req;
}

function outputResult( response ) {
    result.innerHTML = response;
}

function handleError() {
    result.innerHTML = "Error";
}

submit.addEventListener( 'click', convert2Json, false );