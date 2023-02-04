<!--Conexión con la BD-->
<?php
  require 'config/config.php';
  require 'config/BD.php';
  $db = new dataBase();
  $con = $db->conectar();

  $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null; //Valida la variable de sesión

  $listaCarrito = array();

  if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id, nombre, precio, $cantidad AS cantidad FROM productos WHERE id=? AND disponible=1");
        $sql->execute([$clave]);
        $listaCarrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
  }

  if(isset($_POST['generar_factura'])){
    $id_user = $_SESSION['id_user'];
  
    $total = 0;
    foreach($listaCarrito as $productos){
      $_id = $productos['id'];
      $nombre = $productos['nombre'];
      $precio = $productos['precio'];
      $cantidad = $productos['cantidad'];
      $subtotal = $cantidad * $precio;
      $total += $subtotal;
  
      // Agregar factura a la base de datos
      $servidor="localhost";
      $usuario="root";
      $password="";
      $db= "registro";
  
      $conn=mysqli_connect($servidor,$usuario,$password,$db);
  
      $sql = "INSERT INTO facturas (id_user, id_productos, precio, cantidad, total)
              VALUES ('$id_user', '$_id', '$precio', '$cantidad', '$subtotal')";
  
      mysqli_query($conn, $sql);

      // Transferir nombres de los productos al historial de facturas
      $query = "UPDATE facturas f
                JOIN registro.productos p ON f.id_productos = p.id
                SET f.nombre_productos = p.nombre;";

// Ejecución de la consulta
$result = mysqli_query($conn, $query);
    }
    unset($_SESSION['carrito']);// Limpiamos el carrito
  
    // Redirigir al usuario a la página de factura
    header('Location: historial.php');
    exit;
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
        <title>Carrito | Floristería Petalia</title>
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

          <!--Contenido-->

         <div class="container">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($listaCarrito==null){
                                echo '<tr><td colspan="5" class="text-center"><b>Vacío</b></td></tr>';
                            } else{
                                $total = 0;
                                foreach($listaCarrito as $producto){
                                    $_id = $producto['id'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $cantidad = $producto['cantidad'];
                                    $subtotal = $cantidad * $precio;
                                    $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $nombre; ?></td>
                            <td>$ <?php echo number_format($precio, 2, '.', ','); ?></td>
                            <td><input type="number" min="1" max="10" step="1" value="<?php echo $cantidad; ?>" size ="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)"></td>
                            <td><div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo number_format($subtotal, 2, '.', ','); ?></div></td>
                            <td><a href="#" id="eliminar" class="" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fa-regular fa-trash-can"></i></a></td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2"><p class="h3" id="total">$ <?php echo number_format($total, 2, '.', ','); ?></p></td>
                        </tr>

                    </tbody>
                    <?php } ?>
                </table>
            </div>

            <div class="col-md-5 offset-md-8" id="pago">
            <form action="checkout.php" method="post">
                <input type="submit" name="generar_factura" class="btn btn-primary" value="Generar Factura">
            </form>
            </div>

         </div>

         <!--Modal para confirmar eliminar-->
         
          <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="eliminaModalLabel">Eliminar producto</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ¿Desea eliminar el producto del carrito?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" id="btn-elimina" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
              </div>
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


          <!--Bootstrap 5-->
          <script src="bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
          <script>
            let eliminaModal = document.getElementById('eliminaModal')
            eliminaModal.addEventListener('show.bs.modal', function(event){
              let button = event.relatedTarget //llama los datos en el <a>
              let id = button.getAttribute('data-bs-id')
              let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina') //pasamos la id del botón de eliminar al del modal
              buttonElimina.value = id
            })

            function actualizaCantidad(cantidad, id){
              let url = 'classes/actualizarCarrito.php'
              let formData = new FormData()
              formData.append('id', id)
              formData.append('action', 'agregar')
              formData.append('cantidad', cantidad)

              fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
              }).then(response => response.json())
              .then(data => {
                if(data.ok){

                  let divsubtotal = document.getElementById('subtotal_' + id)
                  divsubtotal.innerHTML = data.sub //lo recibe de la condición if 'agregar'

                  let total = 0.00
                  let list = document.getElementsByName('subtotal[]')

                  for(let i = 0; i < list.length; i++){
                    total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                  }

                  total = new Intl.NumberFormat('en-US', {minimumFractionDigits: 2}).format(total)
                  document.getElementById('total').innerHTML = '<?php echo "$ "?>' + total
                }
              })
            }

            function eliminar(){

              let botonElimina = document.getElementById('btn-elimina')
              let id = botonElimina.value

              let url = 'classes/actualizarCarrito.php'
              let formData = new FormData()
              formData.append('id', id)
              formData.append('action', 'eliminar')

              fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
              }).then(response => response.json())
              .then(data => {
                if(data.ok){

                  location.reload()
                }
              })
            }
          </script>
    </body>
</html>