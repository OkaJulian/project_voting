<?php
require_once __DIR__ . "/../config/jwt.php";
require_once __DIR__ . "/../helpers/response.php";
require_once __DIR__ . "/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$headers = getallheaders();
$auth = $headers['Authorization'] ?? '';

if (!$auth) {
    jsonResponse(["message" => "Unauthorized"], 401);
}

$token = str_replace("Bearer ", "", $auth);

try {
    $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
} catch (Exception $e) {
    jsonResponse(["message" => "Invalid or expired token"], 401);
}

$currentUser = (array) $decoded;
