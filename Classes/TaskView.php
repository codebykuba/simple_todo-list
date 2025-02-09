<?php

require_once "ConfigSession.php";

Class TaskView {

    private $tasks;
    private $errors = NULL;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }

    public function setErrors() {
        if(isset($_SESSION['errors'])) {
            $this->errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }
    }

    public function showTasks() {
        if(isset($this->tasks)) {
            foreach($this->tasks as $task) {
                
                echo '<div class="task_page">';
                    echo '<p class="title"><strong>Zadanie nr. ' . htmlspecialchars($task['id']) . ':</strong> ' . htmlspecialchars($task['nazwa']) . '</p>';
                    echo '<p>Status zadania: <strong>' . htmlspecialchars($task['status']) . '</strong></p>';
                    echo '<p>Priorytet: <strong>' . htmlspecialchars($task['priorytet']) . '</strong></p>';
                    echo '<p>Data utworzenia: <strong>' . htmlspecialchars($task['data']) . '</strong></p>';
                    
                    echo '<div class="buttons">';
                        $this->deleteButton($task);
                        $this->doneButton($task);
                    echo '</div>';
                echo '</div>';
            }
        } 
        else {
            echo '<div class="messages">';
                echo '<p class="message">Na razie tu pusto :)</p>';
                echo '<p class="message">Dodaj jakieś zadanie.</p>'; 
            echo '</div>';
        }
    }

    private function deleteButton($task) {
        echo '<form class="task_button" action="Includes/delete_task.inc.php" method="POST">';
            echo '<input type="hidden" name="task_id" value="' . htmlspecialchars($task['id']) . '">';
            echo '<button class="list" type="submit">Usuń zadanie</button>';
        echo '</form>';
    }

    private function doneButton($task) {
        echo '<form class="task_button" action="Includes/update_task.inc.php" method="POST">';
            echo '<input type="hidden" name="task_id" value="' . htmlspecialchars($task['id']) . '">';
            
        if ($task['status'] === 'wykonano') {
            echo '<button class="checked" type="submit">✔️</button>';
        }
        else {
            echo '<button class="not_checked" type="submit">✔️</button>';
        }
        
        echo '</form>';
    }

    public function showErrors() {

    }
}