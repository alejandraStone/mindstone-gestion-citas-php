<?php

/*
Este archivo consulta la API de Google Analytics 4 para obtener las visitas al sitio web.
Requiere las credenciales de la API y el ID de propiedad de Google Analytics.
*/
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/vendor/autoload.php';

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;

class GoogleAnalyticsModel
{
    private $propertyId;
    private $credentialsPath;

    public function __construct($propertyId, $credentialsPath)
    {
        $this->propertyId = $propertyId;
        $this->credentialsPath = $credentialsPath;
        putenv("GOOGLE_APPLICATION_CREDENTIALS={$this->credentialsPath}");
    }

    public function getWebsiteViewsByMonth($year, $month)
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        $client = new BetaAnalyticsDataClient([
            'transport' => 'rest'
        ]);

        $dateRange = new DateRange([
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $metric = new Metric(['name' => 'screenPageViews']);

        $request = new RunReportRequest([
            'property' => "properties/{$this->propertyId}",
            'date_ranges' => [$dateRange],
            'metrics' => [$metric],
        ]);

        $response = $client->runReport($request);
        $views = 0;
        if (count($response->getRows()) > 0) {
            $views = $response->getRows()[0]->getMetricValues()[0]->getValue();
        }
        return (int)$views;
    }
}