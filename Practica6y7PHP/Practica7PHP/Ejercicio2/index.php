<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 2 - Contador con Cookies</title>
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
      max-width: 800px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }

    .header {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
      font-weight: 300;
    }

    .header p {
      font-size: 1.2em;
      opacity: 0.9;
    }

    .content {
      padding: 40px;
    }

    .exercise-description {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #667eea;
    }

    .exercise-description h2 {
      color: #333;
      margin-bottom: 15px;
      font-size: 1.5em;
    }

    .exercise-description p {
      color: #555;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin: 30px 0;
    }

    .feature-card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-icon {
      font-size: 3em;
      margin-bottom: 15px;
    }

    .feature-title {
      color: #333;
      font-size: 1.2em;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .feature-description {
      color: #666;
      font-size: 0.9em;
      line-height: 1.4;
    }

    .action-buttons {
      text-align: center;
      margin: 40px 0;
    }

    .btn {
      display: inline-block;
      padding: 15px 30px;
      margin: 0 10px 10px 10px;
      text-decoration: none;
      border-radius: 10px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1em;
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

    .btn-secondary {
      background: linear-gradient(45deg, #747d8c, #57606f);
      color: white;
      box-shadow: 0 5px 15px rgba(116, 125, 140, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(116, 125, 140, 0.4);
    }

    .technical-info {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
      border: 1px solid #b8daff;
    }

    .technical-info h3 {
      color: #0c5460;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .technical-info ul {
      color: #155724;
      padding-left: 20px;
    }

    .technical-info li {
      margin-bottom: 8px;
      line-height: 1.5;
    }

    .code-snippet {
      background: #2d3748;
      color: #e2e8f0;
      padding: 15px;
      border-radius: 8px;
      margin: 15px 0;
      font-family: 'Courier New', monospace;
      font-size: 0.9em;
      overflow-x: auto;
    }

    .code-snippet .keyword {
      color: #fc8181;
    }

    .code-snippet .function {
      color: #81e6d9;
    }

    .code-snippet .string {
      color: #90cdf4;
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

      .features {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🔢 Ejercicio N°2</h1>
      <p>Contador de Visitas con Cookies PHP</p>
    </div>

    <div class="content">
      <div class="exercise-description">
        <h2>📋 Descripción del Ejercicio</h2>
        <p>
          Crear una cookie llamada <strong>"contador"</strong> que lleve la cuenta en el lado cliente del número de veces que se ha accedido a la página <code>contador.php</code>.
        </p>
        <p>
          Si es la primera vez que se accede, la página dará la bienvenida al usuario. Si ya se ha accedido anteriormente, la página hará uso de la cookie para mostrar el número de veces que se ha visitado dicha página.
        </p>
      </div>

      <div class="features">
        <div class="feature-card">
          <div class="feature-icon">🍪</div>
          <div class="feature-title">Cookie Persistente</div>
          <div class="feature-description">
            Utiliza cookies PHP para mantener el contador entre sesiones del navegador
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">👋</div>
          <div class="feature-title">Mensaje de Bienvenida</div>
          <div class="feature-description">
            Detecta automáticamente si es la primera visita y muestra un mensaje especial
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">📊</div>
          <div class="feature-title">Contador Automático</div>
          <div class="feature-description">
            Incrementa automáticamente el contador con cada visita a la página
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🏆</div>
          <div class="feature-title">Sistema de Logros</div>
          <div class="feature-description">
            Desbloquea logros especiales al alcanzar ciertos números de visitas
          </div>
        </div>
      </div>

      <div class="action-buttons">
        <a href="contador.php" class="btn btn-primary">🚀 Probar Contador</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
      </div>

      <div class="technical-info">
        <h3>🔧 Información Técnica</h3>
        <ul>
          <li><strong>Tecnología:</strong> PHP con cookies del navegador</li>
          <li><strong>Persistencia:</strong> 30 días desde la última visita</li>
          <li><strong>Almacenamiento:</strong> Local en el navegador del usuario</li>
          <li><strong>Funcionalidades extra:</strong> Sistema de logros, información detallada, reset</li>
          <li><strong>Compatibilidad:</strong> Todos los navegadores modernos</li>
        </ul>

        <div class="code-snippet">
          <span class="keyword">if</span> (<span class="function">isset</span>(<span class="keyword">$_COOKIE</span>[<span class="string">'contador'</span>])) {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">$contador</span> = (<span class="function">int</span>)<span class="keyword">$_COOKIE</span>[<span class="string">'contador'</span>] + 1;<br>
          } <span class="keyword">else</span> {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">$contador</span> = 1;<br>
          }<br><br>
          <span class="function">setcookie</span>(<span class="string">'contador'</span>, <span class="keyword">$contador</span>, <span class="function">time</span>() + (30 * 24 * 60 * 60));
        </div>
      </div>
    </div>
  </div>
</body>

</html>