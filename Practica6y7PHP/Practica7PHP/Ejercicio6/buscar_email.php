<?php
session_start();

// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "base2";

$mensaje = "";
$tipo_mensaje = "";
$estudiante_encontrado = null;

// Inicializar historial de búsquedas si no existe
if (!isset($_SESSION['historial_busquedas'])) {
  $_SESSION['historial_busquedas'] = array();
}

// Función para conectar a la base de datos
function conectarBaseDatos()
{
  global $servidor, $usuario_db, $password_db, $nombre_db;

  try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_db;charset=utf8mb4", $usuario_db, $password_db);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conexion;
  } catch (PDOException $e) {
    return false;
  }
}

// Función para buscar estudiante por matrícula
function buscarEstudiante($matricula)
{
  global $mensaje, $tipo_mensaje, $estudiante_encontrado;

  $conexion = conectarBaseDatos();

  if (!$conexion) {
    $mensaje = "Error: No se pudo conectar a la base de datos. Asegúrate de que XAMPP esté ejecutándose y la base de datos 'base2' esté creada.";
    $tipo_mensaje = "error";
    return false;
  }

  try {
    $stmt = $conexion->prepare("SELECT * FROM alumnos WHERE matricula = :matricula");
    $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
      $estudiante_encontrado = $resultado;
      $mensaje = "¡Estudiante encontrado exitosamente!";
      $tipo_mensaje = "success";

      // Agregar al historial de sesión
      $_SESSION['historial_busquedas'][] = array(
        'matricula' => $matricula,
        'nombre_completo' => $resultado['nombre'] . ' ' . $resultado['apellidos'],
        'email' => $resultado['email'],
        'fecha_busqueda' => date('Y-m-d H:i:s'),
        'encontrado' => true
      );

      return true;
    } else {
      $mensaje = "No se encontró ningún estudiante con la matrícula: " . htmlspecialchars($matricula);
      $tipo_mensaje = "warning";

      // Agregar búsqueda sin resultado al historial
      $_SESSION['historial_busquedas'][] = array(
        'matricula' => $matricula,
        'nombre_completo' => 'No encontrado',
        'email' => 'N/A',
        'fecha_busqueda' => date('Y-m-d H:i:s'),
        'encontrado' => false
      );

      return false;
    }
  } catch (PDOException $e) {
    $mensaje = "Error en la consulta: " . $e->getMessage();
    $tipo_mensaje = "error";
    return false;
  }
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricula'])) {
  $matricula = trim($_POST['matricula']);

  // Validar matrícula
  if (empty($matricula)) {
    $mensaje = "Por favor, ingresa un número de matrícula.";
    $tipo_mensaje = "warning";
  } elseif (!preg_match('/^[0-9]+$/', $matricula)) {
    $mensaje = "La matrícula debe contener solo números.";
    $tipo_mensaje = "warning";
  } elseif (strlen($matricula) < 4) {
    $mensaje = "La matrícula debe tener al menos 4 dígitos.";
    $tipo_mensaje = "warning";
  } else {
    buscarEstudiante($matricula);
  }
}

// Obtener estadísticas del historial
$total_busquedas = count($_SESSION['historial_busquedas']);
$busquedas_exitosas = 0;
foreach ($_SESSION['historial_busquedas'] as $busqueda) {
  if ($busqueda['encontrado']) {
    $busquedas_exitosas++;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Búsqueda de Email - Ejercicio 6</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
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
      background: linear-gradient(45deg, #4facfe, #00f2fe);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.8em;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.9;
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

    .alert-error {
      background: #f8d7da;
      border-color: #dc3545;
      color: #721c24;
    }

    .alert-warning {
      background: #fff3cd;
      border-color: #ffc107;
      color: #856404;
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

    .search-form {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
      font-size: 1.1em;
    }

    .form-group input {
      width: 100%;
      padding: 15px;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      font-size: 1.1em;
      transition: all 0.3s ease;
      background: white;
    }

    .form-group input:focus {
      outline: none;
      border-color: #4facfe;
      box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
      transform: translateY(-2px);
    }

    .student-card {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 30px;
      border-radius: 15px;
      margin: 30px 0;
      box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .student-card h3 {
      font-size: 1.8em;
      margin-bottom: 20px;
      text-align: center;
    }

    .student-details {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .detail-item {
      background: rgba(255, 255, 255, 0.2);
      padding: 15px;
      border-radius: 10px;
      backdrop-filter: blur(10px);
    }

    .detail-label {
      font-weight: bold;
      margin-bottom: 5px;
      font-size: 0.9em;
      text-transform: uppercase;
      letter-spacing: 1px;
      opacity: 0.9;
    }

    .detail-value {
      font-size: 1.1em;
      word-break: break-word;
    }

    .email-highlight {
      background: rgba(255, 255, 255, 0.3);
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      margin-top: 20px;
      border: 2px dashed rgba(255, 255, 255, 0.5);
    }

    .email-highlight .email {
      font-size: 1.4em;
      font-weight: bold;
      font-family: monospace;
      background: rgba(255, 255, 255, 0.2);
      padding: 10px 15px;
      border-radius: 8px;
      display: inline-block;
      margin-top: 10px;
    }

    .stats-section {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border-left: 5px solid #4facfe;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 15px;
    }

    .stat-item {
      background: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
      font-size: 2em;
      font-weight: bold;
      color: #4facfe;
      margin-bottom: 5px;
    }

    .stat-label {
      color: #666;
      font-size: 0.9em;
      text-transform: uppercase;
      letter-spacing: 1px;
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
      letter-spacing: 1px;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(45deg, #4facfe, #00f2fe);
      color: white;
      box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
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

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }

      .student-details,
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🔍 Resultado de Búsqueda</h1>
      <p>Sistema de Consulta de Emails Estudiantiles</p>
    </div>

    <div class="content">
      <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?>">
          <strong>
            <?php
            switch ($tipo_mensaje) {
              case 'success':
                echo '✅ Éxito:';
                break;
              case 'error':
                echo '❌ Error:';
                break;
              case 'warning':
                echo '⚠️ Advertencia:';
                break;
              default:
                echo 'ℹ️ Información:';
            }
            ?>
          </strong>
          <?php echo $mensaje; ?>
        </div>
      <?php endif; ?>

      <!-- Formulario de búsqueda -->
      <form method="POST" class="search-form">
        <h3 style="margin-bottom: 20px; color: #333; text-align: center;">🔍 Nueva Búsqueda</h3>

        <div class="form-group">
          <label for="matricula">📝 Número de Matrícula del Estudiante:</label>
          <input
            type="text"
            id="matricula"
            name="matricula"
            placeholder="Ejemplo: 2021001, 2022003, etc."
            value="<?php echo isset($_POST['matricula']) ? htmlspecialchars($_POST['matricula']) : ''; ?>"
            required
            pattern="[0-9]+"
            title="Solo se permiten números"
            maxlength="10">
        </div>

        <div style="text-align: center;">
          <button type="submit" class="btn btn-primary">
            🔍 Buscar Email
          </button>
          <button type="reset" class="btn btn-secondary">
            🔄 Limpiar
          </button>
        </div>
      </form>

      <!-- Mostrar información del estudiante si se encontró -->
      <?php if ($estudiante_encontrado): ?>
        <div class="student-card">
          <h3>👨‍🎓 Información del Estudiante Encontrado</h3>

          <div class="student-details">
            <div class="detail-item">
              <div class="detail-label">📋 Matrícula</div>
              <div class="detail-value"><?php echo htmlspecialchars($estudiante_encontrado['matricula']); ?></div>
            </div>

            <div class="detail-item">
              <div class="detail-label">👤 Nombre</div>
              <div class="detail-value"><?php echo htmlspecialchars($estudiante_encontrado['nombre']); ?></div>
            </div>

            <div class="detail-item">
              <div class="detail-label">👥 Apellidos</div>
              <div class="detail-value"><?php echo htmlspecialchars($estudiante_encontrado['apellidos']); ?></div>
            </div>

            <div class="detail-item">
              <div class="detail-label">🎓 Carrera</div>
              <div class="detail-value"><?php echo htmlspecialchars($estudiante_encontrado['carrera']); ?></div>
            </div>

            <div class="detail-item">
              <div class="detail-label">📚 Semestre</div>
              <div class="detail-value"><?php echo htmlspecialchars($estudiante_encontrado['semestre']) . '°'; ?></div>
            </div>

            <div class="detail-item">
              <div class="detail-label">📅 Fecha de Registro</div>
              <div class="detail-value"><?php echo date('d/m/Y H:i', strtotime($estudiante_encontrado['fecha_registro'])); ?></div>
            </div>
          </div>

          <div class="email-highlight">
            <div class="detail-label">📧 EMAIL DEL ESTUDIANTE</div>
            <div class="email"><?php echo htmlspecialchars($estudiante_encontrado['email']); ?></div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Estadísticas de la sesión -->
      <div class="stats-section">
        <h3 style="color: #0c5460; margin-bottom: 15px;">📊 Estadísticas de tu Sesión</h3>
        <p style="color: #0c5460; margin-bottom: 15px;">
          Estas estadísticas se mantienen durante tu sesión actual y se almacenan usando $_SESSION de PHP.
        </p>

        <div class="stats-grid">
          <div class="stat-item">
            <div class="stat-number"><?php echo $total_busquedas; ?></div>
            <div class="stat-label">Búsquedas Realizadas</div>
          </div>

          <div class="stat-item">
            <div class="stat-number"><?php echo $busquedas_exitosas; ?></div>
            <div class="stat-label">Estudiantes Encontrados</div>
          </div>

          <div class="stat-item">
            <div class="stat-number"><?php echo $total_busquedas - $busquedas_exitosas; ?></div>
            <div class="stat-label">Búsquedas Sin Resultado</div>
          </div>

          <div class="stat-item">
            <div class="stat-number"><?php echo $total_busquedas > 0 ? round(($busquedas_exitosas / $total_busquedas) * 100) : 0; ?>%</div>
            <div class="stat-label">Tasa de Éxito</div>
          </div>
        </div>
      </div>

      <div class="actions">
        <a href="ver_historial.php" class="btn btn-success">
          📈 Ver Historial Completo
        </a>
        <a href="index.php" class="btn btn-primary">
          ← Volver al Inicio
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>

  <script>
    // Animación de los resultados
    window.addEventListener('load', function() {
      const studentCard = document.querySelector('.student-card');
      if (studentCard) {
        studentCard.style.opacity = '0';
        studentCard.style.transform = 'translateY(30px)';

        setTimeout(() => {
          studentCard.style.transition = 'all 0.6s ease-out';
          studentCard.style.opacity = '1';
          studentCard.style.transform = 'translateY(0)';
        }, 200);
      }
    });

    // Validación en tiempo real
    document.getElementById('matricula').addEventListener('input', function(e) {
      const value = e.target.value;

      // Solo permitir números
      if (!/^[0-9]*$/.test(value)) {
        e.target.value = value.replace(/[^0-9]/g, '');
      }
    });
  </script>
</body>

</html>