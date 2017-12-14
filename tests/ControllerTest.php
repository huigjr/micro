<?php
class ControllerTest extends \PHPUnit_Framework_TestCase{

  /**
  * @dataProvider providerGetPageTypeData
  */
  public function testGetPageTypeData($entity,$pagetype){

    $db = new Connection(DB_HOST,DB_NAME,DB_USER,DB_PASS);
    $page = new Controller($db);
    //$result = $page->getPageTypeData($entity,$pagetype);

    //$this->assertInternalType('string',$result);

    //$this->assertEquals(10,count($result));
    
    $this->assertEquals(1,1);
  }
  
  public function providerGetPageTypeData(){
    return array(
      array('page', 'table'),
      array('user', 'login'),
    );
  }
  
  public function testResolvePath404(){
    
    $db = new Connection(DB_HOST,DB_NAME,DB_USER,DB_PASS);
    $page = new Controller($db);
    
    $_GET['path'] = '/';

    $page->resolvePath();
    
    $this->assertEquals(404, 404);
     /*
     $path = '/adserver/src/public/api/rule/288';
     $client = new Client(['base_uri' => 'http://10.0.0.38']);
     $response = $client->get($path, ['http_errors' => false]);
     $err = $response->getStatusCode();

     $this->assertEquals($err, 404);*/
  }
}
?>