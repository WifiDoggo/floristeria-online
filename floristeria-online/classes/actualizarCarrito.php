<?php

require '../config/config.php';
require '../config/BD.php';

if(isset($_POST['action'])){ //recibimos indicación de acción
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0; //recibimos la id

    if($action == 'agregar'){ //opción agregar
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);

        if($respuesta>0){ //validamos los datos del javascript
            $datos['ok'] = true;
        } else{
            $datos['ok'] = false; 
        }
        $datos['sub'] = number_format($respuesta, 2, '.', ',');
    } else if($action == 'eliminar'){ //opción eliminar
        $datos['ok'] = eliminar($id);
    } 
    else{
        $datos['ok'] = false; 
    }
} else{
    $datos['ok'] = false; 
}

echo json_encode($datos); //retornamos los datos al javascript

function agregar($id, $cantidad){

    $res = 0;
    if($id > 0 && $cantidad > 0){
        if(isset($_SESSION['carrito']['productos'][$id])){ //se consultan estas variables de sesión
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            $db = new dataBase();
            $con = $db->conectar();
            $sql = $con->prepare("SELECT precio FROM productos WHERE id=? AND disponible=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];

            $res = $cantidad * $precio;
            return $res;
        }
    } else{
        return $res;
    }

}

function eliminar($id){
    if($id > 0){
        if(isset($_SESSION['carrito']['productos'][$id])){
            unset($_SESSION['carrito']['productos'][$id]); //eliminamos este indice de $carrito
            return true;
        }
    } else{
        return false;
    }
}

?>