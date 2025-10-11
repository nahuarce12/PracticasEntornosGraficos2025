<?php
// Eliminar la cookie del contador
// Para eliminar una cookie, se establece con una fecha en el pasado
setcookie('contador', '', time() - 3600, '/');

// Obtener información para mostrar
$fecha_reset = date('d/m/Y H:i:s');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contador Reseteado - Ejercicio 2</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
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
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 500px;
      width: 100%;
      backdrop-filter: blur(10px);
      animation: slideIn 0.5s ease-out;
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

    .icon {
      font-size: 4em;
      margin-bottom: 20px;
      animation: bounce 1s ease-in-out infinite alternate;
    }

    @keyframes bounce {
      from {
        transform: translateY(0);
      }

      to {
        transform: translateY(-10px);
      }
    }

    .title {
      color: #333;
      font-size: 2.2em;
      margin-bottom: 15px;
      background: linear-gradient(45deg, #ff4757, #ff3742);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: bold;
    }

    .subtitle {
      color: #666;
      font-size: 1.1em;
      margin-bottom: 25px;
      font-style: italic;
    }

    .success-message {
      background: linear-gradient(45deg, #26de81, #20bf6b);
      color: white;
      padding: 20px;
      border-radius: 12px;
      margin: 20px 0;
      box-shadow: 0 5px 15px rgba(38, 222, 129, 0.3);
    }

    .info-box {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 5px solid #ff4757;
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
      margin: 0 10px 10px 10px;
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

    .btn-secondary {
      background: linear-gradient(45deg, #747d8c, #57606f);
      color: white;
      box-shadow: 0 4px 15px rgba(116, 125, 140, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(116, 125, 140, 0.4);
    }

    .note {
      margin-top: 25px;
      padding: 15px;
      background: rgba(255, 193, 7, 0.1);
      border: 1px solid #ffc107;
      border-radius: 8px;
      font-size: 0.9em;
      color: #856404;
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

      .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
      }
    }

    .countdown {
      font-size: 1.2em;
      color: #ff4757;
      font-weight: bold;
      margin: 15px 0;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="icon">🗑️</div>

    <h1 class="title">Contador Reseteado</h1>
    <p class="subtitle">El contador ha sido eliminado exitosamente</p>

    <div class="success-message">
      <h3>✅ Operación Completada</h3>
      <p>La cookie "contador" ha sido eliminada de tu navegador.</p>
      <p>Tu próxima visita será contada como la primera vez.</p>
    </div>

    <div class="info-box">
      <h3>📋 Detalles de la Operación</h3>

      <div class="info-item">
        <span class="info-label">Fecha del Reset:</span>
        <span class="info-value"><?php echo $fecha_reset; ?></span>
      </div>

      <div class="info-item">
        <span class="info-label">Cookie Eliminada:</span>
        <span class="info-value">contador</span>
      </div>

      <div class="info-item">
        <span class="info-label">Estado Anterior:</span>
        <span class="info-value"><?php echo isset($_COOKIE['contador']) ? $_COOKIE['contador'] . ' visitas' : 'No disponible'; ?></span>
      </div>

      <div class="info-item">
        <span class="info-label">Estado Actual:</span>
        <span class="info-value">0 visitas</span>
      </div>
    </div>

    <div class="countdown" id="countdown">
      Redireccionando en <span id="timer">5</span> segundos...
    </div>

    <div class="actions">
      <a href="contador.php" class="btn btn-primary">🔢 Ir al Contador</a>
      <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
    </div>

    <div class="note">
      <p><strong>💡 Nota Técnica:</strong></p>
      <p>La cookie se ha eliminado estableciendo su fecha de expiración en el pasado. Esto es el método estándar para eliminar cookies en PHP.</p>
    </div>
  </div>

  <script>
    // Contador regresivo automático
    let timeLeft = 5;
    const timerElement = document.getElementById('timer');
    const countdownElement = document.getElementById('countdown');

    const countdown = setInterval(function() {
      timeLeft--;
      timerElement.textContent = timeLeft;

      if (timeLeft <= 0) {
        clearInterval(countdown);
        countdownElement.innerHTML = '🔄 Redireccionando...';
        window.location.href = 'contador.php';
      }
    }, 1000);

    // Permitir cancelar la redirección haciendo clic en cualquier botón
    document.querySelectorAll('.btn').forEach(btn => {
      btn.addEventListener('click', function() {
        clearInterval(countdown);
        countdownElement.style.display = 'none';
      });
    });
  </script>
</body>

</html>