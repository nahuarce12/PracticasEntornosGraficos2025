<?php

declare(strict_types=1);

/**
 * Página de Contacto con Formulario
 * 
 * Esta página presenta un formulario para que los visitantes
 * puedan enviar consultas al webmaster.
 * 
 * @author Tu Nombre
 * @version 1.0
 */

// Incluir el autoloader de Composer del Ejercicio1
require_once '../Ejercicio1/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ContactoConfig
{
  // Configuración del servidor SMTP
  public const SMTP_HOST = 'smtp.gmail.com';
  public const SMTP_PORT = 587;
  public const SMTP_USERNAME = 'email@gmail.com'; // Cambiar por tu email
  public const SMTP_PASSWORD = 'contraseña_aplicacion'; // Cambiar por tu contraseña de aplicación
  public const WEBMASTER_EMAIL = 'webmaster@gmail.com'; // Email del webmaster
  public const WEBMASTER_NAME = 'Webmaster';
}

class FormularioContacto
{
  private array $errores = [];
  private array $datos = [];
  private bool $enviado = false;

  public function procesarFormulario(): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->validarDatos();

      if (empty($this->errores)) {
        $this->enviarCorreo();
      }
    }
  }

  private function validarDatos(): void
  {
    // Validar nombre
    $nombre = trim($_POST['nombre'] ?? '');
    if (empty($nombre)) {
      $this->errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (strlen($nombre) < 2) {
      $this->errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
    } else {
      $this->datos['nombre'] = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
    }

    // Validar email
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
      $this->errores['email'] = 'El email es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->errores['email'] = 'El formato del email no es válido.';
    } else {
      $this->datos['email'] = $email;
    }

    // Validar asunto
    $asunto = trim($_POST['asunto'] ?? '');
    if (empty($asunto)) {
      $this->errores['asunto'] = 'El asunto es obligatorio.';
    } elseif (strlen($asunto) < 5) {
      $this->errores['asunto'] = 'El asunto debe tener al menos 5 caracteres.';
    } else {
      $this->datos['asunto'] = htmlspecialchars($asunto, ENT_QUOTES, 'UTF-8');
    }

    // Validar mensaje
    $mensaje = trim($_POST['mensaje'] ?? '');
    if (empty($mensaje)) {
      $this->errores['mensaje'] = 'El mensaje es obligatorio.';
    } elseif (strlen($mensaje) < 10) {
      $this->errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    } else {
      $this->datos['mensaje'] = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    }

    // Validar teléfono (opcional)
    $telefono = trim($_POST['telefono'] ?? '');
    if (!empty($telefono)) {
      if (!preg_match('/^[\d\s\-\+\(\)]+$/', $telefono)) {
        $this->errores['telefono'] = 'El formato del teléfono no es válido.';
      } else {
        $this->datos['telefono'] = htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8');
      }
    }
  }

  private function enviarCorreo(): void
  {
    try {
      $mail = new PHPMailer(true);

      // Configuración del servidor SMTP
      $mail->isSMTP();
      $mail->Host = ContactoConfig::SMTP_HOST;
      $mail->SMTPAuth = true;
      $mail->Username = ContactoConfig::SMTP_USERNAME;
      $mail->Password = ContactoConfig::SMTP_PASSWORD;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = ContactoConfig::SMTP_PORT;
      $mail->CharSet = 'UTF-8';

      // Configuración del remitente y destinatario
      $mail->setFrom(ContactoConfig::SMTP_USERNAME, 'Formulario de Contacto');
      $mail->addAddress(ContactoConfig::WEBMASTER_EMAIL, ContactoConfig::WEBMASTER_NAME);
      $mail->addReplyTo($this->datos['email'], $this->datos['nombre']);

      // Contenido del correo
      $mail->isHTML(true);
      $mail->Subject = 'Consulta Web: ' . $this->datos['asunto'];
      $mail->Body = $this->crearPlantillaHtml();
      $mail->AltBody = $this->crearTextoPlano();

      $mail->send();
      $this->enviado = true;
    } catch (Exception $e) {
      $this->errores['general'] = 'Error al enviar el mensaje: ' . $e->getMessage();
    }
  }

  private function crearPlantillaHtml(): string
  {
    $telefono = isset($this->datos['telefono']) ?
      "<tr><td style='padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;'>Teléfono:</td><td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$this->datos['telefono']}</td></tr>" :
      '';

    return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Nueva Consulta Web</title>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
            <div style='max-width: 600px; margin: 20px auto; background-color: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 20px rgba(0,0,0,0.1);'>
                <!-- Header -->
                <div style='background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 30px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 28px;'>📧 Nueva Consulta Web</h1>
                </div>
                
                <!-- Content -->
                <div style='padding: 30px;'>
                    <p style='margin-bottom: 20px; font-size: 16px; color: #333;'>
                        Has recibido una nueva consulta a través del formulario de contacto de tu sitio web.
                    </p>
                    
                    <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                        <tr>
                            <td style='padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold; width: 120px;'>Nombre:</td>
                            <td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$this->datos['nombre']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;'>Email:</td>
                            <td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$this->datos['email']}</td>
                        </tr>
                        {$telefono}
                        <tr>
                            <td style='padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;'>Asunto:</td>
                            <td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$this->datos['asunto']}</td>
                        </tr>
                    </table>
                    
                    <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745;'>
                        <h3 style='margin: 0 0 10px 0; color: #333;'>Mensaje:</h3>
                        <p style='margin: 0; line-height: 1.6; color: #555;'>" . nl2br($this->datos['mensaje']) . "</p>
                    </div>
                </div>
                
                <!-- Footer -->
                <div style='background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #dee2e6; font-size: 12px; color: #6c757d;'>
                    Mensaje enviado desde el formulario de contacto web<br>
                    <small>Fecha: " . date('d/m/Y H:i:s') . "</small>
                </div>
            </div>
        </body>
        </html>";
  }

  private function crearTextoPlano(): string
  {
    $texto = "Nueva Consulta Web\n\n";
    $texto .= "Nombre: {$this->datos['nombre']}\n";
    $texto .= "Email: {$this->datos['email']}\n";

    if (isset($this->datos['telefono'])) {
      $texto .= "Teléfono: {$this->datos['telefono']}\n";
    }

    $texto .= "Asunto: {$this->datos['asunto']}\n\n";
    $texto .= "Mensaje:\n{$this->datos['mensaje']}\n\n";
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
$formulario = new FormularioContacto();
$formulario->procesarFormulario();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto</title>
  <link rel="stylesheet" href="estilos-adicionales.css" type="text/css">
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

    .contact-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
    }

    .contact-header {
      background: linear-gradient(135deg, var(--primary-color), var(--info-color));
      color: white;
      padding: 40px 30px;
      text-align: center;
    }

    .contact-header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .contact-header p {
      font-size: 1.1rem;
      opacity: 0.9;
      margin: 0;
    }

    .contact-body {
      padding: 40px 30px;
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

    .btn-submit {
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

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
      background: linear-gradient(135deg, #228b54, #1ea080);
    }

    .btn-submit:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
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

    .info-section {
      background: var(--light-color);
      border-radius: 15px;
      padding: 25px;
      margin-top: 30px;
      border-left: 4px solid var(--info-color);
    }

    .info-section h5 {
      color: var(--info-color);
      font-weight: 600;
      margin-bottom: 15px;
    }

    .contact-info {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .contact-info i {
      color: var(--info-color);
      margin-right: 10px;
      width: 20px;
    }

    @media (max-width: 768px) {
      .contact-header h1 {
        font-size: 2rem;
      }

      .contact-body {
        padding: 30px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="contact-card animate-slide-in">
      <!-- Header -->
      <div class="contact-header">
        <h1><i class="fas fa-envelope"></i> Contacto</h1>
        <p>¿Tienes alguna consulta? ¡Nos encantaría escucharte!</p>
      </div>

      <!-- Body -->
      <div class="contact-body">
        <?php if (
          $formulario->isEnviado()
        ): ?>
          <!-- Mensaje de éxito -->
          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading"><i class="fas fa-check-circle"></i> ¡Mensaje Enviado!</h4>
            <p class="mb-0">
              Gracias por contactarnos, <strong><?= htmlspecialchars($formulario->getValue('nombre'), ENT_QUOTES, 'UTF-8') ?></strong>.
              Hemos recibido tu consulta y te responderemos a la brevedad en <strong><?= htmlspecialchars($formulario->getValue('email'), ENT_QUOTES, 'UTF-8') ?></strong>.
            </p>
            <hr>
            <p class="mb-0">
              <a href="contacto.php" class="btn btn-outline-success btn-pulse">
                <i class="fas fa-plus"></i> Enviar Nueva Consulta
              </a>
            </p>
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
          <?php if (ContactoConfig::SMTP_USERNAME === 'tu-email@gmail.com'): ?>
            <div class="alert alert-warning" role="alert">
              <h4 class="alert-heading"><i class="fas fa-cog"></i> Configuración Requerida</h4>
              <p class="mb-0">
                <strong>Atención:</strong> Debes configurar las credenciales SMTP en el archivo
                <code>contacto.php</code> antes de poder enviar correos.
              </p>
            </div>
          <?php endif; ?>
          <!-- Formulario -->
          <form method="POST" action="contacto.php">
            <div class="row">
              <!-- Nombre -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nombre" class="form-label tooltip-custom" data-tooltip="Campo obligatorio">
                    <i class="fas fa-user"></i> Nombre Completo <span class="required">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control <?= $formulario->hasError('nombre') ? 'is-invalid' : '' ?>"
                    id="nombre"
                    name="nombre"
                    value="<?= htmlspecialchars($formulario->getValue('nombre'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Tu nombre completo"
                    required>
                  <?php if ($formulario->hasError('nombre')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('nombre'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email" class="form-label tooltip-custom" data-tooltip="Campo obligatorio">
                    <i class="fas fa-envelope"></i> Correo Electrónico <span class="required">*</span>
                  </label>
                  <input
                    type="email"
                    class="form-control <?= $formulario->hasError('email') ? 'is-invalid' : '' ?>"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($formulario->getValue('email'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="tu@email.com"
                    required>
                  <?php if ($formulario->hasError('email')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('email'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="row">
              <!-- Teléfono -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="telefono" class="form-label">
                    <i class="fas fa-phone"></i> Teléfono
                  </label>
                  <input
                    type="tel"
                    class="form-control <?= $formulario->hasError('telefono') ? 'is-invalid' : '' ?>"
                    id="telefono"
                    name="telefono"
                    value="<?= htmlspecialchars($formulario->getValue('telefono'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="+54 123 456 789">
                  <?php if ($formulario->hasError('telefono')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('telefono'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Asunto -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="asunto" class="form-label tooltip-custom" data-tooltip="Campo obligatorio">
                    <i class="fas fa-tag"></i> Asunto <span class="required">*</span>
                  </label>
                  <input
                    type="text"
                    class="form-control <?= $formulario->hasError('asunto') ? 'is-invalid' : '' ?>"
                    id="asunto"
                    name="asunto"
                    value="<?= htmlspecialchars($formulario->getValue('asunto'), ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Motivo de tu consulta"
                    required>
                  <?php if ($formulario->hasError('asunto')): ?>
                    <div class="invalid-feedback">
                      <?= htmlspecialchars($formulario->getError('asunto'), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Mensaje -->
            <div class="form-group">
              <label for="mensaje" class="form-label tooltip-custom" data-tooltip="Campo obligatorio">
                <i class="fas fa-comment-alt"></i> Mensaje <span class="required">*</span>
              </label>
              <textarea
                class="form-control <?= $formulario->hasError('mensaje') ? 'is-invalid' : '' ?>"
                id="mensaje"
                name="mensaje"
                rows="6"
                placeholder="Describe tu consulta o comentario..."
                required><?= htmlspecialchars($formulario->getValue('mensaje'), ENT_QUOTES, 'UTF-8') ?></textarea>
              <?php if ($formulario->hasError('mensaje')): ?>
                <div class="invalid-feedback">
                  <?= htmlspecialchars($formulario->getError('mensaje'), ENT_QUOTES, 'UTF-8') ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-submit btn-pulse">
              <i class="fas fa-paper-plane"></i> Enviar Mensaje
            </button>
          </form>

          <!-- Información adicional -->
          <div class="info-section">
            <h5><i class="fas fa-info-circle"></i> Información de Contacto</h5>
            <div class="contact-info">
              <i class="fas fa-clock"></i>
              <span>Tiempo de respuesta: 24-48 horas</span>
            </div>
            <div class="contact-info">
              <i class="fas fa-shield-alt"></i>
              <span>Tus datos están protegidos y no serán compartidos</span>
            </div>
            <div class="contact-info">
              <i class="fas fa-headset"></i>
              <span>Soporte técnico disponible de Lunes a Viernes</span>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>

</html>

</html>