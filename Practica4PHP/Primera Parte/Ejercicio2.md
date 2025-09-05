```

Indicar si los siguientes códigos son equivalentes.

a)

<?php
$i = 1;
while ($i <= 10) {
 print $i++;
}
?>

<?php
$i = 1;
while ($i <= 10):
 print $i;
 $i++;
endwhile;
?>

<?php
$i = 0;
do {
 print ++$i;
} while ($i<10);
?>

Los 3 codigos son equivalentes. Todos imprimen los números del 1 al 10, uno tras otro (12345678910)

b)

<?php
for ($i = 1; $i <= 10; $i++) {
 print $i;
}
?>

<?php
for ($i = 1; $i <= 10; print $i, $i++) ;
?>

<?php
for ($i = 1; ;$i++) {
 if ($i > 10) {
 break;
 }
 print $i;
}
?>

<?php
$i = 1;
for (;;) {
 if ($i > 10) {
 break;
 }
 print $i;
 $i++;
}
?>

Si, son equivalentes. Todos imprimen los números del 1 al 10, uno tras otro (12345678910)


c)

<?php
…
…
if ($i == 0) {
 print "i equals 0";
} elseif ($i == 1) {
 print "i equals 1";
} elseif ($i == 2) {
 print "i equals 2";
}
?>

<?php
…
…
switch ($i) {
 case 0:
 print "i equals 0";
 break;
 case 1:
 print "i equals 1";
 break;
 case 2:
 print "i equals 2";
 break;
}
?>

Si, son equivalentes. Ambos verifican el valor de $i y muestran el mismo mensaje segun si $i es 0, 1 o 2.


```
