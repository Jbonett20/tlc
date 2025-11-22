<?php
session_start();
include './app/conexion.php';
// Definir la cantidad de resultados por página
$limite = 99;
$sql_proveedores = "SELECT id_proveedor, nombre_proveedor FROM tbl_proveedor";
$result_proveedores = $link->query($sql_proveedores);
if (!$result_proveedores || $result_proveedores->num_rows === 0) {
    die('No se encontraron proveedores o hubo un error en la consulta.');
}
$sql_categorias = "SELECT id_categoria, nombre_categoria FROM tbl_categoria";
$result_categorias = $link->query($sql_categorias);
if (!$result_categorias || $result_categorias->num_rows === 0) {
    die('No se encontraron categorias o hubo un error en la consulta.');
}
$sql_iva = "SELECT id_iva, iva FROM tbl_iva";
$result_iva = $link->query($sql_iva);
if (!$result_iva || $result_iva->num_rows === 0) {
    die('No se encontraron categorias o hubo un error en la consulta.');
}
// Obtener la página actual desde la URL, por defecto es la página 1
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
// Obtener el término de búsqueda desde la URL
$busqueda = isset($_GET['buscar']) ? $link->real_escape_string($_GET['buscar']) : '';
// Calcular el offset para la consulta SQL
$offset = ($pagina - 1) * $limite;
// Consulta SQL para obtener los datos con paginación y búsqueda
$sql = "SELECT 
            p.codigo_producto, 
            p.descripcion AS nombre, 
            i.stock AS stock, 
            p.valor, 
            p.codigo_barras, 
            p.valor_venta, 
            p.valor_unidad, 
            p.id_proveedor, 
            p.id_categoria,
            p.id_iva,
            p.rentabilidad
        FROM tbl_producto p
        LEFT JOIN tbl_inventario i ON p.codigo_producto = i.id_producto";
// Si hay una búsqueda, agregar la cláusula WHERE
if (!empty($busqueda)) {
    $sql .= " WHERE p.descripcion LIKE '%$busqueda%'";
}
// Agregar paginación
$sql .= " LIMIT $limite OFFSET $offset";
// Ejecutar la consulta
$result = $link->query($sql);
// Calcular el total de páginas considerando la búsqueda
$sql_total = "SELECT COUNT(*) AS total FROM tbl_producto";
if (!empty($busqueda)) {
    $sql_total .= " WHERE descripcion LIKE '%$busqueda%'";
}
$result_total = $link->query($sql_total);
$total_registros = $result_total->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $limite);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inventario2.css">
    <title>Inventario</title>

</head>
<script>
        async function buscarEnTiempoReal() {
            const buscarInput = document.getElementById('buscar');
            const termino = buscarInput.value;
            const response = await fetch(`buscar.php?buscar=${encodeURIComponent(termino)}&pagina=1`);
            const resultadoHTML = await response.text();
            document.querySelector('.tabla tbody').innerHTML = resultadoHTML;
            // Actualizar paginación
            const paginacionResponse = await fetch(`paginacion.php?buscar=${encodeURIComponent(termino)}`);
            const paginacionHTML = await paginacionResponse.text();
            document.querySelector('.paginacion').innerHTML = paginacionHTML;
        }
        document.addEventListener('DOMContentLoaded', () => {
            const buscarInput = document.getElementById('buscar');
            buscarInput.addEventListener('input', buscarEnTiempoReal);
        });
        function abrirModal(codigo, codigo_barras, nombre, stock, valor, valor_venta, valor_unidad, id_proveedor, id_categoria, id_iva, rentabilidad) {
            // Rellenar los campos del formulario
            document.getElementById('codigo').value = codigo;
            document.getElementById('codigo_barras').value = codigo_barras;
            document.getElementById('nombre').value = nombre;
            document.getElementById('stock').value = stock;
            document.getElementById('valor').value = valor;
            document.getElementById('valor_venta').value = valor_venta;
            document.getElementById('valor_unidad').value = valor_unidad;
            const proveedorSelect = document.getElementById('proveedor');
            if (id_proveedor) {
                proveedorSelect.value = id_proveedor; // Seleccionar el proveedor correspondiente
            }
            const categoriaSelect = document.getElementById('categoria');
            if (id_categoria) {
                categoriaSelect.value = id_categoria; // Seleccionar la categoría correspondiente
            }
            const ivaSelect = document.getElementById('iva');
            if (id_iva) {
                ivaSelect.value = id_iva; // Seleccionar el IVA correspondiente
            }
            // Mostrar rentabilidad en el h2
            document.getElementById('rentabilidad-display').textContent = "Rentabilidad: " + rentabilidad + "%";
            // Mostrar el modal
            document.getElementById('modal-editar').style.display = 'block';
        }
        function cerrarModal() {
            document.getElementById('modal-editar').style.display = 'none';
        }
        async function actualizarProducto() {
            const form = document.getElementById('form-editar');
            const formData = new FormData(form);
            // Verificar los datos que se están enviando
            console.log('Datos del producto que se intentan actualizar:');
            console.log(...formData);
            const response = await fetch('actualizar.php', {
                method: 'POST',
                body: formData,
            });
            const resultado = await response.text();
            if (resultado === 'success') {
                alert('Producto actualizado correctamente');
                location.reload();
            } else {
                alert('Error al actualizar el producto: ' + resultado);
            }
        }
        function confirmarEliminar(codigoProducto) {
            const confirmar = window.confirm("¿Estás seguro de que deseas eliminar este producto?");
            if (confirmar) {
                // Enviar solicitud al archivo PHP
                fetch(`eliminar.php?id=${codigoProducto}`, { method: 'GET' })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() === "success") {
                            alert("Producto eliminado correctamente");
                            location.reload(); // Recargar la página
                        } else {
                            alert("Error al eliminar el producto: " + data);
                        }
                    })
                    .catch(error => {
                        console.error("Hubo un error al eliminar el producto:", error);
                        alert("Hubo un problema al eliminar el producto. Intenta nuevamente.");
                    });
            }
        }
    </script>
<body>
    <!--boton regresar a fecturar.php boton con icono de menu -->
    <button class="btn-menu" onclick="window.location.href='https://la30.tuingapp.com/#/facturar'"></button>
    <br><br><br>
    <div class="nav">
        <nav>
            <a href="inventario_general.php">INVENTARIO GENERAL</a>
            <a href="inventario_categorias.php">INVENTARIO POR CATEGORIAS</a>
            <a href="">DESCUADRE DE INVENTARIO</a>
            <a href="">PRODUCTOS POR CADUCAR</a>
        </nav>
    </div>
    <center>
        <div class="contenido">
            <div class="card">
                <input type="search" name="buscar" id="buscar" placeholder="Buscar">
            </div>
    </center>
    <?php
// Rango de páginas a mostrar
$rango_paginas = 5;

// Calcular inicio y fin del rango de páginas
$inicio_rango = max(1, $pagina - floor($rango_paginas / 2));
$fin_rango = min($total_paginas, $inicio_rango + $rango_paginas - 1);

// Ajustar el inicio si el rango no alcanza el número definido
if ($fin_rango - $inicio_rango + 1 < $rango_paginas) {
    $inicio_rango = max(1, $fin_rango - $rango_paginas + 1);
}

$queryParams = !empty($busqueda) ? "&buscar=" . urlencode($busqueda) : "";

echo '<div class="paginacion">';
// Botón para la página anterior
if ($pagina > 1) {
    echo '<a href="?pagina=' . ($pagina - 1) . $queryParams . '">Anterior</a>';
}

// Botones numéricos del rango
for ($i = $inicio_rango; $i <= $fin_rango; $i++) {
    if ($i == $pagina) {
        echo '<a href="?pagina=' . $i . $queryParams . '" class="active">' . $i . '</a>';
    } else {
        echo '<a href="?pagina=' . $i . $queryParams . '">' . $i . '</a>';
    }
}

// Botón para la página siguiente
if ($pagina < $total_paginas) {
    echo '<a href="?pagina=' . ($pagina + 1) . $queryParams . '">Siguiente</a>';
}
echo '</div>';
?>

    </div>
    <br><br>
    <div class="tabla">
        <center>
            <table>
                <thead>
                    <tr>
                        <th>Cod. Producto</th>
                        <th>codigo de barras</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Valor</th>
                        <th>Venta</th>
                        <th>Valor U</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['codigo_producto']}</td>";
                            echo "<td>{$row['codigo_barras']}</td>";
                            echo "<td>{$row['nombre']}</td>";
                            echo "<td>{$row['stock']}</td>";
                            echo "<td>{$row['valor']}</td>";
                            echo "<td>{$row['valor_venta']}</td>";
                            echo "<td>{$row['valor_unidad']}</td>";
                            echo "<td>
    <button type='button' onclick=\"abrirModal('{$row['codigo_producto']}', '{$row['codigo_barras']}', '{$row['nombre']}', '{$row['stock']}', '{$row['valor']}', '{$row['valor_venta']}', '{$row['valor_unidad']}','{$row['id_proveedor']}','{$row['id_categoria']}', '{$row['id_iva']}', '{$row['rentabilidad']}')\">Editar</button> | 
    <button type='button' onclick=\"confirmarEliminar('{$row['codigo_producto']}')\">Eliminar</button>
</td>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </center>
    </div>
    </div>
    <div id="modal-editar" class="modal">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <h3>Editar Producto</h3>
            <form id="form-editar">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" readonly>
                <label for="codigo_barras">Código de barras:</label>
                <input type="text" id="codigo_barras" name="codigo_barras">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">
                <label for="stock">stock:</label>
                <input type="text" id="stock" name="stock">
                <label for="proveedor">Seleccione proveedor:</label>
                <select id="proveedor" name="proveedor">
                    <?php
                    if ($result_proveedores->num_rows > 0) {
                        while ($proveedor = $result_proveedores->fetch_assoc()) {
                            echo "<option value='" . $proveedor['id_proveedor'] . "'>" . $proveedor['id_proveedor'] . " - " . $proveedor['nombre_proveedor'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay proveedores registrados</option>";
                    }
                    ?>
                </select>
                <label for="categoria">Seleccione Categoria:</label>
                <select id="categoria" name="categoria">
                    <?php
                    if ($result_categorias->num_rows > 0) {
                        while ($categoria = $result_categorias->fetch_assoc()) {
                            echo "<option value='" . $categoria['id_categoria'] . "'>" . $categoria['id_categoria'] . " - " . $categoria['nombre_categoria'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay categorías registradas</option>";
                    }
                    ?>
                </select>
                <label for="iva">Seleccione el IVA:</label>
                <select id="iva" name="iva">
                    <?php
                    if ($result_iva->num_rows > 0) {
                        while ($iva = $result_iva->fetch_assoc()) {
                            echo "<option value='" . $iva['id_iva'] . "'>" . $iva['id_iva'] . " - " . $iva['iva'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay IVA registrado</option>";
                    }
                    ?>
                </select>
                <label for="valor">Valor:</label>
                <input type="number" id="valor" name="valor">
                <label for="valor_venta">Valor Venta:</label>
                <input type="number" id="valor_venta" name="valor_venta">
                <label for="valor_unidad">Valor Unidad:</label>
                <input type="number" id="valor_unidad" name="valor_unidad">
                <label for="rentabilidad">Rentabilidad:</label>
                <h2 id="rentabilidad-display"></h2>
                <button type="button" onclick="actualizarProducto()">Actualizar</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
$link->close();
?>