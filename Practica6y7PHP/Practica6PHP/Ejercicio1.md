1.  Consulta a una base de datos: Para comenzar la comunicación con un servidor de base de datos MySQL, es necesario abrir una conexión a ese servidor. Para inicializar esta conexión, PHP ofrece la función:
    mysqli_connect()

Todos sus parámetros son opcionales, pero hay tres de ellos que generalmente son necesarios:
host, usuario, contraseña

Una vez abierta la conexión, se debe seleccionar una base de datos para su uso, mediante la función:
mysqli_select_db()

Esta función debe pasar como parámetro:
la conexión y el nombre de la base de datos

La función mysqli_query() se utiliza para:
ejecutar una consulta SQL

y requiere como parámetros:
la conexión y la consulta SQL

La cláusula or die() se utiliza para:
detener la ejecución del script y mostrar un mensaje si ocurre un error

y la función mysqli_error() se puede usar para:
mostrar el mensaje de error de MySQL asociado a la última operación

Si la función mysqli_query() es exitosa, el conjunto resultante retornado se almacena en una variable, por ejemplo
$vResult, y a continuación se puede ejecutar el siguiente código (explicarlo):

<?php 
while ($fila = mysqli_fetch_array($vResultado))  
{ 
?>
<tr>
  <td><?php echo ($fila[0]); ?></td>
  <td><?php echo ($fila[1]); ?></td>
  <td><?php echo ($fila[2]); ?></td>
</tr>    
<?php 
} 
mysqli_free_result($vResultado);
mysqli_close($link); 
?>

- while ($fila = mysqli_fetch_array($vResultado)): Recorre cada fila del resultado de la consulta ($vResultado) y guarda cada una como array asociativo.
- Dentro del bucle: Se imprimen tres celdas (<td>) con los primeros tres campos de cada fila: $fila[0], $fila[1], $fila[2].
- mysqli_free_result($vResultado);: Libera memoria usada por el resultado de la consulta.
- mysqli_close($link);: Cierra la conexión con la base de datos.
