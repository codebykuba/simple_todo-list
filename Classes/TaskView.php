<?php

require_once "ConfigSession.php";

Class TaskView {

    private $tasks;
    private $errors = NULL;
    private $data = NULL;

    public function __construct($tasks) {
        $this->tasks = $tasks;

        if(isset($_SESSION['data'])) {
            $this->data = $_SESSION['data'];
            unset($_SESSION['data']);
        }
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
        if(isset($this->errors['empty'])) {
            echo '<p class="error">' . htmlspecialchars($this->errors['empty']) . '</p>';
        }

        if(isset($this->errors['too_long'])) {
            echo '<p class="error">' . htmlspecialchars($this->errors['too_long']) . '</p>';
        }
    }

    public function showForm() {
        echo '<div class="form">'; 
            echo '<form class="add" action="Includes/add_task.inc.php" method="POST">';
                                
                //Pole nazwa zadania
                echo '<label for="nazwa">Podaj treść zadania</label>';

                    if(isset($this->data['nazwa'])) {
                        echo '<input type="text" id="nazwa" name="nazwa" placeholder="Treść zadania..." value="' . htmlspecialchars($this->data['nazwa']) . '">';
                    }
                    else {
                        echo '<input type="text" id="nazwa" name="nazwa" placeholder="Treść zadania...">';
                    }

                //Pole priorytetu zadania
                echo '<label for="priorytet">Priorytet zadania</label>';
                
                    if(isset($this->data['priorytet'])) {
                        
                        switch($this->data['priorytet']) {
                            case 'wysoki':
                                echo '<select id="priorytet" name="priorytet">';
                                    echo '<option value="none">Wybierz opcję...</option>';
                                    echo '<option value="wysoki" selected>Wysoki</option>';
                                    echo '<option value="średni">Średni</option>';
                                    echo '<option value="niski">Niski</option>';
                                echo '</select>';
                            break;
                            case 'średni':
                                echo '<select id="priorytet" name="priorytet">';
                                    echo '<option value="none">Wybierz opcję...</option>';
                                    echo '<option value="wysoki">Wysoki</option>';
                                    echo '<option value="średni" selected>Średni</option>';
                                    echo '<option value="niski">Niski</option>';
                                echo '</select>';
                            break;
                            case 'niski':
                                echo '<select id="priorytet" name="priorytet">';
                                    echo '<option value="none">Wybierz opcję...</option>';
                                    echo '<option value="wysoki">Wysoki</option>';
                                    echo '<option value="średni">Średni</option>';
                                    echo '<option value="niski" selected>Niski</option>';
                                echo '</select>';
                            break;
                            default:
                                echo '<select id="priorytet" name="priorytet">';
                                    echo '<option value="none">Wybierz opcję...</option>';
                                    echo '<option value="wysoki">Wysoki</option>';
                                    echo '<option value="średni">Średni</option>';
                                    echo '<option value="niski">Niski</option>';
                                echo '</select>';
                        }
                    }
                    else {
                        echo '<select id="priorytet" name="priorytet">';
                            echo '<option value="none">Wybierz opcję...</option>';
                            echo '<option value="wysoki">Wysoki</option>';
                            echo '<option value="średni">Średni</option>';
                            echo '<option value="niski">Niski</option>';
                        echo '</select>';
                    }
        
                echo '<div class="submit_row">';
                    echo '<button class="sub" type="submit">Dodaj zadanie</button>';
                echo '</div>';
            echo '</form>';       
        echo '</div>';
    }
}