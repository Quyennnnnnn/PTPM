<?php

return [
    // Thiết lập mặc định
    'defaults' => [
        'guard' => 'web', // Guard mặc định cho các ứng dụng web
        'passwords' => 'users', // Bảng người dùng cho việc phục hồi mật khẩu
    ],

    // Guard xác thực
    'guards' => [
        'web' => [
            'driver' => 'session', // Sử dụng session để lưu thông tin đăng nhập
            'provider' => 'users', // Sử dụng provider 'users' cho việc lấy thông tin người dùng
        ],
    ],

    // Provider dùng để lấy thông tin người dùng
    'providers' => [
        'users' => [
            'driver' => 'eloquent', // Dùng Eloquent ORM để truy xuất thông tin người dùng
            'model' => App\Models\User::class, // Mô hình User của ứng dụng
        ],
        // Nếu bạn muốn sử dụng cơ sở dữ liệu thay vì Eloquent, có thể thay thế bằng cách mở phần dưới
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users', // Lấy thông tin từ bảng 'users' trong cơ sở dữ liệu
        // ],
    ],

    // Cấu hình reset mật khẩu
    'passwords' => [
        'users' => [
            'provider' => 'users', // Provider là 'users'
            'table' => 'password_reset_tokens', // Bảng lưu trữ các token reset mật khẩu
            'expire' => 60, // Thời gian hết hạn của token (60 phút)
            'throttle' => 60, // Thời gian giữa các yêu cầu gửi lại email reset mật khẩu (60 phút)
        ],
    ],

    // Thời gian hết hạn của session (3 tiếng)
    'password_timeout' => 10800, // 10800 giây (tương đương 3 tiếng)
];
