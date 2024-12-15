<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <style>
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Contenedor principal */
        .container {
            text-align: center;
        }

        /* Imagen */
        .error-img {
            width: 90%;
            max-width: 400px;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Mensaje */
        .message {
            margin-top: 20px;
            font-size: 1.5rem;
            color: #666;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="error-img" src="https://i.pinimg.com/originals/f3/47/cf/f347cfb87d87e4a39ed179c394d71ec0.gif" alt="Página no encontrada">
        <div class="message">¡Oops! La página que buscas no existe.</div>
        <a class="back-btn" href="http://localhost/entregable/login" target="_blank">Ir al sitio oficial</a>
    </div>

    
</body>

</html>
