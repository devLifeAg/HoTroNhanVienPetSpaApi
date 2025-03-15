<?php

return [
    'paths' => ['api/*'], // Cho phép CORS trên tất cả API endpoints
    'allowed_methods' => ['*'], // Cho phép tất cả HTTP methods (GET, POST, PUT, DELETE, v.v.)
    'allowed_origins' => ['*'], // Cho phép tất cả domain truy cập API
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Cho phép tất cả headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Đặt `true` nếu cần gửi cookie hoặc thông tin đăng nhập
];
