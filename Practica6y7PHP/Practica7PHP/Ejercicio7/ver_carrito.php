<?php
session_start();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = array();
}

// Procesar acciones del carrito
$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
      case 'actualizar':
        if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
          $producto_id = intval($_POST['producto_id']);
          $cantidad = intval($_POST['cantidad']);

          if ($cantidad > 0 && isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] = $cantidad;
            $mensaje = "Cantidad actualizada correctamente";
            $tipo_mensaje = "success";
          }
        }
        break;

      case 'eliminar':
        if (isset($_POST['producto_id'])) {
          $producto_id = intval($_POST['producto_id']);
          if (isset($_SESSION['carrito'][$producto_id])) {
            unset($_SESSION['carrito'][$producto_id]);
            $mensaje = "Producto eliminado del carrito";
            $tipo_mensaje = "success";
          }
        }
        break;

      case 'vaciar':
        $_SESSION['carrito'] = array();
        $mensaje = "Carrito vaciado completamente";
        $tipo_mensaje = "success";
        break;
    }
  }
}

// Calcular totales
$total_items = 0;
$subtotal = 0;

foreach ($_SESSION['carrito'] as $item) {
  $total_items += $item['cantidad'];
  $subtotal += $item['precio'] * $item['cantidad'];
}

$iva = $subtotal * 0.16;
$total = $subtotal + $iva;
$hay_productos = count($_SESSION['carrito']) > 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Carrito - Ejercicio 7</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      background: linear-gradient(45deg, #ff6b6b, #ee5a6f);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 3em;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .content {
      padding: 40px;
    }

    .alert {
      padding: 20px;
      margin: 20px 0;
      border-radius: 10px;
      border-left: 5px solid;
      animation: fadeIn 0.5s ease-out;
    }

    .alert-success {
      background: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .cart-items {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .cart-item {
      display: grid;
      grid-template-columns: 80px 1fr auto auto;
      gap: 20px;
      padding: 25px;
      border-bottom: 2px solid #f0f0f0;
      align-items: center;
      transition: all 0.3s ease;
    }

    .cart-item:hover {
      background: #f8f9fa;
    }

    .item-image {
      font-size: 3em;
      text-align: center;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 12px;
      padding: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .item-details {
      flex: 1;
    }

    .item-name {
      font-size: 1.4em;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }

    .item-description {
      color: #666;
      font-size: 0.9em;
      margin-bottom: 8px;
    }

    .item-category {
      display: inline-block;
      background: #e9ecef;
      color: #666;
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 0.8em;
    }

    .item-price {
      font-size: 1.3em;
      color: #667eea;
      font-weight: bold;
    }

    .item-quantity {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .item-quantity input {
      width: 60px;
      padding: 8px;
      text-align: center;
      border: 2px solid #e1e5e9;
      border-radius: 8px;
      font-size: 1.1em;
      font-weight: bold;
    }

    .item-subtotal {
      font-size: 1.5em;
      font-weight: bold;
      color: #28a745;
      text-align: right;
      min-width: 120px;
    }

    .item-actions {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .btn {
      display: inline-block;
      padding: 12px 25px;
      margin: 5px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1em;
      text-transform: uppercase;
      letter-spacing: 1px;
      border: none;
      cursor: pointer;
    }

    .btn-small {
      padding: 8px 15px;
      font-size: 0.85em;
    }

    .btn-primary {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-danger {
      background: linear-gradient(45deg, #dc3545, #c82333);
      color: white;
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
    }

    .cart-summary {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
      margin-bottom: 30px;
    }

    .cart-summary h3 {
      font-size: 1.8em;
      margin-bottom: 20px;
      text-align: center;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      font-size: 1.1em;
    }

    .summary-row:last-child {
      border-bottom: none;
      border-top: 2px solid rgba(255, 255, 255, 0.4);
      margin-top: 10px;
      padding-top: 20px;
      font-size: 1.5em;
      font-weight: bold;
    }

    .empty-cart {
      text-align: center;
      padding: 80px 30px;
      color: #666;
    }

    .empty-cart-icon {
      font-size: 5em;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .empty-cart h3 {
      margin-bottom: 15px;
      color: #333;
      font-size: 2em;
    }

    .actions {
      text-align: center;
      margin-top: 30px;
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2.2em;
      }

      .content {
        padding: 25px;
      }

      .cart-item {
        grid-template-columns: 1fr;
        gap: 15px;
      }

      .item-image {
        width: 100%;
        padding: 20px;
      }

      .item-subtotal {
        text-align: left;
      }

      .btn {
        display: block;
        width: 100%;
        margin: 10px 0;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🛒 Mi Carrito de Compras</h1>
      <p><?php echo $total_items; ?> productos - Total: $<?php echo number_format($total, 2); ?></p>
    </div>

    <div class="content">
      <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?>">
          <strong><?php echo $tipo_mensaje === 'success' ? '✅ Éxito:' : '⚠️ Advertencia:'; ?></strong>
          <?php echo htmlspecialchars($mensaje); ?>
        </div>
      <?php endif; ?>

      <?php if ($hay_productos): ?>
        <div class="cart-items">
          <?php foreach ($_SESSION['carrito'] as $producto_id => $item): ?>
            <div class="cart-item">
              <div class="item-image">
                <?php echo $item['emoji']; ?>
              </div>

              <div class="item-details">
                <div class="item-name"><?php echo htmlspecialchars($item['nombre']); ?></div>
                <div class="item-description"><?php echo htmlspecialchars($item['descripcion']); ?></div>
                <span class="item-category"><?php echo htmlspecialchars($item['categoria']); ?></span>
                <div class="item-price">$<?php echo number_format($item['precio'], 2); ?> c/u</div>

                <div class="item-actions">
                  <form method="POST" style="display: inline;">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
                    <div class="item-quantity">
                      <label>Cantidad:</label>
                      <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" max="999">
                      <button type="submit" class="btn btn-primary btn-small">Actualizar</button>
                    </div>
                  </form>

                  <form method="POST" style="display: inline;">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
                    <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('¿Eliminar este producto?')">
                      🗑️ Eliminar
                    </button>
                  </form>
                </div>
              </div>

              <div class="item-subtotal">
                $<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="cart-summary">
          <h3>📊 Resumen del Pedido</h3>

          <div class="summary-row">
            <span>Productos en el carrito:</span>
            <span><?php echo count($_SESSION['carrito']); ?></span>
          </div>

          <div class="summary-row">
            <span>Total de artículos:</span>
            <span><?php echo $total_items; ?> unidades</span>
          </div>

          <div class="summary-row">
            <span>Subtotal:</span>
            <span>$<?php echo number_format($subtotal, 2); ?></span>
          </div>

          <div class="summary-row">
            <span>IVA (16%):</span>
            <span>$<?php echo number_format($iva, 2); ?></span>
          </div>

          <div class="summary-row">
            <span>TOTAL A PAGAR:</span>
            <span>$<?php echo number_format($total, 2); ?></span>
          </div>
        </div>

        <div class="actions">
          <a href="index.php" class="btn btn-primary">
            ← Seguir Comprando
          </a>

          <button class="btn btn-success" onclick="alert('¡Función de pago no implementada en este ejercicio!')">
            💳 Proceder al Pago
          </button>

          <form method="POST" style="display: inline;">
            <input type="hidden" name="accion" value="vaciar">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Vaciar todo el carrito?')">
              🗑️ Vaciar Carrito
            </button>
          </form>

          <a href="../index.php" class="btn btn-secondary">
            🏠 Menú Principal
          </a>
        </div>

      <?php else: ?>
        <div class="empty-cart">
          <div class="empty-cart-icon">🛒</div>
          <h3>Tu carrito está vacío</h3>
          <p>No has agregado ningún producto aún.</p>
          <p>¡Explora nuestro catálogo y encuentra lo que necesitas!</p>

          <div style="margin-top: 30px;">
            <a href="index.php" class="btn btn-primary">
              🛍️ Ir a la Tienda
            </a>
            <a href="../index.php" class="btn btn-secondary">
              🏠 Menú Principal
            </a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>