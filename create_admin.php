<?php
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

$admin_data = [
    "admin" => [
        "username" => "admin",
        "password" => $hash
    ]
];

$json_path = __DIR__ . '/data/admin.json';

// Tạo thư mục data nếu chưa có
if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0755, true);
}

file_put_contents($json_path, json_encode($admin_data, JSON_PRETTY_PRINT));
echo "Tạo thành công!<br>";
echo "File: " . $json_path . "<br>";
echo "Hash: " . $hash;
?>