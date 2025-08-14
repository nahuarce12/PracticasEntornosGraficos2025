```
Analizar el siguiente código señalando declaraciones y aplicaciones de reglas, y su efecto.
p.quitar {
color: red;
}
*.desarrollo {
font-size: 8px;
}
.importante {
font-size: 20px;
}
<p class="desarrollo">
En este primer párrafo trataremos lo siguiente:
<br />xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<p class="quitar">
Este párrafo debe ser quitado de la obra…
<br />xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<p >
En este otro párrafo trataremos otro tema:<br />
xxxxxxxxxxxxxxxxxxxxxxxxx
</p>
<p class="importante">
Y este es el párrafo más importante de la obra…
<br />xxxxxxxxxxxxxxxxxxxxxxxxx
</ p>
<h1 class="quitar">Este encabezado también debe ser quitado de la obra</h1>
<p class="quitar importante">Se pueden aplicar varias clases a la vez</p>




Selector: p.quitar
  Especificidad:, clases 1, tipo 1 (más específico que una simple clase).
  Declaraciones:
    color: red;
  Efecto esperado: pone en rojo el texto de cualquier párrafo (<p>) que tenga la clase quitar. El color se hereda a los descendientes inline.

Selector: *.desarrollo
  Especificidad: ID 0, clases 1, tipo 0. El * no aporta especificidad; *.desarrollo es equivalente a .desarrollo.
  Declaraciones:
    font-size: 8px;
  Efecto esperado: reduce a 8px el tamaño de fuente de cualquier elemento con la clase desarrollo (se hereda a su contenido).

Selector: .importante
  Especificidad: ID 0, clases 1, tipo 0.
  Declaraciones:
    font-size: 20px;
  Efecto esperado: aumenta a 20px el tamaño de fuente de cualquier elemento con la clase importante (se hereda a su contenido).



<p class="desarrollo">…</p> - Coincide con: *.desarrollo (.desarrollo). - Resultado: font-size: 8px en el párrafo y su contenido. Color y resto de propiedades por defecto/heredadas.
<p class="quitar">…</p> - Coincide con: p.quitar. - Resultado: color: red en el texto del párrafo. Tamaño de fuente por defecto (p. ej., ~16px si no hay otra regla).
<p>…</p> (sin clase) - Coincide con: ninguna de las reglas definidas. - Resultado: estilos por defecto del navegador/hojas heredadas.
<p class="importante">…</p> - Coincide con: .importante. - Resultado: font-size: 20px en el párrafo.
<h1 class="quitar">…</h1> - Coincide con: ninguna regla (p.quitar solo aplica a p con clase quitar, no a h1). - Resultado: el h1 mantiene estilos por defecto.
<p class="quitar importante">…</p> - Coincide con: p.quitar y .importante. - Cascada/resultado combinado: - color: red (de p.quitar). - font-size: 20px (de .importante).

```
