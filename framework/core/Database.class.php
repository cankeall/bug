<?php

class Database {

	private $db = null;
    public $sqls = [];
    private $dbpre='';
    private $dbname = null;

	public function __construct($group){
	    if($this->db===null) $this->db = get_db($group);
        $this->dbpre = $GLOBALS['conf']['db'][$group]['dbpre'];
        $this->dbname = $GLOBALS['conf']['db'][$group]['database'];
	}

	public function table($table){
	    return $this->dbpre.$table;
	}

    public function last_sql(){
        $length = count($this->sqls);
        return $this->sqls[$length-1];
    }

	public function query($sql){
        if(strpos($sql,'#_')) $sql = str_replace('#_', $this->dbpre, $sql);
        //echo $sql;
        $this->sqls[] = $sql;
	    return $this->db->query($sql);
	}

    public function insert($table,$data){
      
        $keys = array_keys($data);
        $values = array_values($data);
        $values = array_map('addslashes',$values);
       
        $sql = "INSERT INTO {$this->table($table)} (".implode(',',$keys).") VALUES('".implode("','",$values)."')";
        return $this->query($sql);
    }

    public function insertAll($table,$data){

        $keys = [];
        $valueStr = '';

        foreach($data as $tmp){

            if(empty($keys)) 
                $keys = array_keys($tmp);

            $values = array_values($tmp);
            $values = array_map('addslashes',$values);

            $valueStr .= "('".implode("','",$values)."'),";
        }
        $valueStr = rtrim($valueStr,',');
        $sql = "INSERT INTO {$this->table($table)} (".implode(',',$keys).") VALUES".$valueStr;
        return $this->query($sql);
    }

    public function update($table,$data,$where){
         $sql = 'UPDATE '.$this->table($table).' SET ';
         foreach($data as $k=>$v){
             $sql .= "`".$k."`='".$v."',";
         }
         $sql = rtrim($sql,',').' WHERE '.$this->where($where);
         //if($this->query($sql))  return $this->db->affected_rows;
         return $this->query($sql);
    }

    public function where($options){

         if(!is_array($options)){
               return $options;
         }

         $where = '1';
         foreach($options as $k=>$v){
              $where .= ' AND `'.$k.'`=\''.$v.'\'';
         }
         return $where;
    }

    public function fetch($table,$where=1,$fields='*'){
        $sql = 'SELECT '.$fields.' FROM '.$this->table($table).' WHERE '.$this->where($where).' LIMIT 1';
        //echo $sql;
        $query = $this->query($sql);
        return $query->fetch_object();
    }

    public function fetch_array($table,$where=1,$fields='*'){
        $sql = 'SELECT '.$fields.' FROM '.$this->table($table).' WHERE '.$this->where($where).' LIMIT 1';

        $query = $this->query($sql);
        return $query->fetch_assoc();
    }

    public function result($table,$where=1,$fields='*'){
        $sql = 'SELECT '.$fields.' FROM '.$this->table($table).' WHERE '.$this->where($where);
        $query = $this->query($sql);
        $data = array();
        while(($model = $query->fetch_object())!==null){
            $data[] = $model;
        }
        return $data;
    }

    public function result_array($table,$where=1,$fields='*'){
        $sql = 'SELECT '.$fields.' FROM '.$this->table($table).' WHERE '.$this->where($where);
        $query = $this->query($sql);
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    public function count($table,$where=1){
        $sql = 'SELECT count(*) FROM '.$this->table($table).' WHERE '.$this->where($where);
        $query = $this->query($sql);
        // d(DB()->sqls);exit;
        return $query->fetch_row()[0];
    }

    function affected_rows(){
        return $this->db->affected_rows;
    }

    function insert_id(){
        return $this->db->insert_id;
    }
    
    function fetch_auto_increment($table){
    	$sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name='".$this->table($table)."'";
    	$query = $this->query($sql);
    	$result = $query->fetch_object();
    	return $result===null?null:$result->AUTO_INCREMENT;
    }

    //事务开启时false，结束时true
    function autocommit($mode){
        $this->db->autocommit($mode);
    }
    function commit(){
        $this->db->commit();
    }
    function rollback(){
        $this->db->rollback();
    }

    function fetch_schema($table){

        $sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE table_name = '".$this->table($table)."' AND table_schema = '".$this->dbname."'"; 
        $query = $this->query($sql);
        return $query->fetch_all(MYSQLI_ASSOC);
    }

    function delete($table,$where){
        $sql = 'DELETE FROM '.$this->table($table).' WHERE '.$this->where($where);
        return $this->query($sql);
    }

    function trans_begin(){
        return $this->db->begin_transaction();
    }

    function trans_commit(){
        return $this->db->commit();
    }
    
    function trans_rollback(){
        return $this->db->rollback();
    }

}