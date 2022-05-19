<?php

session_start();

// si todas las variables del formulario existen
if (isset($_POST["producto"]) && isset($_POST["cantidad"])) {

    agregar_elemento_carrito();
}

// mostramos el carrito si existe
$carrito_HTML = mostrar_tabla_carrito();

// si el carrito está vacio,
$carrito_vacio = !isset($_SESSION["carrito"]);

/* FIN */










function agregar_elemento_carrito()
{
    // guardará si hay repetición, y si es así, ¿dónde?
    $indice_elemento_repetido = detectar_elemento_repetido();

    // si no -1, está repetido
    if ($indice_elemento_repetido != -1) {

        // si existe, simplemente le sumamos la cantidad al producto
        $_SESSION["carrito"][$indice_elemento_repetido]["cantidad"] += $_POST["cantidad"];
        
    } else {

        // sacamos el precio y nombre del VALUE del <select>
        $nombre = explode("€", $_POST["producto"])[1];
        $precio = floatval(explode("€", $_POST["producto"])[0]);

        // construimos el PACK
        $pack_elemento_carrito = [
            "producto" => $nombre,
            "cantidad" => $_POST["cantidad"],
            "precio" => $precio
        ];

        // añadimos al final de la SESSION que es un array
        $_SESSION["carrito"][] =  $pack_elemento_carrito;
    }
}
// funcion que enseña cada lista del carrito en elementos HTML 
function mostrar_tabla_carrito()
{
    $carrito_HTML = "";
    $precio_total = 0;

    if (isset($_SESSION["carrito"])) {

        $indice = 0;
        foreach ($_SESSION["carrito"] as $key => $pack) {

            $suma_precio_actual = $pack["precio"] * $pack["cantidad"];
            $precio_total += $suma_precio_actual;

            $carrito_HTML .= '<tr>';
            $carrito_HTML .= '  <th>' . ++$indice . '</th>';
            $carrito_HTML .= '  <td>' . $pack["producto"] . '</td>';
            $carrito_HTML .= '  <td>' . $pack["precio"] . '€</td>';
            $carrito_HTML .= '  <td>' . $pack["cantidad"] . '</td>';
            $carrito_HTML .= '  <th>' . $suma_precio_actual . '€</th>';
            $carrito_HTML .= '</tr>';
        }

        // precio total
        $carrito_HTML .= '<tr>';
        $carrito_HTML .= '  <th colspan="5" class="fs-5 text-end">' . $precio_total . '€</th>';
        $carrito_HTML .= '</tr>';
    } else {
        $carrito_HTML = "<p class='my-5 text-end'> Carrito de la compra vacío. Le recomendamos ir al <a href='./index.php'>inicio</a>. </p>";
    }

    return $carrito_HTML;
}

function detectar_elemento_repetido()
{

    $i = -1;

    // recorremos el carrito para averiguar si ya existe en el carrito
    // el producto que hemos vuelto a añadir al carrito.
    if (isset($_SESSION["carrito"])) {
        foreach ($_SESSION["carrito"] as $indice => $value) {

            // reconstruimos el nombre del VALUE
            $producto = $value["precio"] . "€" . $value["producto"];

            // si coinciden nombres, se guarda el indice
            if ($producto == $_POST["producto"]) {
                $i = $indice;
                break;
            }
        }
    }

    return $i;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./src/img/Logo_1.png">
    <title>Carrito NutriShop</title>

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
                <a class="btn btn-secondary" href="./pedidos.php" role="button">Pedidos</a>
            </div>
        </div>
    </nav>


    <h1 class="text-center my-5 _muscle_decoration">Carrito de la compra</h1>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">


                <table class="table container text-end <?php if ($carrito_vacio) echo "d-none" ?>">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo $carrito_HTML;
                        ?>
                    </tbody>
                </table>


                <div class="my-3" dir="rtl">


                    <form action="./pedidos.php" method="post" class="<?php if ($carrito_vacio) echo "d-none"; else echo "d-inline" ?>">
                        <input type="text" name="procesar_pedido" class="d-none" value="1">
                        <button class="btn btn-success">Procesar pedido</button>
                    </form>



                    <a href="./index.php">
                        <button class="btn btn-primary">Seguir comprando</button>
                    </a>
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