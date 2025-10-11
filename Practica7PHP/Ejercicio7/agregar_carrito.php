<?php
session_start();
header('Content-Type: application/json');

// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "Compras";

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = array();
}

// Verificar que se recibieron los datos
if (!isset($_POST['producto_id']) || !isset($_POST['cantidad'])) {
  echo json_encode([
    'success' => false,
    'error' => 'Datos incompletos'
  ]);
  exit;
}

$producto_id = intval($_POST['producto_id']);
$cantidad = intval($_POST['cantidad']);

// Validar cantidad
if ($cantidad <= 0) {
  echo json_encode([
    'success' => false,
    'error' => 'La cantidad debe ser mayor a cero'
  ]);
  exit;
}

try {
  $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_db;charset=utf8mb4", $usuario_db, $password_db);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Obtener información del producto
  $stmt = $conexion->prepare("SELECT * FROM catalogo WHERE id = :id AND activo = TRUE");
  $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
  $stmt->execute();

  $producto = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$producto) {
    echo json_encode([
      'success' => false,
      'error' => 'Producto no encontrado'
    ]);
    exit;
  }

  // Verificar stock disponible
  $cantidad_actual_carrito = 0;
  if (isset($_SESSION['carrito'][$producto_id])) {
    $cantidad_actual_carrito = $_SESSION['carrito'][$producto_id]['cantidad'];
  }

  $cantidad_total = $cantidad_actual_carrito + $cantidad;

  if ($cantidad_total > $producto['stock']) {
    echo json_encode([
      'success' => false,
      'error' => 'Stock insuficiente. Disponible: ' . $producto['stock'] . ' unidades'
    ]);
    exit;
  }

  // Agregar o actualizar producto en el carrito
  if (isset($_SESSION['carrito'][$producto_id])) {
    $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
  } else {
    $_SESSION['carrito'][$producto_id] = [
      'id' => $producto['id'],
      'nombre' => $producto['nombre'],
      'descripcion' => $producto['descripcion'],
      'precio' => $producto['precio'],
      'cantidad' => $cantidad,
      'emoji' => $producto['emoji'],
      'categoria' => $producto['categoria']
    ];
  }

  // Calcular totales
  $total_items = 0;
  $subtotal = 0;
  foreach ($_SESSION['carrito'] as $item) {
    $total_items += $item['cantidad'];
    $subtotal += $item['precio'] * $item['cantidad'];
  }

  echo json_encode([
    'success' => true,
    'mensaje' => 'Producto agregado al carrito',
    'carrito' => [
      'items' => count($_SESSION['carrito']),
      'total_items' => $total_items,
      'subtotal' => $subtotal
    ]
  ]);
} catch (PDOException $e) {
  echo json_encode([
    'success' => false,
    'error' => 'Error al procesar la solicitud',
    'detalles' => $e->getMessage()
  ]);
}
