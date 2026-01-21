<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/VoteController.php";

if ($currentUser['role'] !== 'user') {
    jsonResponse(["message" => "Access denied"], 403);
}

$db = (new Database())->connect();
$controller = new VoteController($db);

$data = json_decode(file_get_contents("php://input"), true);

$controller->vote($currentUser['uid'], $data['candidate_id']);
