<?
  include ("funciones.php");
  session_unregister('codigousuario');
  session_unregister('codigousuariopropio');
  session_unregister('tipousuario');
  session_unregister('nombreusuario');
  session_unregister('emailusuario');
  session_unregister('fechaultimoacceso');
  @session_unset();
  @session_destroy();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  mostrarTextoError ("Sesión cerrada",
          "La sesión ha sido cerrada correctamente. Para volver a entrar
          debe inciar la sesión.<br><A target=\"_blank\" href=\"login.html\">Iniciar sesión</A><br>");
?>


