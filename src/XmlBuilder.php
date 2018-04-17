<?php
class XmlBuilder{
  
  private $di;

  public function __construct($di){
    $this->di = $di;
  }

  public function arrayToXml($array){
    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->formatOutput = true;
    $array = array('node' => $array);
    $this->recursiveAppend($dom,$array,$dom,'xxx');
    return $dom->saveXML();
  }

  private function recursiveAppend($currentelement,$array,$dom,$namespace=null){
    foreach($array as $key => $value){
      $key = $namespace ? $namespace.':'.$key :  $key;
      if(is_array($value)){
        $element = $dom->createElement($key);
        $currentelement->appendChild($element);
        $this->recursiveAppend($element,$value,$dom,$namespace);
      } else {
        $element = $dom->createElement($key,$value);
        $currentelement->appendChild($element);
      }
    }
  }

}
?>