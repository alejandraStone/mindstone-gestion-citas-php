<?php 
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class User{
    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    // Verificar si el email existe (true/false)
    public function emailExist($email){
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $this->conexion->prepare($query);
        $result->execute(['email' => strtolower(trim($email))]);
        return $result->fetchColumn() > 0;
    }
    
    // Login: obtiene los datos del usuario (para luego comparar el password)
    public function login($email){
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute(['email' => strtolower(trim($email))]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // array asociativo o false
    }
    // Contar usuarios para paginación (con filtro)
    public function countUsers($search = '', $role = ''){
        $sql = "SELECT COUNT(*) FROM users WHERE 1";
        $params = [];
        if ($search) {
            $sql .= " AND (name LIKE :search OR lastName LIKE :search OR email LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        if ($role) {
            $sql .= " AND role = :role";
            $params['role'] = $role;
        }
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    // Obtener usuario por ID
    public function getUserById($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //-----METODO CRUD------

    // Crear usuario (para registro público o dashboard) Por defecto, el rol es 'user'
    public function createUser($name, $lastName, $email, $phone, $password, $role = 'user'){
        // Previene duplicados
        if ($this->emailExist($email)) {
            return [
                'success' => false,
                'message' => 'A user with this email already exists.'
            ];
        }

        $query = "INSERT INTO users (name, lastName, email, phone, password, role) 
                  VALUES (:name, :lastName, :email, :phone, :password, :role)";
        $stmt = $this->conexion->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $success = $stmt->execute([
            'name' => $name,
            'lastName' => $lastName,
            'email' => strtolower(trim($email)),
            'phone' => $phone,
            'password' => $hashedPassword,
            'role' => $role
        ]);

        if ($success) {
            return [
                'success' => true,
                'message' => 'User created successfully.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Unexpected error when adding the user.'
            ];
        }
    }
    // Read-Listar usuarios paginados y filtrados
    public function getUsers($limit, $offset, $search = '', $role = '') {
        $sql = "SELECT * FROM users WHERE 1";
        $params = [];
        if ($search) {
            $sql .= " AND (name LIKE :search OR lastName LIKE :search OR email LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        if ($role) {
            $sql .= " AND role = :role";
            $params['role'] = $role;
        }
        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conexion->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue(':' . $key, $val);
        }
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Update- Actualizar usuario
    public function updateUser($id, $name, $lastName, $email, $phone, $role) {
        $stmt = $this->conexion->prepare("UPDATE users SET name = ?, lastName = ?, email = ?, phone = ?, role = ? WHERE id = ?");
        return $stmt->execute([$name, $lastName, $email, $phone, $role, $id]);
    }
    // Delete - Eliminar usuario
    public function deleteUser($id) {
        $stmt = $this->conexion->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    // Resetear contraseña
    public function resetPassword($id, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conexion->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $id]);
    }

}
?>