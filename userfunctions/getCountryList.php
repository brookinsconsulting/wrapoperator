<?

include_once('kernel/classes/datatypes/ezcountry/ezcountrytype.php');

// Quick and dirty way to get the contents of an xml string.
function getCountryList( $ret = false, $debug = false )
{
    /*
    if ( $debug )
        ezDebug::writeNotice( 'call', 'getCountryList:fetch' );
    */

    $countryType = new eZCountryType();
    $countries = $countryType->fetchCountryList();

    /*
    include_once( 'extension/ezdbug/autoloads/ezdbug.php' );
    $d = new eZDBugOperators();
    $d->ezdbugDump( $countries );
    */

    $ret =& $countries;

    if ( $debug )
        ezDebug::writeNotice( $ret, 'getXMLString:ret' );

    return $ret;
}

?>