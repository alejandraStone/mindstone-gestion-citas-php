<?php 
// Incluir archivo de conexión a la base de datos
require_once '../config/database.php'; 

// Crear tablas en la base de datos
try {
    $query = "
    CREATE TABLE IF NOT EXISTS `pilates_lessons` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `pilates_type` VARCHAR(255) NOT NULL,
        `hour` TIME NOT NULL,
        `day` VARCHAR(20) NOT NULL,
        `capacity` INT(11) NOT NULL,
        `coach` INT(11) NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`coach`) REFERENCES coaches(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `lastName` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `phone` VARCHAR(15) NOT NULL,
        `password` VARCHAR(255) NOT NULL,
        PRIMARY KEY (`id`),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS `reservations` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `lesson_id` INT(11) NOT NULL,
        `user_id` INT(11) NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`lesson_id`) REFERENCES pilates_lessons(id),
        FOREIGN KEY (`user_id`) REFERENCES users(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ";

    // Ejecutar las consultas SQL
    $conexion->exec($query);

    echo "Tablas creadas correctamente.";

} catch (PDOException $e) {
    echo "Error al crear las tablas: " . $e->getMessage();
}
?>
