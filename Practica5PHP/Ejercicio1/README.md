# 📧 Script de Correo HTML con PHPMailer

## 🎯 Descripción

Este proyecto contiene dos scripts PHP para enviar correos electrónicos con formato HTML:

1. **`script.php`** - Versión básica usando la función `mail()` de PHP
2. **`script_phpmailer.php`** - Versión avanzada usando PHPMailer con autenticación SMTP

## 🚀 Características

### Script Básico (`script.php`)

- ✅ Función `mail()` nativa de PHP
- ✅ Formato HTML con CSS integrado
- ✅ Validación de parámetros
- ✅ Plantillas predefinidas
- ❌ No soporta autenticación SMTP
- ❌ No funciona con Gmail directamente

### Script PHPMailer (`script_phpmailer.php`)

- ✅ PHPMailer con autenticación SMTP
- ✅ Soporte para Gmail con contraseña de aplicación
- ✅ Encriptación TLS/STARTTLS
- ✅ Plantillas HTML profesionales
- ✅ Archivos adjuntos
- ✅ Manejo robusto de errores
- ✅ Texto alternativo automático

## 📋 Requisitos

- PHP 8.2+
- XAMPP, WAMP, LAMP o servidor web con PHP
- Cuenta de Gmail (para el script PHPMailer)
- Conexión a Internet

## 🔧 Instalación

1. **Clonar o descargar el proyecto:**

   ```bash
   git clone [url-del-repositorio]
   # o descargar y extraer el ZIP
   ```

2. **Colocar en el directorio del servidor web:**

   ```
   c:\Programas\xampp\htdocs\Practica5PHP\
   ```

3. **Los archivos ya incluyen PHPMailer integrado** (no necesitas Composer)

## ⚙️ Configuración

### Para Gmail (Recomendado)

1. **Activa la verificación en dos pasos** en tu cuenta de Google:

   - Ve a [Seguridad de Google](https://myaccount.google.com/security)
   - Activa "Verificación en 2 pasos"

2. **Genera una contraseña de aplicación:**

   - En la misma página, busca "Contraseñas de aplicación"
   - Selecciona "Correo" y "Windows Computer"
   - Copia la contraseña generada (16 caracteres)

3. **Configura el script PHPMailer:**
   ```php
   // En script_phpmailer.php, línea ~25
   public const SMTP_USERNAME = 'tu-email@gmail.com';
   public const SMTP_PASSWORD = 'abcd efgh ijkl mnop'; // Tu contraseña de aplicación
   public const FROM_EMAIL = 'tu-email@gmail.com';
   public const TEST_RECIPIENT = 'destinatario@ejemplo.com';
   ```

### Para otros proveedores SMTP

Modifica la configuración según tu proveedor:

```php
// Ejemplo para Outlook/Hotmail
public const SMTP_HOST = 'smtp-mail.outlook.com';
public const SMTP_PORT = 587;

// Ejemplo para Yahoo
public const SMTP_HOST = 'smtp.mail.yahoo.com';
public const SMTP_PORT = 587;
```

## 🎮 Uso

### Script Básico

```bash
# Desde el navegador
http://localhost/Practica5PHP/Ejercicio1/script.php

# Desde terminal
cd c:\Programas\xampp\htdocs\Practica5PHP\Ejercicio1
C:\Programas\xampp\php\php.exe script.php
```

### Script PHPMailer (Recomendado)

```bash
# Desde el navegador
http://localhost/Practica5PHP/Ejercicio1/script_phpmailer.php

# Desde terminal
cd c:\Programas\xampp\htdocs\Practica5PHP\Ejercicio1
C:\Programas\xampp\php\php.exe script_phpmailer.php
```

## 📝 Personalización

### Cambiar destinatario

```php
const TEST_RECIPIENT = 'nuevo-destinatario@ejemplo.com';
```

### Personalizar plantilla HTML

```php
$htmlContent = $emailSender->createProfessionalTemplate(
    'Tu Título',
    'Tu mensaje aquí...',
    'Texto del Botón',
    'https://tu-enlace.com'
);
```

### HTML completamente personalizado

```php
$htmlCustom = "
<h1 style='color: blue;'>Mi Correo</h1>
<p>Contenido personalizado...</p>
";

$emailSender->sendHtmlEmail(
    'destinatario@ejemplo.com',
    'Mi Asunto',
    $htmlCustom
);
```

## 🐛 Solución de Problemas

### "Failed to connect to mailserver"

- **Problema:** No hay servidor SMTP configurado
- **Solución:** Usa `script_phpmailer.php` con Gmail

### "Authentication failed"

- **Problema:** Contraseña incorrecta
- **Solución:** Verifica que uses contraseña de aplicación (no tu contraseña normal)

### "SMTP connect() failed"

- **Problema:** Conexión bloqueada
- **Soluciones:**
  - Verifica conexión a Internet
  - Revisa firewall/antivirus
  - Usa puerto 587 en lugar de 465

### "Invalid email address"

- **Problema:** Email mal formateado
- **Solución:** Verifica formato: `usuario@dominio.com`

## 📁 Estructura del Proyecto

```
Practica5PHP/
├── Ejercicio1/
│   ├── script.php              # Script básico
│   └── script_phpmailer.php    # Script con PHPMailer
├── vendor/
│   ├── autoload.php           # Autoloader
│   └── phpmailer/
│       └── phpmailer/
│           └── src/           # Clases PHPMailer
├── composer.json              # Configuración de dependencias
└── README.md                  # Esta documentación
```

## 🔒 Seguridad

### ✅ Buenas Prácticas Implementadas

- Validación de emails con `filter_var()`
- Sanitización con `htmlspecialchars()`
- Escape de caracteres especiales
- Parámetros tipados estrictamente
- Manejo robusto de excepciones

### ⚠️ Consideraciones para Producción

- **Nunca** hardcodees credenciales en el código
- Usa variables de entorno: `$_ENV['SMTP_PASSWORD']`
- Implementa rate limiting para prevenir spam
- Agrega logs para monitoreo
- Usa HTTPS en producción

## 📧 Ejemplos de Uso

### Correo de Bienvenida

```php
$htmlContent = $emailSender->createProfessionalTemplate(
    'Bienvenido a Nuestra Plataforma',
    'Gracias por registrarte. Tu cuenta ha sido creada exitosamente.',
    'Comenzar',
    'https://mi-sitio.com/dashboard'
);
```

### Notificación de Compra

```php
$htmlContent = $emailSender->createProfessionalTemplate(
    'Compra Confirmada',
    'Tu pedido #12345 ha sido procesado y será enviado pronto.',
    'Ver Pedido',
    'https://mi-tienda.com/orders/12345'
);
```

### Reset de Contraseña

```php
$htmlContent = $emailSender->createProfessionalTemplate(
    'Restablecer Contraseña',
    'Haz clic en el botón para crear una nueva contraseña.',
    'Restablecer',
    'https://mi-sitio.com/reset?token=abc123'
);
```

## 🤝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature
3. Commitea tus cambios
4. Push a la rama
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

## 🆘 Soporte

Si encuentras problemas:

1. Revisa esta documentación
2. Verifica la configuración
3. Consulta los mensajes de error
4. Abre un issue en el repositorio

---

**¡Disfruta enviando correos HTML profesionales con PHP! 📧✨**
