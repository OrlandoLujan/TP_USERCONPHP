<?php

session_start();

require "database.php";

if (isset($_SESSION['id_usuario'])) {
    $records = $conn->prepare('SELECT id_usuario, email, password FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['id_usuario']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user= null;

    if (count($results) > 0) {
        $user = $results;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a Orivan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto"  rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>


<?php require 'partials/header.php'  ?>   

<?php if (!empty($user)): ?>
        <br>Bienvenido. <?= $user['email'] ?>
        <br>Te has logueado satisfactoriamente
        <a href="logout.php">Desconectarse</a>
    <?php else: ?>
 

<h1>Por favor, Inicie Sesión o Regístrese</h1>

<a href="login.php">Iniciar Sesión</a> o
<a href="signup.php">Registrarse</a>
    <?php endif; ?>

</body>
</html>