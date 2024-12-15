<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si ya está autenticado

?>
<!-- views/auth/login.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <style>
        body {
            background-color:rgb(47, 222, 146); /* Fondo suave y neutro */
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 12px;
            background-color: #ffffff; /* Fondo blanco para la tarjeta */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05); /* Agranda la tarjeta al pasar el mouse */
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 2rem;
        }

        .card-body h2 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #388e3c; /* Verde brillante */
            margin-bottom: 30px;
        }

        .form-label {
            color: #388e3c; /* Verde para las etiquetas */
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            background-color: #fff; /* Fondo blanco para los campos */
            color: #333;
            border: 1px solid #81c784; /* Verde claro para los bordes */
            padding: 15px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #66bb6a; /* Verde más oscuro al enfocar */
            box-shadow: 0 0 5px rgba(102, 187, 106, 0.5);
        }

        .btn-primary {
            background-color: #388e3c; /* Verde brillante */
            border-color: #388e3c;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #66bb6a; /* Verde más claro al pasar el mouse */
            border-color: #66bb6a;
            transform: translateY(-2px); /* Eleva el botón al pasar el mouse */
        }

        .text-center a {
            color: #81c784; /* Verde suave */
            text-decoration: none;
            font-weight: 600;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .alert {
            background-color: #ffeb3b; /* Amarillo brillante para alertas */
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Iniciar Sesión</h2>
                        <div id="loginAlert"></div>
                        <form id="loginForm" onsubmit="login(event)">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Iniciar Sesión
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <p>¿No tienes cuenta? <a href="<?= BASE_URL ?>/register">Regístrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Alerta al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Bienvenido!',
                text: 'Disfruta tu experiencia.',
                confirmButtonText: 'Comenzar',
                imageUrl: 'https://pngimg.com/d/like_PNG44.png', // URL de tu imagen
                imageWidth: 100,  // Ancho de la imagen
                imageHeight: 100, // Alto de la imagen
            });
        });
    </script>

    <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
</body>
</html>
