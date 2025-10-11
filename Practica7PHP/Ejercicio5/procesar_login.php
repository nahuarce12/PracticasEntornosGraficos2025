<?php
session_start();

// Verificar que se hayan enviado los datos por POST
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['usuario']) || !isset($_POST['clave'])) {
  header('Location: index.php');
  exit();
}

// Obtener y sanitizar los datos del formulario
$usuario = trim($_POST['usuario']);
$clave = trim($_POST['clave']);

// Validar que los campos no estén vacíos
if (empty($usuario) || empty($clave)) {
  $error = "Todos los campos son obligatorios.";
} elseif (strlen($usuario) < 3) {
  $error = "El nombre de usuario debe tener al menos 3 caracteres.";
} elseif (strlen($clave) < 4) {
  $error = "La contraseña debe tener al menos 4 caracteres.";
} else {
  // Crear las variables de sesión
  $_SESSION['usuario'] = $usuario;
  $_SESSION['clave'] = $clave;
  $_SESSION['fecha_login'] = date('Y-m-d H:i:s');
  $_SESSION['ip_cliente'] = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
  $_SESSION['navegador'] = $_SERVER['HTTP_USER_AGENT'] ?? 'No disponible';

  $success = "Variables de sesión creadas exitosamente.";
}

// Información adicional
$session_id = session_id();
$session_name = session_name();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procesando Login - Ejercicio 5</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      width: 100%;
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
      text-align: center;
      margin-bottom: 30px;
    }

    .icon {
      font-size: 4em;
      margin-bottom: 15px;
    }

    .title {
      color: #333;
      font-size: 2.2em;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .subtitle {
      color: #666;
      font-size: 1.1em;
      font-style: italic;
    }

    .success-message {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 25px;
      border-radius: 15px;
      margin: 25px 0;
      text-align: center;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .error-message {
      background: linear-gradient(45deg, #dc3545, #c82333);
      color: white;
      padding: 25px;
      border-radius: 15px;
      margin: 25px 0;
      text-align: center;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .session-info {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border-left: 5px solid #28a745;
    }

    .session-info h3 {
      color: #155724;
      margin-bottom: 20px;
      font-size: 1.4em;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .info-item {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .info-label {
      font-weight: bold;
      color: #28a745;
      margin-bottom: 5px;
      font-size: 0.9em;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .info-value {
      color: #333;
      font-family: monospace;
      background: #e9ecef;
      padding: 5px 10px;
      border-radius: 4px;
      word-break: break-all;
      font-size: 0.9em;
    }

    .process-steps {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border: 1px solid #b8daff;
    }

    .process-steps h3 {
      color: #0c5460;
      margin-bottom: 20px;
      text-align: center;
    }

    .step {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      padding: 15px;
      background: white;
      border-radius: 8px;
    }

    .step-number {
      background: #17a2b8;
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      margin-right: 15px;
      flex-shrink: 0;
    }

    .step-text {
      color: #0c5460;
      font-weight: 500;
    }

    .step.completed {
      border-left: 4px solid #28a745;
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
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
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

    .btn-danger {
      background: linear-gradient(45deg, #dc3545, #c82333);
      color: white;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
    }

    @media (max-width: 768px) {
      .container {
        padding: 25px;
        margin: 10px;
      }

      .title {
        font-size: 1.8em;
      }

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }

      .info-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="icon"><?php echo isset($error) ? '❌' : '✅'; ?></div>
      <h1 class="title">Procesamiento de Login</h1>
      <p class="subtitle">Página 2 - Creación de Variables de Sesión</p>
    </div>

    <?php if (isset($error)): ?>
      <div class="error-message">
        <h3>❌ Error en el Procesamiento</h3>
        <p><?php echo htmlspecialchars($error); ?></p>
      </div>
    <?php else: ?>
      <div class="success-message">
        <h3>✅ ¡Sesión Iniciada Correctamente!</h3>
        <p><?php echo htmlspecialchars($success); ?></p>
      </div>
    <?php endif; ?>

    <div class="process-steps">
      <h3>🔄 Proceso Completado</h3>

      <div class="step completed">
        <div class="step-number">1</div>
        <div class="step-text">
          <strong>Formulario enviado:</strong> Datos recibidos desde la página anterior
        </div>
      </div>

      <div class="step completed">
        <div class="step-number">2</div>
        <div class="step-text">
          <strong>Validación realizada:</strong> Verificación de campos obligatorios y longitud
        </div>
      </div>

      <?php if (!isset($error)): ?>
        <div class="step completed">
          <div class="step-number">3</div>
          <div class="step-text">
            <strong>Variables de sesión creadas:</strong> Datos almacenados en $_SESSION
          </div>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!isset($error)): ?>
      <div class="session-info">
        <h3>📊 Variables de Sesión Creadas</h3>
        <p>Se han almacenado los siguientes datos en el servidor:</p>

        <div class="info-grid">
          <div class="info-item">
            <div class="info-label">Usuario</div>
            <div class="info-value"><?php echo htmlspecialchars($usuario); ?></div>
          </div>

          <div class="info-item">
            <div class="info-label">Contraseña</div>
            <div class="info-value"><?php echo str_repeat('*', strlen($clave)); ?></div>
          </div>

          <div class="info-item">
            <div class="info-label">Fecha de Login</div>
            <div class="info-value"><?php echo $_SESSION['fecha_login']; ?></div>
          </div>

          <div class="info-item">
            <div class="info-label">IP del Cliente</div>
            <div class="info-value"><?php echo $_SESSION['ip_cliente']; ?></div>
          </div>

          <div class="info-item">
            <div class="info-label">ID de Sesión</div>
            <div class="info-value"><?php echo $session_id; ?></div>
          </div>

          <div class="info-item">
            <div class="info-label">Nombre de Sesión</div>
            <div class="info-value"><?php echo $session_name; ?></div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="actions">
      <?php if (!isset($error)): ?>
        <a href="mostrar_sesion.php" class="btn btn-primary">
          📋 Ver Variables de Sesión
        </a>
      <?php endif; ?>

      <a href="index.php" class="btn btn-secondary">
        🔄 Volver al Login
      </a>

      <?php if (!isset($error)): ?>
        <a href="cerrar_sesion.php" class="btn btn-danger">
          🚪 Cerrar Sesión
        </a>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>