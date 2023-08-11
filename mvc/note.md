# 

/app => Thư mục chứa controllers, models, views => Chứa code của ứng dụng

/core => Lõi của ứng dụng (Không thay đổi và không được sửa core)

Hàm thuần => Helpers 

@foreach (@users as $user) => <?php forecho ($user as $user): ?>

@endforeach => <?php | ?>

## Xử lý định danh Routes

- Lấy tất cả các Path của config
- Lưu vào 1 mảng
...

## Helper

- Helper Core => Có sẵn tron bộ core 
- Helper App => Hàm tự tạo theo dự án

## Quy trình request

Index => Bootstrap => App =>Request, Response(tồn tại trước routes) => Route(để điều hướng)

Về nhà 

- Viết các phương thức để truy vấn database trong class Model
- Thực hành xây dựng CRUD đơn giản ( Có thể làm todolist)

Buổi sau: 

- Tích hợp Query Builder vào dự án => Thuận tiện hơn trong quá trình truy vấn
- Chữa bài tập CRUD 

=> Hướng tới làm project đơn giản

Thường tách model ra => giải quyết 1 số bài toán

Tình huống : Gọi Database ngoài Model

Tham khảo trên mạng sẽ có 

Connect => DB Driver(Xử lý các thao tác: chung chung nhất có thể ) => DB Business (Model tương ứng mà mình tạo : đang được cá nhân hóa)

BTNV : Xây dựng CRUD đơn giản (TODOList)

Master Layouts
- Dùng Regex(Biểu thức chính quy) => Lấy đường dẫn tới file master layout

- Lấy nội dung trong file master layout

- Dùng Regex(Biểu thức chính quy) => lấy nội dung trong section(Trong view)

- Thay thế yield('name')-> thành nội dung trong section

