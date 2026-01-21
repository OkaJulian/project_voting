<?php
require_once __DIR__ . "/../auth/middleware.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/CandidateController.php";
require_once __DIR__ . "/../helpers/response.php";

if (!isset($currentUser) || $currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Access denied"], 403);
}

$db = (new Database())->connect();
$controller = new CandidateController($db);

$method = $_SERVER['REQUEST_METHOD'];
$id     = $_GET['id'] ?? null;
$data   = json_decode(file_get_contents("php://input"), true);

switch ($method) {

    // READ (GET)
    case "GET":
        $controller->index();
        break;
    
    // CREATE (POST)
    case "POST":
        if (!$data) {
            jsonResponse(["message" => "Invalid JSON body"], 400);
        }
        $controller->store($data);
        break;

    // UPDATE (PUT)
    case "PUT":
        if (!$id) {
            jsonResponse(["message" => "ID kandidat wajib diisi"], 422);
        }
        if (!$data) {
            jsonResponse(["message" => "Invalid JSON body"], 400);
        }
        $controller->update($id, $data);
        break;

    // DELETE (DELETE)
    case "DELETE":
        if (!$id) {
            jsonResponse(["message" => "ID kandidat wajib diisi"], 422);
        }
        $controller->destroy($id);
        break;

    default:
        jsonResponse(["message" => "Method not allowed"], 405);
}
