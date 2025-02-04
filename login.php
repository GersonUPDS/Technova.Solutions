<?php
//Maneja la validación del usuario.
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario existe
    $stmt = $pdo->prepare("
        SELECT u.Id_Usuario, u.Contrasena, r.Cargo 
        FROM Usuario u
        INNER JOIN Roles r ON u.Id_Usuario = r.Id_Usuario
        WHERE u.Email = ?
    ");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['Contrasena'])) {
        $_SESSION['user_id'] = $usuario['Id_Usuario'];
        $_SESSION['role'] = $usuario['Cargo'];
        header('Location: ../TECHNOVASOLUTIONS/dashboard.php');
    } else {
        echo "Credenciales inválidas.";
    }
}
?>