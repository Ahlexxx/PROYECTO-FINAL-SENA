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
    <title>Catálogo de Servicios - Salón de Belleza</title>
    <link rel="stylesheet" href="styles4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="navbar">
        <img src="imagenes/t.png" alt="Logo">
        <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i></a>>
        <a href="catalogo.php" class="Catálogo">CATALOGO</a>
        <a href="agenda.php">AGENDAR</a>
        <a href="inicio1.php" class="active">INICIO</a>
    </div>


    <section class="catalogo">
        <h1>Catálogo de Productos</h1>

        <div class="carrito">
            <h2>Compras</h2>
            <ul id="carrito-lista">
        </ul>
        </div>

        <h2>Shampoos</h2>
        <div class="producto">
            <img src="imagenes/pantene.png" alt="Pantene Pro-V Liso Extremo">
            <h3>Pantene Pro-V Liso Extremo</h3>
            <p>Shampoo para cabello liso.</p>
            <p>Precio: $15.000</p>
            <button onclick="agregarAlCarrito('Pantene Pro-V Liso Extremo')">Comprar Ahora</button>
        </div>
            
        <div class="producto">
            <img src="imagenes/limpieza-renovadora.png" alt="Head & Shoulders">
            <h3>Head & Shoulders</h3>
            <p>Shampoo anticaspa clásico.</p>
            <p>Precio: $15.000</p>
            <button onclick="agregarAlCarrito('Head & Shoulders')">Comprar Ahora</button>
        </div>
            
        <h2>Acondicionadores</h2>
        <div class="producto">
            <img src="imagenes/MTCP0272-GUCP0643-NP.png" alt="Pantene Pro-V 3 Minute Miracle">
            <h3>Pantene Pro-V 3 Minute Miracle</h3>
            <p>Acondicionador intensivo.</p>
            <p>Precio: $30.000</p>
            <button onclick="agregarAlCarrito('Pantene Pro-V 3 Minute Miracle')">Comprar Ahora</button>
        </div>
        
        <div class="producto">
            <img src="imagenes/SUAVE-Y-MANEJABLE-DERMO-ACONDICIONADOR.png" alt="Head & Shoulders Suave y Manejable">
            <h3>Head & Shoulders Suave y Manejable</h3>
            <p>Acondicionador anticaspa.</p>
            <p>Precio: $20.000</p>
            <button onclick="agregarAlCarrito('Head & Shoulders Suave y Manejable')">Comprar Ahora</button>
        </div>
        
        <h2>Perfumes</h2>
        <div class="producto">
            <img src="imagenes/images.jpg" alt="Carolina Herrera 212 VIP">
            <h3>Carolina Herrera 212 VIP</h3>
            <p>Perfume de notas frutales y almizcladas.</p>
            <p>Precio: $100.000</p>
            <button onclick="agregarAlCarrito('Carolina Herrera 212 VIP')">Comprar Ahora</button>
        </div>

        <div class="producto">
            <img src="imagenes/1MILLON.webp" alt="Paco Rabanne 1 Million">
            <h3>Paco Rabanne 1 Million</h3>
            <p>Perfume con notas de cuero y especias.</p>
            <p>Precio: $100.000</p>
            <button onclick="agregarAlCarrito('Paco Rabanne 1 Million')">Comprar Ahora</button>
        </div>
        <h1>Servicios</h1>
        <div class="servicio">
            <img src="imagenes/cortes de pelo.jpg" alt="Corte de Pelo">
            <h2>Corte de Pelo</h2>
            <p>Duración: 30 minutos</p>
            <p>Precio: $15.000</p>
            <button>Reservar Ahora</button>
        </div>

        <div class="servicio">
            <img src="imagenes/manicura.jpg" alt="Manicura">
            <h2>Manicura</h2>
            <p>Duración: 45 minutos</p>
            <p>Precio: $20.000</p>
            <button>Reservar Ahora</button>
        </div>

        <div class="servicio">
            <img src="imagenes/pedicure.jpg" alt="Pedicura">
            <h2>Pedicura</h2>
            <p>Duración: 60 minutos</p>
            <p>Precio: $30.000</p>
            <button>Reservar Ahora</button>
        </div>

        <div class="servicio">
            <img src="imagenes/Diferencias-entre-el-masaje-terapeutico-y-el-masaje-relajante.webp" alt="Masaje">
            <h2>Masaje Relajante</h2>
            <p>Duración: 90 minutos</p>
            <p>Precio: $50.000</p>
            <button>Reservar Ahora</button>
        </div>
    </section>

    <script>
        function agregarAlCarrito(producto) {
            const carritoLista = document.getElementById('carrito-lista');
            const li = document.createElement('li');
            li.textContent = producto;
            
            const botonEliminar = document.createElement('button');
            botonEliminar.textContent = 'Eliminar';
            botonEliminar.classList.add('eliminar');
            botonEliminar.onclick = function() {
                carritoLista.removeChild(li);
            };
            
            li.appendChild(botonEliminar);
            carritoLista.appendChild(li);
        }
            
    </script>
</body>
</html>

