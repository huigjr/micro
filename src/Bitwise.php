<?php
class Bitwise{

	const ROOD = 1;
  const GROEN = 2;
  const BLAUW = 4;
  const GEEL = 8;
  const PAARS = 16;
  const ORANJE = 32;
  const ZWART = 64;
  const WIT = 128;

	public function getProps($bits){
		$output = '';
    if(self::ROOD & $bits) $output .= 'rood, ';
    if(self::GROEN & $bits) $output .= 'groen, ';
    if(self::BLAUW & $bits) $output .= 'blauw, ';
    //return $output;
    return $bits;
	}
}
?>