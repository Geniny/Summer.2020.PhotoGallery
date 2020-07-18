<?php

    require_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if(isset($_POST['login']) && isset($_POST['password']))
        {  

            $link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $login = $_POST['login'];
            $password = $_POST['password'];

            if ($link->connect_errno) {
                printf("Соединение не удалось: %s\n", $link->connect_error);
                exit();
            }
            
            $query = "SELECT * FROM users WHERE login = '$login'";

            if ($result = $link->query($query)) {
            
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password']))
                {
                    if (!session_start())
                    {
                        echo "session error";
                    }
                    else
                    {

                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                        echo session_status();
                    }
                    header("Location: http://".$_SERVER['HTTP_HOST']."/");
                }
            
                $result->free();
               
            }
            
            $link->close();
            exit;
        }
    } 


?>