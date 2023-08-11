<?php 
function config($name){
    $nameArr = explode('.', $name);
    $result = null;
    if (!empty($nameArr)){
        $fileName = $nameArr[0];
        $content = require WEB_PATH_ROOT.'/config/'.$fileName.'.php';

        unset($nameArr[0]);
        $keys = array_values($nameArr);
        if (!empty($keys)){
            
            foreach ($keys as $key){
                // echo $content[$key];
                if ($result == null){
                    $result = $content[$key];
                }else {
                    $result = $result[$key];
                }
            }
        }
    }

    return $result;
}

// Nếu gọi config('app.timezone')
// Hoặc config('app.name')
// hoặc config('database.mysql.db_driver') => mysql

function env($name, $default){
    return !empty($_ENV[$name]) ? $_ENV[$name]:$default;
}