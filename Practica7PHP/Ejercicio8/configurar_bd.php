<?php
// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "prueba";

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

    // Crear la tabla buscador
    $sql_crear_tabla = "
        CREATE TABLE IF NOT EXISTS buscador (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(250) NOT NULL,
            artista VARCHAR(250) NOT NULL,
            album VARCHAR(250),
            anio INT,
            genero VARCHAR(100),
            duracion VARCHAR(10),
            fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_titulo (titulo),
            INDEX idx_artista (artista),
            INDEX idx_genero (genero)
        ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
        ";

    $conexion->exec($sql_crear_tabla);

    // Insertar canciones de ejemplo
    $sql_insertar = "
        INSERT IGNORE INTO buscador (id, titulo, artista, album, anio, genero, duracion) VALUES
        (1, 'Bohemian Rhapsody', 'Queen', 'A Night at the Opera', 1975, 'Rock', '5:55'),
        (2, 'Imagine', 'John Lennon', 'Imagine', 1971, 'Rock/Pop', '3:03'),
        (3, 'Hotel California', 'Eagles', 'Hotel California', 1976, 'Rock', '6:30'),
        (4, 'Billie Jean', 'Michael Jackson', 'Thriller', 1982, 'Pop', '4:54'),
        (5, 'Smells Like Teen Spirit', 'Nirvana', 'Nevermind', 1991, 'Grunge', '5:01'),
        (6, 'Like a Rolling Stone', 'Bob Dylan', 'Highway 61 Revisited', 1965, 'Rock', '6:13'),
        (7, 'Hey Jude', 'The Beatles', 'Hey Jude', 1968, 'Rock/Pop', '7:11'),
        (8, 'Stairway to Heaven', 'Led Zeppelin', 'Led Zeppelin IV', 1971, 'Rock', '8:02'),
        (9, 'Yesterday', 'The Beatles', 'Help!', 1965, 'Pop/Rock', '2:05'),
        (10, 'Sweet Child O Mine', 'Guns N Roses', 'Appetite for Destruction', 1987, 'Hard Rock', '5:56'),
        (11, 'Purple Rain', 'Prince', 'Purple Rain', 1984, 'Rock/Pop', '8:41'),
        (12, 'Wonderwall', 'Oasis', '(What''s the Story) Morning Glory?', 1995, 'Rock', '4:18'),
        (13, 'Shape of You', 'Ed Sheeran', '÷ (Divide)', 2017, 'Pop', '3:54'),
        (14, 'Blinding Lights', 'The Weeknd', 'After Hours', 2020, 'Synthpop', '3:20'),
        (15, 'Rolling in the Deep', 'Adele', '21', 2010, 'Soul/Pop', '3:48'),
        (16, 'Thriller', 'Michael Jackson', 'Thriller', 1982, 'Pop', '5:57'),
        (17, 'One', 'U2', 'Achtung Baby', 1991, 'Rock', '4:36'),
        (18, 'November Rain', 'Guns N Roses', 'Use Your Illusion I', 1991, 'Rock', '8:57'),
        (19, 'Hallelujah', 'Leonard Cohen', 'Various Positions', 1984, 'Folk', '4:36'),
        (20, 'Don''t Stop Believin''', 'Journey', 'Escape', 1981, 'Rock', '4:11'),
        (21, 'Let It Be', 'The Beatles', 'Let It Be', 1970, 'Rock/Pop', '3:50'),
        (22, 'Comfortably Numb', 'Pink Floyd', 'The Wall', 1979, 'Progressive Rock', '6:23'),
        (23, 'Every Breath You Take', 'The Police', 'Synchronicity', 1983, 'Rock/Pop', '4:13'),
        (24, 'Losing My Religion', 'R.E.M.', 'Out of Time', 1991, 'Alternative Rock', '4:27'),
        (25, 'Someone Like You', 'Adele', '21', 2011, 'Soul/Pop', '4:45'),
        (26, 'Uptown Funk', 'Mark Ronson ft. Bruno Mars', 'Uptown Special', 2014, 'Funk/Pop', '4:30'),
        (27, 'Despacito', 'Luis Fonsi ft. Daddy Yankee', 'Vida', 2017, 'Reggaeton', '3:48'),
        (28, 'Thinking Out Loud', 'Ed Sheeran', 'x (Multiply)', 2014, 'Pop', '4:41'),
        (29, 'Shallow', 'Lady Gaga & Bradley Cooper', 'A Star Is Born', 2018, 'Pop/Rock', '3:35'),
        (30, 'Californication', 'Red Hot Chili Peppers', 'Californication', 1999, 'Alternative Rock', '5:21')
        ";

    $conexion->exec($sql_insertar);

    $mensaje = "¡Base de datos configurada correctamente! Se creó la base de datos 'prueba', la tabla 'buscador' y se insertaron 30 canciones de ejemplo.";
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
    $stmt = $conexion->query("SELECT COUNT(*) as total FROM buscador");
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    $mensaje = "Conexión exitosa a la base de datos 'prueba'. La tabla 'buscador' contiene " . $resultado['total'] . " canciones.";
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

// Obtener lista de canciones si hay conexión
$canciones = [];
$stats = ['total' => 0, 'artistas' => 0, 'generos' => 0, 'anio_mas_antiguo' => 0, 'anio_mas_reciente' => 0];

if ($conexion = verificarConexion()) {
  try {
    $stmt = $conexion->query("SELECT * FROM buscador ORDER BY artista, titulo");
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular estadísticas
    $stats['total'] = count($canciones);
    $stats['artistas'] = count(array_unique(array_column($canciones, 'artista')));
    $stats['generos'] = count(array_unique(array_column($canciones, 'genero')));

    if (!empty($canciones)) {
      $anios = array_column($canciones, 'anio');
      $stats['anio_mas_antiguo'] = min($anios);
      $stats['anio_mas_reciente'] = max($anios);
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
  <title>Configuración Base de Datos - Ejercicio 8</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
      background: linear-gradient(45deg, #f093fb, #f5576c);
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
      border-color: #f093fb;
      color: #0c5460;
    }

    .config-section {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      border-left: 5px solid #f093fb;
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
      color: #f093fb;
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
      background: linear-gradient(45deg, #f093fb, #f5576c);
      color: white;
      box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
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

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
      color: #f093fb;
      margin-bottom: 10px;
    }

    .stat-label {
      color: #666;
      font-size: 0.95em;
      text-transform: uppercase;
    }

    .songs-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .songs-table th,
    .songs-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .songs-table th {
      background: #f093fb;
      color: white;
      font-weight: bold;
    }

    .songs-table tr:hover {
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

      .config-grid,
      .stats-grid {
        grid-template-columns: 1fr;
      }

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🛠️ Configuración de Base de Datos</h1>
      <p>Buscador de Canciones - Ejercicio 8</p>
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
            <div class="config-value">buscador</div>
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
            🚀 Crear Base de Datos y Canciones
          </button>
        </form>

        <form method="POST" style="display: inline;">
          <input type="hidden" name="accion" value="verificar">
          <button type="submit" class="btn btn-success">
            ✅ Verificar Conexión
          </button>
        </form>
      </div>

      <?php if (!empty($canciones)): ?>
        <div class="config-section">
          <h3>📊 Estadísticas de la Biblioteca Musical</h3>

          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-number"><?php echo $stats['total']; ?></div>
              <div class="stat-label">Canciones</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo $stats['artistas']; ?></div>
              <div class="stat-label">Artistas</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo $stats['generos']; ?></div>
              <div class="stat-label">Géneros</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo $stats['anio_mas_antiguo']; ?></div>
              <div class="stat-label">Año Más Antiguo</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo $stats['anio_mas_reciente']; ?></div>
              <div class="stat-label">Año Más Reciente</div>
            </div>
          </div>
        </div>

        <div class="config-section">
          <h3>🎵 Biblioteca Musical (<?php echo count($canciones); ?> canciones)</h3>

          <div style="overflow-x: auto;">
            <table class="songs-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>Artista</th>
                  <th>Álbum</th>
                  <th>Año</th>
                  <th>Género</th>
                  <th>Duración</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($canciones as $cancion): ?>
                  <tr>
                    <td><strong><?php echo $cancion['id']; ?></strong></td>
                    <td><?php echo htmlspecialchars($cancion['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($cancion['artista']); ?></td>
                    <td><?php echo htmlspecialchars($cancion['album']); ?></td>
                    <td><?php echo $cancion['anio']; ?></td>
                    <td><?php echo htmlspecialchars($cancion['genero']); ?></td>
                    <td><?php echo htmlspecialchars($cancion['duracion']); ?></td>
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
        <a href="buscar.php" class="btn btn-success">
          🎵 Ver Todas las Canciones
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>
</body>

</html>