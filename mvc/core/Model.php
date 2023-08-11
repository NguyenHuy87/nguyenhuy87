<?php 
namespace Core;

use Core\Database\Database;



class Model{
    use Database;
    protected $table = null;
    protected $primaryKey = 'id';
    protected $field = "*";
    

    
}