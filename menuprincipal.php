<?
  include ("funciones.php");
  iniciarSesionUsuario();
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"/estilos/estilo.css\">";
  //según el usuario mostrar página personal
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    echo "<A target=\"principal\" href=\"programaalta.php\"
        title=\"Añadir un nuevo programa\">Añadir programa</A><br><br>";
    echo "<A target=\"principal\" href=\"programaver.php\"
        title=\"Muestra un listado de los programas dados de alta\">Lista programas</A><br><br>";
    echo "<A target=\"principal\" href=\"usuariover.php\"
        title=\"Muestra un listado de los usuarios registrados\">Lista usuarios</A><br><br>";
    echo "<A target=\"principal\" href=\"usuariogestionar.php\"
        title=\"Eliminar, cambiar tipo, asignar programa\">Gestionar usuarios</A><br><br>";
    echo "<A target=\"principal\" href=\"emailmasivo.php\"
        title=\"Envía un E-Mail a los usuarios seleccionados con el texto introducido\">Envío E-Mail masivo</A><br><br>";
  }
  //Gestionar incidencias
  echo "<A target=\"principal\" href=\"incidenciagestionar.php\"
      title=\"Crear nueva, mostrar listado, cancelar, enviar, imprimir, ... incidencias de programas\">Gestionar incidencias</A><br><br>";

  //modificar datos del usuario
  echo "<A target=\"principal\" href=\"usuariodatos.php\"
      title=\"Modificar los datos de registro (E-Mail, contraseña, nombre, ...)\">Cambiar datos</A><br><br>";
  //subir ficheros
  echo "<A target=\"principal\" href=\"ficherosubir.php\"
      title=\"Desde aquí podrá enviarnos un fichero (base de datos, imagen, fichero log de errores, ...) vía FTP a nuestro servidor\">Subir un fichero</A><br><br>";

  //hipervínculo para adquirir programa
  echo "<A target=\"principal\" href=\"programacomprar.php\"
      title=\"Realizar petición de compra de programa (sin compromiso alguno por su parte)\">Comprar programa</A><br><br>";

  //actualizar programas
  echo "<A target=\"principal\" href=\"actualizarprogramas.php\"
      title=\"Desde aquí podrá descargar las utilidades para la actualización automática de los programas\">Actualizar programas</A><br><br>";

  //según el usuario
  if ($tipousuario == "Administrador")  //si es el administrador
  {
    //añadir trucos
    echo "<A target=\"principal\" href=\"trucoalta.php\"
        title=\"Añadir un nuevo truco\">Añadir truco</A><br><br>";
  }

  //mostrar hipervínculo para mostrar/modificar trucos
  echo "<A target=\"principal\" href=\"trucover.php\"
      title=\"Mostrar trucos para Windows\">Trucos Windows</A><br><br>";

  //mostrar hipervínculo para mostrar calendario
  echo "<A target=\"principal\" href=\"/calendario/index.php\"
      title=\"Calendario (agenda personalizada)\">Calendario (en fase de pruebas)</A><br><br>";

  //mostrar hipervínculo para lista de CD's datos
  if ($tipousuario == "Lista" | $tipousuario == "Pago-Lista"
      | $tipousuario == "Usuario-Lista" | $tipousuario == "Administrador")
  {
    echo "<A target=\"principal\" href=\"cstitulosver.php\"
        title=\"Muestra una lista de los CD's de datos\">CD's de datos</A><br><br>";
    echo "<A target=\"principal\" href=\"csmusicaver.php\"
        title=\"Muestra una lista de los CD's de música\">CD's de música</A><br><br>";
  }

  echo "<A target=\"principal\" href=\"usuarioeliminar.php\"
      title=\"Utilice esta opción para darse de baja definitivamente de este Sitio Web\">Eliminar usuario</A><br><br>";

  echo "<A target=\"principal\" href=\"inicio.php\"
      title=\"Muestra la ventana de inicio\">Inicio</A><br><br>";

  //mostrar hipervínculo cerrar sesión
  echo "<br><br><br><A target=\"_blank\" href=\"cerrarsesion.php\"
      title=\"Cierra esta sesión\">Cerrar sesión</A><br>";
  
?>
