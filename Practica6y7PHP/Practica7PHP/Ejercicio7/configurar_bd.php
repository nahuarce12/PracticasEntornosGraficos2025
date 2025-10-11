<?php
// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "Compras";

$mensaje = "";
$tipo_mensaje = "";

// Función para crear la base de datos y tabla
function crearBaseDatos()
{
  global $servidor, $usuario_db, $password_db, $nombre_db, $mensaje, $tipo_mensaje;

  try {
    // Conectar sin especificar base de datos
    $conexion = new PDO("mysql:host=$servidor", $usuario_db, $password_db);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la base de datos si no existe
    $sql_crear_bd = "CREATE DATABASE IF NOT EXISTS $nombre_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conexion->exec($sql_crear_bd);

    // Usar la base de datos
    $conexion->exec("USE $nombre_db");

    // Crear la tabla catalogo
    $sql_crear_tabla = "
        CREATE TABLE IF NOT EXISTS catalogo (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(200) NOT NULL,
            descripcion TEXT,
            precio DECIMAL(10, 2) NOT NULL,
            stock INT NOT NULL DEFAULT 0,
            categoria VARCHAR(100),
            emoji VARCHAR(10),
            imagen_url VARCHAR(255),
            fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            fecha_actualizado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            activo BOOLEAN DEFAULT TRUE,
            INDEX idx_categoria (categoria),
            INDEX idx_precio (precio)
        ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ";

    $conexion->exec($sql_crear_tabla);

    // Insertar productos de ejemplo
    $sql_insertar = "
        INSERT IGNORE INTO catalogo (id, nombre, descripcion, precio, stock, categoria, emoji) VALUES
        (1, 'Laptop HP Pavilion', 'Laptop HP Pavilion 15 con procesador Intel Core i5, 8GB RAM, 256GB SSD', 899.99, 15, 'Electrónica', '💻'),
        (2, 'Mouse Logitech MX Master', 'Mouse ergonómico inalámbrico con sensor de alta precisión', 99.99, 45, 'Accesorios', '🖱️'),
        (3, 'Teclado Mecánico RGB', 'Teclado mecánico gaming con switches blue y retroiluminación RGB', 129.99, 30, 'Accesorios', '⌨️'),
        (4, 'Monitor Samsung 27\"', 'Monitor curvo Samsung 27 pulgadas Full HD 144Hz', 299.99, 20, 'Electrónica', '🖥️'),
        (5, 'Auriculares Sony WH-1000XM4', 'Auriculares inalámbricos con cancelación de ruido activa', 349.99, 25, 'Audio', '🎧'),
        (6, 'Webcam Logitech C920', 'Webcam Full HD 1080p con micrófono integrado', 79.99, 40, 'Accesorios', '📹'),
        (7, 'SSD Samsung 1TB', 'Unidad de estado sólido NVMe M.2 de 1TB con velocidades de 3500MB/s', 119.99, 50, 'Almacenamiento', '💾'),
        (8, 'Router WiFi 6 TP-Link', 'Router inalámbrico AX3000 con WiFi 6 y 4 antenas', 149.99, 35, 'Redes', '📡'),
        (9, 'Tablet Samsung Galaxy Tab', 'Tablet Android 10.5 pulgadas con S Pen incluido', 449.99, 18, 'Tablets', '📱'),
        (10, 'Impresora HP LaserJet', 'Impresora láser monocromática con WiFi y dúplex automático', 199.99, 12, 'Oficina', '🖨️'),
        (11, 'Disco Duro Externo 2TB', 'Disco duro portátil USB 3.0 de 2TB con protección contra caídas', 89.99, 60, 'Almacenamiento', '💿'),
        (12, 'Hub USB-C 7 en 1', 'Adaptador multipuerto con HDMI, USB 3.0, lector SD y carga PD', 49.99, 75, 'Accesorios', '🔌'),
        (13, 'Micrófono Blue Yeti', 'Micrófono USB profesional con patrón cardioide y omnidireccional', 129.99, 28, 'Audio', '🎙️'),
        (14, 'Cable HDMI 2.1', 'Cable HDMI 2 metros compatible con 4K 120Hz y 8K 60Hz', 19.99, 100, 'Cables', '🔗'),
        (15, 'Silla Gaming Ergonómica', 'Silla gamer con soporte lumbar, reposabrazos 4D y reclinable', 299.99, 10, 'Muebles', '🪑'),
        (16, 'Lámpara LED Escritorio', 'Lámpara LED regulable con carga inalámbrica y puerto USB', 39.99, 55, 'Iluminación', '💡'),
        (17, 'Mousepad XXL', 'Alfombrilla de ratón extra grande 900x400mm con base antideslizante', 24.99, 80, 'Accesorios', '🎯'),
        (18, 'Soporte para Laptop', 'Soporte ajustable de aluminio para laptop con ventilación', 34.99, 45, 'Accesorios', '📐'),
        (19, 'PowerBank 20000mAh', 'Batería externa con carga rápida PD y 3 puertos USB', 49.99, 65, 'Accesorios', '🔋'),
        (20, 'Cámara Web 4K', 'Cámara web 4K con autoenfoque y corrección de luz', 149.99, 22, 'Video', '📷')
        ";

    $conexion->exec($sql_insertar);

    $mensaje = "¡Base de datos configurada correctamente! Se creó la base de datos 'Compras', la tabla 'catalogo' y se insertaron 20 productos de ejemplo.";
    $tipo_mensaje = "success";
  } catch (PDOException $e) {
    $mensaje = "Error al configurar la base de datos: " . $e->getMessage();
    $tipo_mensaje = "error";
  }
}

// Función para verificar la conexión
function verificarConexion()
{
  global $servidor, $usuario_db, $password_db, $nombre_db, $mensaje, $tipo_mensaje;

  try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_db", $usuario_db, $password_db);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Contar registros
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM catalogo");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $mensaje = "Conexión exitosa a la base de datos 'Compras'. La tabla 'catalogo' contiene " . $resultado['total'] . " productos.";
    $tipo_mensaje = "success";

    return $conexion;
  } catch (PDOException $e) {
    $mensaje = "Error de conexión: " . $e->getMessage();
    $tipo_mensaje = "error";
    return false;
  }
}

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
      case 'crear':
        crearBaseDatos();
        break;
      case 'verificar':
        verificarConexion();
        break;
    }
  }
}

// Obtener lista de productos si hay conexión
$productos = [];
$total_valor_inventario = 0;
if ($conexion = verificarConexion()) {
  try {
    $stmt = $conexion->query("SELECT * FROM catalogo ORDER BY categoria, nombre");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular valor total del inventario
    foreach ($productos as $producto) {
      $total_valor_inventario += $producto['precio'] * $producto['stock'];
    }
  } catch (PDOException $e) {
    // Error silencioso
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración Base de Datos - Ejercicio 7</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .header {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.5em;
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
      animation: slideIn 0.5s ease-out;
    }

    .alert-success {
      background: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    .alert-error {
      background: #f8d7da;
      border-color: #dc3545;
      color: #721c24;
    }

    .alert-info {
      background: #cce7ff;
      border-color: #667eea;
      color: #0c5460;
    }

    .config-section {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      border-left: 5px solid #667eea;
    }

    .config-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin: 20px 0;
    }

    .config-item {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }

    .config-label {
      font-weight: bold;
      color: #667eea;
      margin-bottom: 5px;
      font-size: 0.9em;
      text-transform: uppercase;
    }

    .config-value {
      color: #333;
      font-family: monospace;
      background: #e9ecef;
      padding: 8px 12px;
      border-radius: 6px;
    }

    .btn {
      display: inline-block;
      padding: 15px 30px;
      margin: 10px 5px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1em;
      text-transform: uppercase;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .sql-code {
      background: #2d3748;
      color: #e2e8f0;
      padding: 20px;
      border-radius: 10px;
      font-family: 'Courier New', monospace;
      font-size: 0.9em;
      overflow-x: auto;
      margin: 15px 0;
      white-space: pre-wrap;
    }

    .products-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .products-table th,
    .products-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .products-table th {
      background: #667eea;
      color: white;
      font-weight: bold;
    }

    .products-table tr:hover {
      background: #f8f9fa;
    }

    .actions {
      text-align: center;
      margin-top: 30px;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2em;
      }

      .content {
        padding: 25px;
      }

      .config-grid {
        grid-template-columns: 1fr;
      }

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin: 20px 0;
    }

    .stat-card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
      font-size: 2.5em;
      font-weight: bold;
      color: #667eea;
      margin-bottom: 10px;
    }

    .stat-label {
      color: #666;
      font-size: 0.95em;
      text-transform: uppercase;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🛠️ Configuración de Base de Datos</h1>
      <p>Sistema de Carrito de Compras - Ejercicio 7</p>
    </div>

    <div class="content">
      <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje === 'success' ? 'success' : 'error'; ?>">
          <strong><?php echo $tipo_mensaje === 'success' ? '✅ Éxito:' : '❌ Error:'; ?></strong>
          <?php echo htmlspecialchars($mensaje); ?>
        </div>
      <?php endif; ?>

      <div class="config-section">
        <h3>📊 Configuración Actual</h3>

        <div class="config-grid">
          <div class="config-item">
            <div class="config-label">Servidor</div>
            <div class="config-value"><?php echo htmlspecialchars($servidor); ?></div>
          </div>

          <div class="config-item">
            <div class="config-label">Usuario</div>
            <div class="config-value"><?php echo htmlspecialchars($usuario_db); ?></div>
          </div>

          <div class="config-item">
            <div class="config-label">Base de Datos</div>
            <div class="config-value"><?php echo htmlspecialchars($nombre_db); ?></div>
          </div>

          <div class="config-item">
            <div class="config-label">Tabla Principal</div>
            <div class="config-value">catalogo</div>
          </div>
        </div>

        <div class="alert alert-info">
          <strong>💡 Información:</strong>
          Esta configuración utiliza los valores predeterminados de XAMPP.
        </div>
      </div>

      <div class="config-section">
        <h3>🔧 Acciones de Configuración</h3>

        <form method="POST" style="display: inline;">
          <input type="hidden" name="accion" value="crear">
          <button type="submit" class="btn btn-primary">
            🚀 Crear Base de Datos y Productos
          </button>
        </form>

        <form method="POST" style="display: inline;">
          <input type="hidden" name="accion" value="verificar">
          <button type="submit" class="btn btn-success">
            ✅ Verificar Conexión
          </button>
        </form>
      </div>

      <?php if (!empty($productos)): ?>
        <div class="config-section">
          <h3>📊 Estadísticas del Inventario</h3>

          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-number"><?php echo count($productos); ?></div>
              <div class="stat-label">Productos</div>
            </div>

            <div class="stat-card">
              <div class="stat-number">$<?php echo number_format($total_valor_inventario, 2); ?></div>
              <div class="stat-label">Valor Total</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php
                                        $categorias = array_unique(array_column($productos, 'categoria'));
                                        echo count($categorias);
                                        ?></div>
              <div class="stat-label">Categorías</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php
                                        $total_stock = array_sum(array_column($productos, 'stock'));
                                        echo $total_stock;
                                        ?></div>
              <div class="stat-label">Unidades en Stock</div>
            </div>
          </div>
        </div>

        <div class="config-section">
          <h3>📦 Catálogo de Productos (<?php echo count($productos); ?> productos)</h3>

          <div style="overflow-x: auto;">
            <table class="products-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Emoji</th>
                  <th>Nombre</th>
                  <th>Categoría</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Valor</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($productos as $producto): ?>
                  <tr>
                    <td><strong><?php echo $producto['id']; ?></strong></td>
                    <td style="font-size: 1.5em;"><?php echo $producto['emoji']; ?></td>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                    <td><strong>$<?php echo number_format($producto['precio'], 2); ?></strong></td>
                    <td><?php echo $producto['stock']; ?> unidades</td>
                    <td>$<?php echo number_format($producto['precio'] * $producto['stock'], 2); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>

      <div class="config-section">
        <h3>📝 Script SQL Utilizado</h3>

        <div class="sql-code">CREATE TABLE catalogo (
          id INT AUTO_INCREMENT PRIMARY KEY,
          nombre VARCHAR(200) NOT NULL,
          descripcion TEXT,
          precio DECIMAL(10, 2) NOT NULL,
          stock INT NOT NULL DEFAULT 0,
          categoria VARCHAR(100),
          emoji VARCHAR(10),
          imagen_url VARCHAR(255),
          fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          fecha_actualizado TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          activo BOOLEAN DEFAULT TRUE,
          INDEX idx_categoria (categoria),
          INDEX idx_precio (precio)
          ) ENGINE=InnoDB;</div>
      </div>

      <div class="actions">
        <a href="index.php" class="btn btn-primary">
          🛒 Ir a la Tienda
        </a>
        <a href="productos.php" class="btn btn-success">
          📦 Ver Productos
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>
</body>

</html>