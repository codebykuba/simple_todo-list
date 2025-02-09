<?php 
    require_once __DIR__ . "/Classes/ConfigSession.php";
    require_once __DIR__ . "/Classes/TaskMenager.php";
    require_once __DIR__ . "/Classes/TaskView.php";

    //Uruchomienie sesji
    $session = new ConfigSession();
    
    //Pobranie listy zadań z pliku json
    $file_data = file_get_contents("tasks.json");

    //Dekodowanie pliku json
    try {
        $tasks = json_decode($file_data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    } 
    catch (JsonException $e) {
        die($e->getMessage());
    }

    //Przekazanie listy do sesji
    $_SESSION['tasks'] = $tasks;
    
    //Utworzenie klasy view
    $view = new TaskView($tasks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wdth,wght@101.7,200..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:wght@100;400&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>ToDo list</title>
</head>
<body>

    <div class="header">
        <h2>To Do list</h2>
    </div>

    <div class="container">
        <div class="all_tasks">

            <h3>Twoja lista zadań</h3>

            <?php 
                $view->showTasks();
            ?>

        </div>

        <div class="add_tasks">

            <h3>Dodaj nowe zadanie</h3>

            <?php 
                $view->showForm();
            ?>

            <?php 
                $view->setErrors();
            ?>

            <div class="errors">

                <?php 
                    $view->showErrors();
                ?>

            </div>

        </div>
    </div>
</body>
</html>