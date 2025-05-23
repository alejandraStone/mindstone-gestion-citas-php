<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';

$username = "root";
$password = "";
$host = "localhost";
$database = "mindstone";

try {
    // Conexión sin especificar DB para poder crearla si no existe
    $conexion = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear base de datos si no existe
    $conexion->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8 COLLATE utf8_general_ci");

    echo "Base de datos '$database' verificada o creada correctamente.<br>";

    // Conectarse a la base de datos recién creada
    $conexion->exec("USE `$database`");

    // Crear tablas
    $query = "

-- Tabla de usuarios: almacena los datos de todos los usuarios del sistema (admins y usuarios normales)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla de archivos PDF: almacena los documentos subidos por los usuarios (como informes, contratos, etc.)
CREATE TABLE IF NOT EXISTS pdf_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_path VARCHAR(255) NOT NULL,
    description TEXT,
    uploaded_by INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla de especialidades de pilates: almacena los diferentes tipos de clases o especialidades que se ofrecen
CREATE TABLE IF NOT EXISTS pilates_specialities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla de coaches: almacena los datos de los instructores de pilates
CREATE TABLE IF NOT EXISTS coaches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla de coaches y especialidades: relación muchos a muchos entre coaches y especialidades
-- Un coach puede tener varias especialidades y una especialidad puede ser impartida por varios coaches
CREATE TABLE IF NOT EXISTS coach_speciality (
    coach_id INT NOT NULL,
    speciality_id INT NOT NULL,
    PRIMARY KEY (coach_id, speciality_id),
    FOREIGN KEY (coach_id) REFERENCES coaches(id) ON DELETE CASCADE,
    FOREIGN KEY (speciality_id) REFERENCES pilates_specialities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabla de lecciones de pilates: almacena las clases programadas
-- Cada lección tiene un tipo de pilates, un coach, un día y una hora
CREATE TABLE IF NOT EXISTS pilates_lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pilates_type INT NOT NULL,
    coach INT NOT NULL,
    day VARCHAR(10) NOT NULL,
    hour TIME NOT NULL,
    capacity INT NOT NULL,
    UNIQUE (pilates_type, coach, day, hour, capacity),
    FOREIGN KEY (pilates_type) REFERENCES pilates_specialities(id) ON DELETE CASCADE,
    FOREIGN KEY (coach) REFERENCES coaches(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

";

    $conexion->exec($query);
    echo "Todas las tablas fueron creadas correctamente.";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
