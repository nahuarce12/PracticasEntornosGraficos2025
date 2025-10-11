<?php
// Base de datos de noticias
$noticias = [
  'politica' => [
    'titular' => 'Congreso aprueba nueva ley de transparencia gubernamental',
    'subtitular' => 'La medida busca fortalecer la rendición de cuentas públicas',
    'contenido' => 'En una sesión histórica que se extendió hasta altas horas de la madrugada, el Congreso Nacional aprobó por amplia mayoría la nueva Ley de Transparencia Gubernamental. Esta normativa establece mecanismos más estrictos para el acceso a la información pública y fortalece los sistemas de control ciudadano.',
    'autor' => 'María González - Corresponsal Política',
    'fecha' => '30 de Septiembre, 2025',
    'imagen' => '🏛️'
  ],
  'economica' => [
    'titular' => 'Bolsa de valores registra récord histórico en cierre de mes',
    'subtitular' => 'Inversionistas muestran optimismo por perspectivas del próximo trimestre',
    'contenido' => 'Los principales índices bursátiles cerraron septiembre con ganancias superiores al 8%, impulsados por el sector tecnológico y las empresas de energías renovables. Los analistas coinciden en que las perspectivas para el cuarto trimestre son favorables, especialmente para las empresas de innovación.',
    'autor' => 'Carlos Rodríguez - Editor Económico',
    'fecha' => '30 de Septiembre, 2025',
    'imagen' => '📈'
  ],
  'deportiva' => [
    'titular' => 'Selección nacional clasifica al Mundial tras victoria épica',
    'subtitular' => 'Un gol en los últimos minutos asegura el pase a la cita orbital',
    'contenido' => 'En un encuentro que mantuvo en vilo a todo el país, la selección nacional logró la clasificación al próximo Mundial de fútbol tras derrotar 2-1 a su rival tradicional. El gol de la victoria llegó en el minuto 89, desatando la euforia en el estadio y en las calles de todo el territorio nacional.',
    'autor' => 'Roberto Silva - Redactor Deportivo',
    'fecha' => '30 de Septiembre, 2025',
    'imagen' => '⚽'
  ]
];

// Procesar selección de tipo de noticia
$tipo_seleccionado = '';
$mensaje_configuracion = '';

// Verificar si se envió el formulario de configuración
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tipo_noticia'])) {
  $tipo_seleccionado = $_POST['tipo_noticia'];

  // Validar que el tipo sea válido
  if (array_key_exists($tipo_seleccionado, $noticias)) {
    // Guardar preferencia en cookie (30 días)
    setcookie('tipo_noticia_preferida', $tipo_seleccionado, time() + (30 * 24 * 60 * 60), '/');
    $mensaje_configuracion = "Preferencia guardada: mostrando noticias " . ucfirst($tipo_seleccionado) . "s";
  }
}

// Determinar qué noticias mostrar
$mostrar_todas = true;
$noticias_a_mostrar = [];

// Verificar cookie existente
if (isset($_COOKIE['tipo_noticia_preferida'])) {
  $tipo_cookie = $_COOKIE['tipo_noticia_preferida'];
  if (array_key_exists($tipo_cookie, $noticias)) {
    $mostrar_todas = false;
    $noticias_a_mostrar = [$tipo_cookie => $noticias[$tipo_cookie]];
    $tipo_seleccionado = $tipo_cookie;
  }
}

// Si se seleccionó un tipo específico, mostrarlo
if (!empty($tipo_seleccionado) && array_key_exists($tipo_seleccionado, $noticias)) {
  $mostrar_todas = false;
  $noticias_a_mostrar = [$tipo_seleccionado => $noticias[$tipo_seleccionado]];
}

// Si no hay preferencia, mostrar todas las noticias
if ($mostrar_todas) {
  $noticias_a_mostrar = $noticias;
}

$fecha_actual = date('l, j \d\e F \d\e Y');
$fecha_actual_es = str_replace(
  [
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday',
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ],
  [
    'Lunes',
    'Martes',
    'Miércoles',
    'Jueves',
    'Viernes',
    'Sábado',
    'Domingo',
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
  ],
  $fecha_actual
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>El Diario Digital - Noticias de Última Hora</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Georgia', 'Times New Roman', serif;
      background: #f8f9fa;
      line-height: 1.6;
    }

    .newspaper-container {
      max-width: 1200px;
      margin: 0 auto;
      background: white;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      min-height: 100vh;
    }

    /* Header del periódico */
    .newspaper-header {
      background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
      color: white;
      padding: 20px;
      border-bottom: 3px solid #ff6b35;
    }

    .masthead {
      text-align: center;
      border-bottom: 1px solid #444;
      padding-bottom: 15px;
      margin-bottom: 15px;
    }

    .newspaper-title {
      font-size: 3.5em;
      font-weight: bold;
      letter-spacing: 2px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      font-family: 'Georgia', serif;
    }

    .newspaper-subtitle {
      font-size: 1.1em;
      font-style: italic;
      opacity: 0.9;
      margin-top: 5px;
    }

    .header-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.9em;
    }

    .date {
      font-weight: bold;
    }

    .edition {
      font-style: italic;
    }

    /* Configuración de noticias */
    .news-config {
      background: #ff6b35;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .config-title {
      font-size: 1.3em;
      margin-bottom: 15px;
      font-weight: bold;
    }

    .radio-group {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .radio-option {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      padding: 10px 15px;
      border-radius: 25px;
      background: rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .radio-option:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
    }

    .radio-option input[type="radio"] {
      transform: scale(1.2);
      accent-color: white;
    }

    .radio-option.selected {
      background: rgba(255, 255, 255, 0.3);
      border-color: white;
    }

    .radio-option label {
      font-weight: bold;
      cursor: pointer;
      font-size: 1.1em;
    }

    .config-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 12px 25px;
      border: none;
      border-radius: 25px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      font-size: 1em;
    }

    .btn-primary {
      background: white;
      color: #ff6b35;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .btn-danger {
      background: #dc3545;
      color: white;
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-danger:hover {
      background: #c82333;
      transform: translateY(-2px);
    }

    .btn-secondary {
      background: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background: #545b62;
      transform: translateY(-2px);
    }

    /* Mensaje de configuración */
    .config-message {
      background: #d4edda;
      color: #155724;
      padding: 10px 20px;
      border-radius: 5px;
      margin: 15px 20px;
      border: 1px solid #c3e6cb;
      text-align: center;
      font-weight: bold;
    }

    /* Contenido principal */
    .main-content {
      padding: 30px;
    }

    .section-title {
      font-size: 2em;
      color: #333;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 3px solid #ff6b35;
      text-align: center;
    }

    /* Artículos de noticias */
    .news-grid {
      display: grid;
      gap: 30px;
      margin-bottom: 30px;
    }

    .news-grid.single {
      grid-template-columns: 1fr;
    }

    .news-grid.multiple {
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    }

    .news-article {
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .news-article:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .news-category {
      padding: 10px 20px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 0.9em;
    }

    .category-politica {
      background: #007bff;
      color: white;
    }

    .category-economica {
      background: #28a745;
      color: white;
    }

    .category-deportiva {
      background: #dc3545;
      color: white;
    }

    .news-content {
      padding: 25px;
    }

    .news-icon {
      font-size: 3em;
      text-align: center;
      margin-bottom: 15px;
    }

    .news-headline {
      font-size: 1.8em;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
      line-height: 1.3;
    }

    .news-subheadline {
      font-size: 1.2em;
      color: #666;
      font-style: italic;
      margin-bottom: 15px;
      line-height: 1.4;
    }

    .news-body {
      color: #444;
      margin-bottom: 20px;
      line-height: 1.7;
      font-size: 1.05em;
    }

    .news-meta {
      border-top: 1px solid #e0e0e0;
      padding-top: 15px;
      font-size: 0.9em;
      color: #777;
    }

    .news-author {
      font-weight: bold;
      color: #333;
    }

    .news-date {
      font-style: italic;
    }

    /* Estado de preferencias */
    .preferences-status {
      background: #e8f4f8;
      padding: 20px;
      margin: 20px;
      border-radius: 10px;
      border-left: 5px solid #17a2b8;
    }

    .preferences-status h3 {
      color: #0c5460;
      margin-bottom: 10px;
    }

    .preferences-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .preference-item {
      background: white;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
    }

    .preference-label {
      font-weight: bold;
      color: #0c5460;
      margin-bottom: 5px;
    }

    .preference-value {
      color: #333;
      font-family: monospace;
      background: #f8f9fa;
      padding: 5px 10px;
      border-radius: 4px;
      display: inline-block;
    }

    /* Footer */
    .newspaper-footer {
      background: #333;
      color: white;
      padding: 20px;
      text-align: center;
      margin-top: 30px;
    }

    .footer-links {
      margin-bottom: 15px;
    }

    .footer-links a {
      color: #ff6b35;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
    }

    .footer-links a:hover {
      color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .newspaper-title {
        font-size: 2.5em;
      }

      .header-info {
        flex-direction: column;
        gap: 10px;
      }

      .radio-group {
        flex-direction: column;
        align-items: center;
        gap: 15px;
      }

      .config-buttons {
        flex-direction: column;
        align-items: center;
      }

      .main-content {
        padding: 20px;
      }

      .news-headline {
        font-size: 1.5em;
      }
    }
  </style>
</head>

<body>
  <div class="newspaper-container">
    <!-- Header del periódico -->
    <div class="newspaper-header">
      <div class="masthead">
        <h1 class="newspaper-title">📰 EL DIARIO DIGITAL</h1>
        <p class="newspaper-subtitle">Tu fuente confiable de información</p>
      </div>
      <div class="header-info">
        <div class="date"><?php echo $fecha_actual_es; ?></div>
        <div class="edition">Edición Digital - Ejercicio N°4</div>
      </div>
    </div>

    <!-- Configuración de noticias -->
    <div class="news-config">
      <h2 class="config-title">⚙️ Personaliza tu experiencia de lectura</h2>
      <p>Selecciona el tipo de noticias que deseas ver como titular principal</p>

      <form method="POST" action="">
        <div class="radio-group">
          <div class="radio-option <?php echo ($tipo_seleccionado == 'politica') ? 'selected' : ''; ?>">
            <input type="radio" id="politica" name="tipo_noticia" value="politica"
              <?php echo ($tipo_seleccionado == 'politica') ? 'checked' : ''; ?>>
            <label for="politica">🏛️ Noticia Política</label>
          </div>

          <div class="radio-option <?php echo ($tipo_seleccionado == 'economica') ? 'selected' : ''; ?>">
            <input type="radio" id="economica" name="tipo_noticia" value="economica"
              <?php echo ($tipo_seleccionado == 'economica') ? 'checked' : ''; ?>>
            <label for="economica">📈 Noticia Económica</label>
          </div>

          <div class="radio-option <?php echo ($tipo_seleccionado == 'deportiva') ? 'selected' : ''; ?>">
            <input type="radio" id="deportiva" name="tipo_noticia" value="deportiva"
              <?php echo ($tipo_seleccionado == 'deportiva') ? 'checked' : ''; ?>>
            <label for="deportiva">⚽ Noticia Deportiva</label>
          </div>
        </div>

        <div class="config-buttons">
          <button type="submit" class="btn btn-primary">💾 Guardar Preferencia</button>
          <a href="limpiar_cookie.php" class="btn btn-danger">🗑️ Limpiar Preferencias</a>
          <a href="../index.php" class="btn btn-secondary">🏠 Volver al Inicio</a>
        </div>
      </form>
    </div>

    <?php if (!empty($mensaje_configuracion)): ?>
      <div class="config-message">
        ✅ <?php echo htmlspecialchars($mensaje_configuracion); ?>
      </div>
    <?php endif; ?>

    <!-- Estado de preferencias -->
    <div class="preferences-status">
      <h3>📊 Estado de tus Preferencias</h3>
      <p>
        <?php if (isset($_COOKIE['tipo_noticia_preferida'])): ?>
          Tienes configurado mostrar noticias <strong><?php echo ucfirst($_COOKIE['tipo_noticia_preferida']); ?>s</strong> como titular principal.
        <?php else: ?>
          Es tu primera visita o no tienes preferencias guardadas. Se muestran todos los titulares.
        <?php endif; ?>
      </p>

      <div class="preferences-info">
        <div class="preference-item">
          <div class="preference-label">Estado de Cookie</div>
          <div class="preference-value">
            <?php echo isset($_COOKIE['tipo_noticia_preferida']) ? 'Activa' : 'No existe'; ?>
          </div>
        </div>

        <div class="preference-item">
          <div class="preference-label">Tipo Preferido</div>
          <div class="preference-value">
            <?php echo isset($_COOKIE['tipo_noticia_preferida']) ? ucfirst($_COOKIE['tipo_noticia_preferida']) : 'Ninguno'; ?>
          </div>
        </div>

        <div class="preference-item">
          <div class="preference-label">Titulares Mostrados</div>
          <div class="preference-value">
            <?php echo $mostrar_todas ? 'Todos' : 'Filtrado'; ?>
          </div>
        </div>

        <div class="preference-item">
          <div class="preference-label">Fecha Actual</div>
          <div class="preference-value">
            <?php echo date('d/m/Y H:i'); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
      <?php if ($mostrar_todas): ?>
        <h2 class="section-title">🗞️ Titulares del Día - Todas las Secciones</h2>
        <p style="text-align: center; margin-bottom: 30px; font-style: italic; color: #666;">
          Como es tu primera visita o no tienes preferencias configuradas, te mostramos todos los titulares principales.
        </p>
      <?php else: ?>
        <h2 class="section-title">
          📋 Titular Principal - Sección <?php echo ucfirst($tipo_seleccionado); ?>
        </h2>
        <p style="text-align: center; margin-bottom: 30px; font-style: italic; color: #666;">
          Mostrando tu sección preferida según tus configuraciones guardadas.
        </p>
      <?php endif; ?>

      <div class="news-grid <?php echo $mostrar_todas ? 'multiple' : 'single'; ?>">
        <?php foreach ($noticias_a_mostrar as $tipo => $noticia): ?>
          <article class="news-article">
            <div class="news-category category-<?php echo $tipo; ?>">
              <?php echo ucfirst($tipo); ?>
            </div>
            <div class="news-content">
              <div class="news-icon"><?php echo $noticia['imagen']; ?></div>
              <h3 class="news-headline"><?php echo htmlspecialchars($noticia['titular']); ?></h3>
              <h4 class="news-subheadline"><?php echo htmlspecialchars($noticia['subtitular']); ?></h4>
              <p class="news-body"><?php echo htmlspecialchars($noticia['contenido']); ?></p>
              <div class="news-meta">
                <div class="news-author"><?php echo htmlspecialchars($noticia['autor']); ?></div>
                <div class="news-date"><?php echo htmlspecialchars($noticia['fecha']); ?></div>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Footer -->
    <div class="newspaper-footer">
      <div class="footer-links">
        <a href="periódico.php">🏠 Inicio</a>
        <a href="limpiar_cookie.php">🗑️ Limpiar Preferencias</a>
        <a href="../index.php">📚 Volver a Práctica 7</a>
      </div>
      <p>&copy; 2025 El Diario Digital - Ejercicio de PHP con Cookies</p>
    </div>
  </div>

  <script>
    // Manejar selección visual de radio buttons
    document.addEventListener('DOMContentLoaded', function() {
      const radioOptions = document.querySelectorAll('.radio-option');
      const radioInputs = document.querySelectorAll('input[type="radio"]');

      radioOptions.forEach(option => {
        option.addEventListener('click', function() {
          const radio = this.querySelector('input[type="radio"]');
          radio.checked = true;
          updateSelection();
        });
      });

      radioInputs.forEach(input => {
        input.addEventListener('change', updateSelection);
      });

      function updateSelection() {
        radioOptions.forEach(option => {
          option.classList.remove('selected');
        });

        const selected = document.querySelector('input[type="radio"]:checked');
        if (selected) {
          selected.closest('.radio-option').classList.add('selected');
        }
      }

      // Inicializar selección
      updateSelection();
    });

    // Confirmación al limpiar preferencias
    document.querySelector('a[href="limpiar_cookie.php"]').addEventListener('click', function(e) {
      if (!confirm('¿Estás seguro de que deseas limpiar todas tus preferencias de noticias?')) {
        e.preventDefault();
      }
    });
  </script>
</body>

</html>