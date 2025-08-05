Analizar los siguientes segmentos de código indicando en qué sección del documento HTML
se colocan, cuál es el efecto que producen y señalar cada uno de los elementos, etiquetas, y atributos
(nombre y valor), aclarando si es obligatorio.
2.a)

<!-- Código controlado el día 12/08/2009 →
2.b)
<div id="bloque1">Contenido del bloque1</div>
2.c)
<img src="" alt="lugar imagen" id="im1" name="im1" width="32" height="32"
longdesc="detalles.htm" />
2.d)
<meta name="keywords" lang="es" content="casa, compra, venta, alquiler " />
<meta http-equiv="expires" content="16-Sep-2019 7:49 PM" />
2.e)
<a href="http://www.e-style.com.ar/resumen.html" type="text/html" hreflang="es" charset="utf-8"
rel="help">Resumen HTML </a>

2) 
a)
      Ubicación: En cualquier parte del documento HTML.
      Efecto: Es un comentario, no se muestra en el navegador ni tiene efecto visual o funcional. Sirve para dejar notas para desarrolladores.

      Análisis:

        Etiqueta: <!-- ... --> (comentario)

        Contenido: "Código controlado el día 12/08/2009"

        Obligatorio: No es obligatorio, es opcional y no afecta el documento.

b)  
 Ubicación: Dentro del <body>, ya que es contenido visible.
Efecto: Define un bloque contenedor con id="bloque1", puede usarse para aplicar estilo o manipular con JavaScript.

        Análisis:

        Etiqueta: <div> (división o contenedor genérico)

        Elemento: <div id="bloque1">Contenido del bloque1</div>

        Atributo:

          id="bloque1": Identificador único. No obligatorio, pero recomendable si vas a usar CSS o JS.

          Contenido del elemento: Contenido del bloque1

          Obligatorio: El id no es obligatorio. La etiqueta <div> sí debe cerrarse.

c)
Ubicación: Dentro del <body>, ya que representa una imagen.
Efecto: Muestra una imagen (aunque no se ve si src está vacío), con dimensiones 32x32 y atributos de accesibilidad.

        Análisis:

          Etiqueta: <img /> (etiqueta vacía o autocontenida, no lleva cierre)

          Atributos:

            src="" → Obligatorio, indica la ruta de la imagen. Está vacío, por lo que no cargará nada.

            alt="lugar imagen" → Obligatorio, describe la imagen si no se puede cargar (por accesibilidad).

            id="im1" → Identificador único. No obligatorio.

            name="im1" → Nombre del campo, útil en formularios. No obligatorio.

            width="32" → Ancho en píxeles. No obligatorio.

            height="32" → Alto. No obligatorio.

            longdesc="detalles.htm" → URL con una descripción larga. Fue parte de HTML4, pero es obsoleto en HTML5. No obligatorio.

d)
Ubicación: Dentro de la sección <head>.
Efecto:

          La primera etiqueta define palabras clave para buscadores (hoy en día, poco utilizadas).

          La segunda controla cuándo el contenido expira (usado por caches o proxies).

        Análisis:

          Primera línea:

            Etiqueta: <meta />

            Atributos:

              name="keywords" → indica el tipo de metadato.

              lang="es" → idioma del contenido (opcional en <meta>, más común en <html>).

              content="..." → Obligatorio: contiene los datos del metadato.

          Segunda línea:

            Etiqueta: <meta />

            Atributos:

              http-equiv="expires" → se comporta como una cabecera HTTP simulada.

              content="16-Sep-2019 7:49 PM" → fecha de expiración del documento.

e)
Ubicación: Dentro del <body>, ya que es un enlace visible.
Efecto: Crea un hipervínculo a la URL especificada, indicando que el destino está en español, es de tipo HTML, en codificación UTF-8 y que el enlace es una ayuda.

        Análisis:

          Etiqueta: <a>...</a> (ancla o hipervínculo)

          Atributos:

            href="..." → Obligatorio en un enlace. Define la URL de destino.

            type="text/html" → Indica el tipo MIME del recurso (opcional).

            hreflang="es" → Idioma del documento vinculado (opcional).

            charset="utf-8" → Indica la codificación del destino (opcional, no recomendado en HTML5).

            rel="help" → Relación del destino con el documento actual; help sugiere que el enlace lleva a ayuda.
