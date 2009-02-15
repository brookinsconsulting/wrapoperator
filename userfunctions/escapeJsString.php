<?
/*
 Escape a string for htmlcharacters/other characters, safe for javascript.
 Escape Characters: , '
*/

function escapeJsString( $s )
{
    // $t = addcslashes( $s, '\'\\"'."\n\r" );
    // $t = addcslashes( $s, '\'\\"'."\n\r" );
    $t = str_replace("'", "\'", $s);
    $t = str_replace('"', "'+String.fromCharCode(34)+'", $t);

    return $t;
}

?>