<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/5797ea773f.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .navbar {
            background-color: #000;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            height: 50px;
        }

        .navbar-brand {
            font-size: 1em;
            font-weight: bold;
        }

        .navbar-nav li a {
            color: #fff;
            padding: 5px 20px;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 30px;
        }

        .navbar-nav li a.active {
            background-color: #fff;
            color: #000;
        }

        body {
            background-color: lightblue;
        }

        .h1 {
            font-size: 3em;
            color: black;
            background-color: whitesmoke;
            padding: 10px 20px;
            border-radius: 10px;
            text-transform: uppercase;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
            margin-top: 60px;
        }

        .table {
            margin-top: 10px;
            border-color: black;
        }

        .table th {
            background-color: lightskyblue;
            color: white;
        }

        .btn-primary {
            background-color: green;
            border-color: black;
        }

        body {
            background-size: cover;
            background-image: url("img/vector-fondo-animal-ilustracion-mascotas-lindas_53876-127698.jpg.avif");
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/different-type-of-cartoon-dog-faces-vector.jpg" alt="Logo">
                Programación web
            </a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Bienvenido Admin. Alejandro Linares Guevara</a>
                </li>
            </ul>
        </div>
    </nav>

    <h1 class="h1 text-center">Clientes</h1>
    <!--  contenedor div para el formulario y establece su estilo como "display: none;" para ocultarlo inicialmente:-->
    <div id="formularioCliente" method="POST" style="display: none;">
        <!-- formulario mando datos a archivo php -->
        <form action="insertar_cliente.php" method="POST" onsubmit="return validarFormulario()">
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="clientes.php" class="btn btn-secondary">Regresar</a>
        </form>
    </div>

    <script>
        // Validaciones con jQuery
        $(document).ready(function() {
            $('#formularioCliente').submit(function(e) {
                if ($('#nombres').val() == '') {
                    alert('Debe ingresar los nombres');
                    e.preventDefault();
                    return false;
                }
                if ($('#apellidos').val() == '') {
                    alert('Debe ingresar los apellidos');
                    e.preventDefault();
                    return false;
                }
                if ($('#telefono').val() == '') {
                    alert('Debe ingresar el teléfono');
                    e.preventDefault();
                    return false;
                }
                // Otras validaciones aquí si es necesario
                return true;
            });
        });
    </script>

    <!-- modifica  botón "Agregar cliente" para que al hacer clic se muestre el formulario-->
    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="mostrarFormulario()">+ Agregar
        cliente
    </button>

    <!-- script JavaScript para controlar la visibilidad del formulario:-->
    <script>
        function mostrarFormulario() {
            var formulario = document.getElementById("formularioCliente");
            formulario.style.display = "block";

            var botonAgregarCliente = document.querySelector('.btn.btn-primary.btn-lg.btn-block');
            botonAgregarCliente.style.display = "none";
        }

        function validarFormulario() {
            var nombres = document.getElementById("nombres").value;
            var apellidos = document.getElementById("apellidos").value;
            var telefono = document.getElementById("telefono").value;

            if (nombres.trim() === '' || apellidos.trim() === '' || telefono.trim() === '') {
                alert('Por favor, ingrese todos los campos obligatorios.');
                return false; // Evita que el formulario se envíe si faltan campos.
            }
            return true; // Permite que el formulario se envíe si todos los campos requeridos están completos.
        }
    </script>

    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Detalles</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dsn = 'mysql:host=localhost;dbname=veterinaria';
            $user = 'root';
            $pass = '';

            try {
                $conn = new PDO($dsn, $user, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            function generarTablaClientes($conn)
            {
                $output = "<thead>"; // Comienzo de la tabla

                $sql = "SELECT ID, Nombres, Apellidos, Telefono FROM clientes";
                $resultado = $conn->query($sql);

                // Iterar resultados y construir la tabla

                while ($row = $resultado->fetch()) {
                    $output .= "<tr>";
                    $output .= "<th>" . $row['ID'] . "</th>";
                    $output .= "<td>"  . $row['Nombres'] . "</td>";
                    $output .= "<td>" . $row['Apellidos'] . "</td>";
                    $output .= "<td>" . $row['Telefono'] . "</td>";
                    $output .= "<td>" . " <a href='mascotas.php?id=". $row['ID']. "' class='btn btn-outline-info'><i class='fas fa-eye'></i><b>INFO</b> ℹ️</a></td>";
                    $output .= "<td>" . "<a href='update_cliente.php?id=". $row['ID']. "' class='btn btn-outline-warning'><i class='fas fa-edit'></i><b>Editar</b> ✏️</a></td>";
                    $output .= "<td>" . "<a href='delete_cliente.php?id=". $row['ID']. "' class='btn btn-outline-danger' id='eliminarBtn'><i class='fas fa-trash-alt'></i><b>Eliminar</b> 🗑️</a></td>";
                    $output .= "</tr>";
                }
                $output .= "</thead>"; // Fin de la tabla
                return $output;
            }

            echo generarTablaClientes($conn); ?>
            
        </tbody>
    </table>



</body>

</html>