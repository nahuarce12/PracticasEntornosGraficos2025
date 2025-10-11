<?php
session_start();

// Inicializar historial si no existe
if (!isset($_SESSION['historial_canciones'])) {
  $_SESSION['historial_canciones'] = [];
}

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
  if ($_POST['accion'] === 'limpiar') {
    $_SESSION['historial_canciones'] = [];
    $mensaje_limpieza = "Historial limpiado exitosamente.";
  }
}

$historial = $_SESSION['historial_canciones'];
$total_busquedas = count($historial);

// Calcular estadísticas
$total_resultados = 0;
$busquedas_con_resultados = 0;
$busquedas_sin_resultados = 0;
$terminos_mas_buscados = [];

foreach ($historial as $busqueda) {
  $total_resultados += $busqueda['resultados'];

  if ($busqueda['resultados'] > 0) {
    $busquedas_con_resultados++;
  } else {
    $busquedas_sin_resultados++;
  }

  if (!empty($busqueda['titulo'])) {
    $terminos_mas_buscados[] = $busqueda['titulo'];
  }
  if (!empty($busqueda['artista'])) {
    $terminos_mas_buscados[] = $busqueda['artista'];
  }
}

$promedio_resultados = $total_busquedas > 0 ? round($total_resultados / $total_busquedas, 1) : 0;

// Contar términos más buscados
$terminos_contados = array_count_values($terminos_mas_buscados);
arsort($terminos_contados);
$top_terminos = array_slice($terminos_contados, 0, 5, true);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Búsquedas - Ejercicio 8</title>
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
      margin-bottom: 30px;
      border-radius: 10px;
      border-left: 5px solid #28a745;
      background: #d4edda;
      color: #155724;
      animation: slideIn 0.5s ease-out;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }

    .stat-card {
      background: white;
      padding: 25px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      border-top: 4px solid #f093fb;
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
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

    .section {
      background: white;
      border-radius: 15px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .section h2 {
      color: #333;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 3px solid #f093fb;
      font-size: 1.8em;
    }

    .top-terms {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 20px;
    }

    .term-badge {
      background: linear-gradient(45deg, #f093fb, #f5576c);
      color: white;
      padding: 12px 25px;
      border-radius: 25px;
      font-weight: bold;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);
    }

    .term-count {
      background: rgba(255, 255, 255, 0.3);
      padding: 4px 12px;
      border-radius: 15px;
      font-size: 0.9em;
    }

    .history-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .history-table th,
    .history-table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #e0e0e0;
    }

    .history-table th {
      background: #f8f9fa;
      color: #333;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 0.9em;
    }

    .history-table tr:hover {
      background: #f8f9fa;
    }

    .search-term {
      background: #e9ecef;
      padding: 5px 12px;
      border-radius: 15px;
      display: inline-block;
      margin: 2px;
      font-size: 0.9em;
      color: #495057;
    }

    .results-badge {
      padding: 5px 15px;
      border-radius: 20px;
      font-weight: bold;
      display: inline-block;
    }

    .results-success {
      background: #d4edda;
      color: #155724;
    }

    .results-warning {
      background: #fff3cd;
      color: #856404;
    }

    .results-danger {
      background: #f8d7da;
      color: #721c24;
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
    }

    .empty-state-icon {
      font-size: 5em;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .empty-state h3 {
      color: #666;
      margin-bottom: 15px;
      font-size: 1.5em;
    }

    .empty-state p {
      color: #999;
      font-size: 1.1em;
    }

    .btn {
      display: inline-block;
      padding: 15px 30px;
      margin: 10px 5px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1em;
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

    .btn-danger {
      background: linear-gradient(45deg, #dc3545, #c82333);
      color: white;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .actions {
      text-align: center;
      margin-top: 40px;
      padding-top: 30px;
      border-top: 2px solid #e0e0e0;
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

      .stats-grid {
        grid-template-columns: 1fr;
      }

      .history-table {
        font-size: 0.9em;
      }

      .history-table th,
      .history-table td {
        padding: 10px;
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
      <h1>📜 Historial de Búsquedas</h1>
      <p>Seguimiento de Consultas - Ejercicio 8</p>
    </div>

    <div class="content">
      <?php if (isset($mensaje_limpieza)): ?>
        <div class="alert">
          <strong>✅ Éxito:</strong> <?php echo htmlspecialchars($mensaje_limpieza); ?>
        </div>
      <?php endif; ?>

      <?php if ($total_busquedas > 0): ?>

        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-number"><?php echo $total_busquedas; ?></div>
            <div class="stat-label">Búsquedas Totales</div>
          </div>

          <div class="stat-card">
            <div class="stat-number"><?php echo $busquedas_con_resultados; ?></div>
            <div class="stat-label">Con Resultados</div>
          </div>

          <div class="stat-card">
            <div class="stat-number"><?php echo $busquedas_sin_resultados; ?></div>
            <div class="stat-label">Sin Resultados</div>
          </div>

          <div class="stat-card">
            <div class="stat-number"><?php echo $promedio_resultados; ?></div>
            <div class="stat-label">Promedio Resultados</div>
          </div>

          <div class="stat-card">
            <div class="stat-number"><?php echo $total_resultados; ?></div>
            <div class="stat-label">Canciones Encontradas</div>
          </div>
        </div>

        <?php if (!empty($top_terminos)): ?>
          <div class="section">
            <h2>🔥 Términos Más Buscados</h2>
            <div class="top-terms">
              <?php foreach ($top_terminos as $termino => $cantidad): ?>
                <div class="term-badge">
                  <span><?php echo htmlspecialchars($termino); ?></span>
                  <span class="term-count"><?php echo $cantidad; ?>x</span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="section">
          <h2>📊 Registro Completo de Búsquedas</h2>

          <div style="overflow-x: auto;">
            <table class="history-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Criterios de Búsqueda</th>
                  <th>Resultados</th>
                  <th>Fecha y Hora</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($historial as $index => $busqueda): ?>
                  <tr>
                    <td><strong><?php echo $index + 1; ?></strong></td>
                    <td>
                      <?php if (!empty($busqueda['titulo'])): ?>
                        <span class="search-term">
                          📝 Título: <?php echo htmlspecialchars($busqueda['titulo']); ?>
                        </span>
                      <?php endif; ?>

                      <?php if (!empty($busqueda['artista'])): ?>
                        <span class="search-term">
                          🎤 Artista: <?php echo htmlspecialchars($busqueda['artista']); ?>
                        </span>
                      <?php endif; ?>

                      <?php if (empty($busqueda['titulo']) && empty($busqueda['artista'])): ?>
                        <span class="search-term">🎵 Todas las canciones</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php
                      $resultados = $busqueda['resultados'];
                      $clase = 'results-success';
                      if ($resultados === 0) {
                        $clase = 'results-danger';
                      } elseif ($resultados < 5) {
                        $clase = 'results-warning';
                      }
                      ?>
                      <span class="results-badge <?php echo $clase; ?>">
                        <?php echo $resultados; ?> canción<?php echo $resultados !== 1 ? 'es' : ''; ?>
                      </span>
                    </td>
                    <td>
                      📅 <?php echo date('d/m/Y', strtotime($busqueda['fecha'])); ?>
                      <br>
                      ⏰ <?php echo date('H:i:s', strtotime($busqueda['fecha'])); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="actions">
          <form method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de que quieres limpiar todo el historial?');">
            <input type="hidden" name="accion" value="limpiar">
            <button type="submit" class="btn btn-danger">
              🗑️ Limpiar Historial
            </button>
          </form>

          <a href="index.php" class="btn btn-primary">
            🔍 Nueva Búsqueda
          </a>

          <a href="buscar.php" class="btn btn-primary">
            📚 Ver Todas las Canciones
          </a>

          <a href="../index.php" class="btn btn-secondary">
            🏠 Menú Principal
          </a>
        </div>

      <?php else: ?>

        <div class="section">
          <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3>No hay búsquedas en el historial</h3>
            <p>Realiza tu primera búsqueda para comenzar a ver el historial aquí.</p>
          </div>
        </div>

        <div class="actions">
          <a href="index.php" class="btn btn-primary">
            🔍 Realizar Primera Búsqueda
          </a>

          <a href="../index.php" class="btn btn-secondary">
            🏠 Menú Principal
          </a>
        </div>

      <?php endif; ?>
    </div>
  </div>
</body>

</html>