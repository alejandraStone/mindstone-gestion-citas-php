<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/User.php';


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

        $result = $userModel->createUser($name, $lastName, $email, $phone, $password, $role);
        echo json_encode($result);
        exit;
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
    } elseif ($input['action'] === 'reset') {// Resetear contraseña
        $id = $input['id'];
        $newPassword = bin2hex(random_bytes(4)); // random 8-character password
        $result = $userModel->resetPassword($id, $newPassword);
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Password reset successfully.',
                'newPassword' => $newPassword
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to reset password.']);
        }
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action.']);
        exit;
    }
}

echo json_encode(['success' => false, 'error' => 'Invalid request.']);