<?php 
namespace Core;
class Template{
    public static function run($contentView){
        //Xử lý master layout
        $contentView = self::masterLayout($contentView);


        //Xử lý các cú pháp Template
        $contentView = self::show($contentView);
        $contentView = self::foreachLoop($contentView);
        return $contentView;
    }

    public static function masterLayout($contentView){
        preg_match('~@extends\([\'"](.+?)[\'"]\)~si', $contentView , $matches);
        
        echo '<pre>'; 
        print_r($matches); 
        echo '</pre>';
    }

    public static function show($contentView){
        $contentView = preg_replace('/{{\s*(.+?)\s*}}/s', '<?php echo htmlentities ($1); ?>', $contentView);
        $contentView = preg_replace('/{!!\s*(.+?)\s*!!}/s', '<?php echo $1; ?>', $contentView);
        return $contentView;
    }

    public static function foreachLoop($contentView){
        $contentView = preg_replace('/@foreach\s*\((.+?)\)/s', '<?php foreach ($1): ?>', $contentView);

        $contentView = preg_replace('/@endforeach/s', '<?php endforeach; ?>', $contentView);
        return $contentView;
    }


}

// if(!empty($matches[1])){
        //     $layoutPath = $matches[1];
        //     $contentLayout = file_get_contents(WEB_PATH_APP.'/Views/'.$layoutPath.'.php');
        //     echo $contentLayout;
        // }