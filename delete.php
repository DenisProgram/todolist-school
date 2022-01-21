<?php
    require "configDB.php";
    $id = $_GET["id"];

    $preUserDb = substr($_SERVER["HTTP_REFERER"], 17, -4); // не точно база данных
    $userDb = ( ($preUserDb === false) || ($preUserDb === "index") ) ? "tasks" : $preUserDb; // точно база данных

    $sql = 'DELETE FROM `' .$userDb.'` WHERE `id` = ? ';
    $query = $pdo->prepare($sql);
    $query->execute([$id]);

    header("Location: ".$_SERVER['HTTP_REFERER']);
?>