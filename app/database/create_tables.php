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
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (pilates_type, coach, day, hour, capacity),
    FOREIGN KEY (pilates_type) REFERENCES pilates_specialities(id) ON DELETE CASCADE,
    FOREIGN KEY (coach) REFERENCES coaches(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Instancias de clases: almacena las instancias de las lecciones programadas por fechas
CREATE TABLE IF NOT EXISTS class_instances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    instance_date DATE NOT NULL,
    hour TIME NOT NULL, -- 🕒 NUEVA COLUMNA para guardar la hora real de la instancia
    coach_id INT NOT NULL,
    capacity INT NOT NULL,
    is_cancelled BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_class_instances_lesson
        FOREIGN KEY (lesson_id) REFERENCES pilates_lessons(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_class_instances_coach
        FOREIGN KEY (coach_id) REFERENCES coaches(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Reservas de clases
CREATE TABLE IF NOT EXISTS class_reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    class_instance_id INT NOT NULL,
    reserved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    used_credit_id INT DEFAULT NULL,
    is_cancelled BOOLEAN NOT NULL DEFAULT FALSE,

    CONSTRAINT fk_reservations_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_reservations_instance
        FOREIGN KEY (class_instance_id) REFERENCES class_instances(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_reservations_credit
        FOREIGN KEY (used_credit_id) REFERENCES credits(id)
        ON DELETE SET NULL,

    UNIQUE (user_id, class_instance_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Créditos (bonos)
CREATE TABLE IF NOT EXISTS credits (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  purchase_id INT NOT NULL,
  total_credits INT NOT NULL,              -- créditos totales comprados
  used_credits INT DEFAULT 0,              -- créditos ya utilizados
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  expires_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (purchase_id) REFERENCES purchases(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Bonos
CREATE TABLE IF NOT EXISTS bonos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  credits INT NOT NULL,                     -- cuántas clases incluye
  price DECIMAL(8,2) NOT NULL,
  duration_weeks INT DEFAULT 4,             -- duración fija de 4 semanas
  activo TINYINT(1) DEFAULT 1,              -- 1 = activo, 0 = inactivo
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Bonos de usuarios que lo compran
CREATE TABLE IF NOT EXISTS user_bonos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  bono_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL, -- 4 semanas después de start_date
  credits_remaining INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (bono_id) REFERENCES bonos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Tabla de compras: almacena las compras de bonos realizadas por los usuarios
CREATE TABLE IF NOT EXISTS purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bonus_id INT NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    purchased_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    valid_until DATETIME NOT NULL,
    credits INT NOT NULL DEFAULT 0,
    stripe_session_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (bonus_id) REFERENCES bonos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_stripe_session_id (stripe_session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

";

    // Ejecutar la consulta para crear las tablas
    $conexion->exec($query);
    echo "Todas las tablas fueron creadas correctamente.";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
