```

3)
  a)
    <a href="http://www.google.com.ar">Click aquí para ir a Google</a> - Abre Google en la misma ventana/pestaña.
    <a href="http://www.google.com.ar" target="_blank">Click aquí para ir a Google</a> - Abre Google en una nueva ventana/pestaña.
    <a href="http://www.google.com.ar" type="text/html" hreflang="es" charset="utf-8" rel="help"> - type="text/html": Especifica el tipo MIME del enlace
      hreflang="es": Indica que el contenido está en español
      charset="utf-8": Define la codificación de caracteres
      rel="help": Indica que es un enlace de ayuda
    <a href="#">Click aquí para ir a Google</a> - No navega a ningún sitio, solo recarga la página actual.
    <a href="#arriba">Click aquí para volver arriba</a> - Navega al elemento con id="arriba" en la misma página.
    <a name="arriba" id="arriba"></a> - Define un punto de anclaje en la página.

  b)
    <p><img src="im1.jpg" alt="imagen1" /><a href="http://www.google.com.ar">Click aquí</a></p> - Imagen seguida de un enlace de texto. Solo el texto es clickeable.
    <p><a href="http://www.google.com.ar"><img src="im1.jpg" alt="imagen1" /></a> Click aquí</p> - Solo la imagen es clickeable, el texto "Click aquí" no es un enlace.
    <p><a href="http://www.google.com.ar"><img src="im1.jpg" alt="imagen1" />Click aquí</a></p> - Tanto la imagen como el texto son clickeables (un solo enlace).
    <p><a href="http://www.google.com.ar"><img src="im1.jpg" alt="imagen1" /></a> <a href="http://www.google.com.ar">Click aquí</a></p> - Dos enlaces separados que van al mismo destino: uno para la imagen y otro para el texto.

  c)
    <ul>
      <li>xxx</li>
      <li>yyy</li>
      <li>zzz</li>
    </ul>

    Lista no ordenada basica con Viñetas simples (•)

    <ol>
      <li>xxx</li>
      <li>yyy</li>
      <li>zzz</li>
    </ol>

    Lista anidada con Numeración automática (1, 2, 3)

    <ol>
      <li>xxx</li>
      <ol>
        <li value="2">yyy</li>
      </ol>
      <ol>
        <li value="3">zzz</li>
      </ol>
    </ol>

    Listas anidadas con numeración específica usando value.

    <blockquote>
      <p>1. xxx<br />
      2. yyy<br />
      3. zzz</p>
    </blockquote>

    Texto indentado como cita, no es una lista real.

  d)
    <table border="1" width="300">
      <tr>
        <th>Columna 1</th>
        <th>Columna 2</th>
      </tr>
      <tr>
        <td>Celda 1</td>
        <td>Celda 2</td>
      </tr>
      <!-- más filas -->
    </table>

    Estructura básica de tabla

    <table border="1" width="300">
      <tr>
        <td><div align="center"><strong>Columna 1</strong></div></td>
        <td><div align="center"><strong>Columna 2</strong></div></td>
      </tr>
      <!-- más filas -->
    </table>

    Tabla con formato mas avanzado


    Diferencias:  Usa <div align="center"> para centrar contenido
                  Usa <strong> para texto en negrita
                  No usa <th> para encabezados

  e)
    <caption> (izquierda): Es la forma semánticamente correcta de titular una tabla. El título aparece fuera de la estructura de filas y columnas.
    colspan="3" (derecha): Usa una celda que se extiende por 3 columnas para simular un título, pero es parte de la tabla.
    Ambos centran el título, pero <caption> lo coloca encima de la tabla, mientras que colspan lo incluye como primera fila.
  f)
    colspan="3": La celda se extiende 3 columnas horizontalmente
    rowspan="2": La celda se extiende 2 filas verticalmente
    Estas propiedades permiten crear celdas que ocupan múltiples espacios

  g)
    cellpadding="0": Espacio interno de las celdas
    cellspacing="0": Espacio entre celdas
    rowspan y colspan: Para fusionar celdas

  h)
    Tres formularios diferentes:

    Formulario POST: Envía datos de forma segura
    Formulario GET: Envía datos visibles en la URL
    Formulario con mailto: Envía por email
    Diferencias clave:
      method="post" vs method="get"
      target="_blank": Abre resultado en nueva ventana
      action: Define dónde se procesan los datos
      Tipos de input: text, password, submit, reset

  i)
    Botón 1 - Usando <button>:
    <label>Botón 1
    <button type="button" name="boton1" id="boton1">
    <img src="logo.jpg" alt="Botón con imagen" width="30" height="20" /><br />
    <b>CLICK AQUÍ</b></button></label>

    Botón 2 - Usando <input>:
    <label>Botón 2
    <input type="button" name="boton2" id="boton2" value="CLICK AQUÍ" />
    </label>


    Diferencias:
    <button>: Permite contenido HTML complejo (imágenes, texto formateado, etc.)
    <input type="button": Solo admite texto plano en el atributo value
    Ambos son clickeables, pero <button> ofrece más opciones de presentación

  j)
    Radio buttons individuales
    <p><label><input type="radio" name="opcion" id="X" value="X" />X</label><br />
    <label><input type="radio" name="opcion" id="Y" value="Y" />Y</label></p>

    Radio buttons agrupados:
    <p><label><input type="radio" name="opcion1" id="X" value="X" />X</label><br />
    <label><input type="radio" name="opcion2" id="Y" value="Y" />Y</label></p>

    Diferencias:
    Mismo name (primera): Los radio buttons son mutuamente excluyentes - solo se puede seleccionar uno
    Diferente name (segunda): Los radio buttons son independientes - se pueden seleccionar ambos
    El atributo name determina qué radio buttons pertenecen al mismo grupo

  k)
    Select izquierdo - Selección simple:

    <select name="lista">
    <optgroup label="Caso 1">
    <option>Mayo</option>
    <option>Junio</option>
    </optgroup>
    <optgroup label="Caso 2">
    <option>Mayo</option>
    <option>Junio</option>
    </optgroup>
    </select>

    Select derecho - Selección múltiple:

    <select name="lista[]" multiple="multiple">
    <optgroup label="Caso 1">
    <option>Mayo</option>
    <option>Junio</option>
    </optgroup>
    <optgroup label="Caso 2">
    <option>Mayo</option>
    <option>Junio</option>
    </optgroup>
    </select>

    Diferencias:
    multiple="multiple": Permite seleccionar múltiples opciones (Ctrl+click)
    name="lista[]": Array notation para manejar múltiples valores en el servidor
    Visualización: El múltiple se muestra como una lista expandida, el simple como dropdown
    Interacción: Simple = una opción, Múltiple = varias opciones simultáneamente
    <optgroup>: Agrupa opciones visualmente en ambos casos


```
