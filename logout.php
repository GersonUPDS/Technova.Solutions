<?php
session_start();
session_destroy(); // Elimina todas las variables de sesión
header("Location: index.html"); // Redirige al formulario de inicio de sesión
exit();
?>
