<?php
class Controller{

  private $db;
  private $userlevel;
  public $base = '/';

  public function __construct(Connection $db){
    $this->db = $db;
    $this->userlevel = $_SESSION['userlevel'] ?? 0;
    $path = $this->parsePath();
    $this->base = str_replace((isset($_GET['path']) ? $path[0].'/' : ''),'',$_SERVER['REQUEST_URI']);
    if(count($path) === 1) $array = $this->db->getRow("SELECT * FROM `pages` WHERE `url` = '$path[0]' AND `userlevel` <= $this->userlevel");
    if(count($path) === 2) $array = $this->db->getRow("SELECT * FROM `pages` WHERE `url` = '$path[1]' AND `type` = '$path[0]' AND `userlevel` <= $this->userlevel");
    if(!empty($array)){ foreach($array as $key => $value) $this->$key = $value; } else { $this->return404(); }
    $this->getPageData($this->pageid);
  }

  private function getPageData($id){
    $rows = $this->db->getAll("SELECT * FROM `pagedata` WHERE `pageid` = '$id'");
    foreach($rows as $row){
      extract($row);
      $class = new $entity($this->db);
      $this->$name = $this->merge($name,$class->$method($argument));
    }
  }

  private function parsePath(){
    if(isset($_GET['path'])){
      $path = $this->sanitize($_GET['path']);
      if($path && $path{-1} === '/') return explode('/',substr($path,0,-1));
    } else return ['/'];
  }

  private function sanitize($string){
    $output = preg_replace('~[^a-zA-Z0-9-/]~u','',$string);
    return $output === $string ? $string : false;
  }
  
  private function merge($name,$data,$output=''){
    if(file_exists(ROOT.'/template/default/partials/'.$name.'.html')){
      $file = file_get_contents(ROOT.'/template/default/partials/'.$name.'.html');
      foreach($data as $item){
        $string = $file;
        foreach($item as $key => $value) $string = str_replace("{".$key."}",$value,$string);
        $output .= $string;
      }
      return preg_replace_callback('~\[([^]]+)\]~',function($m){return $this->mergeFunctions($m[1]);},$output);
    } else return $data;
  }

  private function mergeFunctions($string){
    $array = explode(':',$string);
    $values = explode(',',$array[1]);
    switch ($array[0]){
      case 'FIRST':return @array_shift(array_filter($values));break;
      case 'IF':return $values[0] == $values[1] ? $values[2] : $values[3];break;
      case 'IFNOT':return $values[0] != $values[1] ? $values[2] : $values[3];break;
    }
  }

  private function return404(){http_response_code(404);echo '404 Page Not Found';exit;}
}
?>