<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($tipousuario != "Administrador")
  {
    mostrarTextoError("Error de acceso", "No tiene permisos para realizar esta operación");
  }

  if ($opModificarTruco) //si se ha pulsado el botón modificar
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($titulo))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el título del truco.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($comentario))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el Comentario del truco.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($so))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el Sistema Operativo.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }

    conectarbd ("bdajpdsoft");

    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      $sql = "UPDATE trucos SET " .
             "titulo='" . $titulo . "'," .
             "comentario='" . $comentario . "'," .
             "so='" . $so . "'," .
             "fichero='" . $fichero . "'" .
             " WHERE codigo=" . $codigotruco;
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError ("Error",
            "No se ha podido modificar el truco " . $codigotruco .
            " inténtelo en otro momento.");
      }
      else
      {
        mostrarTexto ("Proceso realizado",
            "<br><br>El truco ha sido modificado correctamente.");
      }
    }
    else
    {
      mostrarTextoError ("Error",
          "Faltan datos necesarios para actualizar el truco.");
    }
  }
  else //enviar
  {

?>

<form method="post" action="trucoeditar.php">
<p><b><font color="#008080"><span style="font-family: Arial"><font size="2"><b>

<?
  if (! empty($codigousuario))
  {
    //seleccionar truco pasado como parámetro
    conectarbd ("bdajpdsoft");
    $sql = "SELECT *
            FROM trucos
            WHERE codigo='" . $codigotruco ."'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      $stitulo = $row["titulo"];
      $sso = $row["so"];
      $scomentario = $row["comentario"];
      $susuario = $row["codigousuario"];
      $sfichero = $row["fichero"];
    }
    else
    {
      mostrarTextoError ("Error",
          "El truco no se ha encontrado. <A href=\"login.html\">Iniciar sesión</A>");
    }
  }
  else
  {
    mostrarTextoError ("Error",
        "Debe inciar la sesión. <A href=\"login.html\">Iniciar sesión</A>");
  }
  echo "Edición de truco [código: " . $codigotruco . "]    [ " . $nombreusuario . " ]</font></span></b>";
?>


<div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
  <hr size=2 width="100%" align=center>
</div>
<font face="verdana" style="font-size: 10pt">
<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#cccccc" width="81%" id="AutoNumber1" height="148">
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt">Título:</td>
      <td width="75%" height="22" colspan="3">
      <input type="Text" name="titulo" size="52" maxlength="250"

      <?
        echo " value=\"" . $stitulo . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">S.O.:</td>
      <td width="75%" height="22" colspan="3"><input type="Text" name="so" size="52" maxlength="150"

      <?
        echo " value=\"" . $sso . "\"></td>";
      ?>

    </tr>
    <tr>
      <td width="25%" height="22">
      <font style="font-size: 10pt">Fichero:</td>
      <td width="75%" height="22" colspan="3"><input type="Text" name="fichero" size="52" maxlength="250"

      <?
        echo " value=\"" . $fichero . "\"></td>";
      ?>

    </tr>

    <tr>
      <td width="25%" height="22"><font style="font-size: 10pt">Truco:</td>
      <td width="75%" height="22" colspan="3">
      <textarea name="comentario" cols="50" rows="10">
      <?
        echo $scomentario . " </textarea></td>";
      ?>

      <input type=hidden name="codigotruco" value="
      <?
        echo $codigotruco . "\">";
      ?>

      

    </tr>
    <tr>
      <td width="100%" height="56" colspan="4">
      <div align="center">
      <input type="submit" name="opModificarTruco" value="Modificar datos"></td>
      </div>
    </tr>
</table>

</form>

<?

} //end if

?>

</body>

</html>
