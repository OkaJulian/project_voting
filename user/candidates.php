<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/CandidateController.php";

$db = (new Database())->connect();
$controller = new CandidateController($db);

$controller->index();
