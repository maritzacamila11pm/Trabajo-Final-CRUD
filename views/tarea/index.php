<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> <!-- jsPDF para PDF -->
    <style>
        /* Estilo vibrante */
        body {
            background-color:rgb(253, 253, 253); /* Fondo claro */
            color: #333;
        }
        .btn-primary {
            background-color: #FF5733; /* Naranja brillante */
            border-color: #FF5733;
        }
        .btn-primary:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        .btn-secondary {
            background-color: #28a745; /* Verde vibrante */
            border-color: #28a745;
        }
        .btn-secondary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .btn-success {
            background-color: #3498db; /* Azul brillante */
            border-color: #3498db;
        }
        .btn-success:hover {
            background-color: #2980b9;
            border-color: #2471a3;
        }
        .table-dark {
            background-color:rgb(73, 152, 230);
            color: white;
        }
        .table-dark th {
            background-color:rgb(18, 127, 236);
            color: white;
        }
        .table-dark tbody tr:hover {
            background-color: #1abc9c;
        }
        .pagination .page-item.active .page-link {
            background-color: #FF5733;
            border-color: #FF5733;
        }
        .pagination .page-item.active .page-link:hover {
            background-color: #e74c3c;
            border-color: #c0392b;
        }
        .modal-header {
            background-color: #FF5733;
            color: white;
        }
        .modal-footer .btn-secondary {
            background-color: #28a745;
        }
        .modal-footer .btn-danger {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

    <!-- Alerta inicial -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Bienvenido!',
                text: 'Aquí podrás gestionar tus tareas de forma fácil y rápida.',
                confirmButtonText: 'Aceptar',
                imageUrl: 'https://pngimg.com/d/task_PNG84.png', // Imagen de tareas
                imageWidth: 100,
                imageHeight: 100,
            });
        });
    </script>

    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col">
            <h2>Gestión de Tareas</h2>
        </div>
        <div class="col text-end">
            <!-- Botones de Exportación -->
            <a href="<?= BASE_URL ?>/reports/pdf" class="btn btn-secondary">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            <a href="<?= BASE_URL ?>/reports/excel" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
                <i class="fas fa-plus"></i> Nueva Tarea
            </button>
        </div>
    </div>

    <!-- Filtros de Búsqueda -->
    <div class="shadow-none p-3 mb-5 bg-body-tertiary rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            id="searchTask"
                            placeholder="Buscar tarea por nombre...">
                        <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Tareas -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Equipo</th>
                    <th>Responsable</th>
                    <th>Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha Límite</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                <!-- Aquí se llenarán las tareas dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <nav aria-label="Navegación de Tareas">
        <ul class="pagination justify-content-center" id="pagination">
            <!-- La paginación se generará dinámicamente -->
        </ul>
    </nav>

    <!-- Modal para Crear/Editar Tarea -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Nueva Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <input type="hidden" id="taskId">
                        <div class="mb-3">
                            <label for="equipo" class="form-label">Equipo</label>
                            <input type="text" class="form-control" id="equipo" required>
                        </div>
                        <div class="mb-3">
                            <label for="responsable" class="form-label">Responsable</label>
                            <input type="text" class="form-control" id="responsable">
                        </div>
                        <div class="mb-3">
                            <label for="tarea" class="form-label">Tarea</label>
                            <input type="text" class="form-control" id="tarea" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_limite" class="form-label">Fecha Límite</label>
                            <input type="datetime-local" class="form-control" id="fecha_limite" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                    <button type="button" id="saveTaskBtn" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar esta tarea?</p>
                    <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
