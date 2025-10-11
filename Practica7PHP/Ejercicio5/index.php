<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 5 - Formulario de Login</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      max-width: 500px;
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

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .icon {
      font-size: 4em;
      margin-bottom: 15px;
      background: linear-gradient(45deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .title {
      color: #333;
      font-size: 2.2em;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .subtitle {
      color: #666;
      font-size: 1.1em;
      font-style: italic;
    }

    .exercise-info {
      background: #e8f4f8;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      border-left: 4px solid #17a2b8;
    }

    .exercise-info h3 {
      color: #0c5460;
      margin-bottom: 10px;
    }

    .exercise-info p {
      color: #0c5460;
      line-height: 1.5;
      margin-bottom: 8px;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
      font-size: 1.1em;
    }

    .form-group input[type="text"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 15px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 1.1em;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      background: #f8f9fa;
    }

    .form-group input:focus {
      outline: none;
      border-color: #667eea;
      background: white;
      box-shadow: 0 0 15px rgba(102, 126, 234, 0.2);
    }

    .form-group small {
      color: #6c757d;
      font-size: 0.9em;
      margin-top: 5px;
      display: block;
    }

    .btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.2em;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 20px;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .navigation {
      text-align: center;
      margin-top: 20px;
    }

    .nav-link {
      color: #667eea;
      text-decoration: none;
      font-weight: bold;
      padding: 10px 20px;
      border: 2px solid #667eea;
      border-radius: 25px;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .nav-link:hover {
      background: #667eea;
      color: white;
      transform: translateY(-2px);
    }

    .demo-credentials {
      background: #fff3cd;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      border: 1px solid #ffeaa7;
    }

    .demo-credentials h4 {
      color: #856404;
      margin-bottom: 10px;
    }

    .demo-credentials p {
      color: #856404;
      margin-bottom: 5px;
      font-family: monospace;
    }

    @media (max-width: 768px) {
      .login-container {
        padding: 25px;
        margin: 10px;
      }

      .title {
        font-size: 1.8em;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="header">
      <div class="icon">🔐</div>
      <h1 class="title">Formulario de Login</h1>
      <p class="subtitle">Ejercicio N°5 - Manejo de Sesiones</p>
    </div>

    <div class="exercise-info">
      <h3>📋 Objetivo del Ejercicio</h3>
      <p><strong>Página 1:</strong> Formulario para capturar usuario y contraseña</p>
      <p><strong>Página 2:</strong> Crear variables de sesión con los datos</p>
      <p><strong>Página 3:</strong> Recuperar y mostrar los valores de sesión</p>
    </div>

    <div class="demo-credentials">
      <h4>🎯 Credenciales de Demostración</h4>
      <p><strong>Usuario:</strong> admin</p>
      <p><strong>Clave:</strong> 123456</p>
      <p><em>Puedes usar cualquier combinación para probar</em></p>
    </div>

    <form action="procesar_login.php" method="POST">
      <div class="form-group">
        <label for="usuario">👤 Nombre de Usuario:</label>
        <input
          type="text"
          id="usuario"
          name="usuario"
          placeholder="Ingresa tu nombre de usuario..."
          required
          maxlength="50">
        <small>Mínimo 3 caracteres, máximo 50</small>
      </div>

      <div class="form-group">
        <label for="clave">🔑 Contraseña:</label>
        <input
          type="password"
          id="clave"
          name="clave"
          placeholder="Ingresa tu contraseña..."
          required
          minlength="4">
        <small>Mínimo 4 caracteres para mayor seguridad</small>
      </div>

      <button type="submit" class="btn">
        🚀 Iniciar Sesión
      </button>
    </form>

    <div class="navigation">
      <a href="../index.php" class="nav-link">🏠 Volver al Menú Principal</a>
    </div>
  </div>

  <script>
    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
      const usuario = document.getElementById('usuario').value.trim();
      const clave = document.getElementById('clave').value.trim();

      if (usuario.length < 3) {
        e.preventDefault();
        alert('El nombre de usuario debe tener al menos 3 caracteres.');
        document.getElementById('usuario').focus();
        return false;
      }

      if (clave.length < 4) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 4 caracteres.');
        document.getElementById('clave').focus();
        return false;
      }
    });

    // Auto-focus en el primer campo
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('usuario').focus();
    });

    // Efecto de escritura en tiempo real
    document.getElementById('usuario').addEventListener('input', function() {
      if (this.value.length >= 3) {
        this.style.borderColor = '#28a745';
      } else {
        this.style.borderColor = '#e0e0e0';
      }
    });

    document.getElementById('clave').addEventListener('input', function() {
      if (this.value.length >= 4) {
        this.style.borderColor = '#28a745';
      } else {
        this.style.borderColor = '#e0e0e0';
      }
    });
  </script>
</body>

</html>