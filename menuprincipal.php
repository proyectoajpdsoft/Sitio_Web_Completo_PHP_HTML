<?
  include ("funciones.php");
  iniciarSesionUsuario();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  //seg�n el usuario mostrar p�gina personal
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo "<A target=\"principal\" href=\"programaalta.php\"
        title=\"A�adir un nuevo programa\">A�adir programa</A><br><br>";
    echo "<A target=\"principal\" href=\"programaver.php\"
        title=\"Muestra un listado de los programas dados de alta\">Lista programas</A><br><br>";
    echo "<A target=\"principal\" href=\"usuariover.php\"
        title=\"Muestra un listado de los usuarios registrados\">Lista usuarios</A><br><br>";
    echo "<A target=\"principal\" href=\"usuariogestionar.php\"
        title=\"Eliminar, cambiar tipo, asignar programa\">Gestionar usuarios</A><br><br>";
    echo "<A target=\"principal\" href=\"emailmasivo.php\"
        title=\"Env�a un E-Mail a los usuarios seleccionados con el texto introducido\">Env�o E-Mail masivo</A><br><br>";
  }
  //Gestionar incidencias
  echo "<A target=\"principal\" href=\"incidenciagestionar.php\"
      title=\"Crear nueva, mostrar listado, cancelar, enviar, imprimir, ... incidencias de programas\">Gestionar incidencias</A><br><br>";

  //modificar datos del usuario
  echo "<A target=\"principal\" href=\"usuariodatos.php\"
      title=\"Modificar los datos de registro (E-Mail, contrase�a, nombre, ...)\">Cambiar datos</A><br><br>";
  //subir ficheros
  echo "<A target=\"principal\" href=\"ficherosubir.php\"
      title=\"Desde aqu� podr� enviarnos un fichero (base de datos, imagen, fichero log de errores, ...) v�a FTP a nuestro servidor\">Subir un fichero</A><br><br>";

  //hiperv�nculo para adquirir programa
  echo "<A target=\"principal\" href=\"programacomprar.php\"
      title=\"Realizar petici�n de compra de programa (sin compromiso alguno por su parte)\">Comprar programa</A><br><br>";

  //actualizar programas
  echo "<A target=\"principal\" href=\"actualizarprogramas.php\"
      title=\"Desde aqu� podr� descargar las utilidades para la actualizaci�n autom�tica de los programas\">Actualizar programas</A><br><br>";

  //seg�n el usuario
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    //a�adir trucos
    echo "<A target=\"principal\" href=\"trucoalta.php\"
        title=\"A�adir un nuevo truco\">A�adir truco</A><br><br>";
  }

  //mostrar hiperv�nculo para mostrar/modificar trucos
  echo "<A target=\"principal\" href=\"trucover.php\"
      title=\"Mostrar trucos para Windows\">Trucos Windows</A><br><br>";

  //mostrar hiperv�nculo para mostrar calendario
  echo "<A target=\"principal\" href=\"/calendario/index.php\"
      title=\"Calendario (agenda personalizada)\">Calendario (en fase de pruebas)</A><br><br>";

  //mostrar hiperv�nculo para lista de CD's datos
  if ($tipousuario == "Lista" | $tipousuario == "Pago-Lista"
      | $tipousuario == "Usuario-Lista" | $tipousuario == "Administrador")
  {
    echo "<A target=\"principal\" href=\"cstitulosver.php\"
        title=\"Muestra una lista de los CD's de datos\">CD's de datos</A><br><br>";
    echo "<A target=\"principal\" href=\"csmusicaver.php\"
        title=\"Muestra una lista de los CD's de m�sica\">CD's de m�sica</A><br><br>";
  }

  echo "<A target=\"principal\" href=\"usuarioeliminar.php\"
      title=\"Utilice esta opci�n para darse de baja definitivamente de este Sitio Web\">Eliminar usuario</A><br><br>";

  echo "<A target=\"principal\" href=\"inicio.php\"
      title=\"Muestra la ventana de inicio\">Inicio</A><br><br>";

  //mostrar hiperv�nculo cerrar sesi�n
  echo "<br><br><br><A target=\"_blank\" href=\"cerrarsesion.php\"
      title=\"Cierra esta sesi�n\">Cerrar sesi�n</A><br>";
  
?>
