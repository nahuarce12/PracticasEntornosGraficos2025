<?php

declare(strict_types=1);

require_once 'database.php';

$database = new Database();
$ciudades = [];
$error = '';

// Configuración de paginación
$registrosPorPagina = 5;
$paginaActual = (int)($_GET['pagina'] ?? 1);
$paginaActual = max(1, $paginaActual); // Asegurar que sea al menos 1

$inicio = ($paginaActual - 1) * $registrosPorPagina;

// Obtener el total de registros
$totalRegistros = 0;
try {
  $conn = $database->getConnection();
  $countQuery = "SELECT COUNT(*) as total FROM ciudades";
  $countResult = $conn->query($countQuery);
  if ($countResult) {
    $countRow = $countResult->fetch_assoc();
    $totalRegistros = (int)$countRow['total'];
    $countResult->free();
  }
} catch (Exception $e) {
  $error = 'Error al contar las ciudades: ' . $e->getMessage();
}

$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener ciudades de la página actual
if ($totalRegistros > 0) {
  try {
    $query = "SELECT id, ciudad, pais, habitantes, superficie, tieneMetro 
                  FROM ciudades 
                  ORDER BY ciudad ASC 
                  LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $registrosPorPagina, $inicio);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($fila = $result->fetch_assoc()) {
      $ciudades[] = $fila;
    }
    $stmt->close();
  } catch (Exception $e) {
    $error = 'Error al cargar las ciudades: ' . $e->getMessage();
  }
}

// Calcular rangos para la navegación
$rangoInicio = max(1, $paginaActual - 2);
$rangoFin = min($totalPaginas, $paginaActual + 2);

// Información de registros mostrados
$primerRegistro = $inicio + 1;
$ultimoRegistro = min($inicio + $registrosPorPagina, $totalRegistros);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado Paginado - ABML Ciudades</title>
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

    .pagination-info {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
    }

    .pagination-info h3 {
      color: #333;
      margin-bottom: 10px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .info-item {
      background: white;
      padding: 12px;
      border-radius: 8px;
      border-left: 4px solid #007bff;
    }

    .info-number {
      font-size: 1.2rem;
      font-weight: bold;
      color: #007bff;
    }

    .info-label {
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
      margin: 20px 0;
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
      background: linear-gradient(45deg, #007bff, #0056b3);
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

    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin: 30px 0;
      flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
      display: inline-block;
      padding: 8px 12px;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s;
    }

    .pagination a {
      background: #fff;
      color: #007bff;
    }

    .pagination a:hover {
      background: #007bff;
      color: white;
      transform: translateY(-1px);
    }

    .pagination .current {
      background: #007bff;
      color: white;
      border-color: #007bff;
    }

    .pagination .disabled {
      background: #f8f9fa;
      color: #6c757d;
      border-color: #dee2e6;
      cursor: not-allowed;
    }

    .no-cities {
      text-align: center;
      color: #666;
      font-style: italic;
      margin: 40px 0;
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

      .info-grid {
        grid-template-columns: 1fr;
      }

      .pagination {
        gap: 5px;
      }

      .pagination a,
      .pagination span {
        padding: 6px 10px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📄 Listado Paginado</h1>
      <a href="index.php" class="back-link">← Volver al Menú</a>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($totalRegistros > 0): ?>
      <div class="pagination-info">
        <h3>📊 Información de Paginación</h3>
        <div class="info-grid">
          <div class="info-item">
            <div class="info-number"><?php echo $totalRegistros; ?></div>
            <div class="info-label">Total Registros</div>
          </div>
          <div class="info-item">
            <div class="info-number"><?php echo $paginaActual; ?></div>
            <div class="info-label">Página Actual</div>
          </div>
          <div class="info-item">
            <div class="info-number"><?php echo $totalPaginas; ?></div>
            <div class="info-label">Total Páginas</div>
          </div>
          <div class="info-item">
            <div class="info-number"><?php echo $registrosPorPagina; ?></div>
            <div class="info-label">Por Página</div>
          </div>
          <div class="info-item">
            <div class="info-number"><?php echo "{$primerRegistro}-{$ultimoRegistro}"; ?></div>
            <div class="info-label">Mostrando</div>
          </div>
        </div>
      </div>

      <!-- Paginación superior -->
      <?php if ($totalPaginas > 1): ?>
        <div class="pagination">
          <?php if ($paginaActual > 1): ?>
            <a href="?pagina=1">« Primera</a>
            <a href="?pagina=<?php echo ($paginaActual - 1); ?>">‹ Anterior</a>
          <?php else: ?>
            <span class="disabled">« Primera</span>
            <span class="disabled">‹ Anterior</span>
          <?php endif; ?>

          <?php for ($i = $rangoInicio; $i <= $rangoFin; $i++): ?>
            <?php if ($i == $paginaActual): ?>
              <span class="current"><?php echo $i; ?></span>
            <?php else: ?>
              <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
          <?php endfor; ?>

          <?php if ($paginaActual < $totalPaginas): ?>
            <a href="?pagina=<?php echo ($paginaActual + 1); ?>">Siguiente ›</a>
            <a href="?pagina=<?php echo $totalPaginas; ?>">Última »</a>
          <?php else: ?>
            <span class="disabled">Siguiente ›</span>
            <span class="disabled">Última »</span>
          <?php endif; ?>
        </div>
      <?php endif; ?>

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

      <!-- Paginación inferior -->
      <?php if ($totalPaginas > 1): ?>
        <div class="pagination">
          <?php if ($paginaActual > 1): ?>
            <a href="?pagina=1">« Primera</a>
            <a href="?pagina=<?php echo ($paginaActual - 1); ?>">‹ Anterior</a>
          <?php else: ?>
            <span class="disabled">« Primera</span>
            <span class="disabled">‹ Anterior</span>
          <?php endif; ?>

          <?php for ($i = $rangoInicio; $i <= $rangoFin; $i++): ?>
            <?php if ($i == $paginaActual): ?>
              <span class="current"><?php echo $i; ?></span>
            <?php else: ?>
              <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
          <?php endfor; ?>

          <?php if ($paginaActual < $totalPaginas): ?>
            <a href="?pagina=<?php echo ($paginaActual + 1); ?>">Siguiente ›</a>
            <a href="?pagina=<?php echo $totalPaginas; ?>">Última »</a>
          <?php else: ?>
            <span class="disabled">Siguiente ›</span>
            <span class="disabled">Última »</span>
          <?php endif; ?>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <div class="no-cities">
        <h3>No hay ciudades registradas</h3>
        <p>Puede agregar ciudades usando la opción "Alta" del menú principal.</p>
      </div>
    <?php endif; ?>

    <div class="actions-section">
      <a href="listado.php" class="btn btn-success">📋 Ver Listado Completo</a>
      <a href="alta.php" class="btn btn-primary">➕ Agregar Nueva Ciudad</a>
    </div>
  </div>
</body>

</html>