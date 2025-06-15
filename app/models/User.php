<?php
/*
Archivo que define la clase User para manejar operaciones relacionadas con usuarios en la base de datos.
Esta clase incluye métodos para verificar la existencia de un email, iniciar sesión, contar usuarios, crear, leer, actualizar y eliminar usuarios.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class User
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Verificar si el email existe (true/false)
    public function emailExist($email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $this->conexion->prepare($query);
        $result->execute(['email' => strtolower(trim($email))]);
        return $result->fetchColumn() > 0;
    }

    // Login: obtiene los datos del usuario (para luego comparar el password)
    public function login($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute(['email' => strtolower(trim($email))]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // array asociativo o false
    }
    // Contar usuarios para paginación (con filtro)
    public function countUsers($search = '', $role = '')
    {
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
    public function getUserById($id)
    {
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
            $id = $this->conexion->lastInsertId();
            $user = $this->getUserById($id);

            return [
                'success' => true,
                'message' => 'User created successfully.',
                'user' => $user
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Unexpected error when adding the user.'
            ];
        }
    }
    // Read-Listar usuarios paginados
    public function getUsers($limit, $offset, $search = '', $role = '')
    {
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
    // Comprueba si el email existe en otro usuario distinto al actual (por ID)
    public function emailExistOtherUser($email, $id)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email AND id <> :id";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute(['email' => strtolower(trim($email)), 'id' => $id]);
        return $stmt->fetchColumn() > 0;
    }
    //Actualizar user
    public function updateUser($id, $name, $lastName, $email, $phone, $role)
    {
        // Previene duplicados en otros usuarios
        if ($this->emailExistOtherUser($email, $id)) {
            return [
                'success' => false,
                'error' => 'A user with this email already exists.'
            ];
        }
        try {
            $stmt = $this->conexion->prepare("UPDATE users SET name = ?, lastName = ?, email = ?, phone = ?, role = ? WHERE id = ?");
            $stmt->execute([$name, $lastName, $email, $phone, $role, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return ['success' => false, 'error' => 'The email already exists.'];
            }
            return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }
    // Delete - Eliminar usuario
    public function deleteUser($id)
    {
        $stmt = $this->conexion->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    // Resetear contraseña
    public function resetPassword($id, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conexion->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $id]);
    }
    // Obtener usuario por email (para login y recuperación de contraseña)
    public function getUserByEmail($email)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([strtolower(trim($email))]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Método para calcular el porcentaje de crecimiento entre dos valores
   public function calculateGrowthPercentage($current, $previous)
{
    if ($previous > 0) {
        return round((($current - $previous) / $previous) * 100, 2);
    } elseif ($current > 0) {
        return null; // Para que el frontend muestre "New!"
    } else {
        return 0; // Nada de crecimiento ni antes ni ahora
    }
}
    //método para obtener el número de usuarios registrados y crecimiento mensualmente
    public function getMonthlyRegisteredUsersGrowth(int $year, int $month): array
{
    try {
        // Fechas del mes actual
        $startDate = new DateTime("$year-$month-01");
        $endDate = clone $startDate;
        $endDate->modify('last day of this month');
        
        // Usuarios registrados este mes
        $sql = "SELECT COUNT(*) as total
                FROM users
                WHERE created_at BETWEEN :start_date AND :end_date";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':start_date' => $startDate->format('Y-m-d 00:00:00'),
            ':end_date' => $endDate->format('Y-m-d 23:59:59')
        ]);
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $registeredThisMonth = $current ? (int)$current['total'] : 0;

        // Fechas del mes anterior
        $prevMonthDate = (clone $startDate)->modify('-1 month');
        $prevYear = (int)$prevMonthDate->format('Y');
        $prevMonth = (int)$prevMonthDate->format('m');
        $prevStartDate = new DateTime("$prevYear-$prevMonth-01");
        $prevEndDate = clone $prevStartDate;
        $prevEndDate->modify('last day of this month');

        // Usuarios registrados el mes anterior
        $stmt2 = $this->conexion->prepare($sql);
        $stmt2->execute([
            ':start_date' => $prevStartDate->format('Y-m-d 00:00:00'),
            ':end_date' => $prevEndDate->format('Y-m-d 23:59:59')
        ]);
        $prev = $stmt2->fetch(PDO::FETCH_ASSOC);
        $registeredLastMonth = $prev ? (int)$prev['total'] : 0;

        // Calcular crecimiento
        $growth = $this->calculateGrowthPercentage($registeredThisMonth, $registeredLastMonth);

        return [
            'success' => true,
            'registered_this_month' => $registeredThisMonth,
            'registered_last_month' => $registeredLastMonth,
            'growth_percentage' => $growth
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
    }
}
