<?php /** @var string $title */ ?>
<?php require "configDB.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
</head>
<body>

<menu class="menu">


</menu>
<aside>

    <a href="index.php" class="aside-link">Входящие</a>
    <a href="donow.php" class="aside-link"> Текущие дела</a>
    <a href="exam.php" class="aside-link">ЕГЭ</a>
    <a href="schooltasks.php" class="aside-link">Школа</a>
    <a href="deepwork.php" class="aside-link">Уровень мастера</a>
    <a href="later.php" class="aside-link">Когда-нибудь потом</a>
    <a href="archive.php" class="aside-link">Архив</a>
</aside>
<div class="container">
    <h1 class="page-title"><?=$title?></h1>
    <form action="/add.php" method="post">
        <input type="text" name="task" id="task" placeholder="Эх, мне бы..." class="form-control">
        <button type="submit" name="sendTak" class="send-btn btn btn-success">Добавить</button>
    </form>

