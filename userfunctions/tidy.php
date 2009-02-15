<?

// include_once('kernel/classes/datatypes/ezcountry/ezcountrytype.php');

// Quick and dirty way to use tidy to clean output
function tidy( $input, $debug = true, $ret = false )
{
    /*
    if ( $debug )
        ezDebug::writeNotice( 'call', 'getCountryList:fetch' );
    */

    /*
    $PHP_COMMAND='/usr/local/php4.4.4/bin/php -d memory_limit=456M';
    $exec = $PHP_COMMAND . ' update/common/scripts/updatesearchindex2_sub.php ' . $optionString . $objectID;
    */

    // okay - we have valid key.  Let's encrypt the contents now.
    // $call = "$input | /usr/bin/tidy --show-body-only";
    $call = "/usr/bin/tidy --show-body-only";

    // $call .= $this->gpg_decrypt_cmd_parm;
    // $call .= " 3<<< '$key' <<< '$data' ";
    $call .= " <<< '$input' ";

    if ( $debug )
        // ezDebug::writeNotice( $call, 'tidy:call' );

    // $last_line = system( $gpg_call, $decrypted );
    // $decrypted = passthru( $gpg_call, $retcode );
    // $decrypted = passthru( $gpg_call, $retcode );

    /* Add redirection so we can get stderr.
    $handle = popen( $call, 'rw' );
    $contents = fread( $handle, 2096 );
    */

    // @exec( $call.' "'..'"', $contents);
    @exec( $call, $contents );

    // $contents = shell_exec( $call );
    // $contents = 0;

    if ( $debug )
        ezDebug::writeNotice( $contents, 'tidy:ret' );

    // $PHP_COMMAND='/usr/local/php4.4.4/bin/php -d memory_limit=456M';
    // $exec="$input|tidy --show-body-only"; // . $optionString . $objectID";

    /*
    $retval='';
    echo "Executing $exec\n";
    $result = passthru( $exec, $retval );
    $ret = $retval;
    */

    $ret = $contents;

    /*
    include_once( 'extension/ezdbug/autoloads/ezdbug.php' );
    $d = new eZDBugOperators();
    $d->ezdbugDump( $contents );
    */

    // echo('<hr />');

    //     die("$call <hr />");

    /*
    if ( $debug )
        ezDebug::writeNotice( $ret, 'getXMLString:ret' );
    */

    return $ret;
}

?>
