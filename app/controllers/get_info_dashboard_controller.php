<?php
/*
Archivo que maneja la obtención de información para el dashboard del administrador.
Este archivo recibe es llamado por el js y devuelve estadísticas sobre reservas, usuarios y visitas al sitio web.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/class_reservation_model.php';
require_once ROOT_PATH . '/app/models/User.php'; // modelo de usuarios para obtener el crecimiento de usuarios
require_once ROOT_PATH . '/app/models/google_analytics_model.php'; // modelo de Google Analytics para obtener las visitas al sitio web


header('Content-Type: application/json');

try {
    $conexion = getPDO();
    $reservationModel = new ClassReservation($conexion);
    $userModel = new User($conexion);

    // --- DATOS DE GOOGLE ANALYTICS ---
    $propertyId = '493417605'; // numero de propiedad de Google Analytics 4
    $credentialsPath = ROOT_PATH . '/app/helpers/analytics.json';
    $gaModel = new GoogleAnalyticsModel($propertyId, $credentialsPath);

    $now = new DateTime();
    $currentYear = (int)$now->format('Y');
    $currentMonth = (int)$now->format('m');
    $lastMonthDate = (clone $now)->modify('first day of last month');
    $lastMonthYear = (int)$lastMonthDate->format('Y');
    $lastMonth = (int)$lastMonthDate->format('m');

    // Visitas este mes y el mes anterior
    $websiteViewsThisMonth = $gaModel->getWebsiteViewsByMonth($currentYear, $currentMonth);
    $websiteViewsLastMonth = $gaModel->getWebsiteViewsByMonth($lastMonthYear, $lastMonth);

    // Crecimiento porcentual de visitas
    if ($websiteViewsLastMonth > 0) {
        $websiteViewsGrowthPercentage = (($websiteViewsThisMonth - $websiteViewsLastMonth) / $websiteViewsLastMonth) * 100;
    } else {
        $websiteViewsGrowthPercentage = null;
    }

    //Reservas del mes actual
    // Contar reservas del mes actual y calcular crecimiento respecto al mes anterior
    $countResult = $reservationModel->countReservationsInMonthWithGrowth($currentYear, $currentMonth);

    if (!$countResult['success']) {
        throw new Exception('Error fetching reservations: ' . $countResult['message']);
    }

    // Clase más popular del mes
    $popularClass = $reservationModel->getMostPopularClassThisMonth();
    $mostPopularClassName = $popularClass['class_name'] ?? null;

    // Clase MENOS popular del mes
    $leastPopularClass = $reservationModel->getLeastPopularClassThisMonth();
    $leastPopularClassName = $leastPopularClass['class_name'] ?? null;

    // Crecimiento de horas pico
    $peakHourData = $reservationModel->getPeakHourGrowth($currentYear, $currentMonth);

    // Crecimiento de usuarios registrados
    $userStats = $userModel->getMonthlyRegisteredUsersGrowth($currentYear, $currentMonth);

    echo json_encode([
        'success' => true,
        'total_reservations_this_month' => $countResult['count'],
        'growth_percentage' => $countResult['growth_percentage'],
        'most_popular_class' => $mostPopularClassName,
        'least_popular_class' => $leastPopularClassName,
        'peak_hour' => $peakHourData['peak_hour'],
        'peak_hour_bookings' => $peakHourData['reservations_this_month'],
        'peak_hour_growth' => $peakHourData['growth_percentage'],
        'registered_users_this_month' => $userStats['registered_this_month'],
        'registered_users_last_month' => $userStats['registered_last_month'],
        'registered_users_growth_percentage' => $userStats['growth_percentage'],
        // --- Google Analytics: visitas y crecimiento ---
        'website_views_this_month' => $websiteViewsThisMonth,
        'website_views_growth_percentage' => $websiteViewsGrowthPercentage
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unexpected server error.',
        'error' => $e->getMessage()
    ]);
}