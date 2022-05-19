<?php

session_start();

const DAY = 60 * 60 * 24;

/* ========== INSTANCIAR VARIABLES Y DARLES VALOR ========== */
$accion_realizada = ""; // Producto realizado, historial borrado correctamente, pedido deshecho...
$fecha_pedido = "";
$cantidad_pedidos = 0;

if (isset($_COOKIE["fecha_pedido"])) {
    $fecha_pedido = $_COOKIE["fecha_pedido"];
}
if (isset($_COOKIE["cantidad_pedidos"])) {
    $cantidad_pedidos = $_COOKIE["cantidad_pedidos"];
}



/* ========== COMPROBACIÓN DE QUE HACER ========== */
// si existe el POST significa que no venimos por URL, sino de haber presionado algún botón
$botonProcesarPedido = isset($_POST["procesar_pedido"]);
$botonBorrarHistorial = isset($_POST["borrar_historial"]);
$botonDeshacer = isset($_POST["undo_historial"]);

if ($botonDeshacer) { // si se pulsa el botón de "Deshacer pedido"

    deshacerPedido();

} else if ($botonBorrarHistorial) { // si se pulsa el botón de "Borrar historial"

    borrarHistorial();

} else if ($botonProcesarPedido) { // click en el botón "Procesar pedido"

    procesarPedido();

}


/* ========== MOSTRAR DATOS ========== */
$datos_HTML = mostrar_informacion();

/* FIN */


/* ========== FUNCIONES ========== */
function mostrar_informacion()
{
    global $accion_realizada, $cantidad_pedidos, $fecha_pedido;

    $html = "";

    // si hemos hecho alguna acción
    if ($accion_realizada) {
        $html .= "<h2 class='mb-5 fs-4 text-center'> $accion_realizada </h2>";
    }
    // si hay pedidos
    if ($cantidad_pedidos != 0) {
        if ($cantidad_pedidos == 1) {
            $html .= "<p class='my-1'> Ha realizado 1 compra. </p>";
        } else {
            $html .= "<p class='my-1'> Ha realizado  $cantidad_pedidos compras. </p>";
        }
        $html .= "<p class='my-1'> Su última compra fue el  $fecha_pedido . </p>";
    } else {
        $html .= "<p class='my-2 text-center'> Usted no ha realizado ningún pedido. Le recomendamos ir al <a href='./carrito.php'>carrito</a>. </p>";
    }

    return $html;
}

function procesarPedido(){

    global $accion_realizada, $fecha_pedido, $cantidad_pedidos;

    $accion_realizada = "¡PEDIDO REALIZADO CORRECTAMENTE!";
    $fecha_pedido = date("d/m/Y H:i:s");
    $cantidad_pedidos = 1;

    // si no es el primer pedido, se suma 1 a la cantidad de pedidos
    if (isset($_COOKIE["cantidad_pedidos"])) {
        $cantidad_pedidos = $_COOKIE["cantidad_pedidos"] + 1;
    }

    // le sumamos 1 porque las COOKIES no se actualizan
    setcookie("cantidad_pedidos", $cantidad_pedidos, time() + (DAY * 365), "/");
    setcookie("fecha_pedido", $fecha_pedido, time() + (DAY * 365), "/");

    // borramos el carrito
    unset($_SESSION["carrito"]);

}

function deshacerPedido()
{
    global $accion_realizada, $fecha_pedido, $cantidad_pedidos;

    if (isset($_COOKIE["cantidad_pedidos"])) {
        if ($_COOKIE["cantidad_pedidos"] != 0) {


            $accion_realizada = "Pedido deshecho correctamente.";
            $cantidad_pedidos = $_COOKIE["cantidad_pedidos"] - 1; // restamos 1 pedido
            $fecha_pedido = $_COOKIE["fecha_pedido"];

            if ($_COOKIE["cantidad_pedidos"] == 1) { // osea que hay 0 pedidos restando este

                borrarHistorial();
                
            } else {
                setcookie("cantidad_pedidos", $cantidad_pedidos, time() + (DAY * 365), "/");
                setcookie("fecha_pedido", $fecha_pedido, time() + (DAY * 365), "/");
            }


        } else {
            $accion_realizada = "No puedes deshacer un pedido porque no tienes.";
        }
    } else {
        $accion_realizada = "No puedes deshacer un pedido porque no tienes.";
    }
}

function borrarHistorial()
{
    global $accion_realizada, $cantidad_pedidos;

    // borramos las cookies
    setcookie("cantidad_pedidos", "", time() - 3600, "/");
    setcookie("fecha_pedido", "", time() - 3600, "/");

    $accion_realizada = "Historial borrado correctamente.";
    $cantidad_pedidos = 0;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./src/img/Logo_1.png">
    <title>Pedidos NutriShop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" href="./src/css/styles.css">

</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img src="./src/img/Logo_1.png" alt="" width="50" height="50" class="d-inline-block mx-2">
                NutriShop
            </a>
            <div>
                <a class="btn btn-secondary mx-2" href="./index.php" role="button">Inicio</a>
                <a class="btn btn-secondary" href="./carrito.php" role="button">Carrito</a>
            </div>
        </div>
    </nav>

    <h1 class="text-center my-5 _muscle_decoration">Pedidos realizados</h1>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto bg-light p-3 shadow rounded">

                <?php

                echo $datos_HTML;

                ?>

                <div class="mt-5" dir="rtl">
                    <form action="./pedidos.php" method="post" class="d-inline">
                        <input type="text" name="borrar_historial" class="d-none" value="1">
                        <button class="btn btn-danger">Borrar historial</button>
                    </form>
                    <form action="./pedidos.php" method="post" class="d-inline">
                        <input type="text" name="undo_historial" class="d-none" value="1">
                        <button class="btn btn-danger">Deshacer pedido</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <footer class="bg-dark text-light p-3 fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <label>Alejandro Colmenero Moreno</label>
                </div>
                <div class="col-12 col-lg-3">
                    <label>pycolmenero@gmail.com</label>
                </div>
                <div class="col-12 col-lg-3 text-end">
                    <pre class="m-0">2º DAW GRUPO STUDIUM</pre>
                </div>
                <div class="col-12 col-lg-3 text-end">
                    <pre class="m-0">Entorno Servidor
                        Práctica Tema 1</pre>
                </div>
            </div>
        </div>
        <h2 class="float-start fs-4"></h2>
        <div class="text-end">

        </div>
    </footer>

    <script>
        // ESTO ES PARA QUE AL RECARGAR LA PÁGINA NO ME SALGA UN PROMPT DE "Resubmit the form?"
        window.history.replaceState(null, null, window.location.href);
    </script>

</body>

</html>