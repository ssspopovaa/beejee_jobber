<?php

/**
 * Task model class
 */
class Task {

        // count tasks on page for pagination
        const SHOW_BY_DEFAULT = 3;

        /**
         * Saving new task
         * 
         * @param type $name
         * @param type $email
         * @param type $text
         * 
         * @return type
         */
        public static function saveTask($name, $email, $text) {
        // connect to database
        $db = Db::getConnection();

        // sql for insert data
        $sql = 'INSERT INTO tasks (user, email, done, checked, text) '
                . 'VALUES (:user, :email, 0, 0, :text)';

        // prepare and bind request sql
        $result = $db->prepare($sql);
        $result->bindParam(':user', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
                
        return $result->execute();
    }
    /**
     * @param type $page
     * @param type $sort
     * 
     * @return type
     */
    public static function getAllTasks($page = 1, $sort = 1)
    {
        $limit = self::SHOW_BY_DEFAULT;
        // Offset for request
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        // connect to database
        $db = Db::getConnection();

        $sorting = '';
        
        switch ($sort) {
            case 1:
                $sorting .= ' order by user asc';
                break;
            case 2:
                $sorting .= ' order by user desc ';
                break;
            case 3:
                $sorting .= ' order by done asc';
                break;
            case 4:
                $sorting .= ' order by done desc ';
                break;
            case 5:
                $sorting .= ' order by email asc';
                break;
            case 6:
                $sorting .= ' order by email desc';
                break;
            
        }
        // SQL for select all tasks
        $sql = 'SELECT id, user, email, done, checked, text FROM tasks '
                . $sorting
                . ' LIMIT :limit OFFSET :offset ';

        // prepare and bind request
        $result = $db->prepare($sql);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);
        $result->execute();

        // get and return result
        $i = 0;
        $tasks = array();
        while ($row = $result->fetch()) {
            $tasks[$i]['id'] = $row['id'];
            $tasks[$i]['user'] = $row['user'];
            $tasks[$i]['email'] = $row['email'];
            $tasks[$i]['done'] = $row['done'];
            $tasks[$i]['checked'] = $row['checked'];
            $tasks[$i]['text'] = $row['text'];
            $i++;
        }
        return $tasks;
    }
    /**
     * get count all tasks
     * @return count
     */
    public static function getTotalTasks()
    {
        // connect to database
        $db = Db::getConnection();

        // sql for request
        $sql = 'SELECT count(id) AS count FROM tasks';
        $result = $db->prepare($sql);
        $result->execute();

        $row = $result->fetch();
        return $row['count'];
    }
    /**
     * Update edited task
     * 
     * @param type $id
     * @param type $user
     * @param type $email
     * @param type $done
     * @param type $checked
     * @param type $text
     * 
     * @return type
     */
    public static function updateTask($id, $user, $email, $done, $checked, $text)
    {
       //connect to database
        $db = Db::getConnection();

        // sql text for update
        $sql = ' UPDATE tasks 
                SET tasks.user = :user,
                    tasks.email = :email, 
                    tasks.done = :done, 
                    tasks.checked = :checked, 
                    tasks.text = :text 
                WHERE tasks.id = :id ';
        
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user', $user, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':done', $done, PDO::PARAM_INT);
        $result->bindParam(':checked', $checked, PDO::PARAM_INT);
        $result->bindParam(':text', $text, PDO::PARAM_STR);
        
        return $result->execute();
    }
    /**
     * Getting task by id
     * 
     * @param type $id
     * 
     * @return type
     */
    public static function getTaskById($id) {
        // connect to database
        $db = Db::getConnection();

        // sql for select task
        $sql = 'SELECT * '
              . ' FROM tasks'
              . ' WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        return $row;    
    }
}
