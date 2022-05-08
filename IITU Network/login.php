<?php
session_start();
// Получение доступа в базу данных
$mysql = new mysqli('localhost', 'mysql', '', 'iitu-network');
$mysql->query("SET NAMES 'utf8'");
// Проверка на ошибку подключения
if ($mysql->connect_error) {
   echo 'Error number: ' . $mysql->connect_errno . '<br>';
   echo 'Error: ' . $mysql->connect_error;
}


if ($_SESSION['user']) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<!-- change language -->
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Styles -->
   <link rel="stylesheet" href="css/my_reset.css">
   <link rel="stylesheet" href="css/normalize.css">
   <link rel="stylesheet" href="css/header.css">
   <link rel="stylesheet" href="css/login.css">
   <!-- Title -->
   <title>Login</title>
</head>

<body class="body">

   <?php
   require '_header.php';
   ?>

   <main class="main">
      <div class="container">
         <div class="block login">
            <form action="login-validation.php" method="post" class="login-form" id="login-form">
               <div id="error"><?= $_SESSION['input'] ?></div>
               <input type="email" name="email" id="email" class="input login-form__input" placeholder="Email" required>
               <input type="password" name="password" id="password" class="input login-form__input" placeholder="Password" required>
               <input type="submit" id="submit-form" value="Log in" class="button button--input">
            </form>
         </div>
      </div>
   </main>
   <!-- Для затемнения -->
   <div class="blackout"></div>

   <?php


   // function displayError() {

   // }



   $mysql->close();

   ?>
   <!-- JavaScript -->
   <script src="js/burger.js"></script>
   <script src="js/login.js"></script>
</body>


</html>