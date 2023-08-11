<?php 
namespace App\Controllers;

use Core\View;
use Core\Controller;

class HomeController extends Controller
{ //Modul
    //Action
    public function index(){
        //require_once '../app/Views/home/index.php';
        // $data = [
        //     'title' => 'Unicode Academy'
        // ];


        // echo config('service.google_api_key');

        

        $title = 'Unicode Academy';
        $users = [
            'User 1',
            'User 2',
            'User 3'
        ];
        $content = 'Khóa học Unicode';
        $products = [
            'Sản Phẩm1',
            'Sản phẩm 2',
            'Sản phẩm 3'
        ];
        // $this->view('home/index', compact('title', 'users', 'content'));
        View::render('home/index',compact('title', 'users', 'content', 'products'));
    }

    public function report(){
        return 'HomeController Report';
    }
}