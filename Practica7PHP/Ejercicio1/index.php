<?php
session_start();

// Verificar si se ha enviado una selección de estilo
if (isset($_POST['estilo'])) {
  $_SESSION['estilo_usuario'] = $_POST['estilo'];

  // También guardamos en una cookie para persistencia (30 días)
  setcookie('estilo_preferido', $_POST['estilo'], time() + (30 * 24 * 60 * 60), '/');
}

// Determinar qué estilo usar
$estilo_actual = 'claro'; // Estilo por defecto

// Prioridad: POST > SESSION > COOKIE > DEFAULT
if (isset($_POST['estilo'])) {
  $estilo_actual = $_POST['estilo'];
} elseif (isset($_SESSION['estilo_usuario'])) {
  $estilo_actual = $_SESSION['estilo_usuario'];
} elseif (isset($_COOKIE['estilo_preferido'])) {
  $estilo_actual = $_COOKIE['estilo_preferido'];
  $_SESSION['estilo_usuario'] = $estilo_actual; // Sincronizar con la sesión
}

// Validar que el estilo existe
$estilos_disponibles = ['claro', 'oscuro', 'colorido'];
if (!in_array($estilo_actual, $estilos_disponibles)) {
  $estilo_actual = 'claro';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Práctica 7 - Sesiones y Cookies PHP</title>
  <link rel="stylesheet" href="css/<?php echo $estilo_actual; ?>.css">
</head>

<body>
  <div class="container">
    <header>
      <h1>Bienvenido a la Práctica 7</h1>
      <p class="subtitle">Manejo de Sesiones y Cookies con PHP</p>
    </header>

    <main>
      <section class="info-section">
        <h2>Información de la Sesión</h2>
        <div class="info-box">
          <p><strong>Estilo actual:</strong> <?php echo ucfirst($estilo_actual); ?></p>
          <p><strong>ID de sesión:</strong> <?php echo session_id(); ?></p>
          <p><strong>Guardado en sesión:</strong> <?php echo isset($_SESSION['estilo_usuario']) ? 'Sí' : 'No'; ?></p>
          <p><strong>Guardado en cookie:</strong> <?php echo isset($_COOKIE['estilo_preferido']) ? 'Sí' : 'No'; ?></p>
        </div>
      </section>

      <section class="form-section">
        <h2>Seleccionar Estilo</h2>
        <p>Elige tu estilo preferido. La página recordará tu elección en futuras visitas.</p>

        <form method="POST" action="">
          <div class="radio-group">
            <div class="radio-option">
              <input type="radio" id="claro" name="estilo" value="claro"
                <?php echo ($estilo_actual == 'claro') ? 'checked' : ''; ?>>
              <label for="claro">Tema Claro</label>
              <small>Fondo blanco, texto oscuro, diseño minimalista</small>
            </div>

            <div class="radio-option">
              <input type="radio" id="oscuro" name="estilo" value="oscuro"
                <?php echo ($estilo_actual == 'oscuro') ? 'checked' : ''; ?>>
              <label for="oscuro">Tema Oscuro</label>
              <small>Fondo oscuro, texto claro, ideal para la noche</small>
            </div>

            <div class="radio-option">
              <input type="radio" id="colorido" name="estilo" value="colorido"
                <?php echo ($estilo_actual == 'colorido') ? 'checked' : ''; ?>>
              <label for="colorido">Tema Colorido</label>
              <small>Colores vibrantes, gradientes y animaciones</small>
            </div>
          </div>

          <button type="submit" class="btn-submit">Aplicar Estilo</button>
        </form>
      </section>

      <section class="demo-section">
        <h2>Contenido de Demostración</h2>
        <p>Este es un párrafo de ejemplo para mostrar cómo se ve el texto con el estilo seleccionado.</p>

        <div class="demo-cards">
          <div class="card">
            <h3>Tarjeta 1</h3>
            <p>Contenido de la primera tarjeta.</p>
          </div>
          <div class="card">
            <h3>Tarjeta 2</h3>
            <p>Contenido de la segunda tarjeta.</p>
          </div>
          <div class="card">
            <h3>Tarjeta 3</h3>
            <p>Contenido de la tercera tarjeta.</p>
          </div>
        </div>
      </section>
    </main>

    <footer>
      <p>&copy; 2025 - Práctica de PHP con Sesiones y Cookies</p>
      <a href="reset.php" class="reset-link">Resetear Preferencias</a>
    </footer>
  </div>
</body>

</html>