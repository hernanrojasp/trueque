<?php
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../config/database.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if ($uri[0] === 'users') {
    if ($method === 'GET' && count($uri) === 1) {
        listUsers($pdo);
    } elseif ($method === 'GET' && isset($uri[1])) {
        getUser($pdo, $uri[1]);
    } elseif ($method === 'POST') {
        createUser($pdo);
    } elseif ($method === 'DELETE' && isset($uri[1])) {
        deleteUser($pdo, $uri[1]);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
