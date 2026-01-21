<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../helpers/response.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../config/jwt.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['password'])) {
    jsonResponse(["message" => "Username dan password wajib diisi"], 422);
}

$db = (new Database())->connect();

$stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$data['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    jsonResponse(["message" => "User tidak ditemukan"], 401);
}

if (!password_verify($data['password'], $user['password'])) {
    jsonResponse(["message" => "Password salah"], 401);
}

$payload = [
    "uid"  => $user['id'],
    "role" => $user['role'],
    "iat"  => time(),
    "exp"  => time() + JWT_EXPIRE
];

$token = JWT::encode($payload, JWT_SECRET, 'HS256');

jsonResponse([
    "message" => "Login berhasil",
    "token"   => $token,
    "role"    => $user['role']
]);
