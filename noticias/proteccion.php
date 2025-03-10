<?php
$selfSecure = 1;
$fromEmail  = $HTTP_SERVER_VARS["SERVER_ADMIN"];
$admin = "administrador";
$adminpass = "aaaa";
$email = "ajpdsoft@ajpdsoft.com";
$Version = "<a href=\"http://www.ajpdsoft.com\" target=\"_blank\">AjpdSoft</a>";
//echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilos/estilo.css\">";
if($selfSecure){
    if (($PHP_AUTH_USER!=$admin)||($PHP_AUTH_PW!=$adminpass)) {
       Header('WWW-Authenticate: Basic realm="AjpdSoft - Noticias"');
       Header('HTTP/1.0 401 Unauthorized');
       echo "<html>
         <head>
         <title>Error - Acceso denegado</title>
         </head>
         <strong>Acceso denegado<br>
         Se ha enviado un mensaje de advertencia al Administrador Web.
         Su dirección de IP también se ha enviado.
         <hr>
         <em>$Version</em>";
       if(isset($PHP_AUTH_USER)){
          $warnMsg ="
 Alguien intentó acceder de: http://".$HTTP_SERVER_VARS["HTTP_HOST"]."$PHP_SELF
usando un nombre de usuario o contraseña incorrecta:
 
 Fecha: ".date("Y-m-d H:i:s")."
 IP: ".$HTTP_SERVER_VARS["REMOTE_ADDR"]."
 Explorador: ".$HTTP_SERVER_VARS["HTTP_USER_AGENT"]."
 Nombre de usuario usado: $PHP_AUTH_USER
 Contraseña usada: $PHP_AUTH_PW
 
       ";
          mail($email,"Acceso no autorizado - AjpdSoft (Noticias)",$warnMsg,
          "From: $fromEmail\nX-Mailer:$Version AutoWarn System");
       }
       exit;
    }
}

if(!$oCols)$oCols=$termCols;
if(!$oRows)$oRows=$termRows;

?>
