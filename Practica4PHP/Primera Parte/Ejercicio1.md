```

Ejercicio 1:
En el siguiente código identificar:
• las variables y su tipo
• los operadores
• las funciones y sus parámetros
• las estructuras de control
• cuál es la salida por pantalla

<?php
function doble($i) {
 return $i*2;
}
$a = TRUE;
$b = "xyz";
$c = 'xyz';
$d = 12;
echo gettype($a);
echo gettype($b);
echo gettype($c);
echo gettype($d);
if (is_int($d)) {
 $d += 4;
}
if (is_string($a)) {
 echo "Cadena: $a";
}
$d = $a ? ++$d : $d*3;
$f = doble($d++);
$g = $f += 10;
echo $a, $b, $c, $d, $f , $g;
?>



Variables y su tipo:
$a → booleano
$b → string
$c → string
$d → entero
$f → entero
$g → entero

Operadores:
= (asignación)
* (multiplicación)
+= (suma y asignación)
++ (incremento)
? : (ternario)
, (separador en echo)

Funciones y sus parámetros:
doble($i) → parámetro $i
gettype($var) → parámetro: $var
is_int($d) → parámetro: $d
is_string($a) → parámetro: $a
echo → imprime valores

Estructuras de control:
if (is_int($d)) { ... }
if (is_string($a)) { ... }
Operador ternario: $d = $a ? ++$d : $d*3;


Salida por pantalla:
booleanstringstringinteger1xyzxyz184444




```
