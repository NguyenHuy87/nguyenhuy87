<?php 
namespace App\Controllers;
use Core\Model;
use Core\Route;
use Core\Request;
use Core\Session;
use Core\Validator;
use Core\Controller;
use App\Models\Product;
use App\Models\Attribute;

class ProductController extends Controller{

    private $products = [];
    /**
     * Class constructor.
     */
    // public function __construct()
    // {
    //     $productModel = TenModel;
    //     $this->products = $productModel->all;
    // }
    public function index(Request $request){
        
        //Load model
        $productModel = new Product();
        $products = $productModel->getListProduct();
        echo '<pre>'; 
        print_r($products); 
        echo '</pre>';

        //$attributeModel = new Attribute();

        //Logic
        //Load view
        // echo $request->keyword.'</br>';
        // echo '<pre>'; 
        // print_r($request->category); 
        // echo '</pre>';
        return 'ProductController Index';
    }

    public function add(){

        //Request

        //Xử lý

        //Response
        
        //echo Route::getUrl('products-add'); //Hiện url

        $this->view('products/add');
    }

    public function postAdd(Request $request){
        // //Xử lý : 
        // // -lấy dữ liệu (Request)

        // // Khởi tạo $request = new Request() => Tạo 1 request mới (Không có dữ liệu)
        // // đưa request => postAdd(Request $request) => Lấy request hiện tại

        // if ($request->email){
        //     echo $request->email.'<br/>';

        // }
        // // $request->abc = '123';
        // // echo $request->abc;

        // // $request = new Request();
        // // echo '<pre>'; 
        // // print_r($request->all()); 
        // // echo '</pre>';
        // //Tương tác với Database
        // // - Redirect về get(Response)
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         //tên trường -> danh sách rules
        //         'name' => 'required|min:4|max:15',
        //         'email' => 'required|email|unique:users,email',
        //         'password' => 'required|min:6',
        //         'confirm_password' => 'required|min:6|same:password'
        //     ],
        //     [
        //         //tên rule => nội dung thông báo 
        //         'required' => ':attribute không được để trống',
        //         'min' => ':attribute phải từ :min ký tự',
        //         'max' => ':attribute không được lớn hơn :max ký tự',
        //         'same' => ':attribute không khớp với :same',
        //         'email' => ':attribute không đúng định dạng email',
        //         'unique' => ':attribute đã tồn tại trong hệ thống'
        //     ],
        //     [
        //         'name' => 'Tên',
        //         'email' => 'Email',
        //         'password' => 'Mật khẩu',
        //         'confirm_password' => 'Nhập lại mật khẩu',
        //     ]
        // );
        $id = 28;


        $request->validate(
            [
                //tên trường -> danh sách rules
                'name' => 'required|min:4|max:15',
                'email' => 'required|email|unique:users,email,' .$id,
                'password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:password'
            ],
            [
                //tên rule => nội dung thông báo 
                'required' => ':attribute không được để trống',
                'min' => ':attribute phải từ :min ký tự',
                'max' => ':attribute không được lớn hơn :max ký tự',
                'same' => ':attribute không khớp với :same',
                'email' => ':attribute không đúng định dạng email',
                'unique' => ':attribute đã tồn tại trong hệ thống'
            ],
            [
                'name' => 'Tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'confirm_password' => 'Nhập lại mật khẩu',
            ]
        );

        // $validator ->fails();
        // echo '<pre>'; 
        // print_r($validator->getMessage()); 
        // echo '</pre>';
        // if ($validator->passes()){
        //     echo 'Thành công ';
        // }else{
        //     echo 'Thất bại';
        //     redirect('/san-pham/them');
        // }
        // echo '<pre>'; 
        // print_r(Session::get('validate_errors')); 
        // echo '</pre>';
        return 'submit';
        
    }

    public function edit(Request $request,$id){
        $this->view('products/edit', compact('id'));
    }

    public function postEdit($id){
        return $id;
    }
}