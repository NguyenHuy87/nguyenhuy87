<?php 

use Core\Route;
function route($name, $params = []){
    return Route::getUrl($name, $params);

}

function redirect($path){
    header("Location: $path");
    exit;
}