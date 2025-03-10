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
  if ($enviar)
  {
    $seguir = true;
    //INICIO VALIDACION DATOS
    if (empty($codigoincidencia))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "No ha introducido el Código de la incidencia. <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    //comprobamos la fecha de resolución
    if (empty($dia) || empty($mes) || empty($ano))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "La fecha de resolución no es correcta.
           <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (($dia < 1) || ($dia > 31))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "La fecha de resolución no es correcta.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    if (($ano < 1900) || ($ano > 2100))
    {
      $seguir = false;
      mostrarTextoError ("Error",
          "El año de resolución no es correcto.
          <A href=\"javascript:history.back();\">Volver a intentarlo</A>");
    }
    $fecharesolucion = $ano . "-" . $mes . "-" . $dia;
    conectarbd("bd");
    //comprobar si existe la incidencia
    $sql = "SELECT codigo
            FROM incidencias
            WHERE codigo = " . $codigoincidencia;
    $result = mysql_query($sql);
    if (! ($row = mysql_fetch_array($result)))
    {
      $seguir = false;
      mostrarTextoError ("Error",
            "No existe ninguna incidencia con el código: " . $codigoincidencia
            . "        <A href=\"javascript:history.back();\">Volver atrás</A>");

    }
    if ($seguir == true)
    {
      //actualizar como resuelta con la fecha dada y el comentario (si lo hay)
      $sql = "UPDATE incidencias SET " .
             "resuelta=1" . "," .
             "fecharesolucion='" . $fecharesolucion . "'," .
             "comentarioresolucion='" . $comentarioresolucion . "'," .
             "estado='Resuelta' " .
             "WHERE codigo = " . $codigoincidencia;
      $result = mysql_query($sql);
      if (!($result))
      {
        mostrarTextoError ("Error",
            "No se ha podido actualizar como resuelta la incidencia,
            inténtelo en otro momento.");
      }
      else
      {
        mostrarTexto ("Proceso realizado",
            "La incidencia " . $codigoincidencia .
            " ha sido actualizada como resuelta correctamente.");
      }
    }
    else
    {
      mostrarTextoError ("Error",
          "No existe ninguna incidencia con el código: " . $codigoincidencia);
    }
  }
  else //enviar
  {

?>

<form method="post" action="incidenciaresolver.php">

<p><font color="#008080"><span style="font-family: Arial"><font size=2><b>Marcar incidencia como resuelta</b></span></font>
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
    <input type="Text" name="codigoincidencia" size="15" maxlength="15"></td>
  </tr>
  <tr>
    <td width="19%" height="86"><font style="font-size: 10pt" face="verdana">Comentario:</td>
    <td width="84%" height="86">
  <font face="verdana" style="font-size: 10pt">
      <textarea rows="5" name="comentarioresolucion" cols="62"></textarea></td>
  </tr>
  <tr>
    <td width="19%" height="25">
    <font size="2" face="verdana" style="font-size: 10pt">Fecha resol.:</font></td>
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
    <td width="103%" colspan="2" align="center" height="34">
  <font face="verdana" style="font-size: 10pt">
      <input type="submit" name="enviar" value="Resolver incidencia"></td>
  </tr>
</table>
</div>

</form>
<?

} //end if

?>

</body>

</html>
