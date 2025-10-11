<?php
// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "base2";

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

    // Crear la tabla alumnos
    $sql_crear_tabla = "
        CREATE TABLE IF NOT EXISTS alumnos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            matricula VARCHAR(20) NOT NULL UNIQUE,
            nombre VARCHAR(100) NOT NULL,
            apellidos VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            carrera VARCHAR(100),
            semestre INT,
            fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_matricula (matricula)
        ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ";

    $conexion->exec($sql_crear_tabla);

    // Insertar datos de ejemplo
    $sql_insertar = "
        INSERT IGNORE INTO alumnos (matricula, nombre, apellidos, email, carrera, semestre) VALUES
        ('2021001', 'Ana', 'García López', 'ana.garcia@universidad.edu', 'Ingeniería en Sistemas Computacionales', 5),
        ('2021002', 'Carlos', 'Rodríguez Pérez', 'carlos.rodriguez@universidad.edu', 'Ingeniería Industrial', 4),
        ('2021003', 'María', 'Hernández Silva', 'maria.hernandez@universidad.edu', 'Medicina', 6),
        ('2021004', 'José', 'Martínez Cruz', 'jose.martinez@universidad.edu', 'Derecho', 3),
        ('2021005', 'Laura', 'González Ramírez', 'laura.gonzalez@universidad.edu', 'Psicología', 2),
        ('2021006', 'Miguel', 'Sánchez Torres', 'miguel.sanchez@universidad.edu', 'Arquitectura', 7),
        ('2021007', 'Patricia', 'López Morales', 'patricia.lopez@universidad.edu', 'Administración de Empresas', 4),
        ('2021008', 'Roberto', 'Díaz Castillo', 'roberto.diaz@universidad.edu', 'Ingeniería Civil', 5),
        ('2021009', 'Carmen', 'Ruiz Flores', 'carmen.ruiz@universidad.edu', 'Enfermería', 3),
        ('2021010', 'Fernando', 'Moreno Vega', 'fernando.moreno@universidad.edu', 'Contaduría Pública', 6),
        ('2022001', 'Alejandra', 'Castro Jiménez', 'alejandra.castro@universidad.edu', 'Ingeniería en Sistemas Computacionales', 3),
        ('2022002', 'Diego', 'Vargas Herrera', 'diego.vargas@universidad.edu', 'Medicina', 2),
        ('2022003', 'Sofía', 'Mendoza Aguilar', 'sofia.mendoza@universidad.edu', 'Derecho', 4),
        ('2022004', 'Andrés', 'Guerrero Peña', 'andres.guerrero@universidad.edu', 'Ingeniería Industrial', 1),
        ('2022005', 'Valeria', 'Ortega Campos', 'valeria.ortega@universidad.edu', 'Psicología', 2),
        ('2023001', 'Ricardo', 'Navarro Luna', 'ricardo.navarro@universidad.edu', 'Arquitectura', 1),
        ('2023002', 'Gabriela', 'Reyes Cordero', 'gabriela.reyes@universidad.edu', 'Administración de Empresas', 1),
        ('2023003', 'Javier', 'Delgado Santos', 'javier.delgado@universidad.edu', 'Ingeniería Civil', 2),
        ('2023004', 'Isabella', 'Romero Valdez', 'isabella.romero@universidad.edu', 'Enfermería', 1),
        ('2023005', 'Eduardo', 'Silva Ramos', 'eduardo.silva@universidad.edu', 'Contaduría Pública', 1)
        ";

    $conexion->exec($sql_insertar);

    $mensaje = "¡Base de datos configurada correctamente! Se creó la base de datos 'base2', la tabla 'alumnos' y se insertaron 20 registros de estudiantes de ejemplo.";
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
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM alumnos");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $mensaje = "Conexión exitosa a la base de datos 'base2'. La tabla 'alumnos' contiene " . $resultado['total'] . " registros.";
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

// Obtener lista de estudiantes si hay conexión
$estudiantes = [];
if ($conexion = verificarConexion()) {
  try {
    $stmt = $conexion->query("SELECT * FROM alumnos ORDER BY matricula");
    $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    // Error silencioso para mantener la funcionalidad
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración de Base de Datos - Ejercicio 6</title>
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
      max-width: 1200px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
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

    .header p {
      font-size: 1.2em;
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
      border-color: #4facfe;
      color: #0c5460;
    }

    .config-section {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      border-left: 5px solid #667eea;
    }

    .config-section h3 {
      color: #333;
      margin-bottom: 20px;
      font-size: 1.5em;
    }

    .config-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
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
      letter-spacing: 1px;
    }

    .config-value {
      color: #333;
      font-family: monospace;
      background: #e9ecef;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 1em;
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

    .students-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .students-table th,
    .students-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .students-table th {
      background: #667eea;
      color: white;
      font-weight: bold;
    }

    .students-table tr:hover {
      background: #f8f9fa;
    }

    .students-table tr:nth-child(even) {
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

      .students-table {
        font-size: 0.8em;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🛠️ Configuración de Base de Datos</h1>
      <p>Configuración para el Ejercicio 6 - Sistema de Emails Estudiantiles</p>
    </div>

    <div class="content">
      <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje === 'success' ? 'success' : 'error'; ?>">
          <strong><?php echo $tipo_mensaje === 'success' ? '✅ Éxito:' : '❌ Error:'; ?></strong>
          <?php echo htmlspecialchars($mensaje); ?>
        </div>
      <?php endif; ?>

      <div class="config-section">
        <h3>📊 Configuración Actual de la Base de Datos</h3>

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
            <div class="config-value">alumnos</div>
          </div>
        </div>

        <div class="alert alert-info">
          <strong>💡 Información:</strong>
          Esta configuración utiliza los valores predeterminados de XAMPP. Si tu configuración es diferente,
          modifica las variables al inicio del archivo crear_base_datos.php.
        </div>
      </div>

      <div class="config-section">
        <h3>🔧 Acciones de Configuración</h3>

        <form method="POST" style="display: inline;">
          <input type="hidden" name="accion" value="crear">
          <button type="submit" class="btn btn-primary">
            🚀 Crear Base de Datos y Tabla
          </button>
        </form>

        <form method="POST" style="display: inline;">
          <input type="hidden" name="accion" value="verificar">
          <button type="submit" class="btn btn-success">
            ✅ Verificar Conexión
          </button>
        </form>
      </div>

      <div class="config-section">
        <h3>📝 Script SQL Utilizado</h3>
        <p>El siguiente código SQL se ejecuta para crear la estructura de la base de datos:</p>

        <div class="sql-code">-- Crear base de datos
          CREATE DATABASE IF NOT EXISTS base2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

          -- Usar la base de datos
          USE base2;

          -- Crear tabla alumnos
          CREATE TABLE IF NOT EXISTS alumnos (
          id INT AUTO_INCREMENT PRIMARY KEY,
          matricula VARCHAR(20) NOT NULL UNIQUE,
          nombre VARCHAR(100) NOT NULL,
          apellidos VARCHAR(100) NOT NULL,
          email VARCHAR(100) NOT NULL,
          carrera VARCHAR(100),
          semestre INT,
          fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          INDEX idx_matricula (matricula)
          ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</div>
      </div>

      <?php if (!empty($estudiantes)): ?>
        <div class="config-section">
          <h3>👥 Estudiantes en la Base de Datos (<?php echo count($estudiantes); ?> registros)</h3>

          <div style="overflow-x: auto;">
            <table class="students-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Matrícula</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Email</th>
                  <th>Carrera</th>
                  <th>Semestre</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($estudiante['id']); ?></td>
                    <td><strong><?php echo htmlspecialchars($estudiante['matricula']); ?></strong></td>
                    <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($estudiante['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($estudiante['email']); ?></td>
                    <td><?php echo htmlspecialchars($estudiante['carrera']); ?></td>
                    <td><?php echo htmlspecialchars($estudiante['semestre']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>

      <div class="actions">
        <a href="index.php" class="btn btn-primary">
          ← Volver al Buscador
        </a>
        <a href="buscar_email.php" class="btn btn-success">
          🔍 Probar Búsqueda
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>
</body>

</html>