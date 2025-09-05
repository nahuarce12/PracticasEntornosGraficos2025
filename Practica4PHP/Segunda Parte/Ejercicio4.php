<?php
function comprobar_nombre_usuario($nombre_usuario){
 //compruebo que el tamaño del string sea válido.
 if (strlen($nombre_usuario)<3 || strlen($nombre_usuario)>20){
 echo $nombre_usuario . " no es válido<br>";
 return false;
 }
 //compruebo que los caracteres sean los permitidos
 $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
 for ($i=0; $i<strlen($nombre_usuario); $i++){
 if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
 echo $nombre_usuario . " no es válido<br>";
 return false;
 }
 }
 echo $nombre_usuario . " es válido<br>";
 return true;
}

// script de prueba
echo "Pruebas de validación de nombres de usuario:</br>";

// casos validos
comprobar_nombre_usuario("juan123");
comprobar_nombre_usuario("Maria_Gonzalez");
comprobar_nombre_usuario("user-name");
comprobar_nombre_usuario("ABC");

// casos invalidos
comprobar_nombre_usuario("ab");  // Muy corto
comprobar_nombre_usuario("usuario_muy_largo_123456");  // Muy largo
comprobar_nombre_usuario("juan@mail");  // Carácter no permitido (@)
comprobar_nombre_usuario("user name");  // Espacio no permitido
comprobar_nombre_usuario("juan.carlos");  // Punto no permitido
?>