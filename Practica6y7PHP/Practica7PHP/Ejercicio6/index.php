<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Búsqueda de Email de Estudiantes - Ejercicio 6</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
      background: linear-gradient(45deg, #4facfe, #00f2fe);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .header h1 {
      font-size: 2.8em;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.9;
    }

    .content {
      padding: 40px;
    }

    .intro {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #4facfe;
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

    .search-form {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 30px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #333;
      font-size: 1.1em;
    }

    .form-group input {
      width: 100%;
      padding: 15px;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      font-size: 1.1em;
      transition: all 0.3s ease;
      background: white;
    }

    .form-group input:focus {
      outline: none;
      border-color: #4facfe;
      box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
      transform: translateY(-2px);
    }

    .form-group .help-text {
      font-size: 0.9em;
      color: #6c757d;
      margin-top: 5px;
    }

    .btn {
      display: inline-block;
      padding: 15px 30px;
      margin: 10px 5px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1.1em;
      text-transform: uppercase;
      letter-spacing: 1px;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(45deg, #4facfe, #00f2fe);
      color: white;
      box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
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

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
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

    .database-schema {
      background: #2d3748;
      color: #e2e8f0;
      padding: 20px;
      border-radius: 8px;
      font-family: 'Courier New', monospace;
      font-size: 0.9em;
      margin-top: 15px;
      overflow-x: auto;
    }

    .example-data {
      background: #d4edda;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 4px solid #28a745;
    }

    .example-data h5 {
      color: #155724;
      margin-bottom: 15px;
      font-size: 1.2em;
    }

    .example-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .example-table th,
    .example-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    .example-table th {
      background: #4facfe;
      color: white;
      font-weight: bold;
    }

    .example-table tr:hover {
      background: #f8f9fa;
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
      border-top: 4px solid #4facfe;
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
      margin-top: 30px;
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
    }

    .alert {
      padding: 15px 20px;
      margin: 20px 0;
      border-radius: 8px;
      border-left: 4px solid;
    }

    .alert-info {
      background: #cce7ff;
      border-color: #4facfe;
      color: #0c5460;
    }

    .alert-warning {
      background: #fff3cd;
      border-color: #ffc107;
      color: #856404;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>📧 Búsqueda de Email de Estudiantes</h1>
      <p>Ejercicio 6 - Integración con Base de Datos</p>
    </div>

    <div class="content">
      <div class="intro">
        <h3>🎯 Sistema de Consulta de Emails Estudiantiles</h3>
        <p>
          Esta aplicación permite buscar el email de estudiantes utilizando su número de matrícula.
          Los datos se almacenan en una base de datos MySQL y se gestionan mediante sesiones PHP
          para mantener un historial de búsquedas durante la sesión del usuario.
        </p>
      </div>

      <div class="database-info">
        <h4>🗄️ Información de la Base de Datos</h4>
        <p><strong>Base de Datos:</strong> base2</p>
        <p><strong>Tabla:</strong> alumnos</p>
        <p><strong>Estructura de la tabla:</strong></p>
        <div class="database-schema">CREATE TABLE alumnos (
          id INT AUTO_INCREMENT PRIMARY KEY,
          matricula VARCHAR(20) NOT NULL UNIQUE,
          nombre VARCHAR(100) NOT NULL,
          apellidos VARCHAR(100) NOT NULL,
          email VARCHAR(100) NOT NULL,
          carrera VARCHAR(100),
          semestre INT,
          fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
          );</div>
      </div>

      <div class="example-data">
        <h5>📊 Datos de Ejemplo en la Base de Datos</h5>
        <table class="example-table">
          <thead>
            <tr>
              <th>Matrícula</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Email</th>
              <th>Carrera</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2021001</td>
              <td>Ana</td>
              <td>García López</td>
              <td>ana.garcia@universidad.edu</td>
              <td>Ing. en Sistemas</td>
            </tr>
            <tr>
              <td>2021002</td>
              <td>Carlos</td>
              <td>Rodríguez Pérez</td>
              <td>carlos.rodriguez@universidad.edu</td>
              <td>Ing. Industrial</td>
            </tr>
            <tr>
              <td>2021003</td>
              <td>María</td>
              <td>Hernández Silva</td>
              <td>maria.hernandez@universidad.edu</td>
              <td>Medicina</td>
            </tr>
            <tr>
              <td>2021004</td>
              <td>José</td>
              <td>Martínez Cruz</td>
              <td>jose.martinez@universidad.edu</td>
              <td>Derecho</td>
            </tr>
          </tbody>
        </table>
      </div>

      <form action="buscar_email.php" method="POST" class="search-form">
        <h3 style="margin-bottom: 20px; color: #333; text-align: center;">🔍 Buscar Email por Matrícula</h3>

        <div class="form-group">
          <label for="matricula">📝 Número de Matrícula del Estudiante:</label>
          <input
            type="text"
            id="matricula"
            name="matricula"
            placeholder="Ejemplo: 2021001, 2021002, etc."
            required
            pattern="[0-9]+"
            title="Solo se permiten números"
            maxlength="10">
          <div class="help-text">
            Ingresa el número de matrícula del estudiante que deseas buscar
          </div>
        </div>

        <div style="text-align: center;">
          <button type="submit" class="btn btn-primary">
            🔍 Buscar Email
          </button>
          <button type="reset" class="btn btn-secondary">
            🔄 Limpiar Formulario
          </button>
        </div>
      </form>

      <div class="alert alert-info">
        <strong>💡 Información:</strong>
        El sistema utilizará sesiones para mantener un historial de tus búsquedas durante esta sesión.
        Puedes buscar múltiples estudiantes y ver el historial completo.
      </div>

      <div class="alert alert-warning">
        <strong>⚠️ Nota:</strong>
        Para que este ejercicio funcione correctamente, asegúrate de tener configurada la base de datos 'base2'
        con la tabla 'alumnos' y algunos registros de prueba.
      </div>

      <div class="features">
        <div class="feature-card">
          <span class="feature-icon">🗄️</span>
          <h4>Base de Datos MySQL</h4>
          <p>Conexión a base de datos 'base2' con tabla 'alumnos' para almacenar información estudiantil</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">🔍</span>
          <h4>Búsqueda por Matrícula</h4>
          <p>Sistema de búsqueda eficiente que permite encontrar estudiantes por su número de matrícula</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">📊</span>
          <h4>Gestión de Sesiones</h4>
          <p>Mantiene historial de búsquedas realizadas durante la sesión actual del usuario</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">📱</span>
          <h4>Diseño Responsivo</h4>
          <p>Interfaz moderna y adaptable que funciona perfectamente en todos los dispositivos</p>
        </div>
      </div>

      <div class="actions">
        <a href="ver_historial.php" class="btn btn-success">
          📈 Ver Historial de Búsquedas
        </a>
        <a href="crear_base_datos.php" class="btn btn-secondary">
          🛠️ Configurar Base de Datos
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>

  <script>
    // Validación en tiempo real
    document.getElementById('matricula').addEventListener('input', function(e) {
      const value = e.target.value;
      const helpText = e.target.nextElementSibling;

      if (value.length === 0) {
        helpText.textContent = 'Ingresa el número de matrícula del estudiante que deseas buscar';
        helpText.style.color = '#6c757d';
      } else if (!/^[0-9]+$/.test(value)) {
        helpText.textContent = '⚠️ Solo se permiten números';
        helpText.style.color = '#dc3545';
      } else if (value.length < 4) {
        helpText.textContent = '⚠️ La matrícula debe tener al menos 4 dígitos';
        helpText.style.color = '#ffc107';
      } else {
        helpText.textContent = '✅ Formato de matrícula válido';
        helpText.style.color = '#28a745';
      }
    });

    // Animación de entrada
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