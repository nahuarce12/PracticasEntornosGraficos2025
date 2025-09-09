# Ejercicio 2 - Página de Contacto

## Descripción

Esta es una página de contacto profesional que presenta un formulario para que los visitantes puedan enviar consultas al webmaster. El formulario incluye validación tanto del lado del cliente como del servidor, y envía los mensajes por correo electrónico usando PHPMailer.

## Características

### ✨ Funcionalidades

- **Formulario completo** con campos: nombre, email, teléfono (opcional), asunto y mensaje
- **Validación robusta** del lado del servidor usando PHP
- **Envío de correos** usando PHPMailer con plantilla HTML profesional
- **Diseño responsive** con Bootstrap 5 y estilos personalizados
- **Seguridad** con escape de HTML y validación de datos
- **Experiencia de usuario** con feedback visual y mensajes claros

### 🎨 Diseño

- Interfaz moderna con gradientes y efectos visuales
- Diseño responsive que se adapta a móviles y tablets
- Iconos de Font Awesome para mejor usabilidad
- Efectos CSS suaves y feedback visual
- Plantilla de correo HTML profesional

### 🔒 Seguridad

- Escape de HTML con `htmlspecialchars()`
- Validación de email con `filter_var()`
- Sanitización de datos de entrada
- Protección contra XSS
- Validación de formato de teléfono

## Instalación

### Requisitos

- PHP 8.3+ con `strict_types`
- Composer instalado
- Servidor web (Apache/Nginx)
- Cuenta de Gmail con contraseña de aplicación

### Configuración

1. **Instalar dependencias** (ya instaladas en Ejercicio1):

   ```bash
   cd ../Ejercicio1
   composer install
   ```

2. **Configurar credenciales SMTP**:
   Edita el archivo `contacto.php` y modifica la clase `ContactoConfig`:

   ```php
   class ContactoConfig
   {
       public const SMTP_HOST = 'smtp.gmail.com';
       public const SMTP_PORT = 587;
       public const SMTP_USERNAME = 'tu-email@gmail.com'; // ← Cambiar aquí
       public const SMTP_PASSWORD = 'tu-contraseña-de-aplicacion'; // ← Cambiar aquí
       public const WEBMASTER_EMAIL = 'webmaster@tudominio.com'; // ← Email de destino
       public const WEBMASTER_NAME = 'Webmaster NAHUTILUS';
   }
   ```

3. **Obtener contraseña de aplicación de Gmail**:
   - Ve a tu cuenta de Google
   - Seguridad → Verificación en 2 pasos
   - Contraseñas de aplicación
   - Genera una nueva para "Correo"

## Uso

### Acceso

1. Navega a `http://localhost/Practica5PHP/Ejercicio2/contacto.php`
2. Completa el formulario con los datos requeridos
3. Haz clic en "Enviar Mensaje"

### Campos del Formulario

- **Nombre** (obligatorio): Mínimo 2 caracteres
- **Email** (obligatorio): Formato válido de email
- **Teléfono** (opcional): Solo números, espacios, guiones y paréntesis
- **Asunto** (obligatorio): Mínimo 5 caracteres
- **Mensaje** (obligatorio): Mínimo 10 caracteres

### Validaciones

- **Servidor (PHP)**: Validación completa antes del envío
- **HTML5**: Validación básica nativa del navegador
- **Visual**: Campos con borde rojo y mensajes de error específicos

## Estructura del Código

### Clases Principales

#### `ContactoConfig`

Contiene la configuración SMTP y credenciales de correo.

#### `FormularioContacto`

Maneja toda la lógica del formulario:

- `procesarFormulario()`: Procesa el POST del formulario
- `validarDatos()`: Valida todos los campos
- `enviarCorreo()`: Envía el correo usando PHPMailer
- `crearPlantillaHtml()`: Genera la plantilla HTML del correo
- `crearTextoPlano()`: Versión texto plano del correo

### Archivos

- `contacto.php`: Archivo principal con todo el código
- `README.md`: Esta documentación

## Personalización

### Cambiar Estilos

Modifica las variables CSS en la sección `<style>`:

```css
:root {
  --primary-color: #007bff;
  --secondary-color: #6c757d;
  /* ... más variables */
}
```

### Cambiar Plantilla de Correo

Edita el método `crearPlantillaHtml()` en la clase `FormularioContacto`.

### Agregar Campos

1. Añade el campo al HTML
2. Agrega validación en `validarDatos()`
3. Incluye en la plantilla de correo

## Seguridad

### Buenas Prácticas Implementadas

- ✅ Uso de `declare(strict_types=1)`
- ✅ Escape de HTML con `ENT_QUOTES`
- ✅ Validación de entrada robusta
- ✅ Uso de PHPMailer para prevenir inyección de headers
- ✅ Sanitización de datos
- ✅ Configuración segura de SMTP

### Recomendaciones Adicionales

- Implementar CSRF tokens en producción
- Usar HTTPS en producción
- Configurar rate limiting para prevenir spam
- Implementar CAPTCHA si es necesario

## Troubleshooting

### Error: "Undefined variable $emailSender"

- Verifica que las credenciales SMTP estén configuradas correctamente

### Error: "SMTP connect() failed"

- Verifica la configuración SMTP
- Asegúrate de usar una contraseña de aplicación de Gmail
- Verifica que la cuenta tenga verificación en 2 pasos activada

### Formulario no envía

- Revisa los logs de error de PHP
- Verifica que PHPMailer esté instalado correctamente
- Comprueba la configuración del servidor web

## Tecnologías Utilizadas

- **Backend**: PHP 8.3+ con strict types
- **Email**: PHPMailer 6.x
- **Frontend**: HTML5, CSS3
- **Framework CSS**: Bootstrap 5.3
- **Iconos**: Font Awesome 6.0
- **Validación**: PHP del lado del servidor + HTML5 nativo

## Licencia

Este código es para uso educativo en el contexto de la Práctica 5 de PHP.
