<?php

declare(strict_types=1);

/**
 * Script para Recomendar el Sitio a un Amigo
 * 
 * Permite a los visitantes recomendar el sitio web a sus amigos
 * enviando un correo electrónico personalizado.
 * 
 * @author Tu Nombre
 * @version 1.0
 */

// Incluir el autoloader de Composer del Ejercicio1
require_once '../Ejercicio1/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RecomendacionConfig
{
  // Configuración del servidor SMTP
  public const SMTP_HOST = 'smtp.gmail.com';
  public const SMTP_PORT = 587;
  public const SMTP_USERNAME = 'email@gmail.com'; // Cambiar por tu email
  public const SMTP_PASSWORD = 'contraseñaDeAplicacion'; // Cambiar por tu contraseña de aplicación
  public const SITIO_NOMBRE = 'Sitio web';
  public const SITIO_URL = 'http://google.com'; // Cambiar por la URL real del sitio
  public const SITIO_DESCRIPCION = 'Un sitio web increíble con funcionalidades avanzadas y diseño profesional.';
}

class FormularioRecomendacion
{
  private array $errores = [];
  private array $datos = [];
  private bool $enviado = false;

  public function procesarFormulario(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->validarDatos();

      if (empty($this->errores)) {
        $this->enviarRecomendacion();
      }
    }
  }

  private function validarDatos(): void
  {
    // Validar nombre del recomendador
    $tuNombre = trim($_POST['tu_nombre'] ?? '');
    if (empty($tuNombre)) {
      $this->errores['tu_nombre'] = 'Tu nombre es obligatorio.';
    } elseif (strlen($tuNombre) < 2) {
      $this->errores['tu_nombre'] = 'Tu nombre debe tener al menos 2 caracteres.';
    } else {
      $this->datos['tu_nombre'] = htmlspecialchars($tuNombre, ENT_QUOTES, 'UTF-8');
    }

    // Validar email del recomendador
    $tuEmail = trim($_POST['tu_email'] ?? '');
    if (empty($tuEmail)) {
      $this->errores['tu_email'] = 'Tu email es obligatorio.';
    } elseif (!filter_var($tuEmail, FILTER_VALIDATE_EMAIL)) {
      $this->errores['tu_email'] = 'El formato de tu email no es válido.';
    } else {
      $this->datos['tu_email'] = $tuEmail;
    }

    // Validar nombre del amigo
    $nombreAmigo = trim($_POST['nombre_amigo'] ?? '');
    if (empty($nombreAmigo)) {
      $this->errores['nombre_amigo'] = 'El nombre de tu amigo es obligatorio.';
    } elseif (strlen($nombreAmigo) < 2) {
      $this->errores['nombre_amigo'] = 'El nombre debe tener al menos 2 caracteres.';
    } else {
      $this->datos['nombre_amigo'] = htmlspecialchars($nombreAmigo, ENT_QUOTES, 'UTF-8');
    }

    // Validar email del amigo
    $emailAmigo = trim($_POST['email_amigo'] ?? '');
    if (empty($emailAmigo)) {
      $this->errores['email_amigo'] = 'El email de tu amigo es obligatorio.';
    } elseif (!filter_var($emailAmigo, FILTER_VALIDATE_EMAIL)) {
      $this->errores['email_amigo'] = 'El formato del email no es válido.';
    } else {
      $this->datos['email_amigo'] = $emailAmigo;
    }

    // Validar mensaje personalizado (opcional)
    $mensajePersonal = trim($_POST['mensaje_personal'] ?? '');
    if (!empty($mensajePersonal)) {
      if (strlen($mensajePersonal) > 500) {
        $this->errores['mensaje_personal'] = 'El mensaje no puede tener más de 500 caracteres.';
      } else {
        $this->datos['mensaje_personal'] = htmlspecialchars($mensajePersonal, ENT_QUOTES, 'UTF-8');
      }
    }
  }

  private function enviarRecomendacion(): void
  {
    try {
      $mail = new PHPMailer(true);

      // Configuración del servidor SMTP
      $mail->isSMTP();
      $mail->Host = RecomendacionConfig::SMTP_HOST;
      $mail->SMTPAuth = true;
      $mail->Username = RecomendacionConfig::SMTP_USERNAME;
      $mail->Password = RecomendacionConfig::SMTP_PASSWORD;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = RecomendacionConfig::SMTP_PORT;
      $mail->CharSet = 'UTF-8';

      // Configuración del remitente y destinatario
      $mail->setFrom(RecomendacionConfig::SMTP_USERNAME, RecomendacionConfig::SITIO_NOMBRE);
      $mail->addAddress($this->datos['email_amigo'], $this->datos['nombre_amigo']);
      $mail->addReplyTo($this->datos['tu_email'], $this->datos['tu_nombre']);

      // Contenido del correo
      $mail->isHTML(true);
      $mail->Subject = "🌟 {$this->datos['tu_nombre']} te recomienda " . RecomendacionConfig::SITIO_NOMBRE;
      $mail->Body = $this->crearPlantillaHtml();
      $mail->AltBody = $this->crearTextoPlano();

      $mail->send();
      $this->enviado = true;
    } catch (Exception $e) {
      $this->errores['general'] = 'Error al enviar la recomendación: ' . $e->getMessage();
    }
  }

  private function crearPlantillaHtml(): string
  {
    $mensajePersonal = isset($this->datos['mensaje_personal']) ?
      "<div style='background-color: #e3f2fd; padding: 15px; border-radius: 8px; border-left: 4px solid #2196f3; margin: 20px 0;'>
                <h4 style='margin: 0 0 10px 0; color: #1976d2;'>💬 Mensaje personal de {$this->datos['tu_nombre']}:</h4>
                <p style='margin: 0; font-style: italic; line-height: 1.6;'>\"{$this->datos['mensaje_personal']}\"</p>
            </div>" : '';

    return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Recomendación de " . RecomendacionConfig::SITIO_NOMBRE . "</title>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f0f2f5;'>
            <div style='max-width: 600px; margin: 20px auto; background-color: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.1);'>
                <!-- Header -->
                <div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px 30px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 32px; font-weight: 700;'>🌟 ¡Tienes una Recomendación!</h1>
                    <p style='margin: 10px 0 0 0; font-size: 18px; opacity: 0.9;'>Tu amigo {$this->datos['tu_nombre']} quiere que conozcas algo genial</p>
                </div>
                
                <!-- Content -->
                <div style='padding: 40px 30px;'>
                    <div style='text-align: center; margin-bottom: 30px;'>
                        <h2 style='color: #333; font-size: 28px; margin: 0 0 15px 0;'>" . RecomendacionConfig::SITIO_NOMBRE . "</h2>
                        <p style='color: #666; font-size: 16px; line-height: 1.6; margin: 0;'>" . RecomendacionConfig::SITIO_DESCRIPCION . "</p>
                    </div>
                    
                    {$mensajePersonal}
                    
                    <div style='background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 25px; border-radius: 12px; text-align: center; margin: 30px 0;'>
                        <h3 style='color: #495057; margin: 0 0 20px 0;'>🚀 ¿Por qué deberías visitarlo?</h3>
                        <div style='display: grid; gap: 15px; text-align: left;'>
                            <div style='display: flex; align-items: center;'>
                                <span style='background: #28a745; color: white; border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;'>✓</span>
                                <span style='color: #495057;'>Diseño moderno y profesional</span>
                            </div>
                            <div style='display: flex; align-items: center;'>
                                <span style='background: #28a745; color: white; border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;'>✓</span>
                                <span style='color: #495057;'>Funcionalidades avanzadas</span>
                            </div>
                            <div style='display: flex; align-items: center;'>
                                <span style='background: #28a745; color: white; border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;'>✓</span>
                                <span style='color: #495057;'>Fácil de usar y navegar</span>
                            </div>
                            <div style='display: flex; align-items: center;'>
                                <span style='background: #28a745; color: white; border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;'>✓</span>
                                <span style='color: #495057;'>Recomendado por {$this->datos['tu_nombre']}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Call to Action -->
                    <div style='text-align: center; margin: 40px 0;'>
                        <a href='" . RecomendacionConfig::SITIO_URL . "' style='
                            background: linear-gradient(135deg, #007bff, #0056b3);
                            color: white;
                            padding: 16px 40px;
                            text-decoration: none;
                            border-radius: 50px;
                            font-size: 18px;
                            font-weight: 600;
                            display: inline-block;
                            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
                            transition: all 0.3s ease;
                        '>🌐 Visitar " . RecomendacionConfig::SITIO_NOMBRE . "</a>
                    </div>
                    
                    <div style='background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; text-align: center;'>
                        <p style='margin: 0; color: #856404; font-size: 14px;'>
                            <strong>💡 Tip:</strong> ¡También puedes recomendar este sitio a tus amigos!
                        </p>
                    </div>
                </div>
                
                <!-- Footer -->
                <div style='background-color: #f8f9fa; padding: 25px 30px; text-align: center; border-top: 1px solid #dee2e6;'>
                    <p style='margin: 0 0 10px 0; color: #6c757d; font-size: 14px;'>
                        Esta recomendación fue enviada por <strong>{$this->datos['tu_nombre']}</strong> ({$this->datos['tu_email']})
                    </p>
                    <p style='margin: 0; color: #adb5bd; font-size: 12px;'>
                        Enviado el " . date('d/m/Y') . " a las " . date('H:i') . " hrs
                    </p>
                </div>
            </div>
        </body>
        </html>";
  }

  private function crearTextoPlano(): string
  {
    $texto = "🌟 ¡Tienes una Recomendación de " . RecomendacionConfig::SITIO_NOMBRE . "!\n\n";
    $texto .= "Hola {$this->datos['nombre_amigo']},\n\n";
    $texto .= "Tu amigo {$this->datos['tu_nombre']} ({$this->datos['tu_email']}) te recomienda visitar:\n";
    $texto .= RecomendacionConfig::SITIO_NOMBRE . "\n";
    $texto .= RecomendacionConfig::SITIO_URL . "\n\n";

    if (isset($this->datos['mensaje_personal'])) {
      $texto .= "Mensaje personal:\n\"{$this->datos['mensaje_personal']}\"\n\n";
    }

    $texto .= "Descripción:\n" . RecomendacionConfig::SITIO_DESCRIPCION . "\n\n";
    $texto .= "¡Visítalo y descubre por qué {$this->datos['tu_nombre']} te lo recomienda!\n\n";
    $texto .= "Enviado el: " . date('d/m/Y H:i:s');

    return $texto;
  }

  public function getErrores(): array
  {
    return $this->errores;
  }

  public function getDatos(): array
  {
    return $this->datos;
  }

  public function isEnviado(): bool
  {
    return $this->enviado;
  }

  public function hasError(string $campo): bool
  {
    return isset($this->errores[$campo]);
  }

  public function getError(string $campo): string
  {
    return $this->errores[$campo] ?? '';
  }

  public function getValue(string $campo): string
  {
    return $_POST[$campo] ?? $this->datos[$campo] ?? '';
  }
}

// Procesar el formulario
$formulario = new FormularioRecomendacion();
$formulario->procesarFormulario();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recomienda a un Amigo - Sitio Web</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #007bff;
      --secondary-color: #6c757d;
      --success-color: #28a745;
      --danger-color: #dc3545;
      --warning-color: #ffc107;
      --info-color: #17a2b8;
      --light-color: #f8f9fa;
      --dark-color: #343a40;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 20px 0;
    }

    .container {
      max-width: 800px;
    }

    .recommendation-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }

    .recommendation-header {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .recommendation-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .recommendation-header p {
      font-size: 1.1rem;
      opacity: 0.9;
      margin: 0;
    }

    .recommendation-body {
      padding: 40px 30px;
    }

    .section-divider {
      background: linear-gradient(135deg, var(--info-color), var(--primary-color));
      height: 3px;
      border-radius: 2px;
      margin: 30px 0;
    }

    .section-title {
      color: var(--dark-color);
      font-weight: 600;
      font-size: 1.3rem;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }

    .section-title i {
      margin-right: 12px;
      color: var(--primary-color);
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-label {
      font-weight: 600;
      color: var(--dark-color);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
    }

    .form-label i {
      margin-right: 8px;
      width: 20px;
      color: var(--primary-color);
    }

    .form-control {
      border: 2px solid #e9ecef;
      border-radius: 10px;
      padding: 12px 15px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
      transform: translateY(-2px);
    }

    .form-control.is-invalid {
      border-color: var(--danger-color);
    }

    .invalid-feedback {
      display: block;
      font-size: 0.875rem;
      color: var(--danger-color);
      margin-top: 5px;
    }

    .btn-recommend {
      background: linear-gradient(135deg, var(--success-color), #20c997);
      border: none;
      border-radius: 10px;
      padding: 15px 40px;
      font-size: 1.1rem;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
      width: 100%;
    }

    .btn-recommend:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
      background: linear-gradient(135deg, #228b54, #1ea080);
    }

    .alert {
      border-radius: 10px;
      border: none;
      padding: 20px;
      margin-bottom: 30px;
    }

    .alert-success {
      background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
      border-left: 4px solid var(--success-color);
    }

    .alert-danger {
      background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(255, 107, 107, 0.1));
      border-left: 4px solid var(--danger-color);
    }

    .required {
      color: var(--danger-color);
    }

    .info-box {
      background: linear-gradient(135deg, #e3f2fd, #bbdefb);
      border-radius: 15px;
      padding: 25px;
      margin: 30px 0;
      border-left: 4px solid var(--info-color);
    }

    .info-box h5 {
      color: var(--info-color);
      font-weight: 600;
      margin-bottom: 15px;
    }

    .feature-list {
      list-style: none;
      padding: 0;
    }

    .feature-list li {
      padding: 8px 0;
      display: flex;
      align-items: center;
    }

    .feature-list li i {
      color: var(--success-color);
      margin-right: 10px;
      width: 20px;
    }

    @media (max-width: 768px) {
      .recommendation-header h1 {
        font-size: 2rem;
      }

      .recommendation-body {
        padding: 30px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="recommendation-card">
      <!-- Header -->
      <div class="recommendation-header">
        <h1><i class="fas fa-share-alt"></i> Recomienda a un Amigo</h1>
        <p>¿Conoces a alguien que podría disfrutar de nuestro sitio? ¡Compártelo!</p>
      </div>

      <!-- Body -->
      <div class="recommendation-body">
        <?php if ($formulario->isEnviado()): ?>
          <!-- Mensaje de éxito -->
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading"><i class="fas fa-check-circle"></i> ¡Recomendación Enviada!</h4>
            <p class="mb-0">
              ¡Genial! Tu recomendación ha sido enviada exitosamente a
              <strong><?= htmlspecialchars($formulario->getValue('nombre_amigo'), ENT_QUOTES, 'UTF-8') ?></strong>
              (<strong><?= htmlspecialchars($formulario->getValue('email_amigo'), ENT_QUOTES, 'UTF-8') ?></strong>).
            </p>
            <hr>
            <p class="mb-0">
              Tu amigo recibirá un correo con tu recomendación personal y podrá visitar nuestro sitio.
            </p>
            <div class="mt-3">
              <a href="recomendar.php" class="btn btn-outline-success me-2">
                <i class="fas fa-plus"></i> Recomendar a Otro Amigo
              </a>
              <a href="<?= RecomendacionConfig::SITIO_URL ?>" class="btn btn-outline-primary">
                <i class="fas fa-home"></i> Volver al Sitio
              </a>
            </div>
          </div>
        <?php else: ?>
          <!-- Mostrar errores generales -->
          <?php if (isset($formulario->getErrores()['general'])): ?>
            <div class="alert alert-danger" role="alert">
              <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Error</h4>
              <p class="mb-0"><?= htmlspecialchars($formulario->getError('general'), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          <?php endif; ?>

          <!-- Verificar configuración -->
          <?php if (RecomendacionConfig::SMTP_USERNAME === 'tu-email@gmail.com'): ?>
            <div class="alert alert-warning" role="alert">
              <h4 class="alert-heading"><i class="fas fa-cog"></i> Configuración Requerida</h4>
              <p class="mb-0">
                <strong>Atención:</strong> Debes configurar las credenciales SMTP en el archivo
                <code>recomendar.php</code> antes de poder enviar recomendaciones.
              </p>
            </div>
          <?php endif; ?>

          <!-- Información del sitio -->
          <div class="info-box">
            <h5><i class="fas fa-info-circle"></i> ¿Por qué recomendar <?= RecomendacionConfig::SITIO_NOMBRE ?>?</h5>
            <p><?= RecomendacionConfig::SITIO_DESCRIPCION ?></p>
            <ul class="feature-list">
              <li><i class="fas fa-check"></i> Diseño moderno y profesional</li>
              <li><i class="fas fa-check"></i> Funcionalidades avanzadas</li>
              <li><i class="fas fa-check"></i> Fácil de usar y navegar</li>
              <li><i class="fas fa-check"></i> Contenido de calidad</li>
            </ul>
          </div>

          <!-- Formulario -->
          <form method="POST" action="recomendar.php">
            <!-- Sección: Tus Datos -->
            <div class="section-title">
              <i class="fas fa-user"></i> Tus Datos
            </div>

            <div class="row">
              <!-- Tu Nombre -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tu_nombre" class="form-label">
                    <i class="fas fa-user"></i> Tu Nombre <span class="required">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control <?= $formulario->hasError('tu_nombre') ? 'is-invalid' : '' ?>"
                    id="tu_nombre"
                    name="tu_nombre"
                    value="<?= htmlspecialchars($formulario->getValue('tu_nombre'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Tu nombre completo"
                    required>
                  <?php if ($formulario->hasError('tu_nombre')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('tu_nombre'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Tu Email -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="tu_email" class="form-label">
                    <i class="fas fa-envelope"></i> Tu Email <span class="required">*</span>
                  </label>
                  <input
                    type="email"
                    class="form-control <?= $formulario->hasError('tu_email') ? 'is-invalid' : '' ?>"
                    id="tu_email"
                    name="tu_email"
                    value="<?= htmlspecialchars($formulario->getValue('tu_email'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="tu@email.com"
                    required>
                  <?php if ($formulario->hasError('tu_email')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('tu_email'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="section-divider"></div>

            <!-- Sección: Datos de tu Amigo -->
            <div class="section-title">
              <i class="fas fa-user-friends"></i> Datos de tu Amigo
            </div>

            <div class="row">
              <!-- Nombre del Amigo -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nombre_amigo" class="form-label">
                    <i class="fas fa-user-plus"></i> Nombre del Amigo <span class="required">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control <?= $formulario->hasError('nombre_amigo') ? 'is-invalid' : '' ?>"
                    id="nombre_amigo"
                    name="nombre_amigo"
                    value="<?= htmlspecialchars($formulario->getValue('nombre_amigo'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Nombre de tu amigo"
                    required>
                  <?php if ($formulario->hasError('nombre_amigo')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('nombre_amigo'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Email del Amigo -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email_amigo" class="form-label">
                    <i class="fas fa-at"></i> Email del Amigo <span class="required">*</span>
                  </label>
                  <input
                    type="email"
                    class="form-control <?= $formulario->hasError('email_amigo') ? 'is-invalid' : '' ?>"
                    id="email_amigo"
                    name="email_amigo"
                    value="<?= htmlspecialchars($formulario->getValue('email_amigo'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="amigo@email.com"
                    required>
                  <?php if ($formulario->hasError('email_amigo')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('email_amigo'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="section-divider"></div>

            <!-- Sección: Mensaje Personal -->
            <div class="section-title">
              <i class="fas fa-comment-alt"></i> Mensaje Personal (Opcional)
            </div>

            <div class="form-group">
              <label for="mensaje_personal" class="form-label">
                <i class="fas fa-heart"></i> Agrega un Mensaje Personal
              </label>
              <textarea
                class="form-control <?= $formulario->hasError('mensaje_personal') ? 'is-invalid' : '' ?>"
                id="mensaje_personal"
                name="mensaje_personal"
                rows="4"
                placeholder="Escribe por qué le recomiendas este sitio... (máximo 500 caracteres)"
                maxlength="500"><?= htmlspecialchars($formulario->getValue('mensaje_personal'), ENT_QUOTES, 'UTF-8') ?></textarea>
              <?php if ($formulario->hasError('mensaje_personal')): ?>
                <div class="invalid-feedback">
                  <?= htmlspecialchars($formulario->getError('mensaje_personal'), ENT_QUOTES, 'UTF-8') ?>
                </div>
              <?php endif; ?>
              <small class="text-muted">Máximo 500 caracteres</small>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-recommend">
              <i class="fas fa-paper-plane"></i> Enviar Recomendación
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>

</html>