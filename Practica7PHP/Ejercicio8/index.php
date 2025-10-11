<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscador de Canciones - Ejercicio 8</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
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
      background: linear-gradient(45deg, #f093fb, #f5576c);
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
    }

    .header h1 {
      font-size: 3em;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.9;
    }

    .music-icon {
      position: absolute;
      top: 30px;
      right: 30px;
      font-size: 3em;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-15px);
      }
    }

    .content {
      padding: 40px;
    }

    .intro {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #f093fb;
    }

    .intro h3 {
      color: #0c5460;
      margin-bottom: 15px;
      font-size: 1.4em;
    }

    .intro p {
      color: #0c5460;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    .search-section {
      background: white;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
    }

    .search-section h3 {
      color: #333;
      margin-bottom: 25px;
      font-size: 1.6em;
      text-align: center;
    }

    .search-form {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 10px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
      font-size: 1.05em;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 15px;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      font-size: 1.05em;
      transition: all 0.3s ease;
      background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: #f093fb;
      box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.1);
      transform: translateY(-2px);
    }

    .search-buttons {
      grid-column: 1 / -1;
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-top: 10px;
    }

    .btn {
      display: inline-block;
      padding: 15px 35px;
      margin: 5px;
      text-decoration: none;
      border-radius: 30px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1em;
      text-transform: uppercase;
      letter-spacing: 1px;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(45deg, #f093fb, #f5576c);
      color: white;
      box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
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

    .results-section {
      margin-top: 30px;
    }

    .results-header {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      padding: 20px 30px;
      border-radius: 12px 12px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .results-header h3 {
      font-size: 1.5em;
    }

    .results-count {
      background: rgba(255, 255, 255, 0.2);
      padding: 8px 20px;
      border-radius: 20px;
      font-weight: bold;
    }

    .results-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      padding: 25px;
      background: #f8f9fa;
      border-radius: 0 0 12px 12px;
    }

    .song-card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      border-left: 5px solid #f093fb;
    }

    .song-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .song-icon {
      font-size: 2.5em;
      text-align: center;
      margin-bottom: 15px;
    }

    .song-title {
      font-size: 1.4em;
      font-weight: bold;
      color: #333;
      margin-bottom: 8px;
    }

    .song-artist {
      font-size: 1.1em;
      color: #666;
      margin-bottom: 12px;
    }

    .song-details {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 2px solid #f0f0f0;
    }

    .song-detail {
      font-size: 0.9em;
      color: #666;
    }

    .song-detail strong {
      display: block;
      color: #f093fb;
      margin-bottom: 3px;
      font-size: 0.85em;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .no-results {
      text-align: center;
      padding: 60px 30px;
      color: #666;
      background: #f8f9fa;
      border-radius: 12px;
    }

    .no-results-icon {
      font-size: 4em;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .database-info {
      background: #fff3cd;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border: 1px solid #ffeaa7;
    }

    .database-info h4 {
      color: #856404;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .database-info p {
      color: #856404;
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
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
      border-top: 4px solid #f093fb;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-icon {
      font-size: 2.5em;
      margin-bottom: 15px;
      display: block;
    }

    .feature-card h4 {
      color: #333;
      margin-bottom: 10px;
      font-size: 1.2em;
    }

    .feature-card p {
      color: #666;
      line-height: 1.5;
      font-size: 0.95em;
    }

    .actions {
      text-align: center;
      margin-top: 40px;
      padding-top: 30px;
      border-top: 2px solid #e9ecef;
    }

    .alert {
      padding: 20px;
      margin: 20px 0;
      border-radius: 10px;
      border-left: 5px solid;
      animation: fadeIn 0.5s ease-out;
    }

    .alert-success {
      background: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    .alert-info {
      background: #cce7ff;
      border-color: #f093fb;
      color: #0c5460;
    }

    .alert-warning {
      background: #fff3cd;
      border-color: #ffc107;
      color: #856404;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2.2em;
      }

      .content {
        padding: 25px;
      }

      .search-form {
        grid-template-columns: 1fr;
      }

      .search-buttons {
        flex-direction: column;
      }

      .btn {
        width: 100%;
      }

      .results-grid {
        grid-template-columns: 1fr;
      }

      .music-icon {
        position: static;
        margin: 20px auto;
        display: block;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="music-icon">🎵</div>
      <h1>🎵 Buscador de Canciones</h1>
      <p>Ejercicio 8 - Sistema de Búsqueda Musical con Base de Datos</p>
    </div>

    <div class="content">
      <div class="intro">
        <h3>🎯 Encuentra tu Música Favorita</h3>
        <p>
          Explora nuestra biblioteca musical y encuentra canciones por título o artista.
          Este sistema utiliza una base de datos MySQL para almacenar información musical
          y sesiones PHP para mantener un historial de tus búsquedas.
        </p>
      </div>

      <div class="database-info">
        <h4>⚠️ Configuración Requerida</h4>
        <p>
          <strong>Base de Datos:</strong> prueba<br>
          <strong>Tabla:</strong> buscador<br>
          Si es la primera vez que usas este sistema, configura la base de datos primero.
        </p>
        <div style="text-align: center; margin-top: 15px;">
          <a href="configurar_bd.php" class="btn btn-secondary">
            🛠️ Configurar Base de Datos
          </a>
        </div>
      </div>

      <div class="features">
        <div class="feature-card">
          <span class="feature-icon">🗄️</span>
          <h4>Base de Datos MySQL</h4>
          <p>Biblioteca musical almacenada en base de datos 'prueba' con información completa</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">🔍</span>
          <h4>Búsqueda Inteligente</h4>
          <p>Encuentra canciones por título, artista o ambos criterios simultáneamente</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">📊</span>
          <h4>Historial de Sesión</h4>
          <p>Mantiene registro de todas tus búsquedas durante la sesión actual</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">⚡</span>
          <h4>Resultados Dinámicos</h4>
          <p>Visualización instantánea de resultados con información detallada</p>
        </div>
      </div>

      <div class="search-section">
        <h3>🔍 Buscar Canciones</h3>

        <form action="buscar.php" method="GET" class="search-form">
          <div class="form-group">
            <label for="titulo">🎵 Título de la Canción:</label>
            <input
              type="text"
              id="titulo"
              name="titulo"
              placeholder="Ejemplo: Bohemian Rhapsody">
          </div>

          <div class="form-group">
            <label for="artista">🎤 Artista o Banda:</label>
            <input
              type="text"
              id="artista"
              name="artista"
              placeholder="Ejemplo: Queen">
          </div>

          <div class="search-buttons">
            <button type="submit" class="btn btn-primary">
              🔍 Buscar Canciones
            </button>
            <button type="reset" class="btn btn-secondary">
              🔄 Limpiar Filtros
            </button>
          </div>
        </form>

        <div class="alert alert-info">
          <strong>💡 Consejo:</strong>
          Puedes buscar por título, por artista, o por ambos. Deja un campo vacío para buscar solo por el otro criterio.
        </div>
      </div>

      <div class="actions">
        <a href="buscar.php" class="btn btn-success">
          🎵 Ver Todas las Canciones
        </a>
        <a href="historial.php" class="btn btn-primary">
          📈 Ver Historial de Búsquedas
        </a>
        <a href="configurar_bd.php" class="btn btn-secondary">
          🛠️ Configurar Base de Datos
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>

  <script>
    // Validación y efectos visuales
    document.querySelector('form').addEventListener('submit', function(e) {
      const titulo = document.getElementById('titulo').value.trim();
      const artista = document.getElementById('artista').value.trim();

      if (!titulo && !artista) {
        e.preventDefault();
        alert('Por favor, ingresa al menos un criterio de búsqueda (título o artista).');
        return false;
      }
    });

    // Animación de las tarjetas de características
    window.addEventListener('load', function() {
      const cards = document.querySelectorAll('.feature-card');
      cards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          card.style.transition = 'all 0.5s ease';

          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 100);
      });
    });
  </script>
</body>

</html>