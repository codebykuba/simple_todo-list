<?php

Class TaskMenager {
    
    private $tasks;
    private $new_task;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }

    public function addNewTask($new_task) {
        $this->new_task = $new_task;
        $this->tasks[] = $this->new_task;

        $this->saveInFile();
    }

    public function deleteTask($id) {
        unset($this->tasks[($id-1)]);

            //Odswiezenie indeksow zadan
            $new_id = 1;

            foreach($this->tasks as $task) {
                $task['id'] = $new_id;
                $new_tasks[] = $task;
                $new_id++;
            }

            $this->tasks = $new_tasks;

        $this->saveInFile();
    }
    
    public function updateTask($id) {
        
        if( $this->tasks[($id-1)]['status'] == 'w trakcie') {
            $this->tasks[($id-1)]['status'] = 'wykonano';
        }
        else {
            $this->tasks[($id-1)]['status'] = 'w trakcie';
        }

        $this->saveInFile();
    }

    private function saveInFile() {
        try {
            $json_data = json_encode($this->tasks, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } 
        catch (JsonException $e) {
            die($e->getMessage());
        }

        file_put_contents(__DIR__ . '/../tasks.json', $json_data);
    }
}