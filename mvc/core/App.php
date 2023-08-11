<?php 
namespace Core;

use Core\Route;
use Core\Request;
use Dotenv\Dotenv;

class App{
    private $route = null;

    
    public function __construct()
    {
        Session::start();
    }
    public function execute(){
        require_once '../core/helpers/url.php';
        require_once '../core/helpers/validation.php';
        require_once '../core/helpers/config.php';
        // Cần tạo request trước khi Route() khởi động 

        $dotenv = Dotenv::createImmutable(WEB_PATH_ROOT);
        $dotenv->safeLoad();


        $this->route = new Route(new Request());
        //Lớp route sẽ có 1 tham số => Tham số chính là obj của request
        $this->route->execute();
    }

    public function setConst($dir){
        define('WEB_PATH_ROOT', dirname($dir));

        define('WEB_PATH_APP', WEB_PATH_ROOT.'/app');
    }

    
}