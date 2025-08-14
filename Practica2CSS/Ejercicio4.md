```
Dadas las siguientes declaraciones:
* {color:green; }
a:link {color:gray }
a:visited{color:blue }
a:hover {color:fuchsia }
a:active {color:red }
p {font-family: arial,helvetica;font-size: 10px;color:black; }
.contenido{font-size: 14px;font-weight: bold; }
Analizar los siguientes códigos y comparar sus efectos. Explicar:

Caso 1:
<body>
<p class="contenido" style="font-weight: normal;">
Este es un texto ...............</p>
<table>
<tr>
<td>Y esta es una tabla.......</td>
</tr>
<tr>
<td><a href="http://www.google.com.ar">con un
enlace</a></td>
</tr>
</table>
</body>


body
  color: green (por *).
  font-size y font-weight: por defecto del navegador.
p.contenido con style
  Conflicto font-size: p (10px) vs .contenido (14px). Gana .contenido por mayor especificidad (clase > tipo) → 14px.
  font-weight: inline style (font-weight: normal) > .contenido (bold) → normal.
  font-family: arial, helvetica (de p).
  color: black (de p, más específico que *).
table y td
  color: green (heredado de body).
  font-size y font-weight: valores por defecto del navegador (no hay regla que los cambie).
  font-family: por defecto del navegador (p es solo para p).
a dentro del td
  color: según estado (a:link gray, a:visited blue, a:hover fuchsia, a:active red). Estas reglas superan el color heredado/por *.
  font-size y font-weight: heredan del td (por defecto del navegador). En este caso, normal y tamaño por defecto.


Caso 2:
<body class="contenido">
<p> Este es un texto................</p>
<table>
<tr>
<td>Y esta es una tabla.......</td>
</tr>
<tr>
<td><a href="http://www.google.com.ar">con
un enlace</a></td>
</tr>
</table>
</body>

body.contenido
  font-size: 14px; font-weight: bold (de .contenido).
  color: green (de *).
p (sin clase)
  font-size: 10px (regla p especifica valor y siempre supera herencia de body).
  font-weight: bold (heredado de body, p no lo redefine).
  font-family: arial, helvetica (de p).
  color: black (de p).
table y td
  font-size: 14px; font-weight: bold (heredados de body).
  color: green (heredado de body).
  font-family: por defecto del navegador.
a dentro del td
    color: según estado (gray/blue/fuchsia/red). Estas reglas sobreescriben el verde heredado.
font-size y font-weight: heredan del td → 14px y bold.


Ámbito de .contenido:
Caso 1: solo afecta al p que la tiene.
Caso 2: puesta en body, afecta a todo el documento por herencia.
Párrafo principal:
Caso 1: 14px, font-weight normal (por inline), Arial/Helvetica, color negro.
Caso 2: 10px, font-weight bold (heredado), Arial/Helvetica, color negro.
Tabla y su contenido:
Caso 1: tamaño y peso por defecto; color verde.
Caso 2: 14px y bold (heredados del body); color verde.
Enlace:
En ambos: color gobernado por a:link/visited/hover/active; en Caso 1 hereda tamaño/peso por defecto; en Caso 2 hereda 14px y bold del body/td.

```
