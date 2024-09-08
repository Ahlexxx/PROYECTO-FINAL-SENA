<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: iniciar.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bogotá Body</title>
    <link rel="stylesheet" href="styles3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i></a>>
        <a href="catalogo.php">CATALOGO</a>
        <a href="agenda.php">AGENDAR</a>
        <a href="inicio1.php" class="active">INICIO</a>
    </div>
    <header>
        <h1>Bienvenidos a Bogotá Body</h1>
        <p>Tu belleza, nuestra pasión</p>
    </header>
    
    <section class="servicios-destacados">
        <h2>Servicios Destacados</h2>
        <div class="servicio">
            <img src="imagenes/cortes de pelo.jpg" alt="Corte de Pelo">
            <h3>Corte de Pelo</h3>
            <p>Desde $13.000</p>
        </div>
        <div class="servicio">
            <img src="imagenes/manicura.jpg" alt="Manicura">
            <h3>Manicura</h3>
            <p>Desde $15.000</p>
        </div>
    </section>
    
    <section class="testimonios">
        <h2>Testimonios</h2>
        <blockquote>"¡El mejor servicio que he recibido!"</blockquote>
    </section>
    
    <section class="promociones">
        <h2>Promociones Especiales</h2>
        <p>Descuento del 20% en tu primera visita.</p>
    </section>
    
    <section class="ubicacion-horarios">
        <h2>Ubicación y Horarios</h2>
        <p>Carrera 1A 8C 21 Este</p>
        <p>Lunes - Viernes: 9am - 8pm</p>
        <p>Sábado: 10am - 6pm</p>
    </section>
    
    <section class="redes-sociales">
        <h2>Síguenos en Redes Sociales</h2>
        <a href="https://www.facebook.com">Facebook</a>
        <a href="https://www.instagram.com">Instagram</a>
        <a href="https://www.twitter.com">Twitter</a>
    </section>
</body>
</html>


