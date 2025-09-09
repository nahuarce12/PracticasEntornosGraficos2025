<?php

declare(strict_types=1);

/**
 * Ejercicio 4 - Dashboard Principal del Contador de Páginas
 * 
 * Página principal que muestra el contador de páginas visitadas
 * y permite la navegación a otras páginas del sistema.
 * 
 * @author Ejercicio PHP
 * @version 1.0
 */

require_once 'ContadorSesion.php';

// Crear instancia del contador
$contador = new ContadorSesion();

// Procesar acciones GET
$accion = $_GET['accion'] ?? '';

// Procesar acciones
switch ($accion) {
    case 'reiniciar':
        $contador->reiniciarSesion();
        header('Location: index.php');
        exit;
    case 'destruir':
        $contador->destruirSesion();
        header('Location: index.php');
        exit;
}

// Contar esta visita SOLO cuando se accede directamente al index
$contador->contarVisita('Dashboard Principal', '/Ejercicio4/index.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contador de Páginas Visitadas - Ejercicio 4</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #007bff;
      --success-color: #28a745;
      --info-color: #17a2b8;
      --warning-color: #ffc107;
      --danger-color: #dc3545;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }

    .container {
      max-width: 1200px;
    }

    .main-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }

    .card-header {
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .card-body {
      padding: 40px 30px;
    }

    .counter-display {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      margin: 30px 0;
      box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
    }

    .counter-number {
      font-size: 4rem;
      font-weight: 700;
      margin: 0;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .counter-label {
      font-size: 1.2rem;
      margin-top: 10px;
      opacity: 0.9;
    }

    .stat-card {
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      border-radius: 15px;
      padding: 25px;
      margin: 15px 0;
      border-left: 5px solid var(--primary-color);
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .stat-card h4 {
      color: var(--primary-color);
      margin-bottom: 10px;
    }

    .nav-btn {
      background: linear-gradient(135deg, #17a2b8, #138496);
      border: none;
      border-radius: 10px;
      padding: 15px 25px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin: 10px;
    }

    .nav-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(23, 162, 184, 0.3);
      color: white;
    }

    .action-btn {
      background: linear-gradient(135deg, #dc3545, #c82333);
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin: 5px;
    }

    .action-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
      color: white;
    }

    .info-section {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb);
      border-radius: 15px;
      padding: 25px;
      margin: 20px 0;
      border-left: 5px solid var(--info-color);
    }

    .session-info {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin: 15px 0;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .session-info h5 {
      color: var(--primary-color);
      margin-bottom: 15px;
    }

    .badge-custom {
      background: linear-gradient(135deg, #ffc107, #e0a800);
      color: #212529;
      padding: 8px 15px;
      border-radius: 20px;
      font-weight: 600;
    }

    .recent-activity {
      max-height: 300px;
      overflow-y: auto;
    }

    .activity-item {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
      margin: 10px 0;
      border-left: 4px solid var(--success-color);
    }

    .activity-time {
      color: #6c757d;
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      .counter-number {
        font-size: 3rem;
      }

      .card-header,
      .card-body {
        padding: 20px 15px;
      }

      .nav-btn {
        padding: 12px 20px;
        margin: 5px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Tarjeta Principal -->
    <div class="main-card">
      <div class="card-header">
        <h1><i class="fas fa-chart-line"></i> Contador de Páginas Visitadas</h1>
        <p class="mb-0">Sistema de seguimiento de navegación por sesión</p>
      </div>

      <div class="card-body">
        <!-- Contador Principal -->
        <div class="counter-display">
          <h2 class="counter-number"><?= $contador->obtenerContador() ?></h2>
          <p class="counter-label">
            <i class="fas fa-file-alt"></i> Páginas Únicas Visitadas
          </p>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <div class="stat-card">
              <h4><i class="fas fa-mouse-pointer"></i> Total Visitas</h4>
              <h3><?= count($contador->obtenerHistorial()) ?></h3>
              <small class="text-muted">Incluyendo revisitas</small>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="stat-card">
              <h4><i class="fas fa-clock"></i> Tiempo de Sesión</h4>
              <h3><?= $contador->obtenerTiempoSesionFormateado() ?></h3>
              <small class="text-muted">Duración actual</small>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="stat-card">
              <h4><i class="fas fa-calendar-day"></i> Sesión Iniciada</h4>
              <h3><?= date('H:i', $_SESSION['inicio_sesion'] ?? time()) ?></h3>
              <small class="text-muted"><?= date('d/m/Y', $_SESSION['inicio_sesion'] ?? time()) ?></small>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="stat-card">
              <h4><i class="fas fa-trophy"></i> Más Visitada</h4>
              <?php $masVisitada = $contador->obtenerPaginaMasVisitada(); ?>
              <?php if ($masVisitada): ?>
                <h3><?= $masVisitada['visitas'] ?></h3>
                <small class="text-muted"><?= htmlspecialchars($masVisitada['nombre'], ENT_QUOTES, 'UTF-8') ?></small>
              <?php else: ?>
                <h3>-</h3>
                <small class="text-muted">Sin datos</small>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Navegación -->
        <div class="info-section">
          <h3><i class="fas fa-compass"></i> Explorar Páginas</h3>
          <p>Navega por las diferentes páginas para probar el contador:</p>

          <div class="text-center">
            <a href="pagina1.php" class="nav-btn">
              <i class="fas fa-home"></i> Página 1 - Tecnología
            </a>
            <a href="pagina2.php" class="nav-btn">
              <i class="fas fa-futbol"></i> Página 2 - Deportes
            </a>
            <a href="pagina3.php" class="nav-btn">
              <i class="fas fa-envelope"></i> Página 3 - Contacto
            </a>
            <a href="pagina4.php" class="nav-btn">
              <i class="fas fa-flask"></i> Página 4 - Ciencia
            </a>
            <a href="estadisticas.php" class="nav-btn">
              <i class="fas fa-chart-bar"></i> Estadísticas Detalladas
            </a>
          </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="session-info">
          <h5><i class="fas fa-history"></i> Actividad Reciente</h5>
          
          <?php 
          $historial = $contador->obtenerHistorial(); 
          $ultimasVisitas = array_slice(array_reverse($historial), 0, 5);
          ?>
          
          <?php if (!empty($ultimasVisitas)): ?>
            <div class="recent-activity">
              <?php foreach ($ultimasVisitas as $visita): ?>
                <div class="activity-item">
                  <strong><?= htmlspecialchars($visita['pagina'], ENT_QUOTES, 'UTF-8') ?></strong>
                  <div class="activity-time">
                    <i class="fas fa-clock"></i> <?= $visita['hora'] ?> - <?= $visita['fecha'] ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted">
              <i class="fas fa-info-circle"></i> No hay actividad reciente.
              ¡Empieza navegando por las páginas!
            </p>
          <?php endif; ?>
        </div>

        <!-- Información de la Sesión -->
        <div class="session-info">
          <h5><i class="fas fa-info-circle"></i> Información de la Sesión</h5>
          <div class="row">
            <div class="col-md-6">
              <p><strong>ID de Sesión:</strong> <code><?= session_id() ?></code></p>
              <p><strong>Páginas Únicas:</strong> 
                <span class="badge-custom"><?= $contador->obtenerContador() ?></span>
              </p>
            </div>
            <div class="col-md-6">
              <p><strong>Total de Visitas:</strong> 
                <span class="badge-custom"><?= count($contador->obtenerHistorial()) ?></span>
              </p>
              <p><strong>Duración:</strong> 
                <span class="badge-custom"><?= $contador->obtenerTiempoSesionFormateado() ?></span>
              </p>
            </div>
          </div>
        </div>

        <!-- Acciones de Sesión -->
        <div class="text-center mt-4">
          <h5><i class="fas fa-cogs"></i> Gestión de Sesión</h5>
          <a href="?accion=reiniciar" class="action-btn" 
             onclick="return confirm('¿Estás seguro de que quieres reiniciar el contador?')">
            <i class="fas fa-redo"></i> Reiniciar Contador
          </a>
          <a href="?accion=destruir" class="action-btn" 
             onclick="return confirm('¿Estás seguro de que quieres destruir la sesión completa?')">
            <i class="fas fa-trash"></i> Destruir Sesión
          </a>
        </div>

        <!-- Explicación -->
        <div class="info-section mt-4">
          <h4><i class="fas fa-lightbulb"></i> ¿Cómo Funciona?</h4>
          <ul class="list-unstyled">
            <li><i class="fas fa-check text-success"></i> El contador registra cada página <strong>única</strong> que visitas</li>
            <li><i class="fas fa-check text-success"></i> Se mantiene el historial completo de navegación</li>
            <li><i class="fas fa-check text-success"></i> Los datos persisten durante toda tu sesión</li>
            <li><i class="fas fa-check text-success"></i> Puedes reiniciar o destruir la sesión cuando quieras</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
