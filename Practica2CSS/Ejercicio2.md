```

Analizar el siguiente código señalando declaraciones y aplicaciones de reglas, y su efecto.
p#normal {
font-family: arial,helvetica;
font-size: 11px;
font-weight: bold;
}
*#destacado {
border-style: solid;
border-color: blue;
border-width: 2px;
}
#distinto {
background-color: #9EC7EB;
color: red;
}
<p id="normal">Este es un párrafo</p>
<p id="destacado">Este es otro párrafo</p>
<table id="destacado"><tr><td>Esta es una tabla</td></tr></table>
<p id="distinto">Este es el último párrafo</p>


Regla p#normal
Selector: p#normal
Especificidad: Aplica solo a <p id="normal">.
Declaraciones:
font-family: arial, helvetica; (tipografía prioriza Arial, luego Helvetica)
font-size: 11px; (tamaño fijo pequeño)
font-weight: bold; (negrita)
Efecto:
El primer párrafo “Este es un párrafo” se renderiza en Arial/Helvetica, 11px y en negrita.

Regla *#destacado
Selector: *#destacado
Especificidad: Aplica a cualquier elemento cuyo id sea destacado.
Declaraciones:
border-style: solid;
border-color: blue;
border-width: 2px;
Efecto:
<p id="destacado">: muestra un borde azul de 2px alrededor del párrafo.
<table id="destacado">: la tabla completa muestra un borde exterior azul de 2px. Las celdas (<td>) mantienen su estilo por defecto (sin bordes) a menos que se definan aparte. No se usa border-collapse, así que solo se ve el borde del contenedor tabla.

Regla #distinto
Selector: #distinto
Especificidad: Aplica a cualquier elemento con id distinto (acá, un <p>).
Declaraciones:
background-color: #9EC7EB; (celeste claro)
color: red; (texto rojo)
Efecto:
<p id="distinto">: el párrafo se ve con fondo celeste y texto rojo.


<p id="normal">Este es un párrafo</p> - Coincide con p#normal. - Resultado: Arial/Helvetica, 11px, bold.
<p id="destacado">Este es otro párrafo</p> - Coincide con *#destacado. - Resultado: borde azul sólido de 2px alrededor del párrafo.
<table id="destacado"><tr><td>Esta es una tabla</td></tr></table> - Coincide con *#destacado. - Resultado: borde azul sólido de 2px alrededor de la tabla completa.
<p id="distinto">Este es el último párrafo</p> - Coincide con #distinto. - Resultado: fondo #9EC7EB y texto rojo.

```
