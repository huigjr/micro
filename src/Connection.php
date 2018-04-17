<?php
class Connection{

  private $pdo;
  private $host;
  private $dbname;
  private $username;
  private $password;

  public function __construct($host,$dbname,$username,$password){
    $this->host     = $host;
    $this->dbname   = $dbname;
    $this->username = $username;
    $this->password = $password;
  }

  public function beginTransaction(){
    if(is_null($this->pdo)) $this->connect();
    if(!$this->pdo->inTransaction()){
      $this->pdo->beginTransaction();
    } else throw new Exception("Previous transaction not closed properly");
  }

  public function commit(){
    if($this->pdo->inTransaction()) $this->pdo->commit();
  }

  public function rollBack(){
    if($this->pdo->inTransaction()) $this->pdo->rollBack();
  }

  public function dbWrite($query,$data=null){
    $statement = $this->prepareStatement($query);
    return $this->fetch($statement,'none',$data);
  }

  public function getClass($query,$data=null,$class){
    $statement = $this->prepareStatement($query);
    return $this->fetch($statement,'fetchclass',$data,$class);
  }

  public function getRow($query,$data=null){
    $statement = $this->prepareStatement($query);
    return $this->fetch($statement,'fetchrow',$data);
  }

  public function getAll($query,$data=null){
    $statement = $this->prepareStatement($query);
    return $this->fetch($statement,'fetchall',$data);
  }

  public function getColumn($query,$data=null){
    $statement = $this->prepareStatement($query);
    return $this->fetch($statement,'fetchcolumn',$data);
  }

  public function prepareStatement($query){
    if(is_null($this->pdo)) $this->connect();
    return $this->pdo->prepare($query);
  }

  public function fetch($statement,$type='fetchall',$data=null,$class=null){
    try{
      if(!empty($data[0]) && is_array($data[0])){
        foreach($data as $item) $statement->execute($item);
      } else {
        $statement->execute($data);
      }
      if($type=='fetchall'){
        return $statement->fetchAll();
      } elseif($type=='none'){
        return true;
      } elseif($type=='fetchrow'){
        return $statement->fetch();
      } elseif($type=='fetchcolumn'){
        return $statement->fetchColumn();
      } elseif($type=='fetchclass'){
        $statement->setFetchMode(PDO::FETCH_CLASS,$class);
        return $statement->fetch();
      } elseif($type=='fetchobject'){
        $statement->setFetchMode(PDO::FETCH_OBJ);
        return $statement->fetch();
      } else {
        return false;
      }
    }catch(PDOException $e){
      $this->rollBack();
      $this->gracefulDie('Query failed: '.$e->getMessage());
    }
  }

  public function connect(){
    try {
      $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      );
      $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",$this->username,$this->password,$options);
    } catch (PDOException $e) {
      $this->gracefulDie('Connection failed: '.$e->getMessage());
    }
  }

  public function gracefulDie($message){
    $content = date("d-m-Y H:i:s").'|'.$message.PHP_EOL;
    if(!file_exists(dirname(LOG_FILE))) mkdir(dirname(LOG_FILE),0777,true);
    file_put_contents(LOG_FILE,$content,FILE_APPEND);
    include(ERROR_DOC);
    exit;
  }

  public function disconnect(){
    $this->pdo = null;
  }

  public function __destruct() {
    $this->disconnect();
  }
}
?>