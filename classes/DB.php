<?php

class DB{
   private static $_instance = null;
    private $host      = "10.11.22.40";
    private $user      = "root";
    private $pass      = "ro10app";
    private $dbname    = "ro10_main";
    private $dbh;
    private $error;
    private $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            $this->dbh->exec("set names utf8");
        }
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }

     public function query($query){
        $this->stmt = $this->dbh->prepare($query);
     }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
      $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function fetch(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchColumn(){
       $this->execute();
       return $this->stmt->fetchColumn();
    }
    public function fetchNum(){
       $this->execute();
       return $this->stmt->fetch(PDO::FETCH_NUM);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
      $this->execute();
      return $this->stmt->rowCount();
    }

    //  public function fetchAll(){
    //   return $this->stmt->fetch(PDO::FETCH_ASSOC);
    // }

    // public static function getInstance()
    // {
    //     if (!isset(self::$_instance)) {
    //         self::$_instance = new DB();
    //     }
    //     return self::$_instance;
    // }

   //  public function query($sql, $params = array())
   //  {
   //      $this->_error = false;
   //      if ($this->_query = $this->_pdo->prepare($sql)) {
   //          $x = 1;
   //          if (count($params)) {
   //              foreach ($params as $param) {
   //                   $this->_query->bindValue($x, $param);
   //                   $x++;
   //              }
   //          }
   //          if ($this->_query->execute()) {
   //               $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
   //               $this->_count   = $this->_query->rowCount();
   //          } else {
   //              $this->_error = true;
   //          }
   //      }
   //      return $this;
   //  }
   //  public function action($action, $table, $where = array())
   //  {
   //      if (count($where) === 3) {
   //          $operators = array("=", ">", "<", ">=", "<=", "!=");
   //          $filed    = $where[0];
   //          $operator = $where[1];
   //          $value    = $where[2];

   //          if(in_array($operator, $operators)){
   //              $sql = "{$action} FROM {$table} WHERE {$filed} {$operator} ? ";
   //              if(!$this->query($sql, array($value))->error()){
   //                  return $this;
   //              }
   //          }
   //      }
   //      return false;
   //  }
   //  public function action2($action, $table, $where){
   //     $this->action = "{$action} FROM {$table} WHERE ";
   //     $count = 0;
   //      foreach ($where as $key => $value) {
   //          if($count == 0){
   //              $this->action .= "$key '$value'";
   //          }else{
   //             $this->action .= " AND $key '$value' ";
   //          }
   //          $count++;
   //      }
   //      if(!$this->query($this->action, $where)->error()){
   //           return $this;
   //      }
   //      return false;
   //  }
   //  public function get($table, $where){
   //      return $this->action('SELECT * ', $table, $where);
   //  }

   //  public function update($table, $id, $fileds){
   //    $set = '';
   //    $x = 1;
   //       foreach ($fileds as $name => $value) {
   //          $set .= "{$name} = ? ";
   //          if($x < count($fileds)){
   //             $set .= ', ';
   //          }
   //          $x++;
   //        }

   //    $sql = "UPDATE {$table} SET {$set} WHERE id_con_ele = {$id} ";

   //    if(!$this->query($sql, $fileds)->error()){
   //          return true;
   //    }
   //    return false;
   // }
   //  public function insert($table, $fileds = array()){
   //          $keys = array_keys($fileds);
   //          $values = '';
   //          $x = 1;
   //          foreach ($fileds as $filed) {
   //             $values .= '?';
   //             if($x < count($fileds)){
   //                $values .= ', ';
   //             }
   //             $x++;
   //          }

   //          $sql = "INSERT INTO $table (`" . implode('`, `', $keys) . "`) VALUES ({$values}) ";

   //           if(!$this->query($sql, $fileds)->error()){
   //             return true;
   //           }

   //    return false;
   // }
   //  public function results(){
   //    return $this->_results;
   // }
   // public function first(){
   //    return $this->results()[0];
   // }
   //  public function error(){
   //      return $this->_error;
   //  }
   // public function count(){
   //     return $this->_count;
   // }
}
?>