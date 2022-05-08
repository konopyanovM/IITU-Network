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
   <link rel="stylesheet" href="css/index.css">
   <!-- Title -->
   <title>IITU Network</title>
</head>

<body class="body">

   <?php
   require '_header.php';
   ?>

   <!-- <?php echo "Hi"; ?> -->
   <main class="main">
      <section class="welcome section">
         <div class="container">
            <h1 class="welcome__title">Hey! <br />
               You are on the unofficial website of the University of Information Technology.</h1>
         </div>
      </section>
   </main>
   <!-- Для затемнения -->
   <div class="blackout"></div>

   <!-- PHP -->
   <?php



   ?>



   <!-- JavaScript -->

</body>

</html>

<?php
$mysql->close();
