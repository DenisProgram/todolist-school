<?php
    // Конфигурируем базу данных
    require "configDB.php";

    // получаем задачу из POST 
    $task = $_POST["task"];

    // Формируем задачу для записи в бд
    function normalizeTask(string $inputTask):string
    {
        $trimmedInputTask = trim($inputTask);
        echo "Important <br>";
        echo $trimmedInputTask . "<br>";
        $taskWithoutDate = strpos($trimmedInputTask, "сегодня") ? str_replace("сегодня", "", $trimmedInputTask) : $trimmedInputTask;
        echo $taskWithoutDate . "<br>";
        $priorityPart = ($taskWithoutDate[-2] === "p") ? ($taskWithoutDate[-2] . $taskWithoutDate[-1]) : null;
        echo $priorityPart . "<br>";
        $taskWithoutPriority = is_null($priorityPart) ? $taskWithoutDate : substr($inputTask, 0, -2) ; 
        // модифицируем введённую задачу и передаём её дальше
        echo $taskWithoutPriority . "<br>";

        $userDbPart = (strripos($taskWithoutPriority, "~") === false) ? null : 
         substr($taskWithoutPriority, strripos($taskWithoutPriority, "~") + 1, strlen($taskWithoutPriority) - 1);
        $normalTask = is_null($userDbPart) ? $taskWithoutPriority : substr($taskWithoutPriority, 0, strripos($inputTask, "~") );
        return $normalTask;
    }

    // Ищем в тексте приоритетность задачи
    function setPriority(string $inputTask):string
    {
        $trimmedInputTask = trim($inputTask);
        $priorityIsSet = $trimmedInputTask[-2] === "p";
        $priorityIsSetByDate = strpos($trimmedInputTask, "сегодня");
        if ($priorityIsSetByDate)
        {
            echo $trimmedInputTask;
            echo "<br>";
            $trimmedInputTask = str_replace("сегодня", "", $trimmedInputTask);
            echo $trimmedInputTask;
            echo "<br>";
            return "p1";
        }
        return $priorityIsSet ? $trimmedInputTask[-2] . $trimmedInputTask[-1] : "p2"; // p2 - значение по умолчанию
    }

    // Получаем лист, в который хочется положить задачу
    function findUserDB(string $inputTask, string $preferredDb):string
    {
        $trimmedInputTask = trim($inputTask);
        $priorityPart = ($trimmedInputTask[-2] === "p") ? ($trimmedInputTask[-2] . $trimmedInputTask[-1]) : null;
        $taskWithoutPriority = is_null($priorityPart) ? $inputTask : substr($inputTask, 0, -2) ;
        $userDbPart = (strripos($taskWithoutPriority, "~") === false) ? null :  
        substr($taskWithoutPriority, strripos($taskWithoutPriority, "~") + 1, strlen($taskWithoutPriority) - 1);

        if (is_null($userDbPart))
        {
            return $preferredDb; // по умолчанию все задачи добавляются в таблицу tasks
        }
        return $userDbPart;
    }




    // задаём параметры задачи для записи в таблицу
    $wantedDb = substr($_SERVER['HTTP_REFERER'], 17, -4);
    $correctDB = ( ($wantedDb === false) || ($wantedDb === "index") ) ? "tasks" :  $wantedDb;
    $userDb = trim(findUserDB($_POST["task"], $correctDB));
    $priority = trim(setPriority($_POST["task"]));
    $task = normalizeTask($_POST["task"]);

    // отладка add.php
    echo "Задача: <b>" . $task . "</b><br>";
    echo "База данных, для добавления задачи: <b>" . $userDb . "</b><br>";
    echo "Приоритетность задачи: <b>" . $priority . "</b><br>";
    //echo $userDb . " <br> " . $priority . "<br> " . $task . "<br>";

    // проверяем введённый текст и выполняем скрипт
    if ($task === '')
    {
        echo "Введите задание."; // выкидываем ошибку при пустой задаче
        exit();
    }
    // записываем всё в бд
    $sql = "INSERT INTO ".$userDb."(task, priority) VALUES(:task, :priority)";
    $query = $pdo->prepare($sql);
    $query->execute(['task' => $task, 'priority' => $priority]);

    // возращаемся на страницу назад
    header("Location: ".$_SERVER['HTTP_REFERER']);

