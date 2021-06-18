## Cài đặt Laravel 8.
Chúng ta có thể cài laravel qua composer. 
Để sử dụng composer ta cần cài composer trước.
Sử dụng câu lệnh sau để cài laravel vào thư mục elecma
composer create-project --prefer-dist laravel/laravel:^8 elecma

## Cấu hình 
Trong thư mục code, dùng cmd chạy câu lệnh php artisan migration
để cấu hình database.

Tiếp theo, chạy câu lệnh php artisan db:seed để thêm dữ liệu demo
vào trong database.

Chạy câu lệnh php artisan serve để khởi động server. Khi ấy ta có
thể truy cập ứng dụng với đường dẫn http://127.0.0.1:8000.
