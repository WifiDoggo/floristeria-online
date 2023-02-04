<?php 
  require 'config/config.php';
  require 'config/BD.php';
  $db = new dataBase();
  $con = $db->conectar();

  $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE disponible=1");
  $sql->execute();
  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  // Redirigir al usuario al formulario de inicio de sesión
  header('Location: login.php');
  exit;
}

// Conectar a la base de datos
$servidor="localhost";
$usuario="root";
$password="";
$db= "registro";

$conn=mysqli_connect($servidor,$usuario,$password,$db);


// Consultar la tabla de compras para obtener el historial del usuario
$sql = "SELECT id_factura, id_user, nombre_productos, precio, cantidad, total FROM facturas";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Bootstrap 5-->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!--Iconos de Fontawesome-->
        <link href="css/fontawesome.css" rel="stylesheet">
        <link href="css/brands.css" rel="stylesheet">
        <link href="css/solid.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <!--Icono-->
        <link rel="shortcut icon" href="icon.png">
    <title>Autoría de compras | Floristería Petalia</title>
</head>

<body>
<?php if($_SESSION['id_rol'] == 1){ ?>
<!--Header-->
<header class="container-fluid bg-success d-flex justify-content-center">
    <p class="text-light mb-0 p-2 fs-6"> <i class="fa-regular fa-phone-volume"></i> +58 (412)4825048</p>
</header>

<!--Barra de Navegación-->
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="logo.png" alt="" width="" height="75px" class="d-inline-block align-text-center">
    </a>

      <!--Botón para celular-->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="#">Mi Cuenta</a>
          </li>
          
          <li class="nav-item dropdown">
            <a href="#" class="nav-link">Contáctanos</a>
          </li>

        </ul>

          <a href="checkout.php" class="d-flex" id="carrito">
            <i class="fa-solid fa-cart-shopping" id="carrito"></i>
            <span id="num_cart" class="badge bg-danger rounded-pill"><?php echo $num_cart; ?></span>
          </a>
      
          <?php
          if(!isset($_SESSION['logged_in'])){ ?>

        <ul class="navbar-nav me-2 mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="registro/acceso.php">Iniciar Sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="registro/acceso.php">Registrate</a></li>
        </ul>

        <?php }else if($_SESSION['logged_in'] == true){ ?>

          <ul class="navbar-nav me-2 mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="registro/acceso.php"><?php echo $_SESSION['nombre'];?></a></li>
          <li class="nav-item"><a class="nav-link" href="registro/logout.php">Cerrar Sesión</a></li>
        </ul>

        <?php } ?>

        <?php
          if(isset($_SESSION['id_rol']) && $_SESSION['id_rol']==1){ ?>

        <ul class="navbar-nav me-2 mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link text-primary" href="#">Administrar</a></li>
        </ul>

        <?php } ?>
      </div>
    </div>
  </nav>

<h2 class="text-success" id="subtitulo">Autoría de Compras</h2>
    <div class="container">
        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ID USER</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>

                <!--Mostrar el historial de compras en una tabla-->
                <tbody>
                  <?php
                      while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                  <tr>
                    <th scope="row"><?php echo $row['id_factura']; ?></th>
                    <th scope="row"><?php echo $row['id_user']; ?></th>
                    <td><?php echo $row['nombre_productos']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo $row['total']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

    <!--Footer-->

    <footer>
            <div class="container-footer-all">
              <div class="container-body">
                <div class="col1">
                  <h1>Mas información</h1>

                  <p>Petalia es la más amplia Floristería a Domicilio en Venezuela. 
                  Te ofrecemos Arreglos Florales para cualquier ocasión con servicio a domicilio y 
                  entregas el mismo día a nivel nacional. Todo lo que necesitas en arreglos florales para 
                  cumpleaños amor, nacimientos ¡y más!</p>
                </div>

                <div class="col2">
                  <h1>Redes Sociales</h1>

                  <div class="row">
                    <a href="#">
                    <i class="fab fa-facebook"></i>
                    <label>Facebook</label>
                    </a>
                  </div>

                  <div class="row">
                    <a href="#">
                    <i class="fab fa-instagram"></i>
                    <label>Instagram</label>
                    </a>
                  </div>
                </div>

                <div class="col3">
                  <h1>Contacto</h1>
                  <div class="row2">
                    <i class="fas fa-home"></i>
                    <label>Las Delicias</label>
                  </div>

                  <div class="row2">
                    <i class="fas fa-phone-square-alt"></i>
                    <label>+58 (412)4825048</label>
                  </div>

                  <div class="row2">
                    <i class="fas fa-envelope"></i>
                    <label>floristeria.petalia@gmail.com</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="container-footer">
                <div class="copyright">
                  © 2023 Todos los Derechos Reservados | Floristería Petalia by <a href="#">Juan Salas</a>
                </div>

                <div class="information">
                  <a href="#">Información</a> | <a href="#">Privacidad</a> | <a href="#">Terminos y Condiciones</a>
                </div>
            </div>
          </footer>

</body>
</html>

<?php

// Cerrar la conexión a la base de datos
mysqli_close($conn);
                      }
?>