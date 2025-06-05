<?php
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
            // Si el rol es 'user', es registro desde app, iniciamos sesión automáticamente y guardamos los datos del usuario o la sesión
            if ($role === 'user' && isset($result['user'])) {
                loginUserSession($result['user']);
            }
            echo json_encode($result);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => $result['message'] ?? 'Invalid request.']);
            exit;
        }

    } elseif ($input['action'] === 'update') {// Editar usuario
        $id = $input['id'];
        $name = $input['name'];
        $lastName = $input['lastName'];
        $email = $input['email'];
        $phone = $input['phone'];
        $role = $input['role'];

        $result = $userModel->updateUser($id, $name, $lastName, $email, $phone, $role);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update user.']);
        }
        exit;
    } elseif ($input['action'] === 'delete') {// Eliminar usuario
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