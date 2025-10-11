<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 4 - Periódico Digital</title>
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
    }

    .header {
      background: linear-gradient(45deg, #1a1a1a, #333);
      color: white;
      padding: 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50%" font-size="20" fill="rgba(255,255,255,0.1)">📰</text></svg>') repeat;
      opacity: 0.1;
    }

    .header h1 {
      font-size: 2.8em;
      margin-bottom: 10px;
      font-weight: bold;
      position: relative;
      z-index: 1;
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }

    .content {
      padding: 40px;
    }

    .exercise-description {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #ff6b35;
    }

    .exercise-description h2 {
      color: #333;
      margin-bottom: 15px;
      font-size: 1.6em;
    }

    .exercise-description p {
      color: #555;
      line-height: 1.6;
      margin-bottom: 10px;
      font-size: 1.05em;
    }

    .requirements {
      background: #fff3cd;
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
      border: 1px solid #ffeaa7;
    }

    .requirements h3 {
      color: #856404;
      margin-bottom: 20px;
      font-size: 1.4em;
    }

    .requirements ul {
      color: #856404;
      padding-left: 25px;
      line-height: 1.8;
    }

    .requirements li {
      margin-bottom: 10px;
      font-size: 1.05em;
    }

    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin: 30px 0;
    }

    .feature-card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
      border: 2px solid transparent;
    }

    .feature-card:hover {
      transform: translateY(-8px);
      border-color: #ff6b35;
    }

    .feature-icon {
      font-size: 3.5em;
      margin-bottom: 15px;
    }

    .feature-title {
      color: #333;
      font-size: 1.3em;
      font-weight: bold;
      margin-bottom: 12px;
    }

    .feature-description {
      color: #666;
      line-height: 1.5;
      font-size: 1.02em;
    }

    .workflow {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
      border: 1px solid #b8daff;
    }

    .workflow h3 {
      color: #0c5460;
      margin-bottom: 20px;
      font-size: 1.4em;
      text-align: center;
    }

    .workflow-steps {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .workflow-step {
      background: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      position: relative;
      border: 2px solid #17a2b8;
    }

    .step-number {
      background: #17a2b8;
      color: white;
      width: 35px;
      height: 35px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.2em;
      margin: 0 auto 15px auto;
    }

    .step-title {
      color: #0c5460;
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 1.1em;
    }

    .step-description {
      color: #666;
      font-size: 0.95em;
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

    .technical-info {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
      border-left: 5px solid #28a745;
    }

    .technical-info h3 {
      color: #155724;
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

    .demo-preview {
      background: white;
      border: 3px solid #ff6b35;
      border-radius: 15px;
      padding: 20px;
      margin: 25px 0;
      text-align: center;
    }

    .demo-preview h4 {
      color: #ff6b35;
      margin-bottom: 15px;
      font-size: 1.2em;
    }

    .demo-options {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 15px 0;
      flex-wrap: wrap;
    }

    .demo-option {
      padding: 10px 20px;
      border: 2px solid #ff6b35;
      border-radius: 25px;
      background: rgba(255, 107, 53, 0.1);
      color: #ff6b35;
      font-weight: bold;
      font-size: 0.9em;
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

      .features {
        grid-template-columns: 1fr;
      }

      .workflow-steps {
        grid-template-columns: 1fr;
      }

      .demo-options {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📰 Ejercicio N°4</h1>
      <p>Periódico Digital con Configuración de Titulares</p>
    </div>

    <div class="content">
      <div class="exercise-description">
        <h2>📋 Descripción del Ejercicio</h2>
        <p>
          Confeccionar una página que simule ser la de un <strong>periódico digital</strong>.
          La misma debe permitir configurar qué tipo de titular deseamos que aparezca al visitarla.
        </p>
        <p>
          Los tipos de noticias disponibles son: <strong>Noticia política</strong>,
          <strong>Noticia económica</strong> y <strong>Noticia deportiva</strong>.
        </p>
      </div>

      <div class="requirements">
        <h3>📝 Requisitos del Ejercicio</h3>
        <ul>
          <li><strong>Tres objetos radio</strong> para seleccionar el tipo de titular</li>
          <li><strong>Cookie de almacenamiento</strong> para recordar la preferencia del cliente</li>
          <li><strong>Primera visita</strong>: mostrar los tres titulares disponibles</li>
          <li><strong>Visitas posteriores</strong>: mostrar solo el titular seleccionado</li>
          <li><strong>Hipervínculo</strong> a una tercera página que borre la cookie</li>
        </ul>
      </div>

      <div class="workflow">
        <h3>🔄 Flujo de Funcionamiento</h3>
        <div class="workflow-steps">
          <div class="workflow-step">
            <div class="step-number">1</div>
            <div class="step-title">Primera Visita</div>
            <div class="step-description">
              Usuario accede al periódico por primera vez. Se muestran todos los titulares.
            </div>
          </div>

          <div class="workflow-step">
            <div class="step-number">2</div>
            <div class="step-title">Selección</div>
            <div class="step-description">
              Usuario elige su tipo de noticia preferida usando radio buttons.
            </div>
          </div>

          <div class="workflow-step">
            <div class="step-number">3</div>
            <div class="step-title">Cookie</div>
            <div class="step-description">
              Se guarda la preferencia en una cookie persistente.
            </div>
          </div>

          <div class="workflow-step">
            <div class="step-number">4</div>
            <div class="step-title">Personalización</div>
            <div class="step-description">
              En futuras visitas solo se muestra el tipo de noticia preferida.
            </div>
          </div>
        </div>
      </div>

      <div class="features">
        <div class="feature-card">
          <div class="feature-icon">🏛️</div>
          <div class="feature-title">Noticias Políticas</div>
          <div class="feature-description">
            Información sobre gobierno, congreso, políticas públicas y decisiones gubernamentales
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">📈</div>
          <div class="feature-title">Noticias Económicas</div>
          <div class="feature-description">
            Cobertura de mercados, bolsa de valores, empresas, finanzas y economía nacional
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">⚽</div>
          <div class="feature-title">Noticias Deportivas</div>
          <div class="feature-description">
            Resultados deportivos, competencias, selecciones nacionales y eventos deportivos
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-icon">🍪</div>
          <div class="feature-title">Persistencia</div>
          <div class="feature-description">
            Sistema de cookies que recuerda tus preferencias entre diferentes sesiones
          </div>
        </div>
      </div>

      <div class="demo-preview">
        <h4>👀 Vista Previa de Configuración</h4>
        <p>Así se verán las opciones de configuración en el periódico:</p>
        <div class="demo-options">
          <div class="demo-option">🏛️ Noticia Política</div>
          <div class="demo-option">📈 Noticia Económica</div>
          <div class="demo-option">⚽ Noticia Deportiva</div>
        </div>
      </div>

      <div class="action-buttons">
        <a href="periódico.php" class="btn btn-primary">📰 Acceder al Periódico</a>
        <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
      </div>

      <div class="technical-info">
        <h3>🔧 Implementación Técnica</h3>
        <ul>
          <li><strong>Interfaz:</strong> Formulario con radio buttons para selección</li>
          <li><strong>Backend:</strong> PHP para procesamiento y gestión de cookies</li>
          <li><strong>Almacenamiento:</strong> Cookie "tipo_noticia_preferida" con 30 días de duración</li>
          <li><strong>Contenido:</strong> Base de datos simulada con noticias de cada categoría</li>
          <li><strong>Responsive:</strong> Diseño adaptativo para dispositivos móviles</li>
          <li><strong>UX:</strong> Feedback visual y confirmaciones de acciones</li>
        </ul>

        <div class="code-snippet">
          <span class="keyword">if</span> (<span class="function">isset</span>(<span class="keyword">$_COOKIE</span>[<span class="string">'tipo_noticia_preferida'</span>])) {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="keyword">$tipo_seleccionado</span> = <span class="keyword">$_COOKIE</span>[<span class="string">'tipo_noticia_preferida'</span>];<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="comment">// Mostrar solo titular seleccionado</span><br>
          } <span class="keyword">else</span> {<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<span class="comment">// Primera visita: mostrar todos los titulares</span><br>
          }
        </div>
      </div>
    </div>
  </div>
</body>

</html>