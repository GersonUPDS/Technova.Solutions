<?php
// Conexión a la base de datos
$host = "localhost";
$dbname = "technova_solutions";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Consulta SQL para obtener los proveedores
$sql = "SELECT Id_Proveedor, Nombre, Estado FROM Proveedores";
$stmt = $pdo->query($sql);
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
//Una página protegida que muestra contenido según el rol.
require 'auth.php';
autenticarUsuario();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Proveedores</title>
    <style>
        <style>
        /* General */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #111;
            padding: 10px 20px;
            color: white;
        }

        .navbar .logo img {
            height: 40px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 10px;
            margin: 0 100px; /* Asegura que el contenedor esté centrado */
            padding: 0; /* Evita espacio adicional */
        }

        .nav-links li {
            position: relative;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: color 0.3s ease;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .nav-links a:hover {
            color: #00bcd4; /*color para resaltar las letras del menu*/
            
            
        }

        .submenu,
        .submenu2 {
            list-style: none;
            position: absolute;
            top: 100%; /* Mantiene el submenú justo debajo */
            left: 0; /* Alinea el submenú con el borde izquierdo del elemento padre */
            background-color: #333; /* Fondo del submenú */
            border-radius: 5px;
            overflow: hidden;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 0; /* Sin espacio adicional */
            margin: 0;
            min-width: 100%; /* Asegura que tenga al menos el mismo ancho que el padre */
        }

        .submenu li,
        .submenu2 li {
            width: 100%; /* Asegura que cada elemento ocupe el ancho completo */
        }

        .submenu li a,
        .submenu2 li a {
            font-size: 13px;
            text-align: left; /* Alinea el texto a la izquierda */
            color: #fff;
            padding: 10px 20px; /* Más espacio horizontal */
            display: block;
            width: 100%; /* Ocupa el ancho completo del contenedor */
            white-space: nowrap; /* Evita quiebres de texto */
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .submenu li a:hover,
        .submenu2 li a:hover {
            background-color: #00bcd4;
            color: #222; /* Contraste con el fondo */
            
        }

        .nav-links li:hover .submenu,
        .nav-links li:hover .submenu2 {
            display: block;
            animation: fadeIn 0.3s ease-in-out; /* Efecto de aparición */
        }

        /* Animación del submenú */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px); /* Submenú inicia arriba */
            }
            to {
                opacity: 1;
                transform: translateY(0); /* Submenú vuelve a su posición normal */
            }
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 30px;
            background-color: #000;
            color: white;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin: 20px 0;
            color: white;
        }

        /* Main Content */
        .container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        /* Form Section */
        .form-section {
            width: 40%;
            background-color: #111;
            color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .form-section h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-section form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-section table {
            width: 100%;
        }

        .form-section table td {
            padding: 10px;
        }

        .form-section input[type="text"],
        .form-section input[type="submit"],
        .form-section input[type="reset"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-section input[type="submit"] {
            background-color: #00bcd4;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .form-section input[type="reset"] {
            background-color: #00bcd4;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .form-section input[type="submit"]:hover,
        .form-section input[type="reset"]:hover {
            opacity: 0.9;
        }

        /* Data Section */
        .data-section {
            width: 60%;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .data-section h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00bcd4;
        }

        .data-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-section th,
        .data-section td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .data-section th {
            background-color: #00bcd4;
            color: white;
        }

        
        body { font-family: Arial, sans-serif; margin: 0px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #333; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }

    </style>
</head>
<body>

<header class="navbar">
        <div class="logo">
          <img src="logo2.png" alt="TechNova">
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="dashboard.php">Inicio</a></li>

                <li>
                    <?php if (verificarPermiso('Gestionar usuarios')): ?>
                    <a href="#">Gestionar Usuarios</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="usuarios.php">Gestionar Usuarios</a></li>
                        <li><a href="#">Roles</a></li>
                    </ul>
                </li>
                <li>
                    <?php if (verificarPermiso('Gestionar Inventario')): ?>
                    <a href="#">Gestionar Inventario</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="lista_productos.php">Productos</a></li>
                        <li><a href="registrar_productos.php">Compras</a></li>
                        <li><a href="registrar_proveedor.php">Proveedores</a></li>
                    </ul>
                </li>
                <li>
                    <?php if (verificarPermiso('Ver reportes')): ?>
                    <a href="#">Ver reportes</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="#">Detalle de Ventas</a></li>
                        <li><a href="lista_proveedores.php">Lista de Proveedores</a></li>
                        
                    </ul>
                </li>
                <li>
                    <?php if (verificarPermiso('Registrar ventas')): ?>
                    <a href="#">Registrar ventas</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="realizar_venta.php">Ventas</a></li>
                        <li><a href="#">Promociones</a></li>
                        
                    </ul>
                </li>
                <li><a href="#">Soporte</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h1>TechNova Solutions</h1>
        <p><h2>Bienvenido: <?php echo $_SESSION['role']; ?></h2> </p>
    </section>
    <!-- Hero Section -->


    <h2>Lista de Proveedores</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Proveedor</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedores as $proveedor): ?>
                <tr>
                    <td><?php echo $proveedor['Id_Proveedor']; ?></td>
                    <td><?php echo htmlspecialchars($proveedor['Nombre']); ?></td>
                    <td><?php echo htmlspecialchars($proveedor['Estado']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
