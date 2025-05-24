<?php
require_once __DIR__ . '/../config/config.php';
require_once ROOT_PATH . '/app/config/database.php';
class PDFModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    public function savePDF($filePath, $description, $adminId)
    {
        $stmt = $this->conexion->prepare("INSERT INTO pdf_files (file_path, description, uploaded_by, uploaded_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$filePath, $description, $adminId]);
    }
    public function getAllPDFs()
    {
        $stmt = $this->conexion->query("SELECT pf.*, u.name, u.lastName FROM pdf_files pf JOIN users u ON u.id = pf.uploaded_by ORDER BY pf.uploaded_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //Consultar un PDF por ID para mostrar un PDF específico o para descargarlo
    public function getPDFById($id)
{
    $stmt = $this->conexion->prepare("SELECT pf.*, u.name, u.lastName FROM pdf_files pf JOIN users u ON u.id = pf.uploaded_by WHERE pf.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
