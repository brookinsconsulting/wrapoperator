<?php

    // Quick and dirty way to get the issue number from a commit message
    function getIssueFromWebSVNSubversionCommitMessage( $data )
    {
        //given string $data, will return the first $issue string in that string
	$ret = false;

	$split = split( "#", $data );
	if( isset( $split[1] ) )
          $splitTestForZero = split( "0", $split[1] );
	else
          $splitTestForZero = null;

	if( $splitTestForZero[0] == 0 ) { $limit = 6; } else { $limit = 5; }

	if( isset( $split[1] ) ) {
	    $match = $split[1];
    	    $issue = substr( $match, 0, +$limit );

	    if ( $issue != '' && count( $issue ) <= 5 && is_numeric( $issue ) ) {
               // eZDebug::writeDebug( "wrap_operator: getIssueFromPubSVNCommitMessage, results: " . print_r( $issue, TRUE) );
 	       $ret = $issue;
	    }
	}

        return $ret;
    }

?>