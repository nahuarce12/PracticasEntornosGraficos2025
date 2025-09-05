```

Indicar si los siguientes códigos son equivalentes.

<?php
$a = array( 'color' => 'rojo',
 'sabor' => 'dulce',
 'forma' => 'redonda',
 'nombre' => 'manzana',
 4
 );
?>

<?php
$a['color'] = 'rojo';
$a['sabor'] = 'dulce';
$a['forma'] = 'redonda';
$a['nombre'] = 'manzana';
$a[] = 4;
?>


Sí, los dos códigos son equivalentes. Ambos crean un array $a con las mismas claves y valores y agregan el valor 4 sin clave

```
