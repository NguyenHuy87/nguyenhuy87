<?php 

namespace App\Models;

use Core\Model;

class Product extends Model{

    protected $table = 'users';
    protected $primaryKey = 'id';
    public function getListProduct(){
        //Nghiệp vụ liên quan đến database thì viết vào đây 
        //Trả về danh sách các product
        return $this->get("SELECT * FROM users");// Tự hiểu là SELECT * FROM users
    }
}


//Quy ước 
// 1 table => 1 model
// Tạo 1 model => cá nhân hóa tương ứng với table
