<?php
class Controller{

  private $di;
  public $base = '/';

  public function __construct($di){
    $this->di = $di;
    $path = $this->parsePath();
    $this->base = str_replace((isset($_GET['path']) ? $path[0].'/' : ''),'',$_SERVER['REQUEST_URI']);
    if(count($path) === 1) $array = $this->di->get('Connection',array(DB_HOST,DB_NAME,DB_USER,DB_PASS))->getRow("SELECT * FROM `pages` WHERE `url` = '$path[0]'");
    if(!empty($array)){ foreach($array as $key => $value) $this->$key = $value; } else { $this->return404(); }
  }

  private function parsePath(){
    if(isset($_GET['path'])){
      $path = preg_replace('~[^a-zA-Z0-9-/]~u','',$_GET['path']) === $_GET['path'] ? $_GET['path'] : false;
      if($path && substr($path,0,-1) === '/') return explode('/',substr($path,0,-1));
    } else return array('/');
  }

  private function return404(){ header("HTTP/1.0 404 Not Found"); echo '404 Page Not Found'; exit; }
}
?>