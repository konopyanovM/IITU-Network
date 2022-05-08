<?php

require 'connect.php';

$text = $_POST['comment'];

$discussion_id = $_POST['discussion_id'];

$creation_date = date("M j Y");

$mysql->query("INSERT INTO `comments` (`id`, `discussion-id`, `text`, `creation-date`) VALUES ('$_SESSION[user]', '$discussion_id', '$text', '$creation_date')");


header('Location: discussions/discussion_' . $discussion_id . '.php');
exit;


$mysql->close();
