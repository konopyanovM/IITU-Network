<?php

require 'connect.php';

$discussion_id = $_GET['id'];

$discussion = $mysql->query("SELECT * FROM `discussions` WHERE `discussions`.`discussion-id` = $discussion_id")->fetch_assoc();

$upvoted_users = $mysql->query("SELECT * FROM `upvotes`")->fetch_all();

$upvotes = $discussion['upvotes'];

$isUpvoted = false;

$i = 0;

do {
   if (($upvoted_users[$i][0] == $discussion_id) && ($upvoted_users[$i][1] == $_SESSION['user'])) {
      $isUpvoted = true;
      break;
   } else {
      $isUpvoted = false;
   }
   $i++;
} while ($i < sizeof($upvoted_users));




if ($isUpvoted) {
   $mysql->query("DELETE FROM `upvotes` WHERE `id`=$_SESSION[user] AND `discussion-id`=$discussion_id");



   $upvoted_users = $mysql->query("SELECT * FROM `upvotes`")->fetch_all();

   $upvotes--;

   $mysql->query("UPDATE `discussions` SET `upvotes` = '$upvotes' WHERE `discussions`.`discussion-id` = $discussion_id");

   print_r(true);
} else {
   $mysql->query("INSERT INTO `upvotes` (`discussion-id`, `id`) VALUES ('$discussion_id', '$_SESSION[user]')");

   $upvoted_users = $mysql->query("SELECT * FROM `upvotes`")->fetch_all();

   for ($i = 0; $i < sizeof($upvoted_users); $i++) {
      if ($upvoted_users[$i][0] == $discussion_id) {
         $upvotes++;
      }
   }


   $mysql->query("UPDATE `discussions` SET `upvotes` = '$upvotes' WHERE `discussions`.`discussion-id` = $discussion_id");
   print_r(false);
}
