<?php

declare(strict_types=1);

require_once 'database.php';

$database = new Database();
$mensaje = '';
$error = '';
$ciudades = [];

// Procesar eliminación si se confirmó
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_eliminar'])) {
  try {
    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
      throw new Exception('ID de ciudad inválido');
    }

    $conn = $database->getConnection();

    // Obtener nombre de la ciudad antes de eliminar
    $stmt = $conn->prepare("SELECT ciudad, pais FROM ciudades WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ciudad_data = $result->fetch_assoc();
    $stmt->close();

    if (!$ciudad_data) {
      throw new Exception('Ciudad no encontrada');
    }

    // Eliminar ciudad
    $stmt = $conn->prepare("DELETE FROM ciudades WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      $mensaje = "Ciudad '{$ciudad_data['ciudad']}, {$ciudad_data['pais']}' eliminada exitosamente";
    } else {
      throw new Exception('Error al eliminar la ciudad');
    }
    $stmt->close();
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
}

// Obtener todas las ciudades para mostrar
try {
  $conn = $database->getConnection();
  $query = "SELECT id, ciudad, pais, habitantes, superficie, tieneMetro FROM ciudades ORDER BY ciudad ASC";
  $result = $conn->query($query);

  if ($result) {
    while ($fila = $result->fetch_assoc()) {
      $ciudades[] = $fila;
    }
    $result->free();
  }
} catch (Exception $e) {
  $error = 'Error al cargar las ciudades: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Baja de Ciudad - ABML Ciudades</title>
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
      max-width: 1000px;
      margin: 0 auto;
      background: white;
      border-radius: 15px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      padding: 40px;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      color: #333;
      font-size: 2rem;
      margin-bottom: 10px;
    }

    .back-link {
      display: inline-block;
      background: #6c757d;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 0.9rem;
      transition: background 0.3s;
    }

    .back-link:hover {
      background: #545b62;
    }

    .alert {
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-weight: 500;
    }

    .alert-success {
      background-color: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724;
    }

    .alert-error {
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
    }

    .cities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .city-card {
      background: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 10px;
      padding: 20px;
      transition: all 0.3s;
    }

    .city-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .city-name {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .city-info {
      color: #666;
      margin-bottom: 5px;
      font-size: 0.9rem;
    }

    .metro-badge {
      display: inline-block;
      background: #28a745;
      color: white;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      margin-top: 8px;
    }

    .no-metro-badge {
      display: inline-block;
      background: #6c757d;
      color: white;
      padding: 3px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      margin-top: 8px;
    }

    .delete-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      margin-top: 15px;
      transition: background 0.3s;
    }

    .delete-btn:hover {
      background: #c82333;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: white;
      margin: 15% auto;
      padding: 30px;
      border-radius: 10px;
      width: 90%;
      max-width: 400px;
      text-align: center;
    }

    .modal h3 {
      color: #dc3545;
      margin-bottom: 15px;
    }

    .modal-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 20px;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: all 0.3s;
    }

    .btn-danger {
      background: #dc3545;
      color: white;
    }

    .btn-danger:hover {
      background: #c82333;
    }

    .btn-secondary {
      background: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background: #545b62;
    }

    .no-cities {
      text-align: center;
      color: #666;
      font-style: italic;
      margin-top: 40px;
    }

    @media (max-width: 768px) {
      .container {
        margin: 10px;
        padding: 20px;
      }

      .cities-grid {
        grid-template-columns: 1fr;
      }

      .modal-content {
        margin: 30% auto;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🗑️ Baja de Ciudad</h1>
      <a href="index.php" class="back-link">← Volver al Menú</a>
    </div>

    <?php if ($mensaje): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (empty($ciudades)): ?>
      <div class="no-cities">
        <h3>No hay ciudades registradas</h3>
        <p>Puede agregar ciudades usando la opción "Alta" del menú principal.</p>
      </div>
    <?php else: ?>
      <div class="cities-grid">
        <?php foreach ($ciudades as $ciudad): ?>
          <div class="city-card">
            <div class="city-name">
              <?php echo htmlspecialchars($ciudad['ciudad']); ?>
            </div>
            <div class="city-info">
              🏠 País: <?php echo htmlspecialchars($ciudad['pais']); ?>
            </div>
            <div class="city-info">
              👥 Habitantes: <?php echo number_format((int)$ciudad['habitantes']); ?>
            </div>
            <div class="city-info">
              📏 Superficie: <?php echo number_format((float)$ciudad['superficie'], 2); ?> km²
            </div>
            <?php if ($ciudad['tieneMetro']): ?>
              <span class="metro-badge">🚇 Tiene Metro</span>
            <?php else: ?>
              <span class="no-metro-badge">🚌 Sin Metro</span>
            <?php endif; ?>

            <br>
            <button class="delete-btn"
              onclick="confirmarEliminacion(<?php echo $ciudad['id']; ?>, '<?php echo htmlspecialchars($ciudad['ciudad'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($ciudad['pais'], ENT_QUOTES); ?>')">
              Eliminar Ciudad
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Modal de confirmación -->
  <div id="confirmModal" class="modal">
    <div class="modal-content">
      <h3>⚠️ Confirmar Eliminación</h3>
      <p id="confirmMessage">¿Está seguro que desea eliminar esta ciudad?</p>
      <div class="modal-buttons">
        <form id="deleteForm" method="POST" style="display: inline;">
          <input type="hidden" id="cityId" name="id" value="">
          <input type="hidden" name="confirmar_eliminar" value="1">
          <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
        </form>
        <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
      </div>
    </div>
  </div>

  <script>
    function confirmarEliminacion(id, ciudad, pais) {
      document.getElementById('cityId').value = id;
      document.getElementById('confirmMessage').innerHTML =
        `¿Está seguro que desea eliminar la ciudad:<br><strong>${ciudad}, ${pais}</strong>?<br><br>Esta acción no se puede deshacer.`;
      document.getElementById('confirmModal').style.display = 'block';
    }

    function cerrarModal() {
      document.getElementById('confirmModal').style.display = 'none';
    }

    // Cerrar modal al hacer clic fuera de él
    window.onclick = function(event) {
      const modal = document.getElementById('confirmModal');
      if (event.target === modal) {
        cerrarModal();
      }
    }
  </script>
</body>

</html>