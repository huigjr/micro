<?php
class SchoolTest extends \PHPUnit_Framework_TestCase{
  
  public function testgetSchoolVacation(){
    $post['date'] = '2018-02-27';
    $post['regionid'] = 1;
    $post['schoolid'] = 0;

    $school = new School();

    $this->assertInstanceOf('School', $school);

    $result = $school->getSchoolVacation($post);

    $this->assertInternalType("string",$result);
    
    $this->assertEquals(3,$result);
  }
}
?>