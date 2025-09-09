<?php

declare(strict_types=1);

require_once 'ContadorSesion.php';

$contador = new ContadorSesion();
$contador->contarVisita('Estadísticas Detalladas', '/Ejercicio4/estadisticas.php');

$estadisticas = $contador->obtenerEstadisticasPaginas();
$historial = $contador->obtenerHistorial();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estadísticas Detalladas | Contador de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }

    .stats-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
      margin-bottom: 30px;
    }

    .stats-header {
      background: linear-gradient(135deg, #dc3545, #fd7e14);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .stats-content {
      padding: 40px 30px;
    }

    .counter-badge {
      background: linear-gradient(135deg, #007bff, #17a2b8);
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      font-size: 1.2rem;
      font-weight: 600;
      display: inline-block;
      margin: 20px 0;
    }

    .nav-btn {
      background: linear-gradient(135deg, #007bff, #0056b3);
      border: none;
      border-radius: 10px;
      padding: 12px 24px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin: 5px;
    }

    .nav-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
      color: white;
    }

    .stat-metric {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border-radius: 15px;
      padding: 25px;
      margin: 15px 0;
      border-left: 5px solid #dc3545;
      text-align: center;
    }

    .stat-metric h3 {
      color: #dc3545;
      font-size: 2.5rem;
      margin: 0;
    }

    .stat-metric p {
      color: #6c757d;
      margin: 5px 0 0 0;
      font-weight: 600;
    }

    .table-container {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      margin: 20px 0;
    }

    .table th {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border: none;
      font-weight: 600;
      color: #495057;
      padding: 15px;
    }

    .table td {
      border: none;
      padding: 12px 15px;
      vertical-align: middle;
    }

    .table tbody tr:hover {
      background-color: #f8f9fa;
    }

    .progress-bar-custom {
      background: linear-gradient(135deg, #dc3545, #fd7e14);
      border-radius: 10px;
    }

    .badge-page {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 8px 12px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
    }

    .time-info {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb);
      border-radius: 15px;
      padding: 20px;
      margin: 20px 0;
      border-left: 5px solid #17a2b8;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <div class="stats-card">
      <div class="stats-header">
        <h1><i class="fas fa-chart-bar"></i> Estadísticas Detalladas</h1>
        <p>Análisis completo de tu navegación en esta sesión</p>
      </div>

      <div class="stats-content">
        <div class="text-center mb-4">
          <div class="counter-badge">
            <i class="fas fa-eye"></i> Páginas visitadas: <?= $contador->obtenerContador() ?>
          </div>
        </div>

        <!-- Métricas Principales -->
        <div class="row">
          <div class="col-md-3">
            <div class="stat-metric">
              <h3><?= $contador->obtenerContador() ?></h3>
              <p><i class="fas fa-file-alt"></i> Páginas Únicas</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-metric">
              <h3><?= count($historial) ?></h3>
              <p><i class="fas fa-mouse-pointer"></i> Total Visitas</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-metric">
              <h3><?= $contador->obtenerTiempoSesionFormateado() ?></h3>
              <p><i class="fas fa-stopwatch"></i> Tiempo Sesión</p>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stat-metric">
              <h3><?= count($estadisticas) ?></h3>
              <p><i class="fas fa-layer-group"></i> Páginas Distintas</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Estadísticas por Página -->
    <div class="stats-card">
      <div class="stats-content">
        <h3><i class="fas fa-chart-pie"></i> Estadísticas por Página</h3>
        <p class="text-muted">Número de visitas a cada página durante esta sesión:</p>

        <?php if (!empty($estadisticas)): ?>
          <div class="table-container">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th><i class="fas fa-trophy"></i> Ranking</th>
                  <th><i class="fas fa-file-alt"></i> Página</th>
                  <th><i class="fas fa-eye"></i> Visitas</th>
                  <th><i class="fas fa-chart-bar"></i> Porcentaje</th>
                  <th><i class="fas fa-clock"></i> Primera Visita</th>
                  <th><i class="fas fa-history"></i> Última Visita</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $totalVisitas = count($historial);
                foreach ($estadisticas as $index => $pagina):
                  $porcentaje = $totalVisitas > 0 ? round(($pagina['visitas'] / $totalVisitas) * 100, 1) : 0;
                ?>
                  <tr>
                    <td>
                      <span class="badge-page">#<?= $index + 1 ?></span>
                    </td>
                    <td>
                      <strong><?= htmlspecialchars($pagina['nombre'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </td>
                    <td>
                      <span class="badge bg-primary"><?= $pagina['visitas'] ?></span>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                          <div class="progress-bar progress-bar-custom"
                            style="width: <?= $porcentaje ?>%"></div>
                        </div>
                        <small><?= $porcentaje ?>%</small>
                      </div>
                    </td>
                    <td><?= $pagina['primera_visita'] ?></td>
                    <td><?= $pagina['ultima_visita'] ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center text-muted">
            <i class="fas fa-chart-bar fa-3x mb-3"></i>
            <p>No hay datos suficientes para mostrar estadísticas</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Historial Completo -->
    <div class="stats-card">
      <div class="stats-content">
        <h3><i class="fas fa-history"></i> Historial Completo de Navegación</h3>
        <p class="text-muted">Registro detallado de todas las páginas visitadas:</p>

        <?php if (!empty($historial)): ?>
          <div class="table-container">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th><i class="fas fa-hashtag"></i> Orden</th>
                  <th><i class="fas fa-file-alt"></i> Página Visitada</th>
                  <th><i class="fas fa-link"></i> URL</th>
                  <th><i class="fas fa-clock"></i> Hora</th>
                  <th><i class="fas fa-calendar-day"></i> Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (array_reverse($historial) as $index => $visita): ?>
                  <tr>
                    <td>
                      <span class="badge bg-info"><?= count($historial) - $index ?></span>
                    </td>
                    <td>
                      <strong><?= htmlspecialchars($visita['pagina'], ENT_QUOTES, 'UTF-8') ?></strong>
                    </td>
                    <td>
                      <code class="text-muted"><?= htmlspecialchars($visita['url'], ENT_QUOTES, 'UTF-8') ?></code>
                    </td>
                    <td>
                      <span class="badge bg-success"><?= $visita['hora'] ?></span>
                    </td>
                    <td><?= $visita['fecha'] ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Información de Sesión -->
    <div class="stats-card">
      <div class="stats-content">
        <h3><i class="fas fa-info-circle"></i> Información de la Sesión</h3>

        <div class="time-info">
          <div class="row">
            <div class="col-md-6">
              <h5><i class="fas fa-database"></i> Datos de Sesión:</h5>
              <ul class="list-unstyled">
                <li><strong>ID de Sesión:</strong> <code><?= session_id() ?></code></li>
                <li><strong>Inicio de Sesión:</strong> <?= date('d/m/Y H:i:s', $_SESSION['inicio_sesion']) ?></li>
                <li><strong>Hora Actual:</strong> <?= date('d/m/Y H:i:s') ?></li>
                <li><strong>Duración:</strong> <?= $contador->obtenerTiempoSesionFormateado() ?></li>
              </ul>
            </div>
            <div class="col-md-6">
              <h5><i class="fas fa-server"></i> Información del Servidor:</h5>
              <ul class="list-unstyled">
                <li><strong>Servidor:</strong> <?= $_SERVER['SERVER_NAME'] ?? 'localhost' ?></li>
                <li><strong>PHP:</strong> <?= PHP_VERSION ?></li>
                <li><strong>User Agent:</strong> <small><?= substr($_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido', 0, 50) ?>...</small></li>
                <li><strong>IP Cliente:</strong> <?= $_SERVER['REMOTE_ADDR'] ?? 'No disponible' ?></li>
              </ul>
            </div>
          </div>
        </div>

        <hr>

        <h4><i class="fas fa-compass"></i> Navegación</h4>
        <div class="text-center">
          <a href="index.php" class="nav-btn">
            <i class="fas fa-chart-line"></i> Dashboard Principal
          </a>
          <a href="pagina1.php" class="nav-btn">
            <i class="fas fa-home"></i> Página 1
          </a>
          <a href="pagina2.php" class="nav-btn">
            <i class="fas fa-info-circle"></i> Página 2
          </a>
          <a href="pagina3.php" class="nav-btn">
            <i class="fas fa-envelope"></i> Página 3
          </a>
          <a href="pagina4.php" class="nav-btn">
            <i class="fas fa-cog"></i> Página 4
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>