<?php 

use Core\App;
use Core\Route;
require_once '../vendor/autoload.php';



$app = new App();
$app->setConst(__DIR__);
$app->execute();
