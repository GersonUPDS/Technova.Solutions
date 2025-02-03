<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "technova_solutions");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_producto = $_POST["nombre_producto"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $id_proveedor = $_POST["id_proveedor"];

    // Insertar producto en la base de datos
    $sql = "INSERT INTO productos (nombre_producto, descripcion, precio, stock, id_proveedor) VALUES ('$nombre_producto', '$descripcion', '$precio', '$stock', '$id_proveedor')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto registrado con éxito.');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Consulta para obtener los proveedores
$sql_proveedores = "SELECT id_proveedor, nombre FROM proveedores";
$proveedores = $conn->query($sql_proveedores);

$conn->close();
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
    <title>Página TechNova Solutions</title>
    <link rel="stylesheet" href="tablas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    <!-- Main Content -->
    <div class="container">
        <!-- Form Section -->
        <div class="form-section">
            <h2><i class="fas fa-edit"></i> Ingresar Compra</h2>
            <form action="registrar_productos.php" method="POST">
                <table>
                    <tr>
                        <td>Nombre Producto:</td>
                        <td><input type="text" name="nombre_producto" required></td>
                    </tr>

                    <tr>
                        <td>Descripcion:</td>
                        <td><input type="text" name="descripcion" required></td>
                    </tr>

                    <tr>
                        <td>Precio:</td>
                        <td><input type="number" step="0.01" name="precio" required></td>
                    </tr>

                    <tr>
                        <td>Stock:</td>
                        <td><input type="number" name="stock" required></td>
                    </tr>

                    <tr>
                        <td>Proveedor:</td>
                        <td>
                            <select name="id_proveedor" required>
                                <option value="">Seleccione un proveedor</option>
                                <?php while ($proveedor = $proveedores->fetch_assoc()): ?>
                                    <option value="<?= $proveedor['id_proveedor'] ?>">
                                        <?= $proveedor['nombre'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><input type="submit" value="Registrar"></td>
                        <td><input type="reset" value="Limpiar"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
