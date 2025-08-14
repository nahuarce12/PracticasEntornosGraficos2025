```

1. ¿ Qué es CSS y para qué se usa?
2. CSS utiliza reglas para las declaraciones de estilo, ¿cómo funcionan?
3. ¿ Cuáles son las tres formas de dar estilo a un documento?
4. ¿ Cuáles son los distintos tipos de selectores más utilizados?
Ejemplifique cada uno.
5. ¿ Qué es una pseudo-clase? Cuáles son las más utilizadas aplicadas a vínculos?
6. ¿ Qué es la herencia?
7. ¿ En qué consiste el proceso denominado cascada?

1. CSS (Cascading Style Sheets)  es un mecanismo simple que describe cómo se va a mostrar un documento en la pantalla, o cómo se va a imprimir, o incluso cómo va a ser pronunciada la información presente en ese documento a través de un dispositivo de lectura. Controla colores, tipografías, espacios, tamaños, posiciones, animaciones y el diseño responsive. Separa el contenido (HTML) de la presentación (CSS).

2. Una regla CSS tiene:
    Selector: a qué elementos se aplica.
    Bloque de declaraciones: par(es) propiedad: valor;
  El navegador calcula el estilo final combinando reglas mediante especificidad, herencia, importancia (!important) y orden.

3. Las tres formas de dar estilo a un documento son:
    A nivel de html (inline)
    A nivel de pagina (embebida/interna)
    En un archivo externo (.css)

4. Los tipos de selectores mas utilizados son:
    -Universal: Selecciona todos los elementos. Ej: * { box-sizing: border-box; }
    -De Tipo: Selecciona todos los elementos de una etiqueta HTML específica. Ej: h1 { font-size: 2rem; }
    -De Clase: Selecciona elementos que tengan el atributo class con ese nombre. Ej: .card { box-shadow: 0 2px 6px #0002; }
    -De ID: Selecciona el elemento con ese id. Ej: #main { max-width: 1200px; margin: 0 auto; }
    -Descendiente (A B): Selecciona elementos B que estén en cualquier nivel dentro de A. Ej: nav a { text-decoration: none; }
    -Hijo directo (A > B): Selecciona elementos B que sean hijos inmediatos de A. Ej: ul > li { list-style: none; }
    -Hermano adyacente (A + B): Selecciona el primer elemento B inmediatamente después de A, al mismo nivel. Ej: h2 + p { margin-top: 0; }
    -Hermanos generales (A ~ B): Selecciona todos los elementos B que son hermanos posteriores de A. Ej: h2 ~ p { color: #555; }
    -De atributo: Seleccion por presencia o patrón  del atributo.
      Ej: input[type="email"] { border-color: #0af; }
          a[target="_blank"] { cursor: alias; }
          [data-role] { outline: 1px dashed #ccc; }
    -Pseudo-clases: Representan un estado del elemento.
      Ej: button:hover { background: #333; }
          input:focus { border-color: #09f; }
          li:nth-child(2n) { background: #f7f7f7; }
          a:visited { color: purple; }
          .item:not(.active) { opacity: .5; }
    -Pseudo-elementos: Representan partes “virtuales” de un elemento para aplicar estilo o insertar contenido generado.
      Ej: p::first-line { font-variant: small-caps; }
          .btn::before { content: "★ "; color: gold; }

5. Una pseudo-clase describe un estado especial de un elemento (ej.: interacción o posición).
   En enlaces, las más usadas:
    :link (no visitado)
    :visited (visitado)
    :hover (al pasar el mouse)
    :active (al hacer clic)
    :focus (con foco por teclado)

6. Herencia es el mecanismo por el que ciertos valores de propiedades se transmiten desde un elemento padre a sus descendientes (p. ej., color, font-family).

7. El proceso denominado cascada es es el algoritmo que decide el estilo final cuando múltiples reglas coinciden:
    i. Origen y prioridad: navegador (user agent), usuario, autor; y si tienen !important.
    ii. Especificidad: inline > ID > clases/atributos/pseudo-clases > tipo/pseudo-elementos.
    iii. Orden de aparición: a igualdad de todo lo anterior, gana la última regla declarada.






```
