<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./src/img/Logo_1.png">
    <title>Inicio NutriShop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" href="./src/css/styles.css">

</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./src/img/Logo_1.png" alt="" width="50" height="50" class="d-inline-block mx-2">
                NutriShop
            </a>
            <div>
                <a class="btn btn-secondary mx-2" href="./carrito.php" role="button">Carrito</a>
                <a class="btn btn-secondary" href="./pedidos.php" role="button">Pedidos</a>
            </div>
        </div>
    </nav>

    <h1 class="text-center my-5 _muscle_decoration">Selecciona tu producto protéico</h1>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">

                <form action="./carrito.php" class="my-5" method="post">
                    <div class="mb-3">
                        <label for="cart-item">Elige un producto:</label>
                        <select id="cart-item" class="form-select" name="producto">
                            <option value="2.3€ Litro de claras de huevo pasteurizadas"> Litros de claras de huevo pasteurizadas 2.3€ </option>
                            <option value="0.6€ Platano"> Platano 0.6€ </option>
                            <option value="3€ Bote de cacao puro"> Bote de cacao puro 3€ </option>
                            <option value="25€ Bote de creatina"> Bote de creatina 25€ </option>
                            <option value="0.8€ Bolsa de Cacahuate"> Bolsa de Cacahuate 0.8€ </option>
                            <option value="1.4€ Bolsa de Avellanas"> Bolsa de Avellanas 1.4€ </option>
                            <option value="1€ Bolsa de sal marina"> Bolsa de sal marina 1€ </option>
                            <option value="3.35€ Bolsa de semillas de Chia"> Bolsa de semillas de Chia 3.35€ </option>
                            <option value="5.5€ Bolsa de remolacha en polvo"> Bolsa de remolacha en polvo 5.5€ </option>
                            <option value="1.2€ Pack x4 Yogurt blanco"> Pack x4 Yogurt blanco 1.2€ </option>
                            <option value="0.2€ Tallo de apio"> Tallo de apio 0.2€ </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cart-item">Cantidad:</label>
                        <input type="number" value="1" min="1" class="w-100" name="cantidad">
                    </div>
                    <div class="mb-3 button" dir="rtl">
                        <button class="btn btn-primary">Añadir al carrito</button>
                    </div>

                </form>

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
    </footer>


</body>

</html>