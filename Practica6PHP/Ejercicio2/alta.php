<?php

declare(strict_types=1);

require_once 'database.php';

$database = new Database();
$mensaje = '';
$error = '';

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $ciudad = trim($_POST['ciudad'] ?? '');
    $pais = trim($_POST['pais'] ?? '');
    $habitantes = (int)($_POST['habitantes'] ?? 0);
    $superficie = (float)($_POST['superficie'] ?? 0);
    $tieneMetro = isset($_POST['tieneMetro']) ? 1 : 0;

    // Validaciones
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

    // Verificar si la ciudad ya existe
    $stmt = $conn->prepare("SELECT id FROM ciudades WHERE ciudad = ? AND pais = ?");
    $stmt->bind_param("ss", $ciudad, $pais);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      throw new Exception('La ciudad ya existe en ese país');
    }
    $stmt->close();

    // Insertar nueva ciudad
    $stmt = $conn->prepare("INSERT INTO ciudades (ciudad, pais, habitantes, superficie, tieneMetro) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidi", $ciudad, $pais, $habitantes, $superficie, $tieneMetro);

    if ($stmt->execute()) {
      $mensaje = "Ciudad '{$ciudad}' agregada exitosamente";
      // Limpiar formulario
      $_POST = [];
    } else {
      throw new Exception('Error al insertar la ciudad');
    }
    $stmt->close();
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alta de Ciudad - ABML Ciudades</title>
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
      max-width: 600px;
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

    @media (max-width: 768px) {
      .container {
        margin: 10px;
        padding: 20px;
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
      <h1>➕ Alta de Ciudad</h1>
      <a href="index.php" class="back-link">← Volver al Menú</a>
    </div>

    <?php if ($mensaje): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="ciudad">Nombre de la Ciudad *</label>
        <input type="text" id="ciudad" name="ciudad" required
          value="<?php echo htmlspecialchars($_POST['ciudad'] ?? ''); ?>"
          placeholder="Ej: Buenos Aires">
      </div>

      <div class="form-group">
        <label for="pais">País *</label>
        <input type="text" id="pais" name="pais" required
          value="<?php echo htmlspecialchars($_POST['pais'] ?? ''); ?>"
          placeholder="Ej: Argentina">
      </div>

      <div class="form-group">
        <label for="habitantes">Número de Habitantes *</label>
        <input type="number" id="habitantes" name="habitantes" required min="1"
          value="<?php echo htmlspecialchars($_POST['habitantes'] ?? ''); ?>"
          placeholder="Ej: 1500000">
      </div>

      <div class="form-group">
        <label for="superficie">Superficie (km²) *</label>
        <input type="number" id="superficie" name="superficie" required min="0.01" step="0.01"
          value="<?php echo htmlspecialchars($_POST['superficie'] ?? ''); ?>"
          placeholder="Ej: 203.00">
      </div>

      <div class="form-group">
        <div class="checkbox-group">
          <input type="checkbox" id="tieneMetro" name="tieneMetro" value="1"
            <?php echo (isset($_POST['tieneMetro']) && $_POST['tieneMetro']) ? 'checked' : ''; ?>>
          <label for="tieneMetro">¿Tiene Metro/Subte?</label>
        </div>
      </div>

      <div class="btn-container">
        <button type="submit" class="btn btn-primary">Agregar Ciudad</button>
        <button type="reset" class="btn btn-secondary">Limpiar Formulario</button>
      </div>
    </form>
  </div>
</body>

</html>