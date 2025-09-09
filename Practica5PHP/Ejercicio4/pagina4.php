<?php

declare(strict_types=1);

require_once 'ContadorSesion.php';

$contador = new ContadorSesion();
$contador->contarVisita('Página 4 - Ciencia', '/Ejercicio4/pagina4.php');

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página 4 - Configuración | Contador de Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }

    .page-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }

    .page-header {
      background: linear-gradient(135deg, #6f42c1, #e83e8c);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .page-content {
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

    .config-card {
      background: linear-gradient(135deg, #f8d7da, #f5c6cb);
      border-radius: 15px;
      padding: 25px;
      margin: 20px 0;
      border-left: 5px solid #6f42c1;
    }

    .setting-item {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 15px;
      margin: 10px 0;
      border-left: 3px solid #6f42c1;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="page-card">
      <div class="page-header">
        <h1><i class="fas fa-cog"></i> Página 4 - Configuración</h1>
        <p>Panel de configuración y ajustes del sistema</p>
      </div>

      <div class="page-content">
        <div class="text-center mb-4">
          <div class="counter-badge">
            <i class="fas fa-eye"></i> Páginas visitadas: <?= $contador->obtenerContador() ?>
          </div>
        </div>

        <h3><i class="fas fa-sliders-h"></i> Configuración del Sistema</h3>
        <p>Esta página simula un panel de configuración donde los usuarios podrían ajustar diferentes opciones del sistema.</p>

        <div class="config-card">
          <h4><i class="fas fa-tools"></i> Configuraciones de Sesión</h4>
          <p>Desde aquí podrías controlar diferentes aspectos del contador de páginas:</p>

          <div class="setting-item">
            <h6><i class="fas fa-eye"></i> Contador de Páginas</h6>
            <p><strong>Estado:</strong> Activo | <strong>Páginas contadas:</strong> <?= $contador->obtenerContador() ?></p>
          </div>

          <div class="setting-item">
            <h6><i class="fas fa-clock"></i> Duración de Sesión</h6>
            <p><strong>Tiempo actual:</strong> <?= $contador->obtenerTiempoSesionFormateado() ?></p>
          </div>

          <div class="setting-item">
            <h6><i class="fas fa-history"></i> Historial</h6>
            <p><strong>Visitas registradas:</strong> <?= count($contador->obtenerHistorial()) ?></p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <h5>Opciones disponibles:</h5>
            <ul>
              <li><i class="fas fa-redo"></i> Reiniciar contador de páginas</li>
              <li><i class="fas fa-trash"></i> Limpiar historial de navegación</li>
              <li><i class="fas fa-download"></i> Exportar estadísticas</li>
              <li><i class="fas fa-chart-bar"></i> Ver estadísticas detalladas</li>
            </ul>
          </div>
          <div class="col-md-6">
            <h5>Información técnica:</h5>
            <ul>
              <li><strong>Versión PHP:</strong> <?= PHP_VERSION ?></li>
              <li><strong>ID de Sesión:</strong> <?= session_id() ?></li>
              <li><strong>Última visita:</strong> <?= date('H:i:s') ?></li>
              <li><strong>Servidor:</strong> <?= $_SERVER['SERVER_NAME'] ?? 'localhost' ?></li>
            </ul>
          </div>
        </div>

        <div class="config-card">
          <h4><i class="fas fa-exclamation-triangle"></i> Acciones de Sesión</h4>
          <p>Utiliza estas opciones para gestionar tu sesión actual:</p>
          <div class="text-center">
            <a href="index.php?accion=reiniciar" class="btn btn-warning me-2"
              onclick="return confirm('¿Reiniciar el contador de páginas?')">
              <i class="fas fa-redo"></i> Reiniciar Contador
            </a>
            <a href="index.php?accion=destruir" class="btn btn-danger"
              onclick="return confirm('¿Destruir completamente la sesión?')">
              <i class="fas fa-trash"></i> Destruir Sesión
            </a>
          </div>
        </div>

        <hr>

        <h4><i class="fas fa-compass"></i> Navegación</h4>
        <p>Explora las otras secciones del sitio:</p>

        <div class="text-center">
          <a href="index.php" class="nav-btn">
            <i class="fas fa-chart-line"></i> Dashboard Principal
          </a>
          <a href="pagina1.php" class="nav-btn">
            <i class="fas fa-home"></i> Página 1 (Inicio)
          </a>
          <a href="pagina2.php" class="nav-btn">
            <i class="fas fa-info-circle"></i> Página 2 (Acerca de)
          </a>
          <a href="pagina3.php" class="nav-btn">
            <i class="fas fa-envelope"></i> Página 3 (Contacto)
          </a>
          <a href="estadisticas.php" class="nav-btn">
            <i class="fas fa-chart-bar"></i> Estadísticas
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>