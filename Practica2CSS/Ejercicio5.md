```
En cada caso, declarar una regla CSS que produzca el siguiente efecto:
1. Los textos enfatizados dentro de cualquier título deben ser rojos.
2. Cualquier elemento que tenga asignado el atributo "href" y que esté dentro de cualquier párrafo que a
su vez esté dentro de un bloque debe ser color negro.
3. El texto de las listas no ordenadas que estén dentro del bloque identificado como “ultimo” debe ser
amarillo pero si es un enlace a otra página debe ser azul.
4. Los elementos identificados como “importante” dentro de cualquier bloque deben ser verdes, pero si
están dentro de un título deben ser rojos.
5. Todos los elementos h1 que especifique el atributo title, cualquiera que sea su valor, deben ser azules.
6. El color de los enlaces en las listas ordenadas debe ser azul para los enlaces aún no visitados, y violeta
para los ya visitados y, además, no deben aparecer subrayados.

1. h1 em, h2 em, h3 em, h4 em, h5 em, h6 em, h1 strong, h2 strong, h3 strong, h4 strong, h5 strong, h6 strong { color: red; }
2. div p [href] { color: black; }
3. #ultimo ul { color: yellow; } #ultimo ul a { color: blue; }
4. div #importante { color: green; } h1 #importante, h2 #importante, h3 #importante, h4 #importante, h5 #importante, h6 #importante { color: red; }
5. h1[title] { color: blue; }
6.  a:link { color: blue; text-decoration: none; }
    a:visited { color: violet; text-decoration: none; }
```
