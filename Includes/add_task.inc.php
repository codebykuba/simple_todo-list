<?php

require_once __DIR__ . "/../Classes/ConfigSession.php";
require_once __DIR__ . "/../Classes/TaskMenager.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {

    //Pobranie danych od uzytkownika
    $nazwa = $_POST["nazwa"];
    $priorytet = $_POST["priorytet"];

    //Uruchomienie sesji
    $session = new ConfigSession();
        
        //Obsluga bledow
        //1. Puste pola
        if(empty($nazwa) || ($priorytet === 'none')) {
            $errors['empty'] = "Wypełnij wszystkie pola.";
        }

        //2. Za dluga nazwa zadania
        if(strlen($nazwa) >= 100) {
            $errors['too_long'] = "Nazwa zadania jest zbyt długa.";
        }

            //Jesli wystapily bledy
            if(isset($errors) && !empty($errors)) {
                
                $_SESSION["errors"] = $errors;

                //Dane do zapisania w polach w przypadku blędu
                $_SESSION['data'] = array(
                    'nazwa' => $nazwa,
                    'priorytet' => $priorytet
                );

                header("Location: ../index.php");
                die();
            }

    //Przechwycenie listy z sesji i jej wyczyszczenie
    $tasks = $_SESSION['tasks'];
    unset($_SESSION['tasks']);

    //Utworzenie nowego zadania pobranych danych
    if($tasks == NULL) {
        $id = 1;
    }
    else {
        $id = (count($tasks) + 1);
    }

    $new_task = [
        'id' => $id,
        'nazwa' => $nazwa,
        'status' => 'w trakcie',
        'priorytet' => $priorytet,
        'data' => date("Y-m-d")
    ];

    //Przekazanie nowego zadania do menadzera
    $menager = new TaskMenager($tasks);
    $menager->addNewTask($new_task);

    header("Location: ../index.php");
    die();
}
else {
    header("Location: ../index.php");
    die();
}