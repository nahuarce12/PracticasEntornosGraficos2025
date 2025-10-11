<?php
// Eliminar la cookie de preferencias de noticias
setcookie('tipo_noticia_preferida', '', time() - 3600, '/');

// Información para mostrar
$fecha_eliminacion = date('d/m/Y H:i:s');
$cookie_anterior = isset($_COOKIE['tipo_noticia_preferida']) ? $_COOKIE['tipo_noticia_preferida'] : 'No había cookie';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preferencias Eliminadas - El Diario Digital</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Georgia', 'Times New Roman', serif;
      background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
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
      max-width: 600px;
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

    .newspaper-icon {
      font-size: 5em;
      margin-bottom: 20px;
      animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {

      0%,
      20%,
      50%,
      80%,
      100% {
        transform: translateY(0);
      }

      40% {
        transform: translateY(-10px);
      }

      60% {
        transform: translateY(-5px);
      }
    }

    .title {
      color: #333;
      font-size: 2.5em;
      margin-bottom: 15px;
      background: linear-gradient(45deg, #ff6b35, #f7931e);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: bold;
    }

    .subtitle {
      color: #666;
      font-size: 1.2em;
      margin-bottom: 30px;
      font-style: italic;
    }

    .success-message {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 25px;
      border-radius: 15px;
      margin: 25px 0;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .success-message h3 {
      font-size: 1.5em;
      margin-bottom: 10px;
    }

    .info-section {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border-left: 5px solid #ff6b35;
    }

    .info-section h4 {
      color: #333;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .info-item {
      background: white;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .info-label {
      font-weight: bold;
      color: #ff6b35;
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
      display: inline-block;
      font-size: 0.95em;
    }

    .explanation {
      background: #fff3cd;
      color: #856404;
      padding: 20px;
      border-radius: 10px;
      margin: 25px 0;
      border: 1px solid #ffeaa7;
    }

    .explanation h4 {
      margin-bottom: 10px;
      color: #856404;
    }

    .explanation p {
      line-height: 1.6;
    }

    .countdown {
      font-size: 1.3em;
      color: #ff6b35;
      font-weight: bold;
      margin: 20px 0;
    }

    .actions {
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
      background: linear-gradient(45deg, #ff6b35, #f7931e);
      color: white;
      box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
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

    .newspaper-effect {
      position: relative;
      overflow: hidden;
    }

    .newspaper-effect::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg,
          transparent 30%,
          rgba(255, 255, 255, 0.1) 50%,
          transparent 70%);
      animation: shine 3s infinite;
    }

    @keyframes shine {
      0% {
        transform: translateX(-100%) translateY(-100%) rotate(45deg);
      }

      100% {
        transform: translateX(100%) translateY(100%) rotate(45deg);
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 25px;
        margin: 10px;
      }

      .title {
        font-size: 2em;
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
  <div class="container newspaper-effect">
    <div class="newspaper-icon">🗞️</div>

    <h1 class="title">Preferencias Eliminadas</h1>
    <p class="subtitle">Configuración del periódico restablecida</p>

    <div class="success-message">
      <h3>✅ Operación Completada</h3>
      <p>Se han eliminado todas las preferencias de tipo de noticia.</p>
      <p>La próxima vez que visites el periódico verás todos los titulares.</p>
    </div>

    <div class="info-section">
      <h4>📋 Detalles de la Operación</h4>

      <div class="info-grid">
        <div class="info-item">
          <div class="info-label">Fecha de Eliminación</div>
          <div class="info-value"><?php echo $fecha_eliminacion; ?></div>
        </div>

        <div class="info-item">
          <div class="info-label">Cookie Eliminada</div>
          <div class="info-value">tipo_noticia_preferida</div>
        </div>

        <div class="info-item">
          <div class="info-label">Preferencia Anterior</div>
          <div class="info-value"><?php echo ucfirst($cookie_anterior); ?></div>
        </div>

        <div class="info-item">
          <div class="info-label">Estado Actual</div>
          <div class="info-value">Sin preferencias</div>
        </div>
      </div>
    </div>

    <div class="explanation">
      <h4>💡 ¿Qué significa esto?</h4>
      <p>
        <strong>1.</strong> Se ha eliminado la cookie que almacenaba tu tipo de noticia preferida.<br>
        <strong>2.</strong> Al volver al periódico, verás todos los titulares (política, económica y deportiva).<br>
        <strong>3.</strong> Puedes volver a configurar tus preferencias cuando desees.<br>
        <strong>4.</strong> La eliminación se realizó estableciendo la fecha de expiración en el pasado.
      </p>
    </div>

    <div class="countdown" id="countdown">
      Redireccionando al periódico en <span id="timer">8</span> segundos...
    </div>

    <div class="actions">
      <a href="periódico.php" class="btn btn-primary">📰 Volver al Periódico</a>
      <a href="../index.php" class="btn btn-secondary">🏠 Menú Principal</a>
    </div>
  </div>

  <script>
    // Contador regresivo automático
    let timeLeft = 8;
    const timerElement = document.getElementById('timer');
    const countdownElement = document.getElementById('countdown');

    const countdown = setInterval(function() {
      timeLeft--;
      timerElement.textContent = timeLeft;

      if (timeLeft <= 0) {
        clearInterval(countdown);
        countdownElement.innerHTML = '🔄 Redireccionando...';
        window.location.href = 'periódico.php';
      }
    }, 1000);

    // Permitir cancelar la redirección haciendo clic en cualquier botón
    document.querySelectorAll('.btn').forEach(btn => {
      btn.addEventListener('click', function() {
        clearInterval(countdown);
        countdownElement.style.display = 'none';
      });
    });

    // Efecto de confeti al cargar
    function createConfetti() {
      const colors = ['#ff6b35', '#f7931e', '#28a745', '#17a2b8', '#6f42c1'];
      for (let i = 0; i < 50; i++) {
        setTimeout(() => {
          const confetti = document.createElement('div');
          confetti.style.position = 'fixed';
          confetti.style.left = Math.random() * 100 + 'vw';
          confetti.style.top = '-10px';
          confetti.style.width = '10px';
          confetti.style.height = '10px';
          confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
          confetti.style.borderRadius = '50%';
          confetti.style.pointerEvents = 'none';
          confetti.style.zIndex = '1000';
          confetti.style.animation = 'fall 3s linear forwards';

          document.body.appendChild(confetti);

          setTimeout(() => {
            confetti.remove();
          }, 3000);
        }, i * 100);
      }
    }

    // CSS para la animación de caída
    const style = document.createElement('style');
    style.textContent = `
            @keyframes fall {
                to {
                    transform: translateY(100vh) rotate(360deg);
                }
            }
        `;
    document.head.appendChild(style);

    // Ejecutar confeti al cargar
    setTimeout(createConfetti, 500);
  </script>
</body>

</html>