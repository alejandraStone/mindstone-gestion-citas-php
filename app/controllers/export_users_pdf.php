<?php 
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
require_once ROOT_PATH . '/app/models/User.php';
require_once ROOT_PATH . '/app/lib/fpdf186/fpdf.php';//Librería para generar PDF

$conexion = getPDO();
$userModel = new User($conexion);

// Parámetros filtro para exportar
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';


//Obtner todos los usuarios (se puede ajustar el límite y el offset)
$users = $userModel->getUsers(1000, 0, $search, $role);

// --- Crear PDF ---
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Listado de Usuarios', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
// Encabezados de tabla
$pdf->Cell(10, 8, 'ID', 1);
$pdf->Cell(30, 8, 'Nombre', 1);
$pdf->Cell(30, 8, 'Apellido', 1);
$pdf->Cell(55, 8, 'Email', 1);
$pdf->Cell(25, 8, 'Telefono', 1);
$pdf->Cell(20, 8, 'Rol', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);

foreach ($users as $user) {
    $pdf->Cell(10, 8, $user['id'], 1);
    $pdf->Cell(30, 8, utf8_decode($user['name']), 1);
    $pdf->Cell(30, 8, utf8_decode($user['lastName']), 1);
    $pdf->Cell(55, 8, utf8_decode($user['email']), 1);
    $pdf->Cell(25, 8, $user['phone'], 1);
    $pdf->Cell(20, 8, $user['role'], 1);
    $pdf->Ln();
}

// Output del PDF
$pdf->Output('D', 'usuarios.pdf'); // 'D' = Descargar, 'I' = Mostrar en navegador
exit;// Crear un nuevo PDF
?>