<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Práctica 7 - Manejo de Sesiones y Cookies PHP</title>
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
      max-width: 1000px;
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
      padding: 40px;
      text-align: center;
    }

    .header h1 {
      font-size: 3em;
      margin-bottom: 15px;
      font-weight: 300;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.9;
      margin-bottom: 10px;
    }

    .subtitle {
      font-size: 1em;
      opacity: 0.8;
      font-style: italic;
    }

    .content {
      padding: 40px;
    }

    .intro {
      text-align: center;
      margin-bottom: 40px;
    }

    .intro h2 {
      color: #333;
      font-size: 2em;
      margin-bottom: 15px;
    }

    .intro p {
      color: #666;
      font-size: 1.1em;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto;
    }

    .exercises {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: 30px;
      margin: 40px 0;
    }

    .exercise-card {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 2px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .exercise-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(45deg, #667eea, #764ba2);
    }

    .exercise-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      border-color: #667eea;
    }

    .exercise-number {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5em;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .exercise-title {
      color: #333;
      font-size: 1.5em;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .exercise-description {
      color: #666;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .exercise-features {
      list-style: none;
      margin-bottom: 25px;
    }

    .exercise-features li {
      color: #555;
      margin-bottom: 8px;
      padding-left: 20px;
      position: relative;
    }

    .exercise-features li::before {
      content: '✓';
      position: absolute;
      left: 0;
      color: #28a745;
      font-weight: bold;
    }

    .exercise-actions {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn {
      display: inline-block;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 0.9em;
      text-align: center;
      flex: 1;
      min-width: 120px;
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
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .status {
      display: inline-block;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.8em;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .status-completed {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .footer {
      background: #f8f9fa;
      padding: 30px;
      text-align: center;
      border-top: 1px solid #e0e0e0;
    }

    .footer h3 {
      color: #333;
      margin-bottom: 15px;
    }

    .footer p {
      color: #666;
      line-height: 1.6;
    }

    .tech-stack {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px 0;
      flex-wrap: wrap;
    }

    .tech-item {
      background: white;
      padding: 10px 20px;
      border-radius: 25px;
      font-weight: bold;
      color: #333;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2.2em;
      }

      .content {
        padding: 25px;
      }

      .exercises {
        grid-template-columns: 1fr;
        gap: 20px;
      }

      .exercise-actions {
        flex-direction: column;
      }

      .btn {
        flex: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📚 PRÁCTICA 7</h1>
      <p>Manejo de Sesiones y Cookies con PHP</p>
      <p class="subtitle">Desarrollo Web con PHP - Almacenamiento del Cliente</p>
    </div>

    <div class="content">
      <div class="intro">
        <h2>Bienvenido a la Práctica Completa</h2>
        <p>
          Esta práctica está diseñada para enseñar los conceptos fundamentales del manejo de
          <strong>sesiones</strong> y <strong>cookies</strong> en PHP. A través de ejercicios prácticos,
          aprenderás cómo mantener el estado del usuario, personalizar experiencias web y gestionar
          datos persistentes en aplicaciones web modernas.
        </p>
      </div>

      <div class="exercises">
        <!-- Ejercicio 1 -->
        <div class="exercise-card">
          <div class="exercise-number">1</div>
          <div class="status status-completed">✅ Completado</div>
          <div class="exercise-title">Selector de Estilos CSS</div>
          <div class="exercise-description">
            Implementa una página web que permite al usuario elegir entre diferentes temas visuales.
            Las preferencias se almacenan usando sesiones y cookies para recordar la elección entre visitas.
          </div>
          <ul class="exercise-features">
            <li>3 temas diferentes (Claro, Oscuro, Colorido)</li>
            <li>Persistencia con sesiones y cookies</li>
            <li>Formulario de selección dinámico</li>
            <li>Sistema de prioridades de carga</li>
            <li>Función de reset de preferencias</li>
          </ul>
          <div class="exercise-actions">
            <a href="Ejercicio1/" class="btn btn-primary">🚀 Ver Ejercicio</a>
          </div>
        </div>

        <!-- Ejercicio 2 -->
        <div class="exercise-card">
          <div class="exercise-number">2</div>
          <div class="status status-completed">✅ Completado</div>
          <div class="exercise-title">Contador de Visitas</div>
          <div class="exercise-description">
            Crea un sistema de contador que registra el número de veces que un usuario ha visitado
            la página utilizando cookies. Incluye mensajes personalizados y sistema de logros.
          </div>
          <ul class="exercise-features">
            <li>Cookie persistente por 30 días</li>
            <li>Detección de primera visita</li>
            <li>Contador automático incremental</li>
            <li>Sistema de logros por milestones</li>
            <li>Información técnica detallada</li>
          </ul>
          <div class="exercise-actions">
            <a href="Ejercicio2/" class="btn btn-primary">🔢 Ver Contador</a>
          </div>
        </div>

        <!-- Ejercicio 3 -->
        <div class="exercise-card">
          <div class="exercise-number">3</div>
          <div class="status status-completed">✅ Completado</div>
          <div class="exercise-title">Formulario de Usuario</div>
          <div class="exercise-description">
            Implementa un formulario que solicita el nombre de usuario y crea una cookie para recordarlo.
            En futuras visitas, el formulario muestra automáticamente el último nombre ingresado.
          </div>
          <ul class="exercise-features">
            <li>Formulario con validación completa</li>
            <li>Cookie persistente del usuario</li>
            <li>Auto-completado inteligente</li>
            <li>Sanitización de datos de entrada</li>
            <li>Sistema de limpieza de cookies</li>
          </ul>
          <div class="exercise-actions">
            <a href="Ejercicio3/" class="btn btn-primary">👤 Ver Formulario</a>
          </div>
        </div>

        <!-- Ejercicio 4 -->
        <div class="exercise-card">
          <div class="exercise-number">4</div>
          <div class="status status-completed">✅ Completado</div>
          <div class="exercise-title">Periódico Digital</div>
          <div class="exercise-description">
            Simula un periódico digital que permite configurar qué tipo de titular mostrar (política, económica, deportiva).
            Utiliza cookies para recordar la preferencia del usuario entre visitas.
          </div>
          <ul class="exercise-features">
            <li>Simulación completa de periódico</li>
            <li>Tres categorías de noticias</li>
            <li>Radio buttons de configuración</li>
            <li>Primera visita muestra todo</li>
            <li>Sistema de limpieza de preferencias</li>
          </ul>
          <div class="exercise-actions">
            <a href="Ejercicio4/" class="btn btn-primary">📰 Ver Periódico</a>
          </div>
        </div>

        <!-- Ejercicio 5 -->
        <div class="exercise-card">
          <div class="exercise-number">5</div>
          <div class="status status-completed">✅ Completado</div>
          <h3>Sistema de Login con Sesiones</h3>
          <p class="exercise-description">
            Un sistema completo de autenticación con 3 páginas: formulario de login,
            procesamiento de sesiones y visualización de datos almacenados. Incluye
            validación de formularios, manejo seguro de sesiones y cierre de sesión.
          </p>
          <div class="features">
            <span class="feature">🔐 Formulario de Login</span>
            <span class="feature">⚙️ Procesamiento de Sesiones</span>
            <span class="feature">📊 Visualización de Datos</span>
            <span class="feature">🚪 Cierre de Sesión</span>
            <span class="feature">🔒 Validación y Seguridad</span>
          </div>
          <div class="exercise-actions">
            <a href="Ejercicio5/" class="btn btn-primary">🔐 Probar Login</a>
          </div>
        </div>

        <!-- Ejercicio 6 -->
        <div class="exercise-card">
          <div class="exercise-number">6</div>
          <div class="status status-completed">✅ Completado</div>
          <h3>Búsqueda de Emails con Base de Datos</h3>
          <p class="exercise-description">
            Sistema de consulta de emails estudiantiles que integra MySQL con PHP.
            Permite buscar estudiantes por matrícula, mantiene historial de búsquedas
            en sesiones y muestra estadísticas en tiempo real.
          </p>
          <div class="features">
            <span class="feature">🗄️ Base de Datos MySQL</span>
            <span class="feature">🔍 Búsqueda por Matrícula</span>
            <span class="feature">📈 Historial de Sesión</span>
            <span class="feature">📊 Estadísticas en Tiempo Real</span>
            <span class="feature">🛠️ Configuración Automática</span>
          </div>
          <div class="exercise-actions">
            <a href="Ejercicio6/" class="btn btn-primary">📧 Buscar Emails</a>
          </div>
        </div>

        <!-- Ejercicio 7 -->
        <div class="exercise-card">
          <div class="exercise-number">7</div>
          <div class="status status-completed">✅ Completado</div>
          <h3>Carrito de Compras con Base de Datos</h3>
          <p class="exercise-description">
            Sistema completo de tienda online con carrito de compras. Incluye catálogo
            de productos desde MySQL, gestión de inventario, cálculo automático de totales
            con IVA y persistencia del carrito mediante sesiones.
          </p>
          <div class="features">
            <span class="feature">🛒 Carrito Persistente</span>
            <span class="feature">💰 Cálculo Automático</span>
            <span class="feature">📦 Control de Stock</span>
            <span class="feature">🗄️ 20 Productos Variados</span>
            <span class="feature">⚡ AJAX en Tiempo Real</span>
          </div>
          <div class="exercise-actions">
            <a href="Ejercicio7/" class="btn btn-primary">🛍️ Ir a la Tienda</a>
          </div>
        </div>

        <!-- Ejercicio 8 -->
        <div class="exercise-card">
          <div class="exercise-number">8</div>
          <div class="status status-completed">✅ Completado</div>
          <h3>Buscador de Canciones con Base de Datos</h3>
          <p class="exercise-description">
            Sistema de búsqueda avanzado de canciones con MySQL. Permite buscar por título
            y/o artista, mantiene historial de búsquedas en sesiones, incluye 30 canciones
            icónicas y muestra estadísticas detalladas de uso.
          </p>
          <div class="features">
            <span class="feature">🔍 Búsqueda Dual (Título/Artista)</span>
            <span class="feature">📜 Historial de Búsquedas</span>
            <span class="feature">📊 Estadísticas en Tiempo Real</span>
            <span class="feature">🎵 30 Canciones Icónicas</span>
            <span class="feature">🎨 Tarjetas Estilizadas</span>
          </div>
          <div class="exercise-actions">
            <a href="Ejercicio8/" class="btn btn-primary">🎵 Buscar Canciones</a>
          </div>
        </div>
      </div>
    </div>

    <div class="footer">
      <h3>🛠️ Tecnologías Utilizadas</h3>
      <div class="tech-stack">
        <div class="tech-item">PHP 7.4+</div>
        <div class="tech-item">HTML5</div>
        <div class="tech-item">CSS3</div>
        <div class="tech-item">Cookies</div>
        <div class="tech-item">Sesiones</div>
      </div>
      <p>Desarrollado por [Arce Nahuel]
      </p>
    </div>
  </div>
</body>

</html>