<?php
include './app/conexion.php';

// Obtener el término de búsqueda desde la URL
$busqueda = isset($_GET['buscar']) ? $link->real_escape_string($_GET['buscar']) : '';

// Definir la cantidad de resultados por página
$limite = 98;

// Calcular el total de registros considerando la búsqueda
$sql_total = "SELECT COUNT(*) AS total FROM tbl_producto";
if (!empty($busqueda)) {
    $sql_total .= " WHERE descripcion LIKE '%$busqueda%'";
}

$result_total = $link->query($sql_total);
$total_registros = $result_total->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $limite);

// Obtener la página actual desde la URL, por defecto es la página 1
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Definir el rango fijo de páginas
$rango_paginas = 5;
$inicio_rango = max(1, $pagina_actual - floor($rango_paginas / 2));
$fin_rango = min($total_paginas, $inicio_rango + $rango_paginas - 1);

// Ajustar el inicio si el rango no alcanza las 5 páginas
if ($fin_rango - $inicio_rango + 1 < $rango_paginas) {
    $inicio_rango = max(1, $fin_rango - $rango_paginas + 1);
}

// Generar los enlaces de paginación
$queryParams = !empty($busqueda) ? "&buscar=" . urlencode($busqueda) : "";

echo '<div class="paginacion">';
// Botón para la página anterior
if ($pagina_actual > 1) {
    echo '<a href="?pagina=' . ($pagina_actual - 1) . $queryParams . '">Anterior</a>';
}

// Botones numéricos
for ($i = $inicio_rango; $i <= $fin_rango; $i++) {
    if ($i == $pagina_actual) {
        echo '<a href="?pagina=' . $i . $queryParams . '" class="active">' . $i . '</a>';
    } else {
        echo '<a href="?pagina=' . $i . $queryParams . '">' . $i . '</a>';
    }
}

// Botón para la siguiente página
if ($pagina_actual < $total_paginas) {
    echo '<a href="?pagina=' . ($pagina_actual + 1) . $queryParams . '">Siguiente</a>';
}
echo '</div>';

$link->close();
?>
