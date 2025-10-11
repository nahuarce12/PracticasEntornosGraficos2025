<?php
session_start();
header('Content-Type: application/json');

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = array();
}

// Calcular totales
$total_items = 0;
$subtotal = 0;
$items = [];

foreach ($_SESSION['carrito'] as $producto_id => $item) {
  $total_items += $item['cantidad'];
  $subtotal += $item['precio'] * $item['cantidad'];
  $items[] = $item;
}

$iva = $subtotal * 0.16; // 16% de IVA
$total = $subtotal + $iva;

echo json_encode([
  'success' => true,
  'items' => $items,
  'totales' => [
    'cantidad_productos' => count($items),
    'total_items' => $total_items,
    'subtotal' => round($subtotal, 2),
    'iva' => round($iva, 2),
    'total' => round($total, 2)
  ]
]);
