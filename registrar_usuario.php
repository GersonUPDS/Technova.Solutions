<?php
//MANEJA EL REGISTRO DE USUARIOS
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $género = $_POST['género'];
    $estado_civil = $_POST['estado_civil'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $cargo = $_POST['cargo'];  // 'Administrador', 'Supervisor' o 'Cajero'

    try {
        // 1. Insertar en la tabla `Personal`
        $sqlPersonal = "INSERT INTO Personal (Nombre, Apellidos, Direccion, Telefono, Fecha_nacimiento, Género, Estado_civil) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sqlPersonal);
        $stmt->execute([$nombre, $apellidos, $direccion, $telefono, $fecha_nacimiento, $género, $estado_civil]);
        $id_personal = $pdo->lastInsertId(); // Obtener el ID del personal creado

        // 2. Insertar en la tabla `Usuario`
        $sqlUsuario = "INSERT INTO Usuario (Email, Contrasena, Id_Personal) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sqlUsuario);
        $stmt->execute([$email, $password, $id_personal]);
        $id_usuario = $pdo->lastInsertId(); // Obtener el ID del usuario creado

        // 3. Insertar en la tabla `Roles`
        $sqlRol = "INSERT INTO Roles (Id_Usuario, Cargo) VALUES (?, ?)";
        $stmt = $pdo->prepare($sqlRol);
        $stmt->execute([$id_usuario, $cargo]);
        $id_rol = $pdo->lastInsertId(); // OBTENER EL Id_Roles RECIÉN INSERTADO
        
        // Definir permisos por rol
        $permisos = [
            'Administrador' => ['Gestionar usuarios', 'Gestionar inventario', 'Ver reportes', 'Registrar ventas'],
            'Supervisor' => ['Gestionar inventario', 'Ver reportes', 'Registrar ventas'],
            'Cajero' => ['Registrar ventas'],
    ];

    // Verificar si el rol tiene permisos definidos y asignarlos
    if (isset($permisos[$cargo])) {
        foreach ($permisos[$cargo] as $permiso) {
            $sqlPermiso = "INSERT INTO Permiso (Id_Roles, Descripcion) VALUES (?, ?)";
            $stmt = $pdo->prepare($sqlPermiso);
            $stmt->execute([$id_rol, $permiso]);
    }
    }

        echo "Usuario registrado correctamente.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
