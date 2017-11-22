<?php
class ControllerTests extends PHPUnit_Framework_TestCase{

  private $controller;

  public function setUp(){
    $db = new Connection('localhost','micro','root','');
    $this->controller = new Controller($db);
  }

  public function tearDown(){
    $this->controller = NULL;
  }
}