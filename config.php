<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$basePath = '/'; // sửa theo đúng đường dẫn bạn đang dùng

define('BASE_URL', $protocol . $host . $basePath);

// Có thể thêm cấu hình khác nếu cần
