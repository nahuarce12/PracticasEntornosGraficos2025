<?php
// Procesar el formulario si se ha enviado
$mensaje = '';
$tipo_mensaje = '';
$usuario_guardado = '';

// Verificar si hay una cookie existente con el último usuario
if (isset($_COOKIE['ultimo_usuario'])) {
  $usuario_guardado = $_COOKIE['ultimo_usuario'];
}

// Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_usuario'])) {
  $nombre_usuario = trim($_POST['nombre_usuario']);

  // Validar que el nombre no esté vacío
  if (!empty($nombre_usuario)) {
    // Sanitizar el nombre de usuario (remover caracteres especiales)
    $nombre_usuario = filter_var($nombre_usuario, FILTER_SANITIZE_STRING);

    // Crear cookie que expire en 30 días
    $cookie_creada = setcookie('ultimo_usuario', $nombre_usuario, time() + (30 * 24 * 60 * 60), '/');

    if ($cookie_creada) {
      $mensaje = "¡Cookie creada exitosamente! El nombre de usuario '$nombre_usuario' ha sido guardado.";
      $tipo_mensaje = 'success';
      $usuario_guardado = $nombre_usuario; // Actualizar para mostrar inmediatamente
    } else {
      $mensaje = "Error al crear la cookie. Verifique la configuración del servidor.";
      $tipo_mensaje = 'error';
    }
  } else {
    $mensaje = "Por favor, ingrese un nombre de usuario válido.";
    $tipo_mensaje = 'warning';
  }
}

// Limpiar cookie si se solicita
if (isset($_GET['limpiar']) && $_GET['limpiar'] == 'true') {
  setcookie('ultimo_usuario', '', time() - 3600, '/');
  $mensaje = "Cookie eliminada. El formulario ha sido limpiado.";
  $tipo_mensaje = 'info';
  $usuario_guardado = '';
}

// Información adicional
$fecha_actual = date('d/m/Y H:i:s');
$info_cookie = isset($_COOKIE['ultimo_usuario']) ? 'Activa' : 'No existe';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 3 - Formulario con Cookies</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }

    .header {
      background: linear-gradient(45deg, #56ab2f, #a8e6cf);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
      font-weight: 300;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .header p {
      font-size: 1.2em;
      opacity: 0.9;
    }

    .content {
      padding: 40px;
    }

    .message {
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 25px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: slideIn 0.5s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .message.success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .message.error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .message.warning {
      background: #fff3cd;
      color: #856404;
      border: 1px solid #ffeaa7;
    }

    .message.info {
      background: #d1ecf1;
      color: #0c5460;
      border: 1px solid #bee5eb;
    }

    .welcome-section {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #56ab2f;
    }

    .welcome-section h2 {
      color: #333;
      margin-bottom: 15px;
      font-size: 1.5em;
    }

    .last-user {
      background: linear-gradient(45deg, #56ab2f, #a8e6cf);
      color: white;
      padding: 15px 20px;
      border-radius: 10px;
      text-align: center;
      font-size: 1.1em;
      font-weight: bold;
      margin: 15px 0;
      box-shadow: 0 5px 15px rgba(86, 171, 47, 0.3);
    }

    .no-user {
      background: #6c757d;
      color: white;
      padding: 15px 20px;
      border-radius: 10px;
      text-align: center;
      font-style: italic;
      margin: 15px 0;
    }

    .form-section {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .form-section h3 {
      color: #333;
      margin-bottom: 20px;
      font-size: 1.3em;
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
    }

    .form-group input[type="text"] {
      width: 100%;
      padding: 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 1.1em;
      transition: border-color 0.3s ease;
      background: #f8f9fa;
    }

    .form-group input[type="text"]:focus {
      outline: none;
      border-color: #56ab2f;
      background: white;
      box-shadow: 0 0 10px rgba(86, 171, 47, 0.2);
    }

    .form-group small {
      color: #6c757d;
      font-size: 0.9em;
      margin-top: 5px;
      display: block;
    }

    .btn {
      display: inline-block;
      padding: 12px 25px;
      margin: 5px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1em;
      border: none;
      cursor: pointer;
      text-align: center;
    }

    .btn-primary {
      background: linear-gradient(45deg, #56ab2f, #a8e6cf);
      color: white;
      box-shadow: 0 4px 15px rgba(86, 171, 47, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(86, 171, 47, 0.4);
    }

    .btn-danger {
      background: linear-gradient(45deg, #ff4757, #ff3742);
      color: white;
      box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
    }

    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 71, 87, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #747d8c, #57606f);
      color: white;
      box-shadow: 0 4px 15px rgba(116, 125, 140, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(116, 125, 140, 0.4);
    }

    .info-section {
      background: #e8f4f8;
      padding: 20px;
      border-radius: 10px;
      margin: 25px 0;
      border: 1px solid #b8daff;
    }

    .info-section h4 {
      color: #0c5460;
      margin-bottom: 15px;
      font-size: 1.2em;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #d1ecf1;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-label {
      font-weight: bold;
      color: #0c5460;
    }

    .info-value {
      color: #333;
      font-family: monospace;
      background: rgba(255, 255, 255, 0.7);
      padding: 2px 8px;
      border-radius: 4px;
    }

    .actions {
      text-align: center;
      margin-top: 30px;
    }

    .demo-section {
      background: #fff3cd;
      padding: 20px;
      border-radius: 10px;
      margin: 25px 0;
      border: 1px solid #ffeaa7;
    }

    .demo-section h4 {
      color: #856404;
      margin-bottom: 10px;
    }

    .demo-section p {
      color: #856404;
      line-height: 1.5;
    }

    @media (max-width: 768px) {
      .container {
        margin: 10px;
      }

      .content {
        padding: 25px;
      }

      .header h1 {
        font-size: 2em;
      }

      .actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>👤 Formulario de Usuario</h1>
      <p>Ejercicio N°3 - Cookies de Usuario en PHP</p>
    </div>

    <div class="content">
      <?php if (!empty($mensaje)): ?>
        <div class="message <?php echo $tipo_mensaje; ?>">
          <?php
          $iconos = [
            'success' => '✅',
            'error' => '❌',
            'warning' => '⚠️',
            'info' => 'ℹ️'
          ];
          echo $iconos[$tipo_mensaje] ?? '📋';
          ?>
          <?php echo htmlspecialchars($mensaje); ?>
        </div>
      <?php endif; ?>

      <div class="welcome-section">
        <h2>🎯 Estado del Usuario</h2>
        <?php if (!empty($usuario_guardado)): ?>
          <div class="last-user">
            👋 ¡Hola de nuevo, <strong><?php echo htmlspecialchars($usuario_guardado); ?></strong>!
            <br><small>Tu nombre fue guardado en una cookie</small>
          </div>
        <?php else: ?>
          <div class="no-user">
            🆕 No hay usuario previo registrado
            <br><small>Ingresa tu nombre para crear una cookie</small>
          </div>
        <?php endif; ?>
      </div>

      <div class="form-section">
        <h3>📝 Ingresa tu Nombre de Usuario</h3>
        <form method="POST" action="">
          <div class="form-group">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input
              type="text"
              id="nombre_usuario"
              name="nombre_usuario"
              placeholder="Escribe tu nombre de usuario aquí..."
              value="<?php echo htmlspecialchars($usuario_guardado); ?>"
              maxlength="50"
              required>
            <small>El nombre será guardado en una cookie por 30 días</small>
          </div>

          <div style="text-align: center;">
            <button type="submit" class="btn btn-primary">
              🍪 Crear Cookie de Usuario
            </button>
          </div>
        </form>
      </div>

      <div class="info-section">
        <h4>📊 Información de la Cookie</h4>

        <div class="info-item">
          <span class="info-label">Fecha Actual:</span>
          <span class="info-value"><?php echo $fecha_actual; ?></span>
        </div>

        <div class="info-item">
          <span class="info-label">Estado de Cookie:</span>
          <span class="info-value"><?php echo $info_cookie; ?></span>
        </div>

        <div class="info-item">
          <span class="info-label">Último Usuario:</span>
          <span class="info-value">
            <?php echo !empty($usuario_guardado) ? htmlspecialchars($usuario_guardado) : 'Ninguno'; ?>
          </span>
        </div>

        <div class="info-item">
          <span class="info-label">Nombre de Cookie:</span>
          <span class="info-value">ultimo_usuario</span>
        </div>

        <div class="info-item">
          <span class="info-label">Duración:</span>
          <span class="info-value">30 días</span>
        </div>
      </div>

      <div class="demo-section">
        <h4>💡 Cómo Funciona</h4>
        <p>
          <strong>1.</strong> Ingresa tu nombre de usuario y presiona "Crear Cookie"<br>
          <strong>2.</strong> Se creará una cookie que recordará tu nombre por 30 días<br>
          <strong>3.</strong> La próxima vez que visites esta página, aparecerá tu último nombre<br>
          <strong>4.</strong> Puedes cambiar el nombre en cualquier momento<br>
          <strong>5.</strong> Usa "Limpiar Cookie" para empezar de nuevo
        </p>
      </div>

      <div class="actions">
        <a href="formulario.php" class="btn btn-primary">🔄 Recargar Página</a>
        <a href="?limpiar=true" class="btn btn-danger">🗑️ Limpiar Cookie</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
      </div>
    </div>
  </div>

  <script>
    // Auto-focus en el campo de texto
    document.addEventListener('DOMContentLoaded', function() {
      const input = document.getElementById('nombre_usuario');
      if (input && input.value === '') {
        input.focus();
      }
    });

    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
      const input = document.getElementById('nombre_usuario');
      const value = input.value.trim();

      if (value.length === 0) {
        e.preventDefault();
        alert('Por favor, ingresa un nombre de usuario válido.');
        input.focus();
        return false;
      }

      if (value.length < 2) {
        e.preventDefault();
        alert('El nombre de usuario debe tener al menos 2 caracteres.');
        input.focus();
        return false;
      }
    });
  </script>
</body>

</html>