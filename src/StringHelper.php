<?php
class StringHelper{

  public function truncateString($string,$striptags=false,$maxlength=80,$trailing='...'){
    $string = $striptags ? strip_tags($string) : $string;
    if(strlen($string) >= $maxlength){
      $string = substr($string,0,$maxlength);
      $wordarray = str_word_count($string,1);
      array_pop($wordarray);
      return implode(' ',$wordarray).$trailing;
    } else return $string;
  }

  public function makeUrl($string){
    $string = strtr($string,array('&'=>'-','+'=>'plus','Ä'=>'Ae','Æ'=>'Ae','Ö'=>'Oe','Ü'=>'Ue','ß'=>'ss','ä'=>'ae','æ'=>'ae','ö'=>'oe','ü'=>'ue','À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Å'=>'A','Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','×'=>'x','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ý'=>'Y','à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i','ñ'=>'n','ò'=>'o','ô'=>'o','õ'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ý'=>'y','ÿ'=>'y'));
    $string = preg_replace('/[^A-Za-z0-9 ]/','',$string);
    $string = strtolower(trim($string));
    $string = preg_replace('!\s+!','-',$string);
    return preg_replace('!-+!','-',$string);
  }
  
  public function sluggify($string, $separator = '-', $maxLength = 96){
    $title = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $title = preg_replace("%[^-/+|\w ]%", '', $title);
    $title = strtolower(trim(substr($title, 0, $maxLength), '-'));
    $title = preg_replace("/[\/_|+ -]+/", $separator, $title);
    return $title;
  }
  
  public function contains_any_multibyte($string){
    return !mb_check_encoding($string, 'ASCII') && mb_check_encoding($string, 'UTF-8');
  }
}
?>