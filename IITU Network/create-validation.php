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

print_r($_POST);
// Получаем данные из формы
// htmlspecialchars для того чтобы пользователь не вставил в форму свой HTML или JS.
$title = addslashes(htmlspecialchars($_POST['title']));
$text = addslashes(htmlspecialchars($_POST['text']));
$tags = addslashes(htmlspecialchars($_POST['tags']));
$date = htmlspecialchars($_POST['date']);
$location = addslashes(htmlspecialchars($_POST['location']));
$time = htmlspecialchars($_POST['time']);
// Получаем данные из БД



$creation_date = date("M j Y");


$mysql->query("INSERT INTO `discussions` (`id`, `title`, `tags`, `text`, `creation-date`, `date`, `location`, `time`) VALUES ('$_SESSION[user]', '$title', '$tags', '$text', '$creation_date','$date', '$location', '$time')");

$discussion_id = end(($mysql->query("SELECT `discussion-id` FROM `discussions`"))->fetch_all())[0];


$filename = "discussion_$discussion_id";
// Создаем отдельную страницу дискусии
$page_html =
   "
   <?php
   session_start();
   // Получение доступа в базу данных
   \$mysql = new mysqli('localhost', 'mysql', '', 'iitu-network');
   \$mysql->query(\"SET NAMES 'utf8'\");
   // Проверка на ошибку подключения
   if (\$mysql->connect_error) {
      echo 'Error number: ' . \$mysql->connect_errno . '<br>';
      echo 'Error: ' . \$mysql->connect_error;
   }

   \$discussion_id = $discussion_id;
   \$discussion = \$mysql->query(\"SELECT * FROM `discussions` WHERE `discussion-id` = \$discussion_id\")->fetch_assoc();
   ?>
   
   <!DOCTYPE html>
   <html lang='en'>
   
   <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <link rel='stylesheet' href='../css/my_reset.css'>
      <link rel='stylesheet' href='../css/normalize.css'>
      <link rel='stylesheet' href='../css/header.css'>
      <link rel='stylesheet' href='../css/discussion_page.css'>
      <title><?= \$discussion['title'] ?></title>
   </head>
   
   <body>

      <header class='header'>
      <a href='../index.php' class='header__logo logo'>
         <img src='../img/icons/logo.svg' alt='logo' class='logo__img'>
         <span class='logo__text'>International Information Technology University Network</span>
      </a>
      <div class='header__menu'>
         <nav class='header-nav'>
            <ul class='header-nav__list'>
               <li class='header-nav__item'><a href='../discussions.php' class='header-nav__link'>Discussions</a></li>
               <li class='header-nav__item'><a href='#' class='header-nav__link'>Clubs</a></li>
               <li class='header-nav__item'><a href='#' class='header-nav__link'>About</a></li>
            </ul>
         </nav>
   
         <a href='#' class='header-profile'>
            <img src='../img/icons/profile.svg' alt='profile' class='header-profile__img'>
            <p class='header-profile__text'>
               <span class='header-profile__username'>
                  <?php
                  if (\$_SESSION['user']) {
                     \$id = \$_SESSION['user'];
                     \$name = \$mysql->query(\"SELECT name FROM `students` WHERE id = '\$id'\")->fetch_assoc()['name'];
                     echo \$name;
                  }
                  ?>
               </span>
               <span class='header-profile__alias'>
                  <?php
                  if (\$_SESSION['user']) {
                     \$id = \$_SESSION['user'];
                     \$alias = \$mysql->query(\"SELECT alias FROM `students` WHERE id = '\$id'\")->fetch_assoc()['alias'];
                     echo '@' . \$alias;
                  }
   
                  ?>
               </span>
            </p>
         </a>
   
         <?php if (\$_SESSION['user']) : ?>
            <div class='header-leave button' onclick='leave()'>Leave</div>
         <?php else : ?>
            <a href='../login.php' class='header-login button'>Log in</a>
         <?php endif; ?>
   
   
      </div>
      <!-- Кнопка меню (Mobile) -->
      <div class='header__burger'>
         <span></span>
         <span></span>
         <span></span>
      </div>
   
      <script src='../js/header.js'></script>
      <script src='../js/burger.js'></script>
   
   </header>
      
      <main class='main'>
         <div class='container'>
            <div class='discussion-container'>
               <div class='discussion'>
               <div class='discussion__title'>
                  <h2 class='discussion__title-text'><?= \$discussion['title'] ?></h2>
                  <div class='discussion__title-creation-date'><?= \$discussion['creation-date'] ?></div>
               </div>
               <ul class='discussion-tags-list block'>
               <?= createTags(\$discussion['tags']) ?>
               </ul>
               <div class='discussion__body'>
                  <p class='discussion__body-text'><?= \$discussion['text'] ?></p>
               </div>
               <div class='discussion-card__footer'>
                  <div class='discussion-card-rating rating-id__" . $discussion_id . "'>
                    <p class='discussion-card-rating__upvote'>+</p>
                     <p class='discussion-card-rating__value'><?= \$discussion['upvotes'] ?></p>
                  </div>
                  <div class='discussion-card__footer-info'>
                    <p class='discussion-card__footer-location'><?= \$discussion['location'] ?></p>
                    <p class='discussion-card__footer-date'><?= \$discussion['date'] ?></p>
                   <p class='discussion-card__footer-time'><?= \$discussion['time'] ?></p>
                </div>
              </div>
         </div>
            </div>
   
            <hr class='hr hr--bold discussion-hr'>
            <?php

            \$comments = \$mysql->query('SELECT * FROM `comments` WHERE `discussion-id` = ' . \$discussion_id . '')->fetch_all();
            \$rows = sizeof(\$comments);
            ?>
            <div class='comments-container'>
               <p class='comments-data'><?= \$rows ?> comments</p>
               <form action='../create-comment.php' method='POST' class='comments-form'>
                  <textarea name='comment' id='comment' cols='30' rows='5' class='input comments-form__text'></textarea>
                  <input type='text' name='discussion_id' value='" . $discussion_id . "' class='comments-form__hidden'>
                  <input type='submit' class='button comments-form__submit'>
               </form>
               <div class='block comments'>
                  <?php
                  if (\$rows > 0) {
                     for (\$i = 0; \$i < \$rows; \$i++) {
                        \$id = \$comments[\$i][1];
                        \$text = \$comments[\$i][3];
                        \$date = \$comments[\$i][4];
                        \$name = \$mysql->query('SELECT `name` FROM `students` WHERE `id` = '.\$id.'')->fetch_row()[0];
                        print_r(createComment(\$name, \$text, \$date));
                     }
                  } else {
                     print_r('<p class=\"comments__none\">There are no comments yet.</p>');
                  }

                  ?>

               </div>
            </div>

         </div>
      </main>
      <script src='../js/upvotePage.js'></script>
   </body>
   
   </html>

   
<?php

function createComment(\$title, \$text, \$creation_date)
{
   return '
   <div class=\"block block--solid comments-card\">
       <div class=\"comments-card__header\">
          <h3 class=\"comments-card__title\">' . \$title . '</h3>
         <p class=\"comments-card__date\">' . \$creation_date . '</p>
      </div>
      <p class=\"comments-card__body\">' . \$text . '</p>
   </div>
   ';
}

function getStudent(\$id)
{
   global \$students;
   return \$students[(\$id - 1)]['name'];
}

function createTags(\$string)
{
   \$array = explode(',', \$string);
   \$result = '';
   for (\$i = 0; \$i < count(\$array); \$i++) {
      \$result .= \"<li class='discussion-tags-list__item'>\" . \$array[\$i] . \"</li>\";
   }
   return \$result;
}

\$mysql->close();
";


$file = fopen("discussions/$filename.php", "w");

fwrite($file, $page_html);

fclose($file);

header('Location: discussions.php');
exit;


$mysql->close();
