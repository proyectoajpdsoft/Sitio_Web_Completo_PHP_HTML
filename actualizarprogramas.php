<?
  include ("funciones.php");
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  iniciarSesionPaginas();
  $tipoletranormal = "<font face=\"verdana\" style=\"font-size: 10pt\">";
  if ($tipousuario == "Pago" | $tipousuario == "Pago-Lista" |
      $tipousuario == "Administrador")  //si es de pago
  {
    //pondremos un hipervinculo para configuracion.ini por cada programa
    //que tenga registrado
    if ($tipousuario == "Administrador")  //si es el administrador (todos)
    {
      $sqlConsulta = "SELECT codigoprograma, codigousuario, programas.nombre NombrePrograma
                      FROM usuariosprograma, programas
                      WHERE programas.codigo=usuariosprograma.codigoprograma";
    }
    else
    {
      $sqlConsulta = "SELECT codigoprograma, codigousuario, programas.nombre NombrePrograma
                      FROM usuariosprograma, programas
                      WHERE programas.codigo=usuariosprograma.codigoprograma AND
                      codigousuario = " . $codigousuario;
    }
    conectarbd("bd");
    $sqlResultado = mysql_query($sqlConsulta);
    $contador = 0;
    while ($row = mysql_fetch_array($sqlResultado))
    {
      $contador++;
      echo $tipoletranormal . "<br> * Para realizar actualizaciones autom�ticas v�a Web de " .
          $row["NombrePrograma"] . ", descargue estos dos ficheros en
          la misma carpeta y ejecute el fichero: \"actualizar.exe\":";
      echo $tipoletranormal . "<br><A href=\"usuactualiza/actualizar.exe\">
          Descargar fichero ejecutable</A><br>";
      echo $tipoletranormal . "<A href=\"usuactualiza/programa/" .
          $row["codigoprograma"] . "/configuracion.ini\">
          Descargar fichero de configuraci�n</A><br>";
    }
    if ($contador == 0)
    {
      mostrarTexto ("No tiene programas registrados",
        "Para poder realizar actualizaciones autom�ticas
        debe tener programas registrados.");
    }
  }
  else
  {
    mostrarTexto ("No tiene permisos para realizar la operaci�n",
        "Para poder realizar actualizaciones autom�ticas
        ha de ser usuario de pago.");
  }
?>
