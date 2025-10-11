<?php

declare(strict_types=1);

require_once 'database.php';

$database = new Database();
$ciudades = [];
$error = '';

// Obtener todas las ciudades
try {
  $conn = $database->getConnection();
  $query = "SELECT id, ciudad, pais, habitantes, superficie, tieneMetro FROM ciudades ORDER BY ciudad ASC";
  $result = $conn->query($query);

  if ($result) {
    while ($fila = $result->fetch_assoc()) {
      $ciudades[] = $fila;
    }
    $result->free();
  }
} catch (Exception $e) {
  $error = 'Error al cargar las ciudades: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de Ciudades - ABML Ciudades</title>
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

    .stats {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 30px;
      text-align: center;
    }

    .stats h3 {
      color: #333;
      margin-bottom: 10px;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 15px;
    }

    .stat-item {
      background: white;
      padding: 15px;
      border-radius: 8px;
      border-left: 4px solid #667eea;
    }

    .stat-number {
      font-size: 1.5rem;
      font-weight: bold;
      color: #667eea;
    }

    .stat-label {
      color: #666;
      font-size: 0.9rem;
    }

    .alert {
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-weight: 500;
    }

    .alert-error {
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
    }

    .table-container {
      overflow-x: auto;
      margin-top: 20px;
    }

    .cities-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .cities-table th {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 15px;
      text-align: left;
      font-weight: 600;
    }

    .cities-table td {
      padding: 15px;
      border-bottom: 1px solid #e9ecef;
      vertical-align: middle;
    }

    .cities-table tr:hover {
      background-color: #f8f9fa;
    }

    .cities-table tr:last-child td {
      border-bottom: none;
    }

    .metro-badge {
      display: inline-block;
      background: #28a745;
      color: white;
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .no-metro-badge {
      display: inline-block;
      background: #6c757d;
      color: white;
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    .city-name {
      font-weight: 600;
      color: #333;
    }

    .country-name {
      color: #666;
      font-style: italic;
    }

    .number-cell {
      text-align: right;
      font-family: 'Courier New', monospace;
    }

    .no-cities {
      text-align: center;
      color: #666;
      font-style: italic;
      margin-top: 40px;
    }

    .actions-section {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
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

    .btn-success {
      background: #28a745;
      color: white;
    }

    .btn-success:hover {
      background: #218838;
    }

    .btn-warning {
      background: #ffc107;
      color: #212529;
    }

    .btn-warning:hover {
      background: #e0a800;
    }

    .btn-danger {
      background: #dc3545;
      color: white;
    }

    .btn-danger:hover {
      background: #c82333;
    }

    @media (max-width: 768px) {
      .container {
        margin: 10px;
        padding: 20px;
      }

      .cities-table th,
      .cities-table td {
        padding: 10px 8px;
        font-size: 0.9rem;
      }

      .actions-section {
        flex-direction: column;
      }

      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📋 Listado de Ciudades</h1>
      <a href="index.php" class="back-link">← Volver al Menú</a>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($ciudades)): ?>
      <?php
      // Calcular estadísticas
      $totalCiudades = count($ciudades);
      $totalHabitantes = array_sum(array_map(function ($ciudad) {
        return (int)$ciudad['habitantes'];
      }, $ciudades));
      $totalSuperficie = array_sum(array_map(function ($ciudad) {
        return (float)$ciudad['superficie'];
      }, $ciudades));
      $ciudadesConMetro = count(array_filter($ciudades, function ($c) {
        return $c['tieneMetro'];
      }));
      $paises = array_unique(array_column($ciudades, 'pais'));
      $totalPaises = count($paises);
      ?>

      <div class="stats">
        <h3>📊 Estadísticas Generales</h3>
        <div class="stats-grid">
          <div class="stat-item">
            <div class="stat-number"><?php echo number_format($totalCiudades); ?></div>
            <div class="stat-label">Total de Ciudades</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"><?php echo $totalPaises; ?></div>
            <div class="stat-label">Países Representados</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"><?php echo number_format($totalHabitantes); ?></div>
            <div class="stat-label">Total de Habitantes</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"><?php echo number_format($totalSuperficie, 2); ?></div>
            <div class="stat-label">Superficie Total (km²)</div>
          </div>
          <div class="stat-item">
            <div class="stat-number"><?php echo $ciudadesConMetro; ?></div>
            <div class="stat-label">Ciudades con Metro</div>
          </div>
        </div>
      </div>

      <div class="table-container">
        <table class="cities-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Ciudad</th>
              <th>País</th>
              <th>Habitantes</th>
              <th>Superficie (km²)</th>
              <th>Metro</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ciudades as $ciudad): ?>
              <tr>
                <td class="number-cell"><?php echo $ciudad['id']; ?></td>
                <td class="city-name"><?php echo htmlspecialchars($ciudad['ciudad']); ?></td>
                <td class="country-name"><?php echo htmlspecialchars($ciudad['pais']); ?></td>
                <td class="number-cell"><?php echo number_format((int)$ciudad['habitantes']); ?></td>
                <td class="number-cell"><?php echo number_format((float)$ciudad['superficie'], 2); ?></td>
                <td>
                  <?php if ($ciudad['tieneMetro']): ?>
                    <span class="metro-badge">🚇 Sí</span>
                  <?php else: ?>
                    <span class="no-metro-badge">🚌 No</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="no-cities">
        <h3>No hay ciudades registradas</h3>
        <p>Puede agregar ciudades usando la opción "Alta" del menú principal.</p>
      </div>
    <?php endif; ?>

    <div class="actions-section">
      <a href="alta.php" class="btn btn-success">➕ Agregar Nueva Ciudad</a>
      <a href="modificacion.php" class="btn btn-warning">✏️ Modificar Ciudad</a>
      <a href="baja.php" class="btn btn-danger">🗑️ Eliminar Ciudad</a>
      <a href="listado_paginado.php" class="btn btn-primary">📄 Ver con Paginación</a>
    </div>
  </div>
</body>

</html>