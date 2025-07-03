<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\SlotController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/api/slots') === 0) {
    $controller = new SlotController();
    $controller->index();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}