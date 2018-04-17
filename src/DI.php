<?php
class DI{

  private $service = array();

  // Check if class is instanced under alias and if not instance it
  public function get($object,$args=null,$alias=null){
    $alias = $alias ?: $object;
    if(empty($this->service[$alias]))
      $this->service[$alias] = $this->instance($object,$args);
    return $this->service[$alias];
	}
  
  // create instance of object and optionally unpack arguments from array
  private function instance($object,$args=null){
    if($args){
      if(version_compare(PHP_VERSION, '5.6.0', '>=')){
        return new $object(...$args);
      } else {
        $reflect = new ReflectionClass($object);
        return $reflect->newInstanceArgs($args);
      }
    } else {
      return new $object($this);
    }
  }
}
?>