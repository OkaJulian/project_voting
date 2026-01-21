<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/VoteController.php";

if ($currentUser['role'] !== 'admin') {
    jsonResponse(["message" => "Access denied"], 403);
}

$db = (new Database())->connect();
$controller = new VoteController($db);

$controller->results();
