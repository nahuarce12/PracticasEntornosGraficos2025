<?php
session_start();

// Guardar información antes de cerrar la sesión
$session_info = array(
  'usuario' => isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'No disponible',
  'fecha_login' => isset($_SESSION['fecha_login']) ? $_SESSION['fecha_login'] : 'No disponible',
  'session_id' => session_id(),
  'fecha_cierre' => date('Y-m-d H:i:s'),
  'duracion_sesion' => 'Calculando...'
);

// Calcular duración de la sesión si hay fecha de login
if (isset($_SESSION['fecha_login'])) {
  $inicio = new DateTime($_SESSION['fecha_login']);
  $fin = new DateTime();
  $diferencia = $inicio->diff($fin);
  $session_info['duracion_sesion'] = $diferencia->format('%H:%I:%S');
}

// Destruir todas las variables de sesión
$_SESSION = array();

// Eliminar la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(
    session_name(),
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
  );
}

// Destruir la sesión completamente
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sesión Cerrada - Ejercicio 5</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #ff7b7b 0%, #ff6b6b 50%, #ee5a24 100%);
      min-height: 100vh;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      max-width: 700px;
      width: 100%;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(15px);
      animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .header {
      background: linear-gradient(45deg, #ff6b6b, #ee5a24);
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .header::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transform: rotate(45deg);
      animation: shine 3s infinite;
    }

    @keyframes shine {
      0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
      }

      50% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
      }

      100% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
      }
    }

    .header h1 {
      font-size: 2.8em;
      margin-bottom: 15px;
      font-weight: 700;
      position: relative;
      z-index: 1;
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.95;
      position: relative;
      z-index: 1;
    }

    .content {
      padding: 50px 40px;
    }

    .logout-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
      margin-bottom: 40px;
      animation: pulse 2s infinite alternate;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      100% {
        transform: scale(1.02);
      }
    }

    .logout-success h3 {
      font-size: 1.8em;
      margin-bottom: 15px;
    }

    .logout-success p {
      font-size: 1.1em;
      line-height: 1.6;
    }

    .session-summary {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      border-left: 6px solid #ff6b6b;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .session-summary h3 {
      color: #ff6b6b;
      margin-bottom: 25px;
      font-size: 1.6em;
      text-align: center;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .summary-item {
      background: white;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease;
    }

    .summary-item:hover {
      transform: translateY(-5px);
    }

    .summary-label {
      font-weight: bold;
      color: #ff6b6b;
      margin-bottom: 10px;
      font-size: 0.9em;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .summary-value {
      color: #333;
      font-family: monospace;
      background: #e9ecef;
      padding: 10px;
      border-radius: 8px;
      font-size: 1em;
      word-break: break-all;
    }

    .summary-icon {
      font-size: 2em;
      margin-bottom: 10px;
      display: block;
    }

    .explanation {
      background: #e7f3ff;
      padding: 30px;
      border-radius: 15px;
      margin: 30px 0;
      border: 1px solid #b8daff;
    }

    .explanation h4 {
      color: #0c5460;
      margin-bottom: 20px;
      font-size: 1.4em;
      text-align: center;
    }

    .explanation-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .explanation-item {
      background: white;
      padding: 20px;
      border-radius: 10px;
      border-left: 4px solid #0c5460;
    }

    .explanation-item h5 {
      color: #0c5460;
      margin-bottom: 10px;
      font-size: 1.1em;
    }

    .explanation-item p {
      color: #495057;
      line-height: 1.5;
      font-size: 0.95em;
    }

    .code-snippet {
      background: #2d3748;
      color: #e2e8f0;
      padding: 15px;
      border-radius: 8px;
      font-family: 'Courier New', monospace;
      font-size: 0.9em;
      margin: 10px 0;
      overflow-x: auto;
    }

    .actions {
      text-align: center;
      margin-top: 40px;
    }

    .btn {
      display: inline-block;
      padding: 18px 35px;
      margin: 0 10px 15px 10px;
      text-decoration: none;
      border-radius: 30px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1em;
      text-transform: uppercase;
      letter-spacing: 1px;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn-primary {
      background: linear-gradient(45deg, #6f42c1, #e83e8c);
      color: white;
      box-shadow: 0 8px 25px rgba(111, 66, 193, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(111, 66, 193, 0.4);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(108, 117, 125, 0.4);
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2.2em;
      }

      .content {
        padding: 30px 25px;
      }

      .btn {
        display: block;
        margin: 15px 0;
        width: 100%;
      }

      .summary-grid,
      .explanation-grid {
        grid-template-columns: 1fr;
      }
    }

    .floating-particles {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
    }

    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 6s infinite ease-in-out;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0;
      }

      50% {
        transform: translateY(-100px) rotate(180deg);
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  <div class="floating-particles">
    <div class="particle" style="left: 10%; animation-delay: 0s; width: 4px; height: 4px;"></div>
    <div class="particle" style="left: 20%; animation-delay: 1s; width: 6px; height: 6px;"></div>
    <div class="particle" style="left: 30%; animation-delay: 2s; width: 4px; height: 4px;"></div>
    <div class="particle" style="left: 40%; animation-delay: 0.5s; width: 8px; height: 8px;"></div>
    <div class="particle" style="left: 50%; animation-delay: 1.5s; width: 5px; height: 5px;"></div>
    <div class="particle" style="left: 60%; animation-delay: 2.5s; width: 6px; height: 6px;"></div>
    <div class="particle" style="left: 70%; animation-delay: 0.8s; width: 4px; height: 4px;"></div>
    <div class="particle" style="left: 80%; animation-delay: 1.8s; width: 7px; height: 7px;"></div>
    <div class="particle" style="left: 90%; animation-delay: 2.8s; width: 5px; height: 5px;"></div>
  </div>

  <div class="container">
    <div class="header">
      <h1>🚪 Sesión Cerrada</h1>
      <p>Has cerrado la sesión exitosamente</p>
    </div>

    <div class="content">
      <div class="logout-success">
        <h3>✅ ¡Sesión Terminada Correctamente!</h3>
        <p>Todas las variables de sesión han sido eliminadas y la sesión ha sido destruida de forma segura. Gracias por usar nuestro sistema de gestión de sesiones.</p>
      </div>

      <div class="session-summary">
        <h3>📊 Resumen de la Sesión Cerrada</h3>

        <div class="summary-grid">
          <div class="summary-item">
            <span class="summary-icon">👤</span>
            <div class="summary-label">Usuario</div>
            <div class="summary-value"><?php echo htmlspecialchars($session_info['usuario']); ?></div>
          </div>

          <div class="summary-item">
            <span class="summary-icon">🕐</span>
            <div class="summary-label">Inicio de Sesión</div>
            <div class="summary-value"><?php echo htmlspecialchars($session_info['fecha_login']); ?></div>
          </div>

          <div class="summary-item">
            <span class="summary-icon">🕑</span>
            <div class="summary-label">Cierre de Sesión</div>
            <div class="summary-value"><?php echo $session_info['fecha_cierre']; ?></div>
          </div>

          <div class="summary-item">
            <span class="summary-icon">⏱️</span>
            <div class="summary-label">Duración</div>
            <div class="summary-value"><?php echo $session_info['duracion_sesion']; ?></div>
          </div>

          <div class="summary-item">
            <span class="summary-icon">🆔</span>
            <div class="summary-label">ID de Sesión</div>
            <div class="summary-value"><?php echo htmlspecialchars($session_info['session_id']); ?></div>
          </div>

          <div class="summary-item">
            <span class="summary-icon">🌐</span>
            <div class="summary-label">Estado Actual</div>
            <div class="summary-value">Sesión Destruida</div>
          </div>
        </div>
      </div>

      <div class="explanation">
        <h4>🔧 Proceso de Cierre de Sesión Ejecutado</h4>

        <div class="explanation-grid">
          <div class="explanation-item">
            <h5>1. Limpieza de Variables</h5>
            <p>Se ejecutó <code>$_SESSION = array();</code> para vaciar todas las variables de sesión.</p>
            <div class="code-snippet">$_SESSION = array();</div>
          </div>

          <div class="explanation-item">
            <h5>2. Eliminación de Cookie</h5>
            <p>Se eliminó la cookie de sesión del navegador usando <code>setcookie()</code> con tiempo pasado.</p>
            <div class="code-snippet">setcookie(session_name(), '', time() - 42000);</div>
          </div>

          <div class="explanation-item">
            <h5>3. Destrucción de Sesión</h5>
            <p>Se utilizó <code>session_destroy()</code> para eliminar completamente la sesión del servidor.</p>
            <div class="code-snippet">session_destroy();</div>
          </div>

          <div class="explanation-item">
            <h5>4. Seguridad Garantizada</h5>
            <p>No quedan rastros de la sesión en el servidor ni en el navegador del usuario.</p>
            <div class="code-snippet">// Sesión completamente eliminada</div>
          </div>
        </div>
      </div>

      <div class="actions">
        <a href="index.php" class="btn btn-primary">
          🔐 Nuevo Login
        </a>
        <a href="mostrar_sesion.php" class="btn btn-success">
          📊 Ver Estado de Sesión
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>

  <script>
    // Animación de confirmación
    window.addEventListener('load', function() {
      setTimeout(function() {
        const successDiv = document.querySelector('.logout-success');
        if (successDiv) {
          successDiv.style.transform = 'scale(1.05)';
          setTimeout(function() {
            successDiv.style.transform = 'scale(1)';
          }, 200);
        }
      }, 500);
    });
  </script>
</body>

</html>