<?php
class Controller{

  private $db;
  public $base = '/';

  public function __construct(Connection $db){
    $this->db = $db;
    $count = count($_GET);
    $path = empty($_GET['path']) ? null : htmlentities($_GET['path'],ENT_QUOTES);
    $type = empty($_GET['type']) ? null : htmlentities($_GET['type'],ENT_QUOTES);
    $type = $type == ADMIN_DIR ? 'admin' : $type;
    $this->base = str_replace((($path) ? $_GET['path'].'/' : ''),'',$_SERVER['REQUEST_URI']);
    if($count === 0) $array = $this->db->getRow("SELECT * FROM `pages` WHERE `url` = '/'");
    if($count === 1 && $path) $array = $this->db->getRow("SELECT * FROM `pages` WHERE `url` = '$path'");
    if($count === 2 && $path && $type){$array = $this->db->getRow("SELECT * FROM `$type` WHERE `url` = '$path'");}
    if(!empty($array)){
      foreach($array as $key => $value) $this->$key = $value;
    } else {
      http_response_code(404);
      echo '404 Not Found';
      exit;
    }
    $this->nav = $this->getNav();
  }
  
  private function getNav(){
    $tab = "\t";
    $nav = $this->db->getAll("SELECT `name`,`url` FROM `pages` ORDER BY `sequence`");
    $output = '<nav>'.PHP_EOL;
    $output .= $tab.'<ul>'.PHP_EOL;
    foreach($nav as $item){
      $url = ($item['url'] == '/') ? '' : $item['url'];
      $output .= $tab.$tab.'<li><a href="'.$url.'/">'.$item['name'].'</a></li>'.PHP_EOL;
    }
    $output .= $tab.'</ul>'.PHP_EOL;
    $output .= '</nav>'.PHP_EOL;
    return $output;
  }
}
?>