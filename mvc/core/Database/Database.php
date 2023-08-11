<?php 
namespace Core\Database;

use PDO;
use Exception;
use Core\Database\Connection;

trait Database{
    private $conn = null;
    public function __construct( )
    {
        //Kết nối database => Gọi connecion
        $instance = Connection::getInstance(); 
        $this->conn = $instance->getConnection();
        
    }
    private function query($sql, $data= [], $isStatement = false){
        //Trả về statement
        try{
            $statement = $this->conn->prepare($sql);
            $status = $statement->execute($data);
            if ($isStatement){
                return $statement;
            }
            return $status;
        }catch(Exception $e){
            echo $e->getMessage();
            die();
        }
    }

    private function get($sql = null, $data = []){
        //fetchAll
        if (!empty($this->table)){
            $sql = "SELECT $this->fields FROM $this->table";
        }
        $statement = $this->query($sql, $data, true);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    private function first($sql = null, $data = []){
        //fetch
        if (!empty($this->table)){
            $sql = "SELECT $this->fields FROM $this->table";
        }
        $statement = $this->query($sql, $data, true);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    private function create($table = null, $attribute=[]){
        if (!empty($attribute)){
            if (!empty($this->$table)){
                $table = $this->table;
            }
            $keys = array_keys($attribute);
            
            $sql = "INSERT INTO $table(".implode(', ', $keys).") VALUES (".':'.implode(', :', $keys).")";
            $status = $this->query($sql, $attribute);
            return $status;
        }
        return false;
    }

    private function creatGetId($table = null, $attribute){
        
        $this->create($table, $attribute);
        return $this->conn->lastInsertId();
    }

    private function update($table = null, $attribute = [], $condition = null){
        

        if (!empty($this->$table)){
            $table = $this->table;
        }


        //$sql ="UPDATE users SET name=:name, email=:email WHERE id=1";
        if (!empty($attribute)){

            

            $keys = array_keys($attribute);
            $updateStr = "";
            foreach ($keys as $key){
                $updateStr.="$key=:$key, ";
            }
    
            $updateStr = rtrim($updateStr, ', ');
            
            if (!empty($condition)){
                $sql = "UPDATE $table SET $updateStr WHERE $condition";
            }else{
                $sql = "UPDATE $table SET $updateStr";
            }
    
            $status = query($sql, $attribute);
            return $status;
        }
        
        return false;
    }

    private function delete($table, $condition = null, $data= []){
        
        if (!empty($this->$table)){
            $table = $this->table;
        }

        if (!empty($condition)){
            $sql = "DELETE FROM $table WHERE $condition";
        }else{

            if(!empty($data)){
                $sql = "DELETE FROM $table WHERE $this->primaryKey";
            }else{
                $sql = "DELETE FROM $table";
            }
            
        }
    
        $status = $this->query($sql, $data);
        return $status;
    }

    

    

    private function count($sql = null, $data = []){
        if (!empty($this->table)){
            $sql = "SELECT $this->fields FROM $this->table";
        }
        //Đếm số dòng
        $statement = $this->query($sql, $data, true);
        return $statement->rowCount();
    }

    public static function __callStatic($method, $args){    
        return call_user_func_array([new self(), $method], $args);
    }

    public function __call($method, $args){
        return call_user_func_array([$this, $method], $args);
    }
}