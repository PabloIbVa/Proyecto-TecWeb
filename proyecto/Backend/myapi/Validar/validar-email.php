<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use myapi\Auth\UserAuth;

$auth = new UserAuth('bugweb');
$is_available = $auth->emailAvailable($_GET["email"]);

header('Content-Type: application/json');
echo json_encode(['available' => $is_available]);
