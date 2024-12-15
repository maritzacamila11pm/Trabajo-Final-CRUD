//OBTENER TAREA JS
document.addEventListener('DOMContentLoaded',function(){
    // alert('Maritza');
    obtenerTarea();
})

async function obtenerTarea() {
    try {
        const respuesta = await fetch('tarea/obtener');
        const resultado = await respuesta.json();
        
        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        const tareas = resultado.data;
        console.log(tareas);

        const tbody = document.getElementById('taskTableBody');
        tbody.innerHTML = '';
        
        tareas.forEach(tarea => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${tarea.id_tareas}</td>
                <td>${tarea.equipo}</td>
                <td>${tarea.responsable}</td>
                <td>${tarea.tarea}</td>
                <td>${tarea.descripcion || '<span class="text-muted">Sin descripción</span>'}</td>
                <td>${tarea.fecha_limite}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary" onclick="editProduct(${tarea.id_tareas}, ${JSON.stringify(tarea).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${tarea.id_tareas})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        showAlert('error', 'Error al cargar las tareas: ' + error.message);
    }
}


function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertContainer.appendChild(alertDiv);

    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}