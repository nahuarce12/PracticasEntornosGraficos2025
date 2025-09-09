<?php

declare(strict_types=1);

require_once 'ContadorSesion.php';

$contador = new ContadorSesion();
$contador->contarVisita('Página 1 - Tecnología', '/Ejercicio4/pagina1.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página 1 - Inicio | Contador de Sesión</title>
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
      background: linear-gradient(135deg, #28a745, #20c997);
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
  </style>
</head>

<body>
  <div class="container">
    <div class="page-card">
      <div class="page-header">
        <h1><i class="fas fa-home"></i> Página 1 - Inicio</h1>
        <p>Esta es la primera página de ejemplo para probar el contador</p>
      </div>

      <div class="page-content">
        <div class="text-center mb-4">
          <div class="counter-badge">
            <i class="fas fa-eye"></i> Páginas visitadas: <?= $contador->obtenerContador() ?>
          </div>
        </div>

        <h3><i class="fas fa-info-circle"></i> Bienvenido a la Página de Inicio</h3>
        <p>Esta es una página de ejemplo para demostrar cómo funciona el contador de páginas visitadas durante la sesión del usuario.</p>

        <div class="row">
          <div class="col-md-6">
            <h5>Características de esta página:</h5>
            <ul>
              <li>Página principal del sitio</li>
              <li>Información general</li>
              <li>Enlaces de navegación</li>
              <li>Contador de visitas actualizado</li>
            </ul>
          </div>
          <div class="col-md-6">
            <h5>Información de sesión:</h5>
            <ul>
              <li><strong>Páginas visitadas:</strong> <?= $contador->obtenerContador() ?></li>
              <li><strong>Tiempo de sesión:</strong> <?= $contador->obtenerTiempoSesionFormateado() ?></li>
              <li><strong>Total de visitas:</strong> <?= count($contador->obtenerHistorial()) ?></li>
            </ul>
          </div>
        </div>

        <hr>

        <h4><i class="fas fa-compass"></i> Navegación</h4>
        <p>Continúa navegando por las diferentes páginas para ver cómo aumenta el contador:</p>

        <div class="text-center">
          <a href="index.php" class="nav-btn">
            <i class="fas fa-chart-line"></i> Volver al Dashboard
          </a>
          <a href="pagina2.php" class="nav-btn">
            <i class="fas fa-info-circle"></i> Página 2 (Acerca de)
          </a>
          <a href="pagina3.php" class="nav-btn">
            <i class="fas fa-envelope"></i> Página 3 (Contacto)
          </a>
          <a href="pagina4.php" class="nav-btn">
            <i class="fas fa-cog"></i> Página 4 (Configuración)
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