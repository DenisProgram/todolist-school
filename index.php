<?php $title = "📮 Входящие" ?>

<?php require "header.php"?>

    <?php

    $startSymbol = strripos($_POST["task"], "~");
    echo $_POST["task"][$startSymbol];
    echo "<ul>";

    $query = $pdo->query("SELECT * FROM `tasks` ORDER BY `priority`");
    while ($row = $query->fetch(PDO::FETCH_OBJ))
    {
        
        if (($row->priority == "p1") || ($row->priority == "p0"))
        {
            echo '<li class="task-content"><b>'. $row->task . '<span class="task_priority code-red">' .$row->priority. '</span>'.'</b><a href="/delete.php?id='.$row->id.'"><button><img src="cross.png" alt="cross" class="cross"></button></a> </li>';
        }
        else
        {
            echo '<li class="task-content"><b>'. $row->task . '<span class="task_priority code-light">' .$row->priority. '</span>' . '</b><a href="/delete.php?id='.$row->id.'"><button><img src="cross.png" alt="cross" class="cross"></button></a> </li>';
        }
    }
    
    echo "</ul>";

    ?>
    

    </div>
</body>
</html>