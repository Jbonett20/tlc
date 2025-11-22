<?php 
include './app/conexion.php';

// Consulta para obtener las categorías
$query = "SELECT id_categoria, nombre_categoria FROM tbl_categoria";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Error al obtener las categorías: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

.container {
    margin: 20px;
}

.categorias select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
    font-weight: bold;
}

.no-products {
    text-align: center;
    margin-top: 20px;
    font-size: 18px;
    color: #555;
}

.nav {
    background-color: #333;
    padding: 10px 0;
    margin-bottom: 20px;
}

.nav nav {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.nav a {
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 10px 15px;
    transition: background-color 0.3s, color 0.3s;
    border-radius: 5px;
}

.nav a:hover {
    background-color: #575757;
    color: white;
}

.btn-menu {
    display: inline-block;
    background: url('https://cdn.icon-icons.com/icons2/2596/PNG/512/return_icon_154912.png') no-repeat center center;
    background-color: transparent;
    color: white;
    padding: 42px 35px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    width: auto;
    height: 40px; /* Ajusta el alto según sea necesario */
    background-size: 40px 40px; /* Ajusta el tamaño de la imagen */
}

.btn-menu:hover {
    background-color: transparent;
    background-size: 40px 40px; /* Mantén el tamaño del icono igual al hacer hover */
}

.btn-menu:focus {
    outline: none; /* Elimina el contorno del botón cuando se hace clic */
}


@media (max-width: 768px) {
    .nav nav {
        flex-direction: column;
        align-items: center;
    }

    .nav a {
        font-size: 14px;
        margin: 5px 0;
    }

    .btn-menu {
        padding: 10px 12px;
    }

    .categorias select {
        font-size: 14px;
        padding: 8px;
    }
}

    </style>
</head>
<body>

  <!--boton regresar a fecturar.php boton con icono de menu -->
  <button class="btn-menu" onclick="window.location.href='https://la30.tuingapp.com/#/facturar'"></button>
    <br><br><br>

    <div class="nav">
        <nav>
            <a href="inventario_general.php">INVENTARIO GENERAL</a>
            <a href="inventario2.php">INVENTARIO</a>
            <a href="">DESCUADRE DE INVENTARIO</a>
            <a href="">PRODUCTOS POR CADUCAR</a>
        </nav>
    </div>

    <div class="container">
        <div class="categorias">
            <select id="category-select">
                <option value="">Selecciona una categoría</option>
                <?php 
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id_categoria'] . "'>" . htmlspecialchars($row['nombre_categoria']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div id="products-container">
            <!-- Aquí se mostrará la tabla de productos -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('category-select');
            const container = document.getElementById('products-container');

            // Cargar productos al seleccionar una categoría
            select.addEventListener('change', function () {
                const categoryId = this.value;

                if (categoryId) {
                    // Solicitud AJAX para obtener los productos
                    fetch('productoss.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `category_id=${categoryId}`
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta del servidor');
                        return response.text();
                    })
                    .then(data => {
                        // Mostrar los productos en el contenedor
                        container.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error al cargar los productos:', error);
                        container.innerHTML = '<p class="no-products">Ocurrió un error al cargar los productos. Por favor, intenta nuevamente.</p>';
                    });
                } else {
                    container.innerHTML = '';
                }
            });
        });
    </script>
</body>
</html>
