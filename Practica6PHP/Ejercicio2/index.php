<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ABML Ciudades - Sistema de Gestión</title>
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

    .container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      padding: 40px;
      text-align: center;
      max-width: 600px;
      width: 100%;
    }

    h1 {
      color: #333;
      margin-bottom: 30px;
      font-size: 2.5rem;
      font-weight: 300;
    }

    .subtitle {
      color: #666;
      margin-bottom: 40px;
      font-size: 1.1rem;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .menu-item {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 25px 20px;
      border-radius: 10px;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .menu-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .menu-item h3 {
      margin-bottom: 10px;
      font-size: 1.3rem;
    }

    .menu-item p {
      font-size: 0.9rem;
      opacity: 0.9;
    }

    .listado-section {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin-top: 30px;
    }

    .listado-section h3 {
      color: #333;
      margin-bottom: 15px;
    }

    .listado-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .listado-btn {
      background: #28a745;
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.3s ease;
      font-weight: 500;
    }

    .listado-btn:hover {
      background: #218838;
      transform: translateY(-2px);
    }

    .listado-btn.paginated {
      background: #007bff;
    }

    .listado-btn.paginated:hover {
      background: #0056b3;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        margin: 10px;
      }

      h1 {
        font-size: 2rem;
      }

      .menu-grid {
        grid-template-columns: 1fr;
      }

      .listado-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>🏙️ Sistema ABML</h1>
    <p class="subtitle">Gestión de Ciudades del Mundo</p>

    <div class="menu-grid">
      <a href="alta.php" class="menu-item">
        <h3>➕ Alta</h3>
        <p>Agregar nueva ciudad</p>
      </a>

      <a href="baja.php" class="menu-item">
        <h3>🗑️ Baja</h3>
        <p>Eliminar ciudad existente</p>
      </a>

      <a href="modificacion.php" class="menu-item">
        <h3>✏️ Modificación</h3>
        <p>Editar información de ciudad</p>
      </a>
    </div>

    <div class="listado-section">
      <h3>📋 Opciones de Listado</h3>
      <div class="listado-buttons">
        <a href="listado.php" class="listado-btn">Ver Todas las Ciudades</a>
        <a href="listado_paginado.php" class="listado-btn paginated">Listado con Paginación</a>
      </div>
    </div>
  </div>
</body>

</html>