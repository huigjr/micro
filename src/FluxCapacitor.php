<?php
class FluxCapacitor{
  
  private $language = 'Dutch';
  private $time;
  
  public function __construct(){
    $this->time = time();
  }
  
  public function setLanguage($language){
    $choices = array(
      'en' => 'English',
      'fi' => 'Finnish',
      'nl' => 'Dutch',
      'ru' => 'Russian',
      'vi' => 'Vietnamese',
      'zh' => 'Chinese',
    );
    if(!empty($choices[$language])) $this->language = $choices[$language];
  }
  
  public function getLocalDay(){
    echo $this->language;
  }
  
  public function getCarnaval($year){
    return date("Y-m-d", easter_date($year) - 60*60*24*49); 
  }

  public function getEaster($year){
    return date("Y-m-d", easter_date($year)); 
  }
  
  public function getPentecost($year){
    return date("Y-m-d", easter_date($year) + 60*60*24*49); 
  }
}


?>