<?php
session_start();
include './app/conexion.php';

// Variables para la paginación
$limite = 97; // Cantidad de productos por página
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $limite;
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : (isset($_GET['busqueda']) ? $_GET['busqueda'] : '');

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
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.page-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 20px 40px;
}

.btn-menu {
    display: inline-block;
    width: 40px;
    height: 40px;
    background: url('https://cdn.icon-icons.com/icons2/2596/PNG/512/return_icon_154912.png') no-repeat center;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    margin: 20px 0 10px 20px;
    cursor: pointer;
    border: none;
}

.nav {
    background-color: #4b4b4b;
    padding: 12px 10px;
    border-radius: 4px;
}

.nav nav {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.nav a {
    color: #fff;
    text-decoration: none;
    padding: 8px 14px;
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 3px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.2px;
}

.nav a.active,
.nav a:hover {
    background-color: #ffffff;
    color: #4b4b4b;
}

.card {
    margin-top: 18px;
    background-color: #fff;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 16px 18px 20px;
}

.toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.search-form {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
}

.search-form input[type="search"] {
    width: 260px;
    max-width: 100%;
    padding: 8px 10px;
    border-radius: 4px;
    border: 1px solid #d5d5d5;
    outline: none;
}

.toolbar-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 34px;
    padding: 0 14px;
    border-radius: 4px;
    color: #fff;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
}

.btn-excel {
    background-color: #43a047;
}

.btn-pdf {
    background-color: #d32f2f;
}

.paginacion {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.paginacion a {
    display: inline-flex;
    width: 26px;
    height: 26px;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #666;
    border-radius: 50%;
    border: 1px solid #d9d9d9;
    font-size: 12px;
}

.paginacion a.active {
    background-color: #e91e63;
    color: #fff;
    border-color: #e91e63;
}

.paginacion a:hover {
    background-color: #e91e63;
    color: #fff;
    border-color: #e91e63;
}

.table-wrap {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
}

table th,
table td {
    padding: 10px 12px;
    text-align: left;
    border: 1px solid #f3c0d3;
    font-size: 13px;
}

table thead th {
    background-color: #e91e63;
    color: #fff;
    font-weight: 600;
}

.footer-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 16px;
}
</style>

<body>

     <!--boton regresar a fecturar.php boton con icono de menu -->
    <button class="btn-menu" onclick="window.location.href='https://la30.tuingapp.com/#/facturar'"></button>

    <div class="page-wrap">
        <div class="nav">
            <nav>
                <a href="inventario2.php">INVENTARIO</a>
                <a href="inventario_categorias.php">INVENTARIO POR CATEGORIAS</a>
                <a href="">DESCUADRE DE INVENTARIO</a>
                <a href="">PRODUCTOS POR CADUCAR</a>
                <a class="active" href="inventario_general.php">INVENTARIO POR PRODUCTOS GENERAL</a>
            </nav>
        </div>

        <div class="card">
            <div class="toolbar">
                <form class="search-form" method="POST" action="">
                    <input type="search" name="busqueda" placeholder="Buscar producto..." value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>">
                </form>
                <div class="toolbar-actions">
                    <a class="btn-action btn-excel" href="?export=excel&busqueda=<?php echo urlencode($busqueda); ?>">EXCEL</a>
                    <a class="btn-action btn-pdf" href="?export=pdf&busqueda=<?php echo urlencode($busqueda); ?>">PDF</a>
                </div>
            </div>

            <!-- Paginación -->
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <div class="paginacion">
                    <?php
                    if ($pagina > 1) {
                        echo '<a href="?pagina=' . ($pagina - 1) . '&busqueda=' . urlencode($busqueda) . '">‹</a>';
                    }

                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina) {
                            echo '<a href="?pagina=' . $i . '&busqueda=' . urlencode($busqueda) . '" class="active">' . $i . '</a>';
                        } else {
                            echo '<a href="?pagina=' . $i . '&busqueda=' . urlencode($busqueda) . '">' . $i . '</a>';
                        }
                    }

                    if ($pagina < $total_paginas) {
                        echo '<a href="?pagina=' . ($pagina + 1) . '&busqueda=' . urlencode($busqueda) . '">›</a>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Mostrar resultados si existen -->
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
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
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <p>No se encontraron resultados.</p>
            <?php endif; ?>

            <div class="footer-actions">
                <a class="btn-action btn-excel" href="?export=excel&busqueda=<?php echo urlencode($busqueda); ?>">Exportar en Excel</a>
                <a class="btn-action btn-pdf" href="?export=pdf&busqueda=<?php echo urlencode($busqueda); ?>">Exportar en PDF</a>
            </div>
        </div>
    </div>

</body>

</html>

<?php
$link->close();
?>
