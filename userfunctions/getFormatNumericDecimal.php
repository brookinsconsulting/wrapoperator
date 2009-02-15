<?php 

/* Reference
   Round With Decimal Place Control
*/

function getFormatNumericDecimal( $n, $p=2 )
{
  // $r = round( $n, $p );
  $r = number_format($n, 2, '.', '');
  if( $r == '' or $r == 0 or $r == 0.00 )
  {
      $r = '0.00';
  }
  return $r;
}

?>
