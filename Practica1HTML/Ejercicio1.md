1.  Qué es HTML, cuando fue creado, cuáles fueron las distintas versiones y cuál es la última?

    HTML (HyperText Markup Language) es el lenguaje de marcado estándar para estructurar y presentar contenido en la web. Define la semántica y estructura de páginas web.
    Fue especificado por primera vez por Tim Berners-Lee en 1990 y la primera descripción pública (“HTML Tags”) apareció a fines de 1991; la versión formal inicial se remonta a 1993.

    Las versiones que existieron de html son:

    - HTML 2.0 (1995) – primera especificación amplia estandarizada.
    - HTML 3.2 (1997) – estandarizado por W3C, incorporando extensiones de navegadores.
    - HTML 4.0 / 4.01 (1997 / 1999) – introdujo variantes (Strict, Transitional, Frameset, separación de presentación y contenido.
    - XHTML (años 2000) – reescritura basada en XML.
    - HTML5 (Recomendación W3C publicada el 28 de octubre de 2014), luego HTML 5.1 y 5.2; esas versiones fueron retiradas formalmente en favor de la “HTML Living Standard” mantenida por WHATWG, que es la versión actual y viviente.

2.  ¿Cuáles son los principios básicos que el W3C recomienda seguir para la creación de documentos
    con HTML?

    - Compatibilidad e interoperabilidad: Usar estándares abiertos para que las páginas funcionen en distintos navegadores y contextos.
    - Semántica y separación de preocupaciones: Usar etiquetas HTML según su significado (ej. <.header>, <.article>, <.nav>) y no para presentación; la presentación debe manejarse con CSS.
    - Accesibilidad (POUR): El contenido debe ser Perceptible, Operable, Comprensible y Robusto para personas con distintas capacidades. Esto se estructura en las pautas WCAG.
    - Robustez y progresive enhancement: El contenido debería degradarse de forma razonable y funcionar aun en entornos limitados, construyendo sobre lo básico hacia más complejidad.
    - Diseño pensado para la web (Web Standards): Seguir el modelo de estándares web para asegurar mantenibilidad, rendimiento y facilidad de evolución.
    - Utilidad y diseño centrado en el usuario: Las decisiones de diseño de HTML deben priorizar la utilidad real, compatibilidad y evitar rupturas innecesarias en la experiencia. (Reflejado en los principios de diseño de HTML y de plataforma web).

3.  En las Especificaciones de HTML, ¿cuándo un elemento o atributo se considera desaprobado? ¿y
    obsoleto?

    Desaprobado (deprecated): Significa que el elemento/atributo aún puede funcionar, pero no se recomienda su uso porque será eliminado en el futuro y existe una alternativa mejor. Ejemplo: <.font>.

    Obsoleto (obsolete): Ya no se debe usar y puede que no sea soportado por los navegadores. Ejemplo: <.blink> o <.marquee>

4.  Qué es el DTD y cuáles son los posibles DTDs contemplados en la especificación de HTML 4.01?

    DTD (Document Type Definition) es una definición de tipo de documento que describe la gramática (qué elementos, atributos y estructura son válidos) para documentos basados en SGML (en el caso de HTML 4.x). Permite validación formal de la estructura de un documento. En HTML 4.01, el DOCTYPE referencia un DTD

    Los DTDs de HTML 4.01 son tres variantes:

    - Strict – no permite características desaprobadas (deprecated); solo estructura semántica limpia.
    - Transitional – permite elementos y atributos desaprobados para compatibilidad con contenido antiguo.
    - Frameset – como el Transitional pero con soporte para frames.

5.  Qué son los metadatos y cómo se especifican en HTML?

    Los metadatos son “datos sobre los datos”: información que describe características del documento HTML (por ejemplo: codificación de caracteres, descripción, autor, instrucciones para el navegador, configuración de viewport, etc.). No se muestran directamente en el cuerpo de la página pero son consumidos por navegadores, motores de búsqueda, redes sociales y otras herramientas.

    Van dentro del elemento <.head>. Los principales mecanismos son:

    - <title>: título del documento (metadata esencial para SEO y pestañas).
    - <'meta>: define metadatos diversos, por ejemplo:
      - Codificación: <.meta charset="UTF-8">
      - Viewport para móviles: <.meta name="viewport" content="width=device-width, initial-scale=1">
      - Descripción: <.meta name="description" content="Resumen de la página">
      - Instrucciones simulando cabeceras HTTP: <.meta http-equiv="refresh" content="30">
    - <.link>: relación con recursos externos (ej. favicon, hojas de estilo, prefetch).
    - <.base>: base URL para enlaces relativos.
    - Otros: <.style>, <.script> también se consideran parte del conjunto de metadatos en ciertos sentidos estructurales.
