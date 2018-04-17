<?php
class Controller{

  private $di;

  public function __construct($di){
    $this->di = $di;
  }

  // Checks if Class and Method can be called and calls them
  public function getResult(){
    if(!empty($_GET)) foreach($_GET as $key => $value) $gets[$key] = $this->sanitize($value);
    if(!empty($gets['entity']) && !empty($gets['method']) && method_exists($gets['entity'],$gets['method'])){
      return @call_user_func_array(array($this->di->get($gets['entity']),$gets['method']),$this->getPost());
    }
  }

  // retrieve post in JSON format and convert to array
  private function getPost($output=null){
    $array = json_decode(file_get_contents("php://input"),true);
    if($array) foreach($array as $key => $value) $output[$this->sanitize($key)] = $value;
    return is_array($output) ? $output : array();
  }

  // Sanitize string to alphanumerical
  private function sanitize($string){
    $string = preg_replace('/[^A-Za-z0-9]/u', '', trim($string));
    return (trim($string) == '' ? null : trim($string));
  }
}
?>