<!-- ver_video.php -->
<?php
$videoID = $_GET['id'] ?? null;

if (!$videoID) {
    echo "No se proporcionó un ID de video.";
    exit;
}

$embedUrl = "https://drive.google.com/file/d/{$videoID}/preview";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Video desde Google Drive</title>
    <style>
        /* General */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Contenedor principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Título de la página */
        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Estilos para el iframe */
        iframe {
            width: 100%;
            max-width: 900px;
            height: 500px;
            border: none;
            margin: 20px 0;
            border-radius: 8px;
        }

        /* Enlace de regreso */
        .back-link {
            display: inline-block;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s;
            margin-top: 20px;
            text-align: center;
            width: 100%;
        }

        .back-link:hover {
            background-color: #0056b3;
        }

        /* Responsividad */
        @media screen and (max-width: 768px) {
            iframe {
                height: 350px; /* Menor altura en dispositivos pequeños */
            }

            h1 {
                font-size: 1.5rem; /* Título más pequeño en dispositivos pequeños */
            }

            .back-link {
                width: auto; /* El enlace no ocupa todo el ancho en pantallas pequeñas */
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Video Explicativo</h1>
        <<iframe src="<?php echo $embedUrl; ?>" allow="autoplay"></iframe>
        <a href="servicios.php" class="back-link">Regresar a Servicios</a>
  </div>
</body>
</html>
