# Ejercicio 4: Contador de Páginas con Sesiones PHP

## 📋 Descripción

Sistema completo de contador de páginas visitadas utilizando sesiones PHP. Este proyecto demuestra el uso práctico de las sesiones para rastrear la navegación del usuario a través de múltiples páginas web.

## ✨ Características

- **Contador de páginas únicas**: Rastrea cuántas páginas diferentes ha visitado el usuario
- **Historial completo**: Mantiene un registro detallado de todas las visitas
- **Estadísticas avanzadas**: Análisis completo con gráficos y métricas
- **Interfaz moderna**: Diseño responsive con Bootstrap 5 y efectos visuales
- **Tiempo de sesión**: Calcula y muestra la duración de la sesión actual
- **Páginas de ejemplo**: 4 páginas temáticas para probar el sistema
- **Sin JavaScript**: Funcionalidad completa usando solo PHP y CSS

## 🏗️ Estructura del Proyecto

```
Ejercicio4/
├── index.php              # Dashboard principal con contador
├── ContadorSesion.php      # Clase del contador (separada)
├── estadisticas.php       # Página de estadísticas detalladas
├── pagina1.php           # Página de ejemplo - Tecnología
├── pagina2.php           # Página de ejemplo - Deportes
├── pagina3.php           # Página de ejemplo - Arte
├── pagina4.php           # Página de ejemplo - Ciencia
└── README.md             # Este archivo
```

## 🚀 Instalación y Configuración

### Requisitos Previos

- **PHP 8.0+** con soporte para sesiones
- **Servidor web** (Apache, Nginx, etc.)
- **Navegador web** moderno

### Instalación

1. **Clonar/Descargar** los archivos del proyecto
2. **Ubicar** los archivos en el directorio del servidor web
3. **Configurar** el servidor web para servir archivos PHP
4. **Acceder** a `index.php` desde el navegador

### Configuración del Servidor

#### Para XAMPP:

```bash
# Colocar archivos en:
C:\xampp\htdocs\Practica5PHP\Ejercicio4\

# Acceder desde:
http://localhost/Practica5PHP/Ejercicio4/index.php
```

#### Para servidor Linux:

```bash
# Colocar archivos en:
/var/www/html/Ejercicio4/

# Verificar permisos:
chmod 644 *.php
```

## 📖 Guía de Uso

### 1. Inicio de Sesión

- Al acceder por primera vez, se inicia automáticamente una nueva sesión
- El contador comienza en 0 páginas visitadas

### 2. Navegación

- **Dashboard**: Página principal con resumen del contador
- **Páginas 1-4**: Ejemplos temáticos para probar el sistema
- **Estadísticas**: Análisis detallado de la navegación

### 3. Funcionalidades del Contador

- Se incrementa automáticamente al visitar una nueva página
- Mantiene el historial completo de navegación
- Calcula estadísticas por página y tiempo de sesión

## 🔧 Funcionalidades Técnicas

### Clase ContadorSesion

```php
// Métodos principales:
contarVisita($nombrePagina, $url)    // Registra una nueva visita
obtenerContador()                    // Obtiene el número de páginas únicas
obtenerPaginasUnicas()               // Obtiene array de páginas únicas
obtenerHistorial()                   // Obtiene el historial completo
obtenerEstadisticasPaginas()         // Obtiene estadísticas por página
obtenerTiempoSesionFormateado()      // Calcula duración de sesión
```

### Variables de Sesión

```php
$_SESSION['paginas_unicas_visitadas'] // Array de páginas únicas visitadas
$_SESSION['historial_navegacion']    // Array con historial completo
$_SESSION['inicio_sesion']           // Timestamp de inicio de sesión
```

## 🎨 Características del Diseño

### Framework CSS

- **Bootstrap 5.3**: Framework responsive moderno
- **Font Awesome 6**: Iconografía profesional
- **CSS3**: Gradientes, animaciones y efectos visuales

### Temas por Página

- **Dashboard**: Gradiente azul profesional
- **Página 1**: Tema verde tecnológico
- **Página 2**: Tema azul deportivo
- **Página 3**: Tema naranja artístico
- **Página 4**: Tema morado científico
- **Estadísticas**: Tema rojo analítico

### Características Visuales

- Diseño totalmente responsive
- Efectos hover y transiciones suaves
- Tarjetas con sombras y transparencias
- Barras de progreso animadas
- Badges informativos

## 📊 Páginas de Ejemplo

### 1. Dashboard (index.php)

- Muestra el contador principal
- Navegación a todas las páginas
- Resumen de estadísticas básicas

### 2. Página Tecnología (pagina1.php)

- Contenido sobre tecnología moderna
- Tema verde
- Enlaces a recursos tecnológicos

### 3. Página Deportes (pagina2.php)

- Contenido deportivo
- Tema azul
- Información sobre deportes populares

### 4. Página Arte (pagina3.php)

- Contenido artístico
- Tema naranja
- Información sobre arte y cultura

### 5. Página Ciencia (pagina4.php)

- Contenido científico
- Tema morado
- Información sobre descubrimientos

### 6. Estadísticas (estadisticas.php)

- Análisis completo de navegación
- Gráficos y métricas detalladas
- Historial completo de visitas

## 🛠️ Personalización

### Añadir Nuevas Páginas

1. **Crear archivo PHP** con la estructura básica:

```php
<?php
declare(strict_types=1);
require_once 'index.php';
$contador = new ContadorSesion();
$contador->contarVisita('Mi Nueva Página', '/ruta/mi-pagina.php');
?>
```

2. **Añadir navegación** en las demás páginas
3. **Personalizar estilos** según la temática

### Modificar Estilos

- Editar variables CSS en cada archivo
- Cambiar gradientes en las clases `.card-header`
- Personalizar colores de botones en `.nav-btn`

### Extender Funcionalidades

```php
// Ejemplo: añadir tiempo por página
$contador->registrarTiempoPagina($nombrePagina, $tiempoEnPagina);

// Ejemplo: añadir filtros de estadísticas
$estadisticas = $contador->obtenerEstadisticasPorFecha($fecha);
```

## 🐛 Solución de Problemas

### Problemas Comunes

1. **Las sesiones no funcionan**

   ```php
   // Verificar configuración PHP
   phpinfo(); // Buscar session.save_path
   ```

2. **El contador no se incrementa**

   ```php
   // Verificar permisos de escritura
   // Comprobar que session_start() se ejecute
   ```

3. **Errores de CSS**
   ```html
   <!-- Verificar conexión a CDN -->
   <!-- Comprobar sintaxis CSS personalizada -->
   ```

### Debug Mode

```php
// Añadir al inicio de cualquier página para debug:
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ver contenido de sesión:
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
```

## 📈 Estadísticas Disponibles

### Métricas Básicas

- Número total de páginas visitadas
- Tiempo total de sesión
- Número de visitas por página
- Porcentaje de visitas por página

### Información de Sesión

- ID de sesión único
- Timestamp de inicio
- Duración formateada
- Información del navegador

### Historial Detallado

- Orden cronológico de visitas
- Hora exacta de cada visita
- URL completa visitada
- Nombre descriptivo de la página

## 🔒 Seguridad

### Medidas Implementadas

- **Escape de HTML**: Todas las salidas usan `htmlspecialchars()`
- **Tipos estrictos**: `declare(strict_types=1)`
- **Validación de datos**: Verificación de variables de sesión
- **Sanitización**: Limpieza de URLs y nombres de página

## 🔧 Correcciones Implementadas

### Problema Original

- **Contador doble**: Al visitar cualquier página se contaba también una visita a la página principal
- **Inconsistencia de conteos**: Los números no coincidían entre diferentes páginas
- **Arquitectura acoplada**: La clase estaba mezclada con el código del dashboard

### Solución Implementada

- **Clase separada**: `ContadorSesion.php` independiente del dashboard
- **Contador de páginas únicas**: Solo cuenta páginas diferentes, no visitas repetidas
- **Include correcto**: Cada página incluye solo la clase, no el dashboard completo
- **Consistencia garantizada**: Todos los contadores muestran el mismo número

### Recomendaciones Adicionales

- Implementar CSRF tokens para formularios
- Añadir limits de tiempo de sesión
- Validar origen de las requests
- Implementar rate limiting

## 🚀 Posibles Mejoras

### Funcionalidades Avanzadas

- **Base de datos**: Persistir datos entre sesiones
- **Usuarios**: Sistema de login y perfiles
- **Analytics**: Gráficos más avanzados con librerías CSS
- **Export**: Exportar estadísticas a PDF/Excel
- **Real-time**: Actualización en tiempo real con PHP

### Optimizaciones

- **Cache**: Implementar cache de estadísticas
- **Minificación**: Comprimir CSS
- **CDN**: Servir assets desde CDN
- **PWA**: Convertir en Progressive Web App

## 📝 Notas del Desarrollador

### Decisiones de Diseño

- Se eligió usar sesiones nativas de PHP por simplicidad
- Bootstrap 5 para garantizar compatibilidad moderna
- Estructura de clases para facilitar el mantenimiento
- CSS inline para simplificar la distribución
- **Sin JavaScript**: Todas las funcionalidades implementadas con PHP puro para mayor compatibilidad y simplicidad
- **Arquitectura modular**: Clase ContadorSesion separada del dashboard principal
- **Contador de páginas únicas**: Solo cuenta páginas diferentes, no visitas repetidas
- **Historial completo**: Mantiene registro de todas las navegaciones para estadísticas

### Consideraciones de Performance

- Las sesiones se almacenan en el servidor
- No hay consultas a base de datos
- CSS servido desde CDN para mejor caching
- Código optimizado para PHP 8+
- Sin dependencias de JavaScript para mayor compatibilidad

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 👨‍💻 Créditos

- **Desarrollado por**: Ejercicio práctico PHP
- **Framework**: Bootstrap 5.3
- **Iconos**: Font Awesome 6.0
- **Inspiración**: Sistemas modernos de analytics web

---

**Última actualización**: <?= date('d/m/Y H:i:s') ?>

**Versión**: 1.0.0
