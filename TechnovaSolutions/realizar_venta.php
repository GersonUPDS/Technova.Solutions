<?php
// Conectar a la base de datos
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

// Obtener los productos de la base de datos
$sql = "SELECT * FROM Productos WHERE Stock > 0";
$stmt = $pdo->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar la venta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_productos = $_POST["producto"];
    $cantidad = $_POST["cantidad"];

    // Obtener el precio y stock del producto seleccionado
    $stmt = $pdo->prepare("SELECT Precio, Stock FROM Productos WHERE Id_Productos = ?");
    $stmt->execute([$id_productos]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto && $producto["Stock"] >= $cantidad) {
        $total = $producto["Precio"] * $cantidad;

        // Insertar la venta en la base de datos
        $stmt = $pdo->prepare("INSERT INTO Ventas (Id_Productos, Cantidad, Total) VALUES (?, ?, ?)");
        $stmt->execute([$id_productos, $cantidad, $total]);

        // Actualizar el stock del producto
        $stmt = $pdo->prepare("UPDATE Productos SET Stock = Stock - ? WHERE Id_Productos = ?");
        $stmt->execute([$cantidad, $id_productos]);

        echo "<script>alert('Venta realizada con éxito. Total: $" . number_format($total, 2) . "');</script>";
    } else {
        echo "<script>alert('Stock insuficiente.');</script>";
    }
}
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
    <title>Generar Venta</title>
    <link rel="stylesheet" href="tablas.css">
 
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
            <h2><i class="fas fa-edit"></i> Registrar Venta</h2>
            <form action="realizar_venta.php" method="POST">
                <table>
                    <tr>
                        <td><label for="productos">Seleccione un producto:</label></td>
                        <td><select name="producto" id="productos" required>
                        <option value="">-- Seleccione --</option>
                            <?php foreach ($productos as $producto): ?>
                                <option value="<?= $producto['Id_Productos'] ?>" data-precio="<?= $producto['Precio'] ?>">
                            <?= $producto['Nombre_Producto'] ?> - $<?= number_format($producto['Precio'], 2) ?> (Stock: <?= $producto['Stock'] ?>)
                        </option>
                        <?php endforeach; ?>
                        </select></td>
                    </tr>

                    <tr>
                        <td><label for="cantidad">Cantidad:</label></td>
                        <td><input type="number" name="cantidad" id="cantidad" min="1" required></td>
                    </tr>

                    <tr>
                        <td>Total: $<span id="total">0.00</span></td>
                    </tr>

                    <tr>
                        <td><input type="submit" value="Realizar Venta"></td>
                        <td><input type="reset" value="Limpiar"></td>
                    </tr>
                </table> 
            </form>
        </div>
    </div>

        <script>
            document.getElementById("productos").addEventListener("change", calcularTotal);
            document.getElementById("cantidad").addEventListener("input", calcularTotal);

            function calcularTotal() {
                let producto = document.getElementById("productos");
                let cantidad = document.getElementById("cantidad").value;
                let precio = producto.options[producto.selectedIndex].getAttribute("data-precio");

                if (precio && cantidad > 0) {
                    let total = precio * cantidad;
                    document.getElementById("total").textContent = total.toFixed(2);
                } else {
                    document.getElementById("total").textContent = "0.00";
                }
            }
        </script>

</body>
</html>


