<?php

    // Quick and dirty way to get number of leading sentences in text, stolen from somewhere.
    function getLeadingSentences($data, $max)
    {
        //given string $data, will return the first $max sentences in that string

        $re = "^s*.{10,10}[^.?!]+[.?!]+s*";
        $out = "";
        for($i = 0; $i < $max; $i++) {
            if(ereg($re, $data, $match)) {
                //if a sentence is found, take it out of $data and add it to $out
                $out .= $match[0];
                $data = ereg_replace($re, "", $data);
            }
            else {
                $i = $max;
            }
        }
        return $out;
    }

?>