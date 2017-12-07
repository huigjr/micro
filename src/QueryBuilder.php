<?php
class QueryBuilder{

  public function buildDuplicateQuery($column,$table,int $morethen = 1){
    $column = $this->safeValue($column);
    $table = $this->safeValue($table);
    return "SELECT $column FROM $table GROUP BY $column HAVING COUNT($column) > $morethen";
  }

  public function buildCountQuery($column,$table){
    $column = $this->safeValue($column);
    $table = $this->safeValue($table);
    return "SELECT $column,COUNT($column) as `count` FROM $table GROUP BY $column";
  }

  public function buildDeleteQuery($value,$column,$table){
    $output['statement'] = "DELETE FROM ".$this->safeValue($table)." WHERE ".$this->safeValue($column)." = '".$this->safeValue($value,'')."'";
    $output['parameters'] = null;
    return $output;
  }

  public function buildUpdateQuery($array,$table,$id){
    $array = (is_string($array)) ? json_decode($array,true) : $array;
    $columns = (!empty($array[0]) && is_array($array[0])) ? $array[0] : $array;
    foreach($columns as $key => $value){
      if($key !== $id) $set[] = $this->safeValue($key).' = :'.$this->safeValue($key,"");
    }
    $output['statement'] = "UPDATE ".$this->safeValue($table)." SET ".implode(',',$set)." WHERE ".$this->safeValue($id).' = :'.$this->safeValue($id,"");
    $output['parameters'] = $array;
    return $output;
  }

  public function buildInsertQuery($array,$table){
    $array = (is_string($array)) ? json_decode($array,true) : $array;
    $columns = (!empty($array[0]) && is_array($array[0])) ? $array[0] : $array;
    foreach($columns as $key => $value){
      $into[] = $this->safeValue($key);
      $values[] = ':'.$this->safeValue($key,"");
    }
    $output['statement'] = "INSERT INTO ".$this->safeValue($table)." (".implode(',',$into).') VALUES ('.implode(',',$values).')';
    if(!empty($array[0]) && is_array($array[0])){
      foreach($array as $item){
        $output['parameters'][] = $item;
      }
    } else {
      $output['parameters'][] = $array;
    }
    return $output;
  }

  public function buildSelectQuery($array){
    $array = (is_string($array)) ? json_decode($array,true) : $array;
    $select = 'SELECT '.(empty($array['select']) ? '*' : $this->flattenQueryPart($array['select'],', '));
    if(empty($array['from'])){
      throw new Exception('No valid "from" data in query.');
    } else {
      $from = ' FROM '.$this->flattenQueryPart($array['from'],' INNER JOIN ');
      $from .= (!empty($array['on'])) ? ' ON '.$this->flattenQueryPart($array['on'],' = ') : '';
    }
    $wherearray = empty($array['where']) ? null : $this->buildWhere($array['where']);
    $where = (($wherearray) && ($wherearray['statements'])) ? $wherearray['statements'] : '';
    $orderby = empty($array['orderby']) ? '' : $this->buildOrderBy($array['orderby']);
    $limit = empty($array['limit']) ? '' : ' LIMIT '.(is_array($array['limit']) ? implode(',',$array['limit']) : $array['limit']);
    return array(
      'statement' => $select.$from.$where.$orderby.$limit,
      'parameters' => (($wherearray) && ($wherearray['parameters'])) ? $wherearray['parameters'] : null,
    );
  }

  private function buildOrderBy($data){
    if(is_array($data)){
      $data = array_filter($data);
      $attr = '';
      foreach($data as $key => &$value){
        if($value === 'DESC' || $value === 'ASC'){
          $attr = ' '.$value;
          unset($data[$key]);
        }
      }
      return ' ORDER BY '.$this->flattenQueryPart($data,', ').$attr;
    } else {
      return ' ORDER BY '.$this->flattenQueryPart($data,', ');
    }
  }

  private function buildWhere($data){
    if(!empty($data[0]) && is_array($data[0])){
      foreach($data as $item){ 
        $return = $this->handleWhere($item);
        $statements[] = $return['statements'];
        $parameters[] = $return['parameters'];
      }
    } elseif(!empty($data[0]) && !is_array($data[0])){
      $return = $this->handleWhere($data);
      $statements[] = $return['statements'];
      $parameters[] = $return['parameters'];
    }
    if(!empty($parameters)) foreach($parameters as $key => $value) if(!empty($value)) foreach($value as $key2 => $value2) $output[$key2] = $value2;
    return array(
      'statements' => empty($statements) ? null : ' WHERE '.implode(' AND ',$statements),
      'parameters' => empty($output) ? null : $output,
    );
  }

  private function handleWhere($data){
    if(count($data) !== 3){
      throw new Exception('"Where" data doesn\'t have 3 arguments');
    } else {
      $begin = $this->safeValue($data[0]);
      $parameters = null;
      if($data[2] === null){
        $middle = ($data[1] === '<>') ? 'IS NOT' : 'IS';
        $end = 'NULL';
      } else {
        $middle = preg_replace('/[^=<>]/u','',trim($data[1]));
        $end = ":".$this->safeValue($data[0],'');
        $parameters = array($this->safeValue($data[0],'') => $data[2]);
      }
      return array(
        'statements' => $begin.' '.$middle.' '.$end,
        'parameters' => $parameters,
      );
    }
  }

  private function flattenQueryPart($array,$implode=','){
    if(!is_array($array)){
      $return[] = $this->safeValue($array);
    } else {
      foreach($array as $item) $return[] = $this->safeValue($item);
    }
    return implode($implode,$return);
  }

  private function safeValue($string,$quote="`"){
    return $quote.preg_replace('/[^a-zA-Z0-9-_]/u','',trim($string)).$quote;
  }
}
?>