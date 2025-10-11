<?php
session_start();

// Verificar si existen las variables de sesión
$session_exists = isset($_SESSION['usuario']) && isset($_SESSION['clave']);

// Información adicional de la sesión
$session_id = session_id();
$session_name = session_name();
$session_vars_count = count($_SESSION);
$tiempo_sesion = isset($_SESSION['fecha_login']) ? $_SESSION['fecha_login'] : 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Variables de Sesión - Ejercicio 5</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 900px;
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
      background: linear-gradient(45deg, #6f42c1, #e83e8c);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .header p {
      font-size: 1.2em;
      opacity: 0.9;
    }

    .content {
      padding: 40px;
    }

    .status-section {
      margin-bottom: 30px;
    }

    .success-status {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 25px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
      margin-bottom: 30px;
    }

    .error-status {
      background: linear-gradient(45deg, #dc3545, #c82333);
      color: white;
      padding: 25px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
      margin-bottom: 30px;
    }

    .session-details {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #6f42c1;
    }

    .session-details h3 {
      color: #6f42c1;
      margin-bottom: 20px;
      font-size: 1.5em;
    }

    .session-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 25px;
    }

    .session-item {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .session-item:hover {
      transform: translateY(-3px);
    }

    .session-label {
      font-weight: bold;
      color: #6f42c1;
      margin-bottom: 8px;
      font-size: 0.95em;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .session-value {
      color: #333;
      font-family: monospace;
      background: #e9ecef;
      padding: 8px 12px;
      border-radius: 6px;
      word-break: break-all;
      font-size: 1em;
    }

    .session-value.password {
      letter-spacing: 3px;
      font-size: 1.2em;
    }

    .technical-info {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border: 1px solid #b8daff;
    }

    .technical-info h4 {
      color: #0c5460;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .tech-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }

    .tech-item {
      background: white;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
    }

    .explanation {
      background: #fff3cd;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border: 1px solid #ffeaa7;
    }

    .explanation h4 {
      color: #856404;
      margin-bottom: 15px;
      font-size: 1.2em;
    }

    .explanation p {
      color: #856404;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    .actions {
      text-align: center;
      margin-top: 30px;
    }

    .btn {
      display: inline-block;
      padding: 15px 30px;
      margin: 0 10px 10px 10px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1em;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .btn-primary {
      background: linear-gradient(45deg, #6f42c1, #e83e8c);
      color: white;
      box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(111, 66, 193, 0.4);
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

    .all-session-vars {
      background: #f1f3f4;
      padding: 20px;
      border-radius: 10px;
      margin-top: 20px;
    }

    .all-session-vars h5 {
      color: #333;
      margin-bottom: 15px;
    }

    .session-dump {
      background: #2d3748;
      color: #e2e8f0;
      padding: 15px;
      border-radius: 8px;
      font-family: 'Courier New', monospace;
      font-size: 0.9em;
      overflow-x: auto;
      white-space: pre-wrap;
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2em;
      }

      .content {
        padding: 25px;
      }

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }

      .session-grid,
      .tech-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📊 Variables de Sesión</h1>
      <p>Página 3 - Recuperación de Datos de Sesión</p>
    </div>

    <div class="content">
      <div class="status-section">
        <?php if ($session_exists): ?>
          <div class="success-status">
            <h3>✅ ¡Variables de Sesión Encontradas!</h3>
            <p>Se han recuperado exitosamente los datos almacenados en la sesión.</p>
          </div>
        <?php else: ?>
          <div class="error-status">
            <h3>❌ No hay Variables de Sesión</h3>
            <p>No se encontraron datos de sesión. Debes iniciar sesión primero.</p>
          </div>
        <?php endif; ?>
      </div>

      <?php if ($session_exists): ?>
        <div class="session-details">
          <h3>🔍 Datos Recuperados de la Sesión</h3>
          <p>Los siguientes valores fueron almacenados y ahora han sido recuperados:</p>

          <div class="session-grid">
            <div class="session-item">
              <div class="session-label">👤 Usuario</div>
              <div class="session-value"><?php echo htmlspecialchars($_SESSION['usuario']); ?></div>
            </div>

            <div class="session-item">
              <div class="session-label">🔑 Contraseña</div>
              <div class="session-value password"><?php echo str_repeat('●', strlen($_SESSION['clave'])); ?></div>
            </div>

            <div class="session-item">
              <div class="session-label">📅 Fecha de Login</div>
              <div class="session-value"><?php echo htmlspecialchars($tiempo_sesion); ?></div>
            </div>

            <div class="session-item">
              <div class="session-label">🌐 IP del Cliente</div>
              <div class="session-value"><?php echo htmlspecialchars($_SESSION['ip_cliente'] ?? 'No disponible'); ?></div>
            </div>

            <div class="session-item">
              <div class="session-label">🆔 ID de Sesión</div>
              <div class="session-value"><?php echo $session_id; ?></div>
            </div>

            <div class="session-item">
              <div class="session-label">📝 Nombre de Sesión</div>
              <div class="session-value"><?php echo $session_name; ?></div>
            </div>
          </div>

          <div class="all-session-vars">
            <h5>🗂️ Todas las Variables de Sesión ($_SESSION):</h5>
            <div class="session-dump"><?php
                                      $session_copy = $_SESSION;
                                      // Ocultar la contraseña en el dump por seguridad
                                      if (isset($session_copy['clave'])) {
                                        $session_copy['clave'] = str_repeat('*', strlen($session_copy['clave']));
                                      }
                                      echo htmlspecialchars(print_r($session_copy, true));
                                      ?></div>
          </div>
        </div>
      <?php endif; ?>

      <div class="technical-info">
        <h4>⚙️ Información Técnica de la Sesión</h4>

        <div class="tech-grid">
          <div class="tech-item">
            <div class="session-label">Estado de Sesión</div>
            <div class="session-value"><?php echo $session_exists ? 'Activa' : 'No iniciada'; ?></div>
          </div>

          <div class="tech-item">
            <div class="session-label">Variables Almacenadas</div>
            <div class="session-value"><?php echo $session_vars_count; ?></div>
          </div>

          <div class="tech-item">
            <div class="session-label">Fecha Actual</div>
            <div class="session-value"><?php echo date('Y-m-d H:i:s'); ?></div>
          </div>

          <div class="tech-item">
            <div class="session-label">Función Utilizada</div>
            <div class="session-value">isset($_SESSION['variable'])</div>
          </div>
        </div>
      </div>

      <div class="explanation">
        <h4>💡 ¿Cómo Funcionan las Variables de Sesión?</h4>
        <p><strong>1. Creación:</strong> En la página anterior se utilizó <code>$_SESSION['variable'] = 'valor'</code> para almacenar datos.</p>
        <p><strong>2. Persistencia:</strong> Los datos se mantienen en el servidor hasta que la sesión expire o se cierre.</p>
        <p><strong>3. Recuperación:</strong> Esta página utiliza <code>isset($_SESSION['variable'])</code> para verificar si existen.</p>
        <p><strong>4. Acceso:</strong> Los valores se obtienen directamente con <code>$_SESSION['variable']</code>.</p>
        <p><strong>5. Seguridad:</strong> Los datos permanecen en el servidor, no en el navegador del usuario.</p>
      </div>

      <div class="actions">
        <?php if ($session_exists): ?>
          <a href="procesar_login.php" class="btn btn-success">
            ⬅️ Página Anterior
          </a>
          <a href="cerrar_sesion.php" class="btn btn-danger">
            🚪 Cerrar Sesión
          </a>
        <?php else: ?>
          <a href="index.php" class="btn btn-primary">
            🔐 Ir al Login
          </a>
        <?php endif; ?>

        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>
</body>

</html>