<?php 
namespace Core\Database;

use PDO;
use Exception;

class Connection {
    private static $instances = null;
    private $conn = null;

    

    
    public function __construct()
    {
        //Connect database with PDO

        $connection = config('database.connection_default');
        
        $config = config('database.'.$connection);

        try{
            $dsn = $config['db_driver'].':dbname='.$config['db_name'].';host='.$config['db_host'];
            
            $options =[
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
    
    
            $this->conn = new PDO($dsn, $config['db_user'], $config['db_password'], $options);

            echo 'Connected!';
    
            //var_dump($conn);
        
        }catch(Exception $e) {
            // echo 'Erorrs: ' .$e-> getMessage().'<br/>';
            // echo 'File: ' .$e->getFile().'<br/>';
            // echo 'Line:' .$e->getLine().'<br/>';
            echo $e->getMessage();
            die();
    
        }
        
    }

    public static function getInstance()
    {
        //Để $instances là thuộc tính tĩnh 
        // => nếu $instances đã tồn tại rồi 
        // thì khi khởi tạo lại sẽ không gán null cho instance nữa
        // => lấy giá trị cũ ra
        if (self::$instances == null){
            self::$instances = new self();
        }

        return self::$instances;
    }

    public function getConnection(){
        return $this->conn;
    }

    
}