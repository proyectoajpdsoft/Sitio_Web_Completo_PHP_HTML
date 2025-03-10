<html>
<style>
</style>
<body>

<?php
  include ("funciones.php");
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($enviar)
  {
    //comprobar si el usuario existe
    conectarbd ("bd");
    $sql = "SELECT codigo, email, contrasena, nombre, codigousuario
            FROM usuarios
            WHERE email = '" .$email ."'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      if ($row[2] == $contrasena)
      {
        mostrarTexto ("Información", "Su código de usuario es: " .
            $row["codigousuario"] . "<br>Su nombre es: " .$row[3] .
            "<br>Su E-Mail es: " .$row[1]);
      }
      else
      {
        mostrarTextoError ("Error",
            "La contraseña introducida no coindice con la del
            usuario seleccionado.
            <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
      }
    }
    else
    {
      mostrarTextoError ("Error",
          "No existe ningún usuario registrado con el E-Mail " .
          $email . "
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
  }
  else //enviar
  {

?>

<form method="post" action="recordarcodigo.php">

<p><font color="#008080" size="2"><span style="font-family: Arial"><b>Recordar código de usuario</b></span></font>
<div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
  <font face="verdana" style="font-size: 10pt">
  <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#cccccc" width="80%" id="AutoNumber1" height="148">
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">E-Mail:</td>
      <td width="75%" height="22"><input type="Text" name="email" size="42" maxlength="200"></td>
    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Contraseña:</td>
      <td width="75%" height="22"><input type="password" name="contrasena" size="17" maxlength="15"></td>
    </tr>
    <tr>
      <td width="100%" height="56" colspan="2">
      <div align="center">
      <input type="submit" name="enviar" value="Recordar código"></td>
      </div>
    </tr>
</table>

</form>

<?

} //end if

?>

</body>

</html>
