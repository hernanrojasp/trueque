<?php
require_once __DIR__ . '/../models/User.php';

function listUsers($pdo) {
    $user = new User($pdo);
    echo json_encode($user->getAll());
}

function getUser($pdo, $id) {
    $user = new User($pdo);
    $result = $user->getById($id);
    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
}

function createUser($pdo) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data['name'] || !$data['email']) {
        http_response_code(400);
        echo json_encode(['error' => 'Nombre y correo requeridos']);
        return;
    }
    $user = new User($pdo);
    if ($user->create($data)) {
        http_response_code(201);
        echo json_encode(['mensaje' => 'Usuario creado']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al crear usuario']);
    }
}

function deleteUser($pdo, $id) {
    $user = new User($pdo);
    if ($user->delete($id)) {
        echo json_encode(['mensaje' => 'Usuario eliminado']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo eliminar']);
    }
}
