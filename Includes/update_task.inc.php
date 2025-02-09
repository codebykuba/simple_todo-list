<?php

require_once __DIR__ . "/../Classes/ConfigSession.php";
require_once __DIR__ . "/../Classes/TaskMenager.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {

    //Pobranie id zadania
    $task_id = $_POST['task_id'];

    //Pobranie zadan z sesji
    $session = new ConfigSession();
    $tasks = $_SESSION['tasks'];
    unset($_SESSION['tasks']);

    //Usunecie zadanie poprzez menager
    $menager = new TaskMenager($tasks);
    $menager->updateTask($task_id);

    header("Location: ../index.php");
    die();
}
else {
    header("Location: ../index.php");
    die();
}