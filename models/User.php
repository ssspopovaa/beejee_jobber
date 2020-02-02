<?php

/**
 * Class User model
 */
class User
{
    /**
     * Check for existing users data
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Password</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email, $password)
    {
        // connect to database
        $db = Db::getConnection();

        // sql request text
        $sql = 'SELECT * FROM admins WHERE login = :login AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();

        $user = $result->fetch();

        if ($user) {
        
            // If exist - return user id
            return $user['id'];
        }
        
        return false;
    }

    /**
     * Save user
     * @param integer $userId <p>user id</p>
     */
    public static function auth($userId)
    {
        // Save in session
        $_SESSION['user'] = $userId;
    }

    /**
     * Return user id or redirect to login page
     * @return string <p>User id</p>
     */
    public static function checkLogged()
    {
        // If session exist - return user id
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Check is user guest
     * @return boolean
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Check name > 2 
     * @param string $name 
     * @return boolean 
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * @param string $email <p>E-mail</p>
     * @return boolean 
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}
