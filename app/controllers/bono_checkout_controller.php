<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/bono_model.php';
require_once ROOT_PATH . '/app/session/session_manager.php';

// Este archivo no redirecciona: devuelve datos para incluir desde la vista
function getBonusData(int $bonusId): ?array
{
    if (!isAuthenticated() || $_SESSION['user']['role'] !== 'user') {
        return null;
    }

    if ($bonusId <= 0) {
        return null;
    }

    try {
        $conexion = getPDO();
        $bonusModel = new Bonus($conexion);
        $bonus = $bonusModel->getBonusById($bonusId);

        return is_array($bonus) && isset($bonus['id']) ? $bonus : null;
    } catch (Exception $e) {
        error_log("Error al obtener bono en checkout: " . $e->getMessage());
        return null;
    }
}
