<?php
session_start();

// Verificar si hay historial de búsquedas
$hay_historial = isset($_SESSION['historial_busquedas']) && !empty($_SESSION['historial_busquedas']);

// Acción para limpiar historial
if (isset($_POST['accion']) && $_POST['accion'] === 'limpiar_historial') {
  $_SESSION['historial_busquedas'] = array();
  $hay_historial = false;
  $mensaje_limpieza = "¡Historial de búsquedas limpiado exitosamente!";
}

// Calcular estadísticas
$total_busquedas = $hay_historial ? count($_SESSION['historial_busquedas']) : 0;
$busquedas_exitosas = 0;
$matriculas_buscadas = array();
$emails_encontrados = array();

if ($hay_historial) {
  foreach ($_SESSION['historial_busquedas'] as $busqueda) {
    if ($busqueda['encontrado']) {
      $busquedas_exitosas++;
      $emails_encontrados[] = $busqueda['email'];
    }
    $matriculas_buscadas[] = $busqueda['matricula'];
  }

  // Eliminar duplicados para estadísticas
  $matriculas_unicas = array_unique($matriculas_buscadas);
  $emails_unicos = array_unique($emails_encontrados);
}

// Ordenar historial por fecha más reciente
if ($hay_historial) {
  $_SESSION['historial_busquedas'] = array_reverse($_SESSION['historial_busquedas']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Búsquedas - Ejercicio 6</title>
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
      animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.8em;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .header p {
      font-size: 1.3em;
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
      animation: fadeIn 0.5s ease-out;
    }

    .alert-success {
      background: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    .alert-info {
      background: #cce7ff;
      border-color: #667eea;
      color: #0c5460;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .stats-section {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      border-left: 5px solid #667eea;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .stat-card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }

    .stat-number {
      font-size: 2.5em;
      font-weight: bold;
      color: #667eea;
      margin-bottom: 10px;
    }

    .stat-label {
      color: #666;
      font-size: 0.95em;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 500;
    }

    .stat-description {
      color: #888;
      font-size: 0.8em;
      margin-top: 5px;
      line-height: 1.4;
    }

    .historial-section {
      background: white;
      padding: 0;
      border-radius: 15px;
      margin-bottom: 30px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .historial-header {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 25px 30px;
      text-align: center;
    }

    .historial-header h3 {
      font-size: 1.6em;
      margin-bottom: 10px;
    }

    .historial-content {
      padding: 30px;
    }

    .historial-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }

    .historial-table th,
    .historial-table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    .historial-table th {
      background: #667eea;
      color: white;
      font-weight: bold;
      font-size: 0.9em;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .historial-table tr:hover {
      background: #f8f9fa;
    }

    .historial-table tr:nth-child(even) {
      background: #f8f9fa;
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8em;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .status-found {
      background: #d4edda;
      color: #155724;
    }

    .status-not-found {
      background: #f8d7da;
      color: #721c24;
    }

    .email-cell {
      font-family: monospace;
      background: #e9ecef;
      padding: 8px 12px;
      border-radius: 6px;
      display: inline-block;
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .no-history {
      text-align: center;
      padding: 60px 30px;
      color: #666;
    }

    .no-history-icon {
      font-size: 4em;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .no-history h3 {
      margin-bottom: 15px;
      color: #333;
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

    .btn-danger {
      background: linear-gradient(45deg, #dc3545, #c82333);
      color: white;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
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

    .actions {
      text-align: center;
      margin-top: 30px;
    }

    .session-info {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border-left: 5px solid #4facfe;
    }

    .session-info h4 {
      color: #0c5460;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .session-info p {
      color: #0c5460;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2.2em;
      }

      .content {
        padding: 25px;
      }

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }

      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      }

      .historial-table {
        font-size: 0.8em;
      }

      .historial-table th,
      .historial-table td {
        padding: 10px 8px;
      }

      .email-cell {
        max-width: 120px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📈 Historial de Búsquedas</h1>
      <p>Seguimiento de Consultas de Email Estudiantiles</p>
    </div>

    <div class="content">
      <?php if (isset($mensaje_limpieza)): ?>
        <div class="alert alert-success">
          <strong>✅ Éxito:</strong> <?php echo $mensaje_limpieza; ?>
        </div>
      <?php endif; ?>

      <div class="session-info">
        <h4>🔄 Información de Sesión</h4>
        <p>
          <strong>ID de Sesión:</strong> <?php echo session_id(); ?>
        </p>
        <p>
          <strong>Sesión Iniciada:</strong>
          <?php echo isset($_SESSION['historial_busquedas']) ? 'Sí' : 'No'; ?>
        </p>
        <p>
          Este historial se mantiene durante tu sesión actual utilizando la variable superglobal $_SESSION de PHP.
          Cuando cierres el navegador o la sesión expire, este historial se perderá.
        </p>
      </div>

      <?php if ($hay_historial): ?>
        <!-- Estadísticas -->
        <div class="stats-section">
          <h3 style="color: #333; margin-bottom: 20px;">📊 Estadísticas de tus Búsquedas</h3>

          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-number"><?php echo $total_busquedas; ?></div>
              <div class="stat-label">Total Búsquedas</div>
              <div class="stat-description">Consultas realizadas en esta sesión</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo $busquedas_exitosas; ?></div>
              <div class="stat-label">Estudiantes Encontrados</div>
              <div class="stat-description">Búsquedas con resultado positivo</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo $total_busquedas - $busquedas_exitosas; ?></div>
              <div class="stat-label">Sin Resultado</div>
              <div class="stat-description">Matrículas no encontradas</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo count($matriculas_unicas); ?></div>
              <div class="stat-label">Matrículas Únicas</div>
              <div class="stat-description">Estudiantes diferentes buscados</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo count($emails_unicos); ?></div>
              <div class="stat-label">Emails Únicos</div>
              <div class="stat-description">Correos diferentes encontrados</div>
            </div>

            <div class="stat-card">
              <div class="stat-number"><?php echo round(($busquedas_exitosas / $total_busquedas) * 100); ?>%</div>
              <div class="stat-label">Tasa de Éxito</div>
              <div class="stat-description">Porcentaje de búsquedas exitosas</div>
            </div>
          </div>
        </div>

        <!-- Historial detallado -->
        <div class="historial-section">
          <div class="historial-header">
            <h3>📋 Historial Detallado de Búsquedas</h3>
            <p>Registro cronológico de todas las consultas realizadas</p>
          </div>

          <div class="historial-content">
            <div style="overflow-x: auto;">
              <table class="historial-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Matrícula</th>
                    <th>Estudiante</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Fecha/Hora</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($_SESSION['historial_busquedas'] as $index => $busqueda): ?>
                    <tr>
                      <td><strong><?php echo $index + 1; ?></strong></td>
                      <td>
                        <strong><?php echo htmlspecialchars($busqueda['matricula']); ?></strong>
                      </td>
                      <td>
                        <?php echo htmlspecialchars($busqueda['nombre_completo']); ?>
                      </td>
                      <td>
                        <?php if ($busqueda['encontrado']): ?>
                          <span class="email-cell"><?php echo htmlspecialchars($busqueda['email']); ?></span>
                        <?php else: ?>
                          <em style="color: #999;">No disponible</em>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="status-badge <?php echo $busqueda['encontrado'] ? 'status-found' : 'status-not-found'; ?>">
                          <?php echo $busqueda['encontrado'] ? '✅ Encontrado' : '❌ No encontrado'; ?>
                        </span>
                      </td>
                      <td>
                        <?php echo date('d/m/Y H:i:s', strtotime($busqueda['fecha_busqueda'])); ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      <?php else: ?>
        <!-- Sin historial -->
        <div class="historial-section">
          <div class="no-history">
            <div class="no-history-icon">📭</div>
            <h3>No hay búsquedas en tu historial</h3>
            <p>Aún no has realizado ninguna búsqueda de estudiantes en esta sesión.</p>
            <p>¡Comienza a buscar emails para ver tu historial aquí!</p>
          </div>
        </div>
      <?php endif; ?>

      <div class="actions">
        <a href="buscar_email.php" class="btn btn-primary">
          🔍 Realizar Nueva Búsqueda
        </a>

        <a href="index.php" class="btn btn-success">
          ← Volver al Inicio
        </a>

        <?php if ($hay_historial): ?>
          <form method="POST" style="display: inline;">
            <input type="hidden" name="accion" value="limpiar_historial">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas limpiar todo el historial?')">
              🗑️ Limpiar Historial
            </button>
          </form>
        <?php endif; ?>

        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>

  <script>
    // Animación de entrada para las tarjetas de estadísticas
    window.addEventListener('load', function() {
      const statCards = document.querySelectorAll('.stat-card');
      statCards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          card.style.transition = 'all 0.5s ease';

          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 100);
      });

      // Animación para las filas de la tabla
      const tableRows = document.querySelectorAll('.historial-table tbody tr');
      tableRows.forEach((row, index) => {
        setTimeout(() => {
          row.style.opacity = '0';
          row.style.transform = 'translateX(-20px)';
          row.style.transition = 'all 0.4s ease';

          setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
          }, 50);
        }, index * 50);
      });
    });
  </script>
</body>

</html>