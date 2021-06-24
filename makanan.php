<?php
require_once('./vendor/autoload.php');

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit();
}

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit();
}

list(, $token) = explode(' ', $headers['Authorization']);

try {
    JWT::decode(
        $token,
        $_ENV['ACCESS_TOKEN_SECRET'],
        ['HS256']
    );
    $makanan = [
        [
            'nama_makanan' => 'Bakso',
            'keterangan' => 'Yamin Manis Pedas',
            'harga' => 'Rp 13.000'
        ],
        [
            'nama_makanan' => 'Seblak',
            'keterangan' => 'Pedas',
            'harga' => 'Rp 15.000'
        ],
        [
            'nama_makanan' => 'Okinawa Brown Sugar',
            'keterangan' => 'Kokumi (L)',
            'harga' => 'Rp 35.000'
        ]
    ];
    echo json_encode($makanan);
} catch (Exception $e) {
    http_response_code(401);
    exit();
}