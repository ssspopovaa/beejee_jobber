<?php

/**
 * SiteController
 */
class SiteController
{
    /**
     * Action for main page
     */
    public function actionIndex($page = 1)
    {
        // Set sorting by default by name down if not set
        if(!$_SESSION['sort']) {
            $_SESSION['sort'] = 1;
        };
        
        $total = Task::getTotalTasks();
        $tasks = Task::getAllTasks($page, $_SESSION['sort']);
        
        // Create Pagination object
        $pagination = new Pagination($total, $page, Task::SHOW_BY_DEFAULT, 'page-');

        // wiev main page
        require_once(ROOT . '/views/site/index.php');
        return true;
    }

    /**
     * Action for creating task
     */
    public function actionCreate()
    {
        // vars for form
        $name = false;    
        $email = false;
        $text = false;
        $result = false;
        $success = '';
        
        // Processing form
        if (isset($_POST['submit'])) {
            
            // If form was send 
            // get form data
            $email = $_POST['email'];
            $text = htmlspecialchars($_POST['description']);
            $name = htmlspecialchars($_POST['name']);
         
            // Errors flag
            $errors = false;
            
            // Fields validation            
            if (strlen($name) < 2 ) {
                $errors[] = 'Слишком короткое имя';
            }
            
            if (strlen($text) < 1 ) {
                $errors[] = 'Заполните описание задачи';
            }
            
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            
            if (empty($errors)) {
                if(Task::saveTask($name, $email, $text)) {
                    $success = 'Задача успешно создана';
                } else {
                    $errors[] = 'Не удалось добавить запись в базу данных';
                };
            }
        }

        // require view
        require_once(ROOT . '/views/site/create.php');
        return true;
    }
    /** 
     * Set session var for sorting type 
     * 
     * @param type $id
     */
    public function actionSort($id) {
        $_SESSION['sort'] = $id;
        
        // Return user on page from it went
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }
    /**
     * Editing task
     * @param type $id
     * @return boolean
     */
    public function actionEdit($id) {
        if (User::isGuest()) {
            header("Location: / ");
        }
            
        $oldValues = Task::getTaskById(intval($id));
        // Set previous form values 
        $name = $oldValues['user'];    
        $email = $oldValues['email'];
        $done = $oldValues['done'];
        $checked = $oldValues['checked'];
        $text = $oldValues['text'];
        $result = false;
        $success = ''; 
        
        // If form was send
        if (isset($_POST['submit'])) {
             
            // Get field data
            $done = 1;
            $email = $_POST['email'];
            
            $textOriginal = $oldValues['text'];    
            $text = htmlspecialchars($_POST['description']);
            if ($textOriginal != $text) {
                $checked = 1; 
            }

            $name = htmlspecialchars($_POST['name']);
            // Errors flag
            $errors = false;
                        
            if (strlen($name) < 2 ) {
                $errors[] = 'Слишком короткое имя';
            }
            
            if (strlen($text) < 1 ) {
                $errors[] = 'Заполните описание задачи';
            }
            // Fields validation
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            
            if (empty($errors)) {
                if (Task::updateTask($id, $name, $email, $done, $checked, $text)) {
                    $success = 'Задача успешно обновлена';
                } else {
                    $errors[] = 'Не удалось обновить запись в базе данных';
                };
            }
        }

        // require view
        require_once(ROOT . '/views/site/edit.php');
        return true;
    }
}
