# Ejercicio 3 - Script para Recomendar el Sitio a un Amigo

## Descripción

Este ejercicio implementa un sistema completo para que los visitantes puedan recomendar el sitio web a sus amigos mediante correo electrónico. El script incluye un formulario intuitivo, validación robusta y una plantilla de correo atractiva y profesional.

## Características

### ✨ Funcionalidades Principales

- **Formulario de recomendación** con campos para el recomendador y el amigo
- **Mensaje personalizado opcional** para agregar un toque personal
- **Validación completa** del lado del servidor usando PHP
- **Plantilla de correo HTML** profesional y atractiva
- **Diseño responsive** adaptado a móviles y tablets
- **Seguridad** con escape de HTML y validación de datos

### 🎨 Diseño y UX

- Interfaz moderna con gradientes y efectos visuales
- Diseño dividido en secciones claras y organizadas
- Iconos de Font Awesome para mejor usabilidad
- Límite de caracteres visual para el mensaje personal
- Feedback visual completo con mensajes de error y éxito

### 📧 Sistema de Correo

- Envío mediante PHPMailer con SMTP seguro
- Plantilla HTML responsive con diseño profesional
- Versión de texto plano como respaldo
- Personalización completa del mensaje
- Información del remitente para transparencia

## Instalación

### Requisitos

- PHP 8.3+ con `strict_types`
- Composer instalado (dependencias del Ejercicio1)
- Servidor web (Apache/Nginx)
- Cuenta de Gmail con contraseña de aplicación

### Configuración

1. **Verificar dependencias** (ya instaladas en Ejercicio1):

   ```bash
   cd ../Ejercicio1
   composer install
   ```

2. **Configurar credenciales SMTP**:
   Edita el archivo `recomendar.php` y modifica la clase `RecomendacionConfig`:

   ```php
   class RecomendacionConfig
   {
       public const SMTP_HOST = 'smtp.gmail.com';
       public const SMTP_PORT = 587;
       public const SMTP_USERNAME = 'tu-email@gmail.com'; // ← Cambiar aquí
       public const SMTP_PASSWORD = 'tu-contraseña-de-aplicacion'; // ← Cambiar aquí
       public const SITIO_NOMBRE = 'NAHUTILUS & ASSOCIATIONS';
       public const SITIO_URL = 'http://localhost/Practica5PHP';
       public const SITIO_DESCRIPCION = 'Un sitio web increíble con funcionalidades avanzadas y diseño profesional.';
   }
   ```

3. **Personalizar información del sitio**:
   - `SITIO_NOMBRE`: Nombre de tu sitio web
   - `SITIO_URL`: URL completa de tu sitio
   - `SITIO_DESCRIPCION`: Descripción que aparecerá en el correo

## Uso

### Acceso

1. Navega a `http://localhost/Practica5PHP/Ejercicio3/recomendar.php`
2. Completa el formulario con tus datos y los de tu amigo
3. Opcionalmente, agrega un mensaje personal
4. Haz clic en "Enviar Recomendación"

### Campos del Formulario

#### Tus Datos

- **Tu Nombre** (obligatorio): Mínimo 2 caracteres
- **Tu Email** (obligatorio): Formato válido de email

#### Datos de tu Amigo

- **Nombre del Amigo** (obligatorio): Mínimo 2 caracteres
- **Email del Amigo** (obligatorio): Formato válido de email

#### Mensaje Personal

- **Mensaje Personal** (opcional): Máximo 500 caracteres
- Contador de caracteres en tiempo real

### Validaciones

- **Servidor (PHP)**: Validación completa antes del envío
- **HTML5**: Validación básica nativa del navegador
- **Visual**: Campos con borde rojo y mensajes de error específicos

## Estructura del Código

### Clases Principales

#### `RecomendacionConfig`

Contiene la configuración SMTP y la información del sitio web.

#### `FormularioRecomendacion`

Maneja toda la lógica del formulario:

- `procesarFormulario()`: Procesa el POST del formulario
- `validarDatos()`: Valida todos los campos
- `enviarRecomendacion()`: Envía el correo usando PHPMailer
- `crearPlantillaHtml()`: Genera la plantilla HTML del correo
- `crearTextoPlano()`: Versión texto plano del correo

### Archivos

- `recomendar.php`: Archivo principal con todo el código
- `README.md`: Esta documentación

## Plantilla de Correo

### Características del Email

- **Header atractivo** con gradiente y mensaje personalizado
- **Sección principal** con información del sitio
- **Mensaje personal** destacado (si se proporciona)
- **Lista de beneficios** con iconos y checkmarks
- **Call-to-Action** prominente para visitar el sitio
- **Footer informativo** con datos del remitente

### Elementos Visuales

- Gradientes y colores profesionales
- Iconos y emojis para mayor atractivo
- Diseño responsive para móviles
- Botón de acción destacado
- Información de transparencia

## Personalización

### Cambiar Estilos

Modifica las variables CSS en la sección `<style>`:

```css
:root {
  --primary-color: #007bff;
  --success-color: #28a745;
  /* ... más variables */
}
```

### Personalizar Plantilla de Correo

Edita el método `crearPlantillaHtml()` en la clase `FormularioRecomendacion`.

### Modificar Información del Sitio

Actualiza las constantes en `RecomendacionConfig`:

- `SITIO_NOMBRE`
- `SITIO_URL`
- `SITIO_DESCRIPCION`

## Seguridad

### Buenas Prácticas Implementadas

- ✅ Uso de `declare(strict_types=1)`
- ✅ Escape de HTML con `ENT_QUOTES`
- ✅ Validación de entrada robusta
- ✅ Uso de PHPMailer para prevenir inyección de headers
- ✅ Sanitización de datos
- ✅ Configuración segura de SMTP
- ✅ Límite de caracteres en mensaje personal

### Consideraciones Adicionales

- Validación de formato de email en ambos campos
- Prevención de spam mediante validación del servidor
- Transparencia en el correo (muestra quién lo envió)

## Troubleshooting

### Error: "Undefined variable"

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

## Casos de Uso

### Usuario Final

1. Descubre el sitio web y le gusta
2. Quiere compartirlo con un amigo
3. Completa el formulario de recomendación
4. Su amigo recibe un correo atractivo y profesional
5. El amigo visita el sitio web recomendado

### Beneficios para el Sitio

- Aumenta el tráfico mediante recomendaciones orgánicas
- Mejora la credibilidad con recomendaciones de amigos
- Genera leads de calidad (usuarios recomendados)
- Facilita el marketing viral

## Licencia

Este código es para uso educativo en el contexto de la Práctica 5 de PHP.
