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
// Код


// Получаем данные из формы
// htmlspecialchars для того чтобы пользователь не вставил в форму свой HTML или JS.
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
// Получаем данные из БД
$user = $mysql->query("SELECT * FROM `students` WHERE email = '$email'")->fetch_assoc();


if (!empty($user)) {
   inputValidation($email, $pass);
   if (userValidation($user, $email, $password)) {
      $_SESSION['user'] = $user['id'];
   } else {
   }
} else {
}


header('Location: login.php');
exit;

function inputValidation($email, $pass)
{
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'valid';
   } else {
      echo 'invalid';
   }
}

function userValidation($user, $email, $pass)
{
   if (md5($pass) == $user['password'] && $email == $user['email']) {
      return TRUE;
   } else {
      return FALSE;
   }
}
$mysql->close();
