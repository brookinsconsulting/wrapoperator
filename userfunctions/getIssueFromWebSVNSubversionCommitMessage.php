<?php

    // Quick and dirty way to get the issue number from a commit message
    function getIssueFromPubSVNCommitMessage( $data )
    {
        //given string $data, will return the first $issue string in that string
	$ret = false;

	$split = split( "#", $data );

	if( isset( $split[1] ) ) {
	    $match = $split[1];
    	    $issue = substr( $match, 0, +5 );

	    if ( $issue != '' && count( $issue ) <= 5 ) {
               // eZDebug::writeDebug( "wrap_operator: getIssueFromPubSVNCommitMessage, results: " . print_r( $issue, TRUE) );
 	       $ret = $issue;
	    }
	}

        return $ret;
    }

?>