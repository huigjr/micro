<?php
class ConnectionTest extends \PHPUnit_Framework_TestCase{
  
  public function testConnection(){
    $query = 'SELECT * FROM `pages` ';

    $db = new Connection(DB_HOST,DB_NAME,DB_USER,DB_PASS);

    $this->assertInstanceOf('Connection', $db);

    $result = $db->getRow($query);

    $this->assertInternalType('array',$result);

    $this->assertEquals(10,count($result));
  }
}
?>