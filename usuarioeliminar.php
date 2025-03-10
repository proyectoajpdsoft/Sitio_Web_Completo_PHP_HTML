<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    //si existe eliminar
    conectarbd ("bdajpdsoft");
    $sql = "DELETE FROM usuarios
            WHERE codigo = '" . $codigousuario . "'";
    $result = mysql_query($sql);
    session_unset();
    session_destroy();
    mostrarTextoError ("Usuario eliminado", "El usuario " . $nombreusuario .
        " ha sido eliminado correctamente. <A target=\"_blank\" href=\"login.html\">Iniciar sesión</A>");
  }
  else //enviar
  {

?>

<form method="post" action="usuarioeliminar.php">
<p><b><font color="#008080"><span style="font-family: Arial"><font size="2"><b>
Eliminar usuario [ </span></font>
<?
  echo $tipoletranormal . $nombreusuario . " ";
?>
]<div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
  <hr size=2 width="100%" align=center>
</div>
<font face="verdana" style="font-size: 10pt">
<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#cccccc" width="81%" id="AutoNumber1" height="148">
    <tr>
      <td width="25%" height="22"><font face="verdana" style="font-size: 10pt">
      Pulse el botón "Eliminar usuario" para darse de baja definitivamente.
    </tr>
    <tr>
      <td width="100%" height="56" colspan="4">
      <div align="center">
      <input type="submit" name="enviar" value="Eliminar usuario"></td>
      </div>
    </tr>
    <tr>
      <td width="100%" height="56" colspan="4">
      <b><font size="2">Nota: la eliminación será permanente.</font></b></tr>
</table>

</form>

<?

} //end if

?>

</body>

</html>
