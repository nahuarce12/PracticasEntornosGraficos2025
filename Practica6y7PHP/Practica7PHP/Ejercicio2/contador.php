<?php
// Inicializar contador
$contador = 1;
$es_primera_visita = true;

// Verificar si existe la cookie "contador"
if (isset($_COOKIE['contador'])) {
  // No es la primera visita, incrementar contador
  $contador = (int)$_COOKIE['contador'] + 1;
  $es_primera_visita = false;
}

// Actualizar la cookie con el nuevo valor (válida por 30 días)
setcookie('contador', $contador, time() + (30 * 24 * 60 * 60), '/');

// Obtener información adicional para mostrar
$fecha_actual = date('d/m/Y H:i:s');
$ip_usuario = $_SERVER['REMOTE_ADDR'] ?? 'No disponible';
$navegador = $_SERVER['HTTP_USER_AGENT'] ?? 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 2 - Contador de Visitas</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
      text-align: center;
      max-width: 600px;
      width: 100%;
      backdrop-filter: blur(10px);
    }

    .header {
      margin-bottom: 30px;
    }

    .header h1 {
      color: #333;
      font-size: 2.5em;
      margin-bottom: 10px;
      background: linear-gradient(45deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .subtitle {
      color: #666;
      font-size: 1.2em;
      font-style: italic;
    }

    .welcome-message {
      background: linear-gradient(45deg, #4CAF50, #45a049);
      color: white;
      padding: 25px;
      border-radius: 15px;
      margin: 20px 0;
      box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }

    .return-message {
      background: linear-gradient(45deg, #2196F3, #1976D2);
      color: white;
      padding: 25px;
      border-radius: 15px;
      margin: 20px 0;
      box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
    }

    .counter-display {
      font-size: 3em;
      font-weight: bold;
      color: #333;
      margin: 20px 0;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .info-section {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 5px solid #667eea;
    }

    .info-section h3 {
      color: #333;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .info-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #e0e0e0;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-label {
      font-weight: bold;
      color: #555;
    }

    .info-value {
      color: #333;
      font-family: monospace;
      background: #e9ecef;
      padding: 2px 8px;
      border-radius: 4px;
    }

    .actions {
      margin-top: 30px;
    }

    .btn {
      display: inline-block;
      padding: 12px 25px;
      margin: 0 10px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      font-size: 1em;
    }

    .btn-primary {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
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

    .achievement {
      background: linear-gradient(45deg, #ffa502, #ff6348);
      color: white;
      padding: 15px;
      border-radius: 10px;
      margin: 15px 0;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.02);
      }

      100% {
        transform: scale(1);
      }
    }

    .milestone {
      font-size: 1.5em;
      margin: 10px 0;
    }

    @media (max-width: 768px) {
      .container {
        padding: 25px;
        margin: 10px;
      }

      .header h1 {
        font-size: 2em;
      }

      .counter-display {
        font-size: 2.5em;
      }

      .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
      }

      .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🔢 Contador de Visitas</h1>
      <p class="subtitle">Ejercicio N°2 - Cookies en PHP</p>
    </div>

    <?php if ($es_primera_visita): ?>
      <div class="welcome-message">
        <h2>🎉 ¡Bienvenido!</h2>
        <p>Esta es tu primera visita a nuestra página contador.</p>
        <p>¡Esperamos que disfrutes explorando nuestro sitio!</p>
      </div>
    <?php else: ?>
      <div class="return-message">
        <h2>👋 ¡Bienvenido de vuelta!</h2>
        <p>Nos alegra verte nuevamente por aquí.</p>
      </div>
    <?php endif; ?>

    <div class="counter-display">
      Visita #<?php echo $contador; ?>
    </div>

    <?php
    // Mostrar logros por milestones
    if ($contador == 5): ?>
      <div class="achievement">
        <div class="milestone">🏆 ¡Logro Desbloqueado!</div>
        <p>¡Has visitado la página 5 veces! Eres un visitante frecuente.</p>
      </div>
    <?php elseif ($contador == 10): ?>
      <div class="achievement">
        <div class="milestone">🌟 ¡Logro Especial!</div>
        <p>¡10 visitas! Claramente te gusta estar aquí.</p>
      </div>
    <?php elseif ($contador == 25): ?>
      <div class="achievement">
        <div class="milestone">💎 ¡Logro Épico!</div>
        <p>¡25 visitas! Eres oficialmente un visitante VIP.</p>
      </div>
    <?php elseif ($contador >= 50): ?>
      <div class="achievement">
        <div class="milestone">👑 ¡Logro Legendario!</div>
        <p>¡Más de 50 visitas! Eres una leyenda del contador.</p>
      </div>
    <?php endif; ?>

    <div class="info-section">
      <h3>📊 Información de la Visita</h3>

      <div class="info-item">
        <span class="info-label">Fecha y Hora:</span>
        <span class="info-value"><?php echo $fecha_actual; ?></span>
      </div>

      <div class="info-item">
        <span class="info-label">Total de Visitas:</span>
        <span class="info-value"><?php echo $contador; ?></span>
      </div>

      <div class="info-item">
        <span class="info-label">Estado de Cookie:</span>
        <span class="info-value"><?php echo isset($_COOKIE['contador']) ? 'Activa' : 'Nueva'; ?></span>
      </div>

      <div class="info-item">
        <span class="info-label">Tu IP:</span>
        <span class="info-value"><?php echo $ip_usuario; ?></span>
      </div>

      <div class="info-item">
        <span class="info-label">Navegador:</span>
        <span class="info-value" style="font-size: 0.8em;">
          <?php
          // Simplificar el nombre del navegador
          if (strpos($navegador, 'Chrome') !== false) {
            echo 'Google Chrome';
          } elseif (strpos($navegador, 'Firefox') !== false) {
            echo 'Mozilla Firefox';
          } elseif (strpos($navegador, 'Safari') !== false && strpos($navegador, 'Chrome') === false) {
            echo 'Safari';
          } elseif (strpos($navegador, 'Edge') !== false) {
            echo 'Microsoft Edge';
          } else {
            echo 'Otro navegador';
          }
          ?>
        </span>
      </div>
    </div>

    <div class="actions">
      <a href="contador.php" class="btn btn-primary">🔄 Recargar Página</a>
      <a href="reset_contador.php" class="btn btn-danger">🗑️ Resetear Contador</a>
      <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
    </div>

    <div style="margin-top: 30px; padding: 15px; background: #e9ecef; border-radius: 8px; font-size: 0.9em; color: #666;">
      <p><strong>💡 Información Técnica:</strong></p>
      <p>Este contador utiliza cookies PHP para almacenar el número de visitas en tu navegador local. La cookie expira en 30 días.</p>
    </div>
  </div>
</body>

</html>