//OBTENER TAREA JS
document.addEventListener('DOMContentLoaded',function(){
    // alert('Maritza');
    obtenerTarea();
})

async function obtenerTarea() {
    try {
        const respuesta = await fetch('tarea/obtener-tarea');
        const resultado = await respuesta.json();
        console.log(resultado);
        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        const tareas = resultado.data;
        console.log(tareas);  // Para asegurarte que los datos están bien estructurados
        const tbody = document.getElementById('taskTableBody');
        tbody.innerHTML = '';
        
        tareas.forEach(tarea => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${tarea.id_tareas}</td>
                <td>${tarea.equipo}</td>
                <td>${tarea.responsable}</td>
                <td>${tarea.tarea}</td>
                <td>${tarea.fase}</td>
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
    }, 6000);
}
//FORMA 1 - FUNCIONA A MEDIAS 
// async function guardarTarea() {
//     const equipo = document.getElementById('equipo').value.trim();
//     const responsable = document.getElementById('responsable').value.trim();
//     const tarea = document.getElementById('tarea').value.trim();
//     const fase = document.getElementById('fase').value.trim();
//     const descripción = document.getElementById('descripcion').value.trim();
//     const fecha_limite = document.getElementById('fecha_limite').value.trim();

//     try {
//         const response = await fetch('tarea/guardar-tarea', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({
//                 equipo: equipo,
//                 responsable: responsable,
//                 tarea: tarea,
//                 fase: fase,
//                 descripcion: descripción,
//                 fecha_limite: fecha_limite,

//             })
//         });

//         const responseJson = await response.json();

//         if (responseJson.status === 'error') {
//             showAlert('error', responseJson.message);
//             return;
//         }

//         showAlert('success', responseJson.message);
//         //recargar
//         setTimeout(() => {
//             obtenerTarea();
//             const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
//             modal.hide();
//         }, 500);
//     } catch (error) {
//         showAlert('error', 'Error al guardar la tarea: ' + error);
//     }
// }

//FORMA 2 - 
async function guardarTarea(){
    try {
        const formData = new FormData();
        
        // Obtener los valores de los campos del formulario
        const equipo = document.getElementById('equipo').value;
        const responsable = document.getElementById('responsable').value;
        const tarea = document.getElementById('tarea').value;
        const fase = document.getElementById('fase').value;
        const descripcion = document.getElementById('descripcion').value;  // Asegúrate que el ID sea correcto
        const fechaLimite = document.getElementById('fecha_limite').value;  // Usamos .value, no .files[0]

        // Asegúrate de que los campos obligatorios no estén vacíos
        if (!equipo || !tarea || !fechaLimite) {
            Swal.fire({
                icon: 'error',
                title: 'Faltan campos requeridos',
                text: 'Por favor, complete los campos obligatorios.'
            });
            return;
        }

        // Agregar los datos al FormData
        formData.append('equipo', equipo);
        formData.append('responsable', responsable);
        formData.append('tarea', tarea);
        formData.append('fase', fase);
        formData.append('descripcion', descripcion);
        formData.append('fecha_limite', fechaLimite);

        // Enviar la solicitud POST
        const response = await fetch('tarea/guardar-tarea', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'error') {
            throw new Error(result.message);
        }

        // Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();

        // Mostrar mensaje de éxito
        showAlert('success', result.message);

        // Obtener las tareas nuevamente si es necesario
        obtenerTarea();

        // Opcional: Resetear el formulario
        // resetForm();

    } catch (error) {
        // Manejo de errores
        showAlert('error', error.message);
    }
}
