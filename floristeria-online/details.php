<!--Conexión con la BD-->
<?php
  require 'config/config.php';
  require 'config/BD.php';
  $db = new dataBase();
  $con = $db->conectar();

  $id = isset($_GET['id']) ? $_GET['id'] : ""; //Verifica que haya un id, si no hay, asigna uno vacio
  $token = isset($_GET['token']) ? $_GET['token'] : "";

  if($id == ''||$token == ''){
    echo"Error: Dato inexsistente";
    exit;
  } else {

    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN); //Compara el token recibido con el token del producto

    if($token == $token_tmp){

        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND disponible=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){

            $sql = $con->prepare("SELECT nombre, descripcion, precio FROM productos WHERE id=? AND disponible=1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $imagen = "images/productos/".$id."/img.jpg";

            if(!file_exists($imagen)){
              $imagen = "images/null.png"; //placeholder de imagen perdida
            }
            
        }
    } else{
        echo"Error: Dato inexsistente";
        exit;
    }
  }


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
        <title><?php echo $nombre;?> | Floristería Petalia</title>
    </head>

    <body>
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

                <ul class="navbar-nav me-2 mb-2 mb-lg-0">
                  <li class="nav-item"><a class="nav-link" href="registro/acceso.php">Iniciar Sesión</a></li>
                  <li class="nav-item"><a class="nav-link" href="registro/acceso.php">Registrate</a></li>
                </ul>

              </div>
            </div>
          </nav>

          <!--Contenido Principal-->
          <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 order-md-1">
                        <img src="<?php echo $imagen ?>" alt="" height="500px">
                    </div>
                    <div class="col-md-6 order-md-2">
                        <h2><?php echo $nombre;?></h2>
                        <h2>$ <?php echo number_format($row['precio'], 2, '.', ',');?></h2>
                        <p class="lead">
                            <?php echo $descripcion;?>
                        </p>

                        <div class="d-grid gap-3 col-10 mx-auto">
                            <button class="btn btn-success" type="button">Comprar ahora</button>
                            <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $id;?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                        </div>
                    </div>
                </div>
            </div>
          </main>

          



          <!--Footer-->

	        <footer>
            <div class="container-footer-all">
              <div class="container-body">
                <div class="col1">
                  <h1>Mas información</h1>

                  <p>Floristería Petalia es la más amplia Floristería a Domicilio en Venezuela. 
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