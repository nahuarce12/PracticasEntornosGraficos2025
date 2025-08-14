Dado los códigos de los documentos principal.html y estilo2.css, realizar las modificaciones necesarias en el
documento HTML para reemplazar la hoja de estilo interna por la externa estilo2.css (sin modificarla) y
obtener la misma salida en el navegador.

Se eliminó la hoja de estilos interna y se enlazó la externa con <link rel="stylesheet" href="estilos2.css">.
id="titulo" pasó a id="encabezado" (coincide con #encabezado del CSS externo).
Se agregó class="vineta" al UL (el CSS externo estiliza ul.vineta).
Se movieron estilos del menú a #menu (el CSS externo ya los define ahí); la clase navBar ya no es necesaria.
Se agregó class="estilopie" al pie para aplicar borde, color y tamaño de fuente definidos en el CSS externo.
