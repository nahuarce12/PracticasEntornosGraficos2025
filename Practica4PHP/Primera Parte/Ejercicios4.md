```

Si el archivo datos.php contiene el código que sigue:

<?php
$color = 'blanco';
$flor = 'clavel';
?>

Indicar las salidas que produce el siguiente código. Justificar.

<?php
echo "El $flor $color \n";
include 'datos.php';
echo " El $flor $color";
?>

Salida:
El
El clavel blanco

El primer echo no muestra valores porque las variables aún no existen.
El segundo echo sí muestra los valores definidos en datos.php.

```
