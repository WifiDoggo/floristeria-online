<!--Conexión con la BD-->
<?php
  require 'config/config.php';
  require 'config/BD.php';
  $db = new dataBase();
  $con = $db->conectar();

  $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE disponible=1");
  $sql->execute();
  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!--Inicio de la página-->
<!DOCTYPE html>
<html lang="es">
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
        <title>Floristería Petalia</title>
    </head>

    <body>
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
                    <a class="nav-link" href="cuenta.php">Mi Cuenta</a>
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
                  <li class="nav-item"><a class="nav-link" href="cuenta.php"><?php echo $_SESSION['nombre'];?></a></li>
                  <li class="nav-item"><a class="nav-link" href="registro/logout.php">Cerrar Sesión</a></li>
                </ul>

                <?php } ?>

                <?php
                  if(isset($_SESSION['id_rol']) && $_SESSION['id_rol']==1){ ?>

                <ul class="navbar-nav me-2 mb-2 mb-lg-0">
                  <li class="nav-item"><a class="nav-link text-primary" href="admin.php">Administrar</a></li>
                </ul>

                <?php } ?>
              </div>
            </div>
          </nav>

          <!--Imagen Principal-->

          <div class="imagenFija">
            <h1>Floristería Petalia</h1>
            <p>Petalia es la más amplia Floristería a Domicilio en Venezuela. 
              Te ofrecemos Arreglos Florales para cualquier ocasión con servicio a domicilio y 
              entregas el mismo día a nivel nacional. Todo lo que necesitas en arreglos florales para 
              cumpleaños amor, nacimientos ¡y más!</p>
          </div>

          <!--Texto-->

          <!--Flores en venta-->
          <h2 class="text-success" id="subtitulo">Regala Flores</h2>

          <div class="row row-cols-1 row-cols-md-4 g-4" id="objetos">

          <?php foreach($resultado as $row) { ?> <!--inicio del foreach. imprime los productos almacenados en la BD-->
            <div class="col" id="tarjeta">
              <div class="card w-85">
                <?php 
                
                $id = $row['id'];
                $imagen = "images/productos/".$id."/img.jpg";

                if(!file_exists($imagen)){
                  $imagen = "images/null.png";
                }
                
                ?> <!--ruta de acceso de la imagen del producto-->
                <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>" class="">
                <img src="<?php echo $imagen ?>" class="card-img-top"></a>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row['nombre']?></h5>
                  <p class="card-text">$ <?php echo number_format($row['precio'], 2, '.', ',')?></p>
                  <button class="btn btn-success" type="button" onclick="addProducto(<?php echo $row['id'];?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>')">Agregar</button>
                  <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN);?>" class="btn btn-outline-primary">Ver más</a>
                </div>
              </div>
            </div>
            <?php } ?> <!--fin del foreach-->
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


          <!--Bootstrap 5-->
          <script src="bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
          <script>
            function addProducto(id, token){
              let url = 'classes/carrito.php'
              let formData = new FormData()
              formData.append('id', id)
              formData.append('token', token)

              fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
              }).then(response => response.json())
              .then(data => {
                if(data.ok){
                  let elemento = document.getElementById("num_cart")
                  elemento.innerHTML = data.numero
                }
              })
            }
          </script>
    </body>
</html>