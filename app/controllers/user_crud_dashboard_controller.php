<?php
/*
Archivo que maneja la creación, actualización y eliminación de usuarios en el dashboard.
Este archivo recibe solicitudes POST con la acción a realizar (create, update, delete) y los datos del usuario.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/User.php';
require_once ROOT_PATH . '/app/session/session_manager.php';


header('Content-Type: application/json');
$conexion = getPDO();
$userModel = new User($conexion);

$input = json_decode(file_get_contents('php://input'), true);

if ($input && isset($input['action'])) {
    if ($input['action'] === 'create') { // Crear usuario
        $name = $input['name'] ?? '';
        $lastName = $input['lastName'] ?? '';
        $email = $input['email'] ?? '';
        $phone = $input['phone'] ?? '';
        $password = $input['password'] ?? '';
        $role = $input['role'] ?? 'user';

        if (!$name || !$lastName || !$email || !$phone || !$password || !$role) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
            exit;
        }
        // Crear el usuario
        $result = $userModel->createUser($name, $lastName, $email, $phone, $password, $role);
        if ($result['success']) {
            // Solo iniciamos sesión si el contexto es "signup" (registro desde la app) y guardamos los datos del usuario o la sesión
            $context = $input['context'] ?? null;

            if ($role === 'user' && $context === 'signup' && isset($result['user'])) {
                loginUserSession($result['user']);
            }
            echo json_encode($result);
            exit;
        } else {
            echo json_encode(['success' => 
            false, 'message' => $result['message'] ?? 'Invalid request.']);
            exit;
        }
    } elseif ($input['action'] === 'update') { // Editar usuario
        $id = $input['id'];
        $name = $input['name'];
        $lastName = $input['lastName'];
        $email = $input['email'];
        $phone = $input['phone'];
        $role = $input['role'];

        $result = $userModel->updateUser($id, $name, $lastName, $email, $phone, $role);

        if (isset($result['success']) && $result['success'] === true) {
            echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
        } else {
            $error = $result['message'] ?? ($result['error'] ?? 'Failed to update user.');
            echo json_encode(['success' => false, 'error' => $error]);
        }
        exit;
    } elseif ($input['action'] === 'delete') { // Eliminar usuario
        $id = $input['id'];
        $result = $userModel->deleteUser($id);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete user.']);
        }
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action.']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid request.']);
