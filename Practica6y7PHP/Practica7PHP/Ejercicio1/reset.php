<?php
session_start();

// Limpiar la sesión
unset($_SESSION['estilo_usuario']);

// Eliminar la cookie
setcookie('estilo_preferido', '', time() - 3600, '/');

// Mensaje de confirmación y redirección
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preferencias Reseteadas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .message-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 400px;
    }

    .success {
      color: #28a745;
      font-size: 18px;
      margin-bottom: 20px;
    }

    .btn {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
      margin-top: 15px;
    }

    .btn:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="message-box">
    <h2 class="success">✓ Preferencias Reseteadas</h2>
    <p>Se han eliminado todas las preferencias de estilo guardadas en la sesión y cookies.</p>
    <p>La próxima vez que visites la página, se mostrará el estilo por defecto.</p>
    <a href="index.php" class="btn">Volver al Inicio</a>
  </div>
</body>

</html>