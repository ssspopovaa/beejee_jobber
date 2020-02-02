<?php

/**
 * UserController
 */
class UserController
{
      
    /**
     * Action for admin login
     */
    public function actionLogin()
    {
        // vars for a form
        $login = false;
        $password = false;
        
        // form processing
        if (isset($_POST['submit'])) {
            // If form was send 
            // Get data from form
            $login = $_POST['login'];
            $password = $_POST['password'];

            // Errors flag
            $errors = false;

            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }

            // Check for user existing
            $userId = User::checkUserData($login, $password);

            if ($userId == false) {
                // If data is wrong - show error
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // If data is right - remember user in session
                User::auth($userId);

                // Redirect on main page 
                header("Location: /");
            }
        }

        // require view
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * Remove user data from session
     */
    public function actionLogout()
    {        
        session_start();
        unset($_SESSION["user"]);
        
        // Redirect user on main page
        header("Location: /");
    }
}
