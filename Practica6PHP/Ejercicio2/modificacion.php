<?php

declare(strict_types=1);

require_once 'database.php';

$database = new Database();
$mensaje = '';
$error = '';
$ciudades = [];
$ciudad_actual = null;

// Procesar actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
  try {
    $id = (int)($_POST['id'] ?? 0);
    $ciudad = trim($_POST['ciudad'] ?? '');
    $pais = trim($_POST['pais'] ?? '');
    $habitantes = (int)($_POST['habitantes'] ?? 0);
    $superficie = (float)($_POST['superficie'] ?? 0);
    $tieneMetro = isset($_POST['tieneMetro']) ? 1 : 0;

    // Validaciones
    if ($id <= 0) {
      throw new Exception('ID de ciudad inválido');
    }
    if (empty($ciudad)) {
      throw new Exception('El nombre de la ciudad es obligatorio');
    }
    if (empty($pais)) {
      throw new Exception('El nombre del país es obligatorio');
    }
    if ($habitantes <= 0) {
      throw new Exception('El número de habitantes debe ser mayor a 0');
    }
    if ($superficie <= 0) {
      throw new Exception('La superficie debe ser mayor a 0');
    }

    $conn = $database->getConnection();

    // Verificar si existe otra ciudad con el mismo nombre y país (excluyendo la actual)
    $stmt = $conn->prepare("SELECT id FROM ciudades WHERE ciudad = ? AND pais = ? AND id != ?");
    $stmt->bind_param("ssi", $ciudad, $pais, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      throw new Exception('Ya existe otra ciudad con ese nombre en ese país');
    }
    $stmt->close();

    // Actualizar ciudad
    $stmt = $conn->prepare("UPDATE ciudades SET ciudad = ?, pais = ?, habitantes = ?, superficie = ?, tieneMetro = ? WHERE id = ?");
    $stmt->bind_param("ssidii", $ciudad, $pais, $habitantes, $superficie, $tieneMetro, $id);

    if ($stmt->execute()) {
      $mensaje = "Ciudad actualizada exitosamente";
    } else {
      throw new Exception('Error al actualizar la ciudad');
    }
    $stmt->close();
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
}

// Cargar ciudad para editar si se seleccionó
if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  try {
    $conn = $database->getConnection();
    $stmt = $conn->prepare("SELECT * FROM ciudades WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ciudad_actual = $result->fetch_assoc();
    $stmt->close();

    if (!$ciudad_actual) {
      $error = 'Ciudad no encontrada';
    }
  } catch (Exception $e) {
    $error = 'Error al cargar la ciudad: ' . $e->getMessage();
  }
}

// Obtener todas las ciudades para el selector
try {
  $conn = $database->getConnection();
  $query = "SELECT id, ciudad, pais FROM ciudades ORDER BY ciudad ASC";
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
  <title>Modificación de Ciudad - ABML Ciudades</title>
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
      max-width: 800px;
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

    .selector-section {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
    }

    .selector-section h3 {
      color: #333;
      margin-bottom: 15px;
    }

    .city-selector {
      display: flex;
      gap: 15px;
      align-items: flex-end;
      flex-wrap: wrap;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #333;
      font-weight: 500;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 12px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #667eea;
    }

    .checkbox-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .checkbox-group input[type="checkbox"] {
      width: auto;
      margin: 0;
    }

    .btn-container {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
    }

    .btn {
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s;
      display: inline-block;
      text-align: center;
    }

    .btn-primary {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary {
      background: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background: #545b62;
    }

    .btn-warning {
      background: #ffc107;
      color: #212529;
    }

    .btn-warning:hover {
      background: #e0a800;
    }

    .edit-form {
      display: none;
      margin-top: 30px;
      padding-top: 30px;
      border-top: 2px solid #e9ecef;
    }

    .edit-form.active {
      display: block;
    }

    @media (max-width: 768px) {
      .container {
        margin: 10px;
        padding: 20px;
      }

      .city-selector {
        flex-direction: column;
      }

      .btn-container {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>✏️ Modificación de Ciudad</h1>
      <a href="index.php" class="back-link">← Volver al Menú</a>
    </div>

    <?php if ($mensaje): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (empty($ciudades)): ?>
      <div class="alert alert-error">
        No hay ciudades registradas. Puede agregar ciudades usando la opción "Alta" del menú principal.
      </div>
    <?php else: ?>
      <!-- Selector de ciudad -->
      <div class="selector-section">
        <h3>Seleccionar Ciudad para Modificar</h3>
        <div class="city-selector">
          <div class="form-group" style="flex: 1; min-width: 250px;">
            <label for="citySelect">Elegir Ciudad:</label>
            <select id="citySelect" onchange="seleccionarCiudad()">
              <option value="">-- Seleccione una ciudad --</option>
              <?php foreach ($ciudades as $ciudad): ?>
                <option value="<?php echo $ciudad['id']; ?>"
                  <?php echo ($ciudad_actual && $ciudad['id'] == $ciudad_actual['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($ciudad['ciudad'] . ', ' . $ciudad['pais']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <!-- Formulario de edición -->
      <div id="editForm" class="edit-form <?php echo $ciudad_actual ? 'active' : ''; ?>">
        <h3 style="color: #333; margin-bottom: 20px; text-align: center;">
          Editando Ciudad
        </h3>

        <form method="POST" action="">
          <input type="hidden" name="id" value="<?php echo $ciudad_actual['id'] ?? ''; ?>">

          <div class="form-group">
            <label for="ciudad">Nombre de la Ciudad *</label>
            <input type="text" id="ciudad" name="ciudad" required
              value="<?php echo htmlspecialchars($ciudad_actual['ciudad'] ?? ''); ?>"
              placeholder="Ej: Buenos Aires">
          </div>

          <div class="form-group">
            <label for="pais">País *</label>
            <input type="text" id="pais" name="pais" required
              value="<?php echo htmlspecialchars($ciudad_actual['pais'] ?? ''); ?>"
              placeholder="Ej: Argentina">
          </div>

          <div class="form-group">
            <label for="habitantes">Número de Habitantes *</label>
            <input type="number" id="habitantes" name="habitantes" required min="1"
              value="<?php echo $ciudad_actual['habitantes'] ?? ''; ?>"
              placeholder="Ej: 1500000">
          </div>

          <div class="form-group">
            <label for="superficie">Superficie (km²) *</label>
            <input type="number" id="superficie" name="superficie" required min="0.01" step="0.01"
              value="<?php echo $ciudad_actual['superficie'] ?? ''; ?>"
              placeholder="Ej: 203.00">
          </div>

          <div class="form-group">
            <div class="checkbox-group">
              <input type="checkbox" id="tieneMetro" name="tieneMetro" value="1"
                <?php echo ($ciudad_actual && $ciudad_actual['tieneMetro']) ? 'checked' : ''; ?>>
              <label for="tieneMetro">¿Tiene Metro/Subte?</label>
            </div>
          </div>

          <div class="btn-container">
            <button type="submit" name="actualizar" class="btn btn-primary">
              Actualizar Ciudad
            </button>
            <button type="button" class="btn btn-secondary" onclick="cancelarEdicion()">
              Cancelar
            </button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>

  <script>
    function seleccionarCiudad() {
      const select = document.getElementById('citySelect');
      const selectedId = select.value;

      if (selectedId) {
        window.location.href = `modificacion.php?id=${selectedId}`;
      } else {
        document.getElementById('editForm').classList.remove('active');
      }
    }

    function cancelarEdicion() {
      document.getElementById('citySelect').value = '';
      document.getElementById('editForm').classList.remove('active');
      window.location.href = 'modificacion.php';
    }
  </script>
</body>

</html>