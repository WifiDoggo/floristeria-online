<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión | Floristería Petalia</title>
  <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="estilo.css">
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <!--Icono-->
  <link rel="shortcut icon" href="../icon.png">

</head>

<body>
<!--Barra de Navegación-->
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">
      <img src="../logo.png" alt="" width="" height="75px" class="d-inline-block align-text-center">
  </a>

    <!--Botón para celular-->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="../cuenta.php">Mi Cuenta</a>
        </li>
        
        <li class="nav-item dropdown">
          <a href="#" class="nav-link">Contáctanos</a>
        </li>

      </ul>

    </div>
  </div>
</nav>

<!--Iniciar sesión-->
  <div align="center" class="container my-5">
    <form action="acceso.php" method="post">
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <div class="card" style="width: 18rem;">
         
          <div class="card-body">
            <h5 class="card-title text-success">Iniciar Sesion</h5>

            Ingrese Correo
            <input type="text" name="correoLogin">
            <br>

            Ingrese Contraseña
            <input type="password" name="contrasenaLogin">
            <br>
            <br>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-success" name="ingresar" value="ingresar">Ingresar</button>

            </div>
          </div>
        </div>
      </div>

      <!--Registrarse-->
      <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div align="left" class="card">
        <div class="card-body">
              <h5 align="left" class="card-title text-success">Registrarse</h5> </br>
              <img align="right" width="450" height="450" src="../images/marca.png" class="rounded mx-auto d-block-end" alt="">
              <h5 class="card-title">Ingrese Sus Datos</h5>

              <p align="left" class="card-text">Ingrese Nombre <br><input type="text" name="nombre" value=""></p>
              <p align="left" class="card-text">Ingrese Apellido <br><input type="text" name="apellido" value=""></p>
              <p align="left" class="card-text">Ingrese Cédula <br><input type="text" name="cedula" value=""></p>
              <p align="left" class="card-text">Ingrese Correo Electronico <br><input type="text" name="correo" value=""></p>
              <p align="left" class="card-text">Ingrese Contraseña <br><input type="password" name="contrasena" value=""></p>
              <p align="left" class="card-text">Ingrese ID <br><input type="password" name="id_rol" placeholder="1-Administrador 2-Cliente" value=""></p><br>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success" name="enviar" value="Registrar">Registrar</button>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>


</body>

</html>

<?php 
$servidor="localhost";
$usuario="root";
$password="";
$db= "registro";

$conexion = new mysqli($servidor,$usuario,$password,$db);

if ($conexion-> connect_error) {

	die("Conexion fallida: " . $conexion-> connect_error);
}

//Registrarse
if (isset($_POST['enviar'])) {

	$correo=$_POST['correo'];
	$Nom=$_POST['nombre'];
	$Ape=$_POST['apellido'];
	$Cont=$_POST['contrasena'];
	$Ced=$_POST['cedula'];
	$ID=$_POST['id_rol'];

	$sql = "INSERT INTO usuarios(nombre , apellido , contrasena , cedula , correo , id_rol) 
  VALUES ('$Nom','$Ape','$Cont','$Ced','$correo','$ID')";

	if ($conexion->query($sql)=== true) {

							echo "<div align='center'>

							Registrado!
								
							</div>";
						}	else {

							die("Error al registrar!: " . $conexion->error);
						}
					}
$conexion->close();
session_start();

//Iniciar sesión
if(isset($_POST['ingresar'])){
  $servidor="localhost";
  $usuario="root";
  $password="";
  $db= "registro";

  $conn=mysqli_connect($servidor,$usuario,$password,$db);
  
  $cor=$_POST['correoLogin'];
  $cont=$_POST['contrasenaLogin'];

  $sql = "SELECT nombre, contrasena, id_rol, id_user FROM usuarios WHERE correo = '$cor'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $hash = $row['contrasena'];
  $nombre = $row['nombre'];
  $id_rol = $row['id_rol'];
  $id_user = $row['id_user'];

  if ($cont == $hash) {
    // Iniciar sesión y almacenar información del usuario
    $_SESSION['logged_in'] = true;
    $_SESSION['correo'] = $cor;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['id_rol'] = $id_rol;
    $_SESSION['id_user'] = $id_user;

    // Redirige al usuario al panel de control
    header('Location: ../index.php');
    exit;
  } else {
    echo "<script>alert('Datos incorrectos');</script>";
  }
}
?>