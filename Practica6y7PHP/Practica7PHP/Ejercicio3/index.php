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
      max-width: 800px;
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
      border-left: 5px solid #56ab2f;
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
      background: linear-gradient(45deg, #56ab2f, #a8e6cf);
      color: white;
      box-shadow: 0 5px 15px rgba(86, 171, 47, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(86, 171, 47, 0.4);
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

    .workflow {
      background: #fff3cd;
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
      border: 1px solid #ffeaa7;
    }

    .workflow h3 {
      color: #856404;
      margin-bottom: 20px;
      font-size: 1.3em;
    }

    .workflow-step {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      padding: 10px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 8px;
    }

    .step-number {
      background: #56ab2f;
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
      color: #856404;
      font-weight: 500;
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
      <h1>👤 Ejercicio N°3</h1>
      <p>Formulario de Usuario con Cookies PHP</p>
    </div>

    <div class="content">
      <div class="exercise-description">
        <h2>📋 Descripción del Ejercicio</h2>
        <p>
          Crear un <strong>formulario</strong> que solicite la carga del nombre de usuario.
          Cuando se presione un botón crear una <strong>cookie</strong> para dicho usuario.
        </p>
        <p>
          Luego cada vez que ingrese al formulario mostrar el <strong>último nombre de usuario ingresado</strong>,
          permitiendo al sistema recordar al usuario entre diferentes visitas.
        </p>
      </div>

      <div class="workflow">
        <h3>🔄 Flujo del Ejercicio</h3>

        <div class="workflow-step">
          <div class="step-number">1</div>
          <div class="step-text">Usuario accede al formulario por primera vez</div>
        </div>

        <div class="workflow-step">
          <div class="step-number">2</div>
          <div class="step-text">Ingresa su nombre de usuario en el campo de texto</div>
        </div>

        <div class="workflow-step">
          <div class="step-number">3</div>
          <div class="step-text">Presiona "Crear Cookie de Usuario" para guardar</div>
        </div>

        <div class="workflow-step">
          <div class="step-number">4</div>
          <div class="step-text">Se crea una cookie con el nombre del usuario</div>
        </div>

        <div class="workflow-step">
          <div class="step-number">5</div>
          <div class="step-text">En futuras visitas, el formulario muestra el último nombre</div>
        </div>
      </div>

      <div class="features">
        <div class="feature-card">
          <div class="feature-icon">📝</div>
          <div class="feature-title">Formulario Inteligente</div>
          <div class="feature-description">
            Campo de texto que recuerda automáticamente el último usuario ingresado
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🍪</div>
          <div class="feature-title">Cookie Persistente</div>
          <div class="feature-description">
            Almacena el nombre de usuario por 30 días usando cookies PHP
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🔒</div>
          <div class="feature-title">Validación Segura</div>
          <div class="feature-description">
            Sanitiza y valida los datos de entrada para mayor seguridad
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">📊</div>
          <div class="feature-title">Información Detallada</div>
          <div class="feature-description">
            Muestra el estado de la cookie y información técnica del sistema
          </div>
        </div>
      </div>

      <div class="action-buttons">
        <a href="formulario.php" class="btn btn-primary">🚀 Ir al Formulario</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
      </div>

      <div class="technical-info">
        <h3>🔧 Implementación Técnica</h3>
        <ul>
          <li><strong>Lenguaje:</strong> PHP puro con validación y sanitización</li>
          <li><strong>Almacenamiento:</strong> Cookies del navegador con 30 días de duración</li>
          <li><strong>Validación:</strong> Verificación de campos vacíos y caracteres especiales</li>
          <li><strong>Seguridad:</strong> Filtrado con FILTER_SANITIZE_STRING</li>
          <li><strong>UX:</strong> Auto-completado del formulario con último usuario</li>
          <li><strong>Responsive:</strong> Diseño adaptativo para todos los dispositivos</li>
        </ul>

        <div class="code-snippet">
          <span class="keyword">if</span> (<span class="keyword">$_SERVER</span>[<span class="string">'REQUEST_METHOD'</span>] == <span class="string">'POST'</span>) {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">$nombre_usuario</span> = <span class="function">trim</span>(<span class="keyword">$_POST</span>[<span class="string">'nombre_usuario'</span>]);<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">$nombre_usuario</span> = <span class="function">filter_var</span>(<span class="keyword">$nombre_usuario</span>, <span class="function">FILTER_SANITIZE_STRING</span>);<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="function">setcookie</span>(<span class="string">'ultimo_usuario'</span>, <span class="keyword">$nombre_usuario</span>, <span class="function">time</span>() + (30 * 24 * 60 * 60));<br>
          }
        </div>
      </div>
    </div>
  </div>
</body>

</html>