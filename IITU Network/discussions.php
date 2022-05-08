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
   <link rel="stylesheet" href="css/discussions.css">
   <link rel="stylesheet" href="css/header.css">
   <title>Discussions</title>
</head>

<body>

   <?php require '_header.php';
   ?>

   <main class="main">
      <div class="container">
         <div class="discussions-container">
            <div class="discussions-nav block">
               <a href="create-discussion.php" class="button discussion-nav__create">Create discussion</a>
            </div>
            <div class="discussions-body block">
               <?php
               // Получаем количество строк
               $rows = $mysql->query("SELECT COUNT(*) FROM discussions")->fetch_array()[0];
               // Создаем массив для хранения строк
               $array = array();
               $students = array();
               // Получаем строки
               $TABLE_discussions = $mysql->query("SELECT * FROM `discussions`");
               $TABLE_students = $mysql->query("SELECT * FROM `students`");

               for ($i = 0; $i < $rows; $i++) {
                  array_push($array, $TABLE_discussions->fetch_assoc());
               }

               for ($i = 0; $i < $TABLE_students->num_rows; $i++) {
                  array_push($students, $TABLE_students->fetch_assoc());
               }

               // Создаем треды (дискуссии)
               for ($i = 0; $i < $rows; $i++) {
                  print_r(createDiscussion($array[$i]['discussion-id'], $array[$i]['id'], $array[$i]['title'], $array[$i]['tags'], $array[$i]['text'], $array[$i]['upvotes'], $array[$i]['downvotes'], $array[$i]['creation-date'], $array[$i]['comments'], $array[$i]['bookmarks'], $array[$i]['date'], $array[$i]['location'], $array[$i]['time']));
               }

               ?>
            </div>
         </div>

      </div>
   </main>
   <script src="js/upvote.js"></script>
</body>

</html>

<?php

function createDiscussion($discussion_id, $id, $title, $tags, $text, $upvotes, $downvotes, $creation_date, $comments, $bookmarks, $date, $location, $time)
{
   return '
   <div class="block discussion-card card-id__' . $discussion_id . '">
      <div class="discussion-card__title">
         <a class="discussion-card__title-text" href="discussions/discussion_' . $discussion_id . '.php">' . $title . '</a>
         <p class="discussion-card__title-creator">' . getStudent($id) . '</p>
         <p class="discussion-card__title-interpunct">·</p>
         <p class="discussion-card__title-creation-date">' . $creation_date . '</p>
      </div>
      <ul class="discussion-card__tags-list">
         ' . createTags($tags) . '
      </ul>
      <p class="discussion-card__text">' . $text . '</p>
      <div class="discussion-card__footer">
         <div class="discussion-card-rating rating-id__' . $discussion_id . '">
            <p class="discussion-card-rating__upvote">+</p>
            <p class="discussion-card-rating__value">' . $upvotes . '</p>
         </div>
         <div class="discussion-card__footer-info">
            <p class="discussion-card__footer-location">' . $location . '</p>
            <p class="discussion-card__footer-date">' . $date . '</p>
            <p class="discussion-card__footer-time">' . $time . '</p>
         </div>
      </div>
   </div>
   ';
}

function createTags($string)
{
   $array = explode(',', $string);
   $result = '';
   for ($i = 0; $i < count($array); $i++) {
      $result .= "<li class='discussion-card__tags-item'>" . $array[$i] . "</li>";
   }
   return $result;
}

function getStudent($id)
{
   global $students;
   return $students[($id - 1)]['name'];
}



$mysql->close();
