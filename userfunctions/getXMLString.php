<?php

    // Quick and dirty way to get the contents of an xml string.
    function getXMLString($name = false, $data, $ret = false, $debug = false)
    {
        // given string $data, will return the text string content of the $name attribute content of a given valid xml document. 
        if ( $debug )
        ezDebug::writeNotice( $name, 'getXMLString:name' );

        // get information out of eZXML
        $xml = new eZXML();
        $xmlDoc = $data;

        if ( $debug )
        ezDebug::writeNotice( $data, 'getXMLString:data' );

        // continue only with content
        if( $xmlDoc != null and $name != null )
        {
            $dom = $xml->domTree( $xmlDoc );
            $element = $dom->elementsByName( "$name" );

            if( is_object( $element[0] ) )
            {
                $string = $element[0]->textContent();
                $ret = $string;
            }
            else
            {
                eZDebug::writeNotice( 'Key "'.$name.'" does not exist.', 'wrap_operator');
            }
        }

        if ( $debug )
        ezDebug::writeNotice( $ret, 'getXMLString:ret' );

        return $ret;
     }
?>