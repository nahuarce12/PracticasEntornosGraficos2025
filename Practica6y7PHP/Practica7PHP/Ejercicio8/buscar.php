<?php
session_start();

// Configuración de la base de datos
$servidor = "127.0.0.1:3308";
$usuario_db = "root";
$password_db = "";
$nombre_db = "prueba";

// Inicializar historial de búsquedas
if (!isset($_SESSION['historial_canciones'])) {
  $_SESSION['historial_canciones'] = [];
}

// Variables para resultados
$canciones = [];
$mensaje = "";
$termino_titulo = "";
$termino_artista = "";
$total_resultados = 0;

try {
  $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_db", $usuario_db, $password_db);
  $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conexion->exec("SET NAMES utf8mb4");

  // Procesar búsqueda
  if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['titulo']) || isset($_GET['artista']))) {
    $termino_titulo = trim($_GET['titulo'] ?? '');
    $termino_artista = trim($_GET['artista'] ?? '');

    // Construir consulta SQL
    $sql = "SELECT * FROM buscador WHERE 1=1";
    $params = [];

    if (!empty($termino_titulo)) {
      $sql .= " AND titulo LIKE :titulo";
      $params[':titulo'] = '%' . $termino_titulo . '%';
    }

    if (!empty($termino_artista)) {
      $sql .= " AND artista LIKE :artista";
      $params[':artista'] = '%' . $termino_artista . '%';
    }

    $sql .= " ORDER BY artista, titulo";

    $stmt = $conexion->prepare($sql);
    $stmt->execute($params);
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_resultados = count($canciones);

    // Guardar en historial
    $busqueda = [
      'titulo' => $termino_titulo,
      'artista' => $termino_artista,
      'resultados' => $total_resultados,
      'fecha' => date('Y-m-d H:i:s')
    ];

    array_unshift($_SESSION['historial_canciones'], $busqueda);

    // Limitar historial a 20 búsquedas
    $_SESSION['historial_canciones'] = array_slice($_SESSION['historial_canciones'], 0, 20);

    if ($total_resultados === 0) {
      $mensaje = "No se encontraron canciones con los criterios especificados.";
    }
  } else {
    // Mostrar todas las canciones
    $stmt = $conexion->query("SELECT * FROM buscador ORDER BY artista, titulo");
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total_resultados = count($canciones);
  }
} catch (PDOException $e) {
  $mensaje = "Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados - Buscador de Canciones</title>
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

    .search-bar {
      background: white;
      padding: 25px;
      border-radius: 15px;
      margin: 30px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .search-form {
      display: grid;
      grid-template-columns: 1fr 1fr auto;
      gap: 15px;
      align-items: end;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group label {
      margin-bottom: 8px;
      color: #f093fb;
      font-weight: bold;
      font-size: 0.9em;
      text-transform: uppercase;
    }

    .form-group input {
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 1em;
      transition: all 0.3s ease;
    }

    .form-group input:focus {
      outline: none;
      border-color: #f093fb;
      box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.1);
    }

    .btn {
      padding: 12px 30px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1em;
      border: none;
      cursor: pointer;
      display: inline-block;
      text-align: center;
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

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .results-info {
      margin: 20px 30px;
      padding: 20px;
      background: #f8f9fa;
      border-radius: 12px;
      border-left: 5px solid #f093fb;
    }

    .results-info h2 {
      color: #333;
      margin-bottom: 10px;
    }

    .search-terms {
      color: #666;
      font-size: 1.1em;
      margin-top: 10px;
    }

    .search-terms span {
      display: inline-block;
      background: white;
      padding: 8px 15px;
      border-radius: 20px;
      margin: 5px;
      font-weight: bold;
      color: #f093fb;
    }

    .alert {
      margin: 20px 30px;
      padding: 20px;
      border-radius: 10px;
      border-left: 5px solid #dc3545;
      background: #f8d7da;
      color: #721c24;
    }

    .songs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 25px;
      padding: 30px;
    }

    .song-card {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      border-top: 4px solid #f093fb;
    }

    .song-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
    }

    .song-title {
      font-size: 1.4em;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .song-artist {
      font-size: 1.2em;
      color: #f093fb;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .song-details {
      margin-top: 15px;
      padding-top: 15px;
      border-top: 2px solid #f0f0f0;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
      font-size: 0.95em;
    }

    .detail-label {
      color: #666;
      font-weight: bold;
    }

    .detail-value {
      color: #333;
    }

    .genre-badge {
      display: inline-block;
      background: linear-gradient(45deg, #f093fb, #f5576c);
      color: white;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.85em;
      font-weight: bold;
      margin-top: 10px;
    }

    .actions {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: center;
      padding: 30px;
      background: #f8f9fa;
      border-top: 1px solid #ddd;
    }

    .stats-bar {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px 30px;
      margin: 30px;
      border-radius: 15px;
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2em;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .stat-label {
      font-size: 0.9em;
      opacity: 0.9;
    }

    @media (max-width: 768px) {
      .search-form {
        grid-template-columns: 1fr;
      }

      .songs-grid {
        grid-template-columns: 1fr;
      }

      .header h1 {
        font-size: 2em;
      }

      .actions {
        flex-direction: column;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🎵 Resultados de Búsqueda</h1>
      <p>Biblioteca Musical - Ejercicio 8</p>
    </div>

    <div class="search-bar">
      <form class="search-form" method="GET" action="buscar.php">
        <div class="form-group">
          <label for="titulo">🎼 Título de la Canción</label>
          <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($termino_titulo); ?>" placeholder="Ej: Bohemian Rhapsody">
        </div>

        <div class="form-group">
          <label for="artista">🎤 Artista</label>
          <input type="text" id="artista" name="artista" value="<?php echo htmlspecialchars($termino_artista); ?>" placeholder="Ej: Queen">
        </div>

        <button type="submit" class="btn btn-primary">
          🔍 Buscar
        </button>
      </form>
    </div>

    <div class="results-info">
      <h2>📊 Resultados de la búsqueda: <?php echo $total_resultados; ?> cancion<?php echo $total_resultados !== 1 ? 'es' : ''; ?> encontrada<?php echo $total_resultados !== 1 ? 's' : ''; ?></h2>

      <?php if (!empty($termino_titulo) || !empty($termino_artista)): ?>
        <div class="search-terms">
          <strong>Criterios de búsqueda:</strong>
          <?php if (!empty($termino_titulo)): ?>
            <span>📝 Título: "<?php echo htmlspecialchars($termino_titulo); ?>"</span>
          <?php endif; ?>
          <?php if (!empty($termino_artista)): ?>
            <span>🎤 Artista: "<?php echo htmlspecialchars($termino_artista); ?>"</span>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <p style="color: #666; margin-top: 10px;">Mostrando todas las canciones disponibles en la biblioteca.</p>
      <?php endif; ?>
    </div>

    <?php if (!empty($mensaje)): ?>
      <div class="alert">
        <strong>⚠️ Aviso:</strong> <?php echo htmlspecialchars($mensaje); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($canciones)): ?>
      <?php
      // Calcular estadísticas
      $artistas_unicos = count(array_unique(array_column($canciones, 'artista')));
      $generos_unicos = count(array_unique(array_column($canciones, 'genero')));
      $anios = array_column($canciones, 'anio');
      $anio_promedio = !empty($anios) ? round(array_sum($anios) / count($anios)) : 0;
      ?>

      <div class="stats-bar">
        <div class="stat-item">
          <div class="stat-number"><?php echo $total_resultados; ?></div>
          <div class="stat-label">Canciones</div>
        </div>
        <div class="stat-item">
          <div class="stat-number"><?php echo $artistas_unicos; ?></div>
          <div class="stat-label">Artistas</div>
        </div>
        <div class="stat-item">
          <div class="stat-number"><?php echo $generos_unicos; ?></div>
          <div class="stat-label">Géneros</div>
        </div>
        <div class="stat-item">
          <div class="stat-number"><?php echo $anio_promedio; ?></div>
          <div class="stat-label">Año Promedio</div>
        </div>
      </div>

      <div class="songs-grid">
        <?php foreach ($canciones as $cancion): ?>
          <div class="song-card">
            <div class="song-title">
              🎵 <?php echo htmlspecialchars($cancion['titulo']); ?>
            </div>
            <div class="song-artist">
              <?php echo htmlspecialchars($cancion['artista']); ?>
            </div>

            <div class="song-details">
              <div class="detail-row">
                <span class="detail-label">💿 Álbum:</span>
                <span class="detail-value"><?php echo htmlspecialchars($cancion['album']); ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">📅 Año:</span>
                <span class="detail-value"><?php echo $cancion['anio']; ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">⏱️ Duración:</span>
                <span class="detail-value"><?php echo htmlspecialchars($cancion['duracion']); ?></span>
              </div>
            </div>

            <span class="genre-badge">
              🎸 <?php echo htmlspecialchars($cancion['genero']); ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="actions">
      <a href="index.php" class="btn btn-primary">
        ← Nueva Búsqueda
      </a>
      <a href="historial.php" class="btn btn-success">
        📜 Ver Historial
      </a>
      <a href="configurar_bd.php" class="btn btn-secondary">
        ⚙️ Configuración
      </a>
      <a href="../index.php" class="btn btn-secondary">
        🏠 Menú Principal
      </a>
    </div>
  </div>
</body>

</html>