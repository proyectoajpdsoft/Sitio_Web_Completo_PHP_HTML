<html>
<body>

<?php
  include ("funciones.php");
  iniciarSesionPaginas();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  if ($tipousuario != "Administrador")  //si no es el administrador
  {
    mostrarTextoError("Error de acceso", "No tiene permisos para realizar esta operación.");
  }
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($nombre))
    {
      $seguir = false;
      mostrarTextoError("Error", "No ha introducido el Nombre.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (empty($codigo))
    {
      $seguir = false;
      mostrarTextoError("Error", "No ha introducido el Código.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    elseif ((strlen($codigo)) > 15)
    {
      $seguir = false;
       mostrarTextoError("Error", "El código debe ser de menos de 15 caracteres (se pueden
          introducir números y letras).
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    //comprobamos la fecha de  creación
    if (empty($dia) || empty($mes) || empty($ano))
    {
      $seguir = false;
       mostrarTextoError("Error", "La fecha de creación no es correcta.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (($dia < 1) || ($dia > 31))
    {
      $seguir = false;
       mostrarTextoError("Error", "La fecha de creación no es correcta.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (($ano < 1900) || ($ano > 2003))
    {
      $seguir = false;
       mostrarTextoError("Error", "El año de creación no es correcto.
      <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    $fechacreacion = $ano . "-" . $mes . "-" . $dia;
    if ($finalizado != 1)
    {
      $finalizado = 0;
    }
    if ($libre != 1)
    {
      $libre = 0;
    }

    //comprobar si el codigo de programa ya existe
    conectarbd("bd");
    $sql = "SELECT codigo, nombre FROM programas WHERE codigo = '" .$codigo ."'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      $seguir = false;
       mostrarTextoError("Error", "Ya existe un programa con el código: " .
           $codigo ." -> " .$row[1]);
    }
    //comprobar si el nombre de programa ya existe
    $sql = "SELECT codigo, nombre FROM programas WHERE nombre = '" .$nombre ."'";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_array($result))
    {
      $seguir = false;
      mostrarTextoError("Error", "Ya existe un programa con el nombre: " .
          $nombre ." -> " .$row[0]);
    }

    //FIN VALIDACION DATOS
    if ($seguir == true)  //si la validación es correcta
    {
      $sql = "INSERT INTO programas (codigo, nombre, version, so, comentario, tamano, precio, tipo, finalizado, libre, fechacreacion)";
      $sql .= "VALUES ('$codigo', '$nombre', '$version', '$so', '$comentario', '$tamano', '$precio', '$tipo', '$finalizado', '$libre', '$fechacreacion')";
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError("Error", "No se ha podido dar de alta el programa " .
            $nombre . " inténtelo en otro momento.");
      }
      mostrarTexto("Proceso realizado", "El programa ha sido dado de alta correctamente.");
    }
    else
    {
      mostrarTextoError("Error", "Faltan datos necesarios para añadir el programa.");
    }
  }
  else //enviar
  {

?>

<form method="post" action="programaalta.php">

<p><font color="#008080"><span style="font-family: Arial"><font size=2><b>Añadir programa [

<?
  echo $nombreusuario;
?>

]</b></span></font>
<div class=MsoNormal align=center style='text-align:center; width:657; height:28'>
<hr size=2 width="100%" align=center>
</div>
  <font face="verdana" style="font-size: 10pt">
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="98%" id="AutoNumber2" bordercolorlight="#C0C0C0" bordercolordark="#C0C0C0" height="377">
  <tr>
    <td width="19%" height="25">
  <font face="verdana" style="font-size: 10pt">
    <font style="font-size: 10pt">Código:</td>
    <td width="84%" height="25">
  <font face="verdana" style="font-size: 10pt">
    <input type="Text" name="codigo" size="15" maxlength="15"></td>
  </tr>
  <tr>
    <td width="19%" height="23"><font style="font-size: 10pt" face="verdana">Nombre:</td>
    <td width="84%" height="23">
  <font face="verdana" style="font-size: 10pt">
      <input type="Text" name="nombre" size="72" maxlength="150"></td>
  </tr>
  <tr>
    <td width="19%" height="25"><font style="font-size: 10pt" face="verdana">Versión:</td>
    <td width="84%" height="25">
  <font face="verdana" style="font-size: 10pt">
      <input type="Text" name="version" size="15" maxlength="15"></td>
  </tr>
  <tr>
    <td width="19%" height="24"><font style="font-size: 10pt" face="verdana">S.O.:</td>
    <td width="84%" height="24">
  <font face="verdana" style="font-size: 10pt">
    <input type="Text" name="so" size="42" maxlength="100"></td>
  </tr>
  <tr>
    <td width="19%" height="86"><font style="font-size: 10pt" face="verdana">Comentario:</td>
    <td width="84%" height="86">
  <font face="verdana" style="font-size: 10pt">
      <textarea rows="5" name="comentario" cols="62"></textarea></td>
  </tr>
  <tr>
    <td width="19%" height="27"><font style="font-size: 10pt" face="verdana">Tamaño
    (MB):</td>
    <td width="84%" height="27">
  <font face="verdana" style="font-size: 10pt">
      <input name="tamano" size="10" maxlength="6" value="0"></td>
  </tr>
  <tr>
    <td width="19%" height="24">
  <font face="verdana" style="font-size: 10pt">
      <p align="right">Precio
      (Euros):</td>
    <td width="84%" height="24">
  <font face="verdana" style="font-size: 10pt">
      <input name="precio" size="10" maxlength="6" value="0.00"></td>
  </tr>
  <tr>
    <td width="19%" height="25"><font style="font-size: 10pt" face="verdana">Tipo:</td>
    <td width="84%" height="25">
  <font face="verdana" style="font-size: 10pt">
      <input type="Text" name="tipo" size="41" maxlength="30"></td>
  </tr>
  <tr>
    <td width="19%" height="25">
    <font size="2" face="verdana" style="font-size: 10pt">Fecha creac.:</font></td>
    <td width="84%" height="25">
  <font face="verdana" style="font-size: 10pt">
    <font size="2">Día:</font> <select size="1" name="dia">
  <option selected>01</option>
  <option>02</option>
  <option>03</option>
  <option>04</option>
  <option>05</option>
  <option>06</option>
  <option>07</option>
  <option>08</option>
  <option>09</option>
  <option>10</option>
  <option>11</option>
  <option>12</option>
  <option>13</option>
  <option>14</option>
  <option>15</option>
  <option>16</option>
  <option>17</option>
  <option>18</option>
  <option>19</option>
  <option>20</option>
  <option>21</option>
  <option>22</option>
  <option>23</option>
  <option>24</option>
  <option>25</option>
  <option>26</option>
  <option>27</option>
  <option>28</option>
  <option>29</option>
  <option>30</option>
  <option>31</option>
  </select>&nbsp;
      <font size="2">Mes:</font> <select size="1" name="mes">
  <option selected value="01">Enero</option>
  <option value="02">Febrero</option>
  <option value="03">Marzo</option>
  <option value="04">Abril</option>
  <option value="05">Mayo</option>
  <option value="06">Junio</option>
  <option value="07">Julio</option>
  <option value="08">Agosto</option>
  <option value="09">Septiembre</option>
  <option value="10">Octubre</option>
  <option value="11">Noviembre</option>
  <option value="12">Diciembre</option>
  </select>&nbsp;
      Año:<input name="ano" size="6" maxlength="4" value="2003"></td>
  </tr>
  <tr>
    <td width="19%" height="23"><font style="font-size: 10pt" face="verdana">
    Libre:</td>
    <td width="84%" height="23">
  <font face="verdana" style="font-size: 10pt">
      <input type="checkbox" name="libre" value="1" checked></td>
  </tr>
  <tr>
    <td width="19%" height="25"><font style="font-size: 10pt" face="verdana">
    Finalizado:</td>
    <td width="84%" height="25">
  <font face="verdana" style="font-size: 10pt">
      <input type="checkbox" name="finalizado" value="1" checked></td>
  </tr>
  <tr>
    <td width="103%" colspan="2" align="center" height="34">
  <font face="verdana" style="font-size: 10pt">
      <input type="submit" name="enviar" value="Añadir programa"></td>
  </tr>
</table>
</div>

</form>
<?

} //end if

?>

</body>

</html>
