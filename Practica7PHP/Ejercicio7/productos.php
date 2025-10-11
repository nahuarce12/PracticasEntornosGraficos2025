<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "Compras";

try {
  $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_db;charset=utf8mb4", $usuario_db, $password_db);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Obtener todos los productos activos
  $stmt = $conexion->query("SELECT * FROM catalogo WHERE activo = TRUE ORDER BY categoria, nombre");
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode([
    'success' => true,
    'productos' => $productos,
    'total' => count($productos)
  ]);
} catch (PDOException $e) {
  echo json_encode([
    'success' => false,
    'error' => 'No se pudo conectar a la base de datos. Asegúrate de configurarla primero.',
    'detalles' => $e->getMessage()
  ]);
}
