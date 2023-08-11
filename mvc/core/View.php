<?php 
namespace Core;

use Core\Template;
use Dotenv\Store\File\Paths;

class View {
    public static function render($path, $data = []){
        extract($data);
        
        $contentView = self::getView($path);

        //Thay thế 
        $contentView = Template::run($contentView);
        
            
        eval('?> '.$contentView.'<?php');
    }

    private static function getView($path){
        $path = WEB_PATH_APP.'/Views/'.$path.'.php';
        return file_get_contents($path);
    }
}