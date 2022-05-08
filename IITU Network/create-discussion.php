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
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/my_reset.css">
   <link rel="stylesheet" href="css/normalize.css">
   <link rel="stylesheet" href="css/header.css">
   <link rel="stylesheet" href="css/create_discussion.css">
   <title>Create discussion</title>
</head>

<body>

   <?php require '_header.php';
   ?>

   <main class="main">
      <div class="container">
         <div class="block create">
            <form action="create-validation.php" method="POST" class="create-form">
               <label for="title" class="create-label">Title *</label>
               <input type="text" name="title" id="title" class="input create-input" autocomplete="off" required>
               <label for="text" class="create-label">Additional Information</label>
               <input type="text" name="text" id="text" class="input create-input" autocomplete="off">
               <label for="tags" class="create-label">Tags *</label>
               <input type="text" name="tags" id="tags" class="input create-input" autocomplete="off" required>
               <hr class="hr hr--bold create-hr">
               <label for="date" class="create-label">Date</label>
               <input type="date" name="date" id="date" class="input create-input">
               <label for="location" class="create-label">Location</label>
               <input type="text" name="location" id="location" class="input create-input" autocomplete="off">
               <label for="time" class="create-label">Time</label>
               <input type="time" name="time" id="time" class="input create-input">
               <input type="submit" id="submit-form" value="Create" class="button--input">
            </form>
         </div>
      </div>
   </main>

</body>

</html>