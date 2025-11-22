<?php
session_start();
include './app/conexion.php';

// Variables para la paginación
$limite = 97; // Cantidad de productos por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

$resultado = null;
$total_paginas = 0;

// Contar el total de productos
$sql_total = "SELECT COUNT(*) AS total FROM tbl_producto";
if ($busqueda) {
    $sql_total .= " WHERE descripcion LIKE '%$busqueda%'";
}
$result_total = $link->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_productos = $row_total['total'];

// Calcular el total de páginas
$total_paginas = ceil($total_productos / $limite);

// Consulta para obtener los productos de la página actual
$sql = "SELECT p.codigo_producto, p.descripcion, i.unidad 
        FROM tbl_producto p
        INNER JOIN tbl_inventario i ON p.id_producto = i.id_producto";
if ($busqueda) {
    $sql .= " WHERE p.descripcion LIKE '%$busqueda%'";
}
$sql .= " LIMIT $limite OFFSET $offset";

$resultado = $link->query($sql);

// Función para exportar a Excel
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Inventario_General.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $sql_export = "SELECT p.codigo_producto, p.descripcion, i.unidad 
                   FROM tbl_producto p
                   INNER JOIN tbl_inventario i ON p.id_producto = i.id_producto";
    if ($busqueda) {
        $sql_export .= " WHERE p.descripcion LIKE '%$busqueda%'";
    }
    $resultado_export = $link->query($sql_export);

    echo "<table border='1'>";
    echo "<thead>
            <tr>
                <th>Código Producto</th>
                <th>Descripción</th>
                <th>Unidad</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $resultado_export->fetch_assoc()) {
        echo "<tr>
                <td>{$row['codigo_producto']}</td>
                <td>{$row['descripcion']}</td>
                <td>{$row['unidad']}</td>
              </tr>";
    }
    echo "</tbody>";
    echo "</table>";
    exit;
}

// Función para exportar a PDF
if (isset($_GET['export']) && $_GET['export'] === 'pdf') {
    require '../fpdf/fpdf.php';

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Títulos de las columnas
    $pdf->Cell(50, 10, 'Código Producto', 1);
    $pdf->Cell(100, 10, 'Descripción', 1);
    $pdf->Cell(40, 10, 'Unidad', 1);
    $pdf->Ln();

    $sql_export = "SELECT p.codigo_producto, p.descripcion, i.unidad 
                   FROM tbl_producto p
                   INNER JOIN tbl_inventario i ON p.id_producto = i.id_producto";
    if ($busqueda) {
        $sql_export .= " WHERE p.descripcion LIKE '%$busqueda%'";
    }
    $resultado_export = $link->query($sql_export);

    $pdf->SetFont('Arial', '', 12);
    while ($row = $resultado_export->fetch_assoc()) {
        $pdf->Cell(50, 10, $row['codigo_producto'], 1);
        $pdf->Cell(100, 10, $row['descripcion'], 1);
        $pdf->Cell(40, 10, $row['unidad'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'Inventario_General.pdf');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inventario2.css">
    <title>Inventario</title>
</head>
<style>
  /* inventario2.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.btn-menu {
    display: block;
    width: 40px;
    height: 40px;
    background: url('https://cdn.icon-icons.com/icons2/2596/PNG/512/return_icon_154912.png') no-repeat center;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    margin: 20px;
    cursor: pointer;
}

.nav {
    background-color: #333;
    padding: 10px;
    text-align: center;
}

.nav a {
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
}

.conteiner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.carta {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.carta h1 {
    margin-top: 0;
}

.carta form {
    margin-top: 20px;
}

.carta button {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

table {
    width: 70%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

table th,
table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f0f0f0;
}

.paginacion {
    text-align: center;
    margin-top: 20px;
}

.paginacion a {
    display: inline-block;
    padding: 5px 10px;
    text-decoration: none;
    color: #333;
    border-radius: 3px;
    margin: 0 5px;
}

.paginacion a.active {
    background-color: #333;
    color: #fff;
}

button {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 20px;
}

</style>

<body>

     <!--boton regresar a fecturar.php boton con icono de menu -->
     <button class="btn-menu" onclick="window.location.href='https://la30.tuingapp.com/#/facturar'"></button>
    <br><br><br>

    <div class="nav">
        <nav>
            <a href="inventario2.php">INVENTARIO </a>
            <a href="inventario_categorias.php">INVENTARIO POR CATEGORIAS</a>
            <a href="">DESCUADRE DE INVENTARIO</a>
            <a href="">PRODUCTOS POR CADUCAR</a>
        </nav>
    </div>


        <!-- Paginación -->
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <div class="paginacion">
                <?php
                if ($pagina > 1) {
                    echo '<a href="?pagina=' . ($pagina - 1) . '&busqueda=' . urlencode($busqueda) . '">Prev</a>';
                }

                for ($i = 1; $i <= $total_paginas; $i++) {
                    if ($i == $pagina) {
                        echo '<a href="?pagina=' . $i . '&busqueda=' . urlencode($busqueda) . '" class="active">' . $i . '</a>';
                    } else {
                        echo '<a href="?pagina=' . $i . '&busqueda=' . urlencode($busqueda) . '">' . $i . '</a>';
                    }
                }

                if ($pagina < $total_paginas) {
                    echo '<a href="?pagina=' . ($pagina + 1) . '&busqueda=' . urlencode($busqueda) . '">Next</a>';
                }
                ?>
            </div>
            <br>
        <?php endif; ?>

        <!-- Mostrar resultados si existen -->
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <center>
            <table>
                <thead>
                    <tr>
                        <th>Código Producto</th>
                        <th>Descripción</th>
                        <th>Unidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['codigo_producto']; ?></td>
                            <td><?php echo $row['descripcion']; ?></td>
                            <td><?php echo $row['unidad']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </center>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>No se encontraron resultados.</p>
        <?php endif; ?>

        <!-- Botones para exportar -->
        <center>
            <button onclick="window.location.href='?export=excel&busqueda=<?php echo urlencode($busqueda); ?>'">Exportar en Excel</button>
            <button onclick="window.location.href='?export=pdf&busqueda=<?php echo urlencode($busqueda); ?>'">Exportar en PDF</button>
        </center>
        <br><br>
    </div>

</body>

</html>

<?php
$link->close();
?>
