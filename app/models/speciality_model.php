<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

class Speciality
{
    // Obtener todas las especialidades de la tabla `specialities`
    public static function getAll()
    {
        try {
            $pdo = getPDO(); // Función que devuelve el objeto PDO
            $stmt = $pdo->query("SELECT id, name FROM pilates_specialities ORDER BY name ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
