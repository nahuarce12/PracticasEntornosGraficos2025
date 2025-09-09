<?php

declare(strict_types=1);

/**
 * Script para enviar correo electrónico con formato HTML usando PHPMailer
 * 
 * Este script utiliza PHPMailer para enviar emails con autenticación SMTP,
 * incluyendo soporte para contraseñas de aplicación de Gmail.
 * 
 * @author Sistema PHP
 * @version 2.0
 */

// Incluir autoloader de PHPMailer
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Configuración de correo electrónico
 * IMPORTANTE: Cambia estos valores por los tuyos
 */
class EmailConfig
{
  // Configuración SMTP de Gmail
  public const SMTP_HOST = 'smtp.gmail.com';
  public const SMTP_PORT = 587;
  public const SMTP_SECURE = PHPMailer::ENCRYPTION_STARTTLS;

  // TUS CREDENCIALES - ¡CAMBIAR AQUÍ!
  public const SMTP_USERNAME = 'email@gmail.com'; // Tu email de Gmail
  public const SMTP_PASSWORD = 'contraseña_aplicacion'; // Contraseña de aplicación (16 caracteres)

  // Configuración del remitente
  public const FROM_EMAIL = 'email@gmail.com'; // Mismo que SMTP_USERNAME
  public const FROM_NAME = 'Sistema de Notificaciones';

  // Email de prueba
  public const TEST_RECIPIENT = 'email_destinatario@gmail.com'; // Email del destinatario
}

/**
 * Clase para el envío de correos con PHPMailer
 */
class EmailSenderPHPMailer
{
  private PHPMailer $mailer;
  private array $config;


  public function getLastError(): string
  {
    return $this->mailer->ErrorInfo ?? '';
  }
  /**
   * Constructor
   */
  public function __construct(array $config = [])
  {
    $this->config = array_merge([
      'host' => EmailConfig::SMTP_HOST,
      'port' => EmailConfig::SMTP_PORT,
      'username' => EmailConfig::SMTP_USERNAME,
      'password' => EmailConfig::SMTP_PASSWORD,
      'secure' => EmailConfig::SMTP_SECURE,
      'from_email' => EmailConfig::FROM_EMAIL,
      'from_name' => EmailConfig::FROM_NAME,
    ], $config);

    $this->initializeMailer();
  }

  /**
   * Inicializar PHPMailer con configuración SMTP
   */
  private function initializeMailer(): void
  {
    $this->mailer = new PHPMailer(true);

    try {
      // Configuración del servidor SMTP
      $this->mailer->isSMTP();
      $this->mailer->Host = $this->config['host'];
      $this->mailer->SMTPAuth = true;
      $this->mailer->Username = $this->config['username'];
      $this->mailer->Password = $this->config['password'];
      $this->mailer->SMTPSecure = $this->config['secure'];
      $this->mailer->Port = $this->config['port'];
      $this->mailer->CharSet = 'UTF-8';

      // Configurar remitente por defecto
      $this->mailer->setFrom($this->config['from_email'], $this->config['from_name']);
    } catch (Exception $e) {
      throw new RuntimeException("Error configurando PHPMailer: {$e->getMessage()}");
    }
  }

  /**
   * Enviar correo HTML con PHPMailer
   *
   * @param string $to Email del destinatario
   * @param string $subject Asunto del correo
   * @param string $htmlBody Contenido HTML
   * @param string $altBody Contenido en texto plano (opcional)
   * @param array $attachments Archivos adjuntos (opcional)
   * @return bool
   * @throws RuntimeException
   */
  public function sendHtmlEmail(
    string $to,
    string $subject,
    string $htmlBody,
    string $altBody = '',
    array $attachments = []
  ): bool {
    try {
      // Validar parámetros
      $this->validateParameters($to, $subject, $htmlBody);

      // Limpiar destinatarios anteriores
      $this->mailer->clearAddresses();
      $this->mailer->clearAttachments();

      // Configurar destinatario
      $this->mailer->addAddress($to);

      // Configurar contenido
      $this->mailer->isHTML(true);
      $this->mailer->Subject = $subject;
      $this->mailer->Body = $htmlBody;
      $this->mailer->AltBody = $altBody ?: strip_tags($htmlBody);

      // Agregar archivos adjuntos si los hay
      foreach ($attachments as $attachment) {
        if (file_exists($attachment)) {
          $this->mailer->addAttachment($attachment);
        }
      }

      // Enviar
      return $this->mailer->send();
    } catch (Exception $e) {
      throw new RuntimeException("Error enviando correo: {$e->getMessage()}");
    }
  }

  /**
   * Validar parámetros de entrada
   */
  private function validateParameters(string $to, string $subject, string $htmlBody): void
  {
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
      throw new InvalidArgumentException('Email del destinatario no válido');
    }

    if (empty(trim($subject))) {
      throw new InvalidArgumentException('El asunto no puede estar vacío');
    }

    if (empty(trim($htmlBody))) {
      throw new InvalidArgumentException('El cuerpo del correo no puede estar vacío');
    }
  }

  /**
   * Crear plantilla HTML profesional
   */
  public function createProfessionalTemplate(
    string $title,
    string $message,
    string $buttonText = '',
    string $buttonUrl = '',
    string $footerText = ''
  ): string {
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
    $safeFooter = htmlspecialchars($footerText, ENT_QUOTES, 'UTF-8');

    $buttonHtml = '';
    if (!empty($buttonText) && !empty($buttonUrl)) {
      $safeButtonText = htmlspecialchars($buttonText, ENT_QUOTES, 'UTF-8');
      $safeButtonUrl = htmlspecialchars($buttonUrl, ENT_QUOTES, 'UTF-8');
      $buttonHtml = "
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$safeButtonUrl}' style='
                        background-color: #007bff;
                        color: white;
                        padding: 12px 30px;
                        text-decoration: none;
                        border-radius: 5px;
                        display: inline-block;
                        font-weight: bold;
                    '>{$safeButtonText}</a>
                </div>";
    }

    return "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$safeTitle}</title>
        </head>
        <body style='
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        '>
            <div style='
                max-width: 600px;
                margin: 20px auto;
                background-color: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            '>
                <!-- Header -->
                <div style='
                    background: linear-gradient(135deg, #007bff, #0056b3);
                    color: white;
                    padding: 30px;
                    text-align: center;
                '>
                    <h1 style='margin: 0; font-size: 28px;'>{$safeTitle}</h1>
                </div>
                
                <!-- Content -->
                <div style='padding: 40px 30px;'>
                    <div style='font-size: 16px; margin-bottom: 20px;'>
                        {$safeMessage}
                    </div>
                    {$buttonHtml}
                </div>
                
                <!-- Footer -->
                <div style='
                    background-color: #f8f9fa;
                    padding: 20px 30px;
                    text-align: center;
                    border-top: 1px solid #dee2e6;
                    font-size: 12px;
                    color: #6c757d;
                '>
                    " . ($safeFooter ?: 'Este mensaje fue enviado automáticamente. Por favor, no responder directamente.') . "
                    <br><br>
                    <small>Enviado con ❤️ desde PHP + PHPMailer</small>
                </div>
            </div>
        </body>
        </html>";
  }

  /**
   * Obtener información de configuración (sin mostrar contraseña)
   */
  public function getConfigInfo(): array
  {
    return [
      'host' => $this->config['host'],
      'port' => $this->config['port'],
      'username' => $this->config['username'],
      'password' => '***' . substr($this->config['password'], -4), // Solo los últimos 4 caracteres
      'secure' => $this->config['secure'],
      'from_email' => $this->config['from_email'],
      'from_name' => $this->config['from_name'],
    ];
  }
}

// ==================== EJEMPLO DE USO ====================

try {
  echo "<div style='max-width: 800px; margin: 20px auto; font-family: Arial, sans-serif;'>";

  // Verificar configuración
  if (
    EmailConfig::SMTP_USERNAME === 'tu-email@gmail.com' ||
    EmailConfig::SMTP_PASSWORD === 'tu-contraseña-de-aplicacion'
  ) {

    echo "<div style='
            background-color: #fff3cd;
            border: 2px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        '>";
    echo "<h3>⚠️ Configuración Requerida</h3>";
    echo "<p><strong>Antes de usar este script, debes configurar:</strong></p>";
    echo "<ol>";
    echo "<li><strong>SMTP_USERNAME:</strong> Tu email de Gmail</li>";
    echo "<li><strong>SMTP_PASSWORD:</strong> Tu contraseña de aplicación de Gmail (16 caracteres)</li>";
    echo "<li><strong>FROM_EMAIL:</strong> Tu email de Gmail (mismo que USERNAME)</li>";
    echo "<li><strong>TEST_RECIPIENT:</strong> Email del destinatario de prueba</li>";
    echo "</ol>";
    echo "<p><strong>📝 Cómo obtener la contraseña de aplicación:</strong></p>";
    echo "<ol>";
    echo "<li>Ve a <a href='https://myaccount.google.com/security' target='_blank'>Seguridad de Google</a></li>";
    echo "<li>Activa la verificación en dos pasos</li>";
    echo "<li>Busca 'Contraseñas de aplicación'</li>";
    echo "<li>Genera una nueva contraseña para 'Correo'</li>";
    echo "<li>Usa esa contraseña de 16 caracteres en SMTP_PASSWORD</li>";
    echo "</ol>";
    echo "</div>";
    return;
  }

  // Crear instancia del servicio de correo
  $emailSender = new EmailSenderPHPMailer();

  // Mostrar configuración (sin contraseña completa)
  echo "<div style='
        background-color: #d1ecf1;
        border: 2px solid #bee5eb;
        color: #0c5460;
        padding: 15px;
        border-radius: 10px;
        margin: 20px 0;
    '>";
  echo "<h3>📧 Configuración SMTP</h3>";
  $config = $emailSender->getConfigInfo();
  foreach ($config as $key => $value) {
    echo "<p><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> {$value}</p>";
  }
  echo "</div>";

  // Configurar el correo
  $destinatario = EmailConfig::TEST_RECIPIENT;
  $asunto = 'Correo HTML con PHPMailer - Prueba Exitosa';

  // Crear contenido HTML usando la plantilla
  $htmlContent = $emailSender->createProfessionalTemplate(
    'Bienvenido al Sistema de Notificaciones',
    "¡Felicidades! Tu configuración de PHPMailer está funcionando correctamente.\n\n" .
      "Este correo fue enviado usando:\n" .
      "✅ PHPMailer con autenticación SMTP\n" .
      "✅ Contraseña de aplicación de Gmail\n" .
      "✅ Formato HTML profesional\n" .
      "✅ Encriptación TLS segura\n\n" .
      "Ahora puedes enviar correos electrónicos de forma segura y profesional.",
    'Visitar Documentación',
    'https://github.com/PHPMailer/PHPMailer',
    'Correo enviado desde PHP con PHPMailer - ' . date('Y-m-d H:i:s')
  );

  // Enviar el correo
  echo "<div style='text-align: center; margin: 20px 0;'>";
  echo "<p>Enviando correo a: <strong>{$destinatario}</strong></p>";
  echo "<p>Asunto: <strong>{$asunto}</strong></p>";
  echo "</div>";

  $resultado = $emailSender->sendHtmlEmail(
    $destinatario,
    $asunto,
    $htmlContent
  );

  // Mostrar resultado
  if ($resultado) {
    echo "<div style='
            background-color: #d4edda;
            border: 2px solid #c3e6cb;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        '>";
    echo "<h3>✅ ¡Correo enviado exitosamente!</h3>";
    echo "<p><strong>Destinatario:</strong> {$destinatario}</p>";
    echo "<p><strong>Asunto:</strong> {$asunto}</p>";
    echo "<p><strong>Método:</strong> SMTP con autenticación</p>";
    echo "<p><strong>Formato:</strong> HTML profesional</p>";
    echo "<p><strong>Hora:</strong> " . date('Y-m-d H:i:s') . "</p>";
    echo "</div>";
  } else {
    // Mostrar el error interno de PHPMailer
    $errorMsg = method_exists($emailSender, 'getLastError') ? $emailSender->getLastError() : 'Error desconocido al enviar el correo';
    echo "<div style='
            background-color: #f8d7da;
            border: 2px solid #f5c6cb;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        '>";
    echo "<h3>❌ Error al enviar el correo</h3>";
    echo "<p><strong>Mensaje de error:</strong> " . htmlspecialchars($errorMsg, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<h4>💡 Posibles soluciones:</h4>";
    echo "<ul>";
    echo "<li>Verifica que la contraseña de aplicación sea correcta (16 caracteres)</li>";
    echo "<li>Asegúrate de que el email de Gmail sea válido</li>";
    echo "<li>Verifica que tengas conexión a Internet</li>";
    echo "<li>Comprueba que Gmail no esté bloqueando el acceso</li>";
    echo "</ul>";
    echo "</div>";
  }
} catch (InvalidArgumentException $e) {
  echo "<div style='
        background-color: #fff3cd;
        border: 2px solid #ffeaa7;
        color: #856404;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    '>";
  echo "<h3>⚠️ Error de validación</h3>";
  echo "<p>{$e->getMessage()}</p>";
  echo "</div>";
} catch (RuntimeException $e) {
  echo "<div style='
        background-color: #f8d7da;
        border: 2px solid #f5c6cb;
        color: #721c24;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    '>";
  echo "<h3>❌ Error del servidor</h3>";
  echo "<p>{$e->getMessage()}</p>";
  echo "<h4>💡 Posibles soluciones:</h4>";
  echo "<ul>";
  echo "<li>Verifica que la contraseña de aplicación sea correcta (16 caracteres)</li>";
  echo "<li>Asegúrate de que el email de Gmail sea válido</li>";
  echo "<li>Verifica que tengas conexión a Internet</li>";
  echo "<li>Comprueba que Gmail no esté bloqueando el acceso</li>";
  echo "</ul>";
  echo "</div>";
} catch (Throwable $e) {
  echo "<div style='
        background-color: #f8d7da;
        border: 2px solid #f5c6cb;
        color: #721c24;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    '>";
  echo "<h3>❌ Error inesperado</h3>";
  echo "<p>Ha ocurrido un error: {$e->getMessage()}</p>";
  echo "<p><strong>Línea:</strong> {$e->getLine()}</p>";
  echo "<p><strong>Archivo:</strong> {$e->getFile()}</p>";
  echo "</div>";
}

echo "</div>";

// ==================== INSTRUCCIONES ADICIONALES ====================
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Script PHPMailer - Correo HTML con Gmail</title>
  <style>
    .container {
      max-width: 800px;
      margin: 0 auto;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .info-box {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 25px;
      margin: 20px 0;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .code-box {
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 5px;
      padding: 15px;
      font-family: 'Courier New', monospace;
      overflow-x: auto;
      margin: 10px 0;
    }

    .success {
      background-color: #d4edda;
      border-color: #c3e6cb;
    }

    .warning {
      background-color: #fff3cd;
      border-color: #ffeaa7;
    }

    .info {
      background-color: #d1ecf1;
      border-color: #bee5eb;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="info-box">
      <h2>📧 Script PHPMailer con Gmail</h2>
      <p>Este script utiliza <strong>PHPMailer</strong> para enviar correos HTML con autenticación SMTP de Gmail.</p>

      <h3>🔧 Configuración Requerida</h3>
      <div class="code-box">
        // En la clase EmailConfig, modifica:
        const SMTP_USERNAME = 'tu-email@gmail.com';
        const SMTP_PASSWORD = 'abcd efgh ijkl mnop'; // Contraseña de aplicación
        const FROM_EMAIL = 'tu-email@gmail.com';
        const TEST_RECIPIENT = 'destinatario@ejemplo.com';
      </div>

      <h3>📝 Pasos para configurar Gmail</h3>
      <ol>
        <li><strong>Activa la verificación en dos pasos</strong> en tu cuenta de Google</li>
        <li>Ve a <a href="https://myaccount.google.com/security" target="_blank">Seguridad de Google</a></li>
        <li>Busca <strong>"Contraseñas de aplicación"</strong></li>
        <li>Selecciona <strong>"Correo"</strong> y <strong>"Windows Computer"</strong></li>
        <li>Copia la contraseña generada (16 caracteres con espacios)</li>
        <li>Úsala en <code>SMTP_PASSWORD</code></li>
      </ol>

      <h3>✨ Características</h3>
      <ul>
        <li>✅ Autenticación SMTP segura con Gmail</li>
        <li>✅ Soporte para contraseñas de aplicación</li>
        <li>✅ Plantillas HTML profesionales</li>
        <li>✅ Encriptación TLS/STARTTLS</li>
        <li>✅ Validación robusta de parámetros</li>
        <li>✅ Manejo completo de errores</li>
        <li>✅ Archivos adjuntos (opcional)</li>
        <li>✅ Texto alternativo automático</li>
      </ul>
    </div>

    <div class="info-box warning">
      <h3>⚠️ Importante</h3>
      <ul>
        <li><strong>NO uses tu contraseña normal de Gmail</strong></li>
        <li><strong>Siempre usa contraseñas de aplicación</strong> para scripts</li>
        <li><strong>Mantén tus credenciales seguras</strong> y no las subas a repositorios públicos</li>
        <li><strong>Para producción:</strong> usa variables de entorno</li>
      </ul>
    </div>

    <div class="info-box info">
      <h3>🚀 Uso Avanzado</h3>
      <p>Una vez configurado, puedes:</p>
      <ul>
        <li>Personalizar plantillas HTML</li>
        <li>Agregar archivos adjuntos</li>
        <li>Enviar correos masivos (con rate limiting)</li>
        <li>Integrar con bases de datos</li>
        <li>Crear sistemas de notificaciones</li>
      </ul>
    </div>
  </div>
</body>

</html>