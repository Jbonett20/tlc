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
function abrirModal(codigo, codigo_barras, nombre, und, valor, valor_venta, valor_unidad, id_proveedor, id_categoria, id_iva, rentabilidad) {
    // Rellenar los campos del formulario
    document.getElementById('codigo').value = codigo;
    document.getElementById('codigo_barras').value = codigo_barras;
    document.getElementById('nombre').value = nombre;
    document.getElementById('und').value = und;
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
