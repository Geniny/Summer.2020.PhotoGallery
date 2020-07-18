<?php 
    class UserService
    {
        function authorize()
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                if(isset($_POST['login']) && isset($_POST['password']))
                {
                    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
                        or die("Ошибка " . mysqli_error($link));
                    
                    $login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));
                    $password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));

                    if ($password == $repeated_password)
                    {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $query ="INSERT INTO users VALUES(NULL, '$login','$hashed_password', NULL)";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                        if($result)
                        {
                            header('Location: /index.html');
                        }
                    }
                    else
                    {
                        echo "Error";
                    }
        
                    mysqli_close($link);
                }
            }
        }

        function register()
        {
            require_once 'config.php';
 
            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['repeat_password']))
                {  
                    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
                        or die("Ошибка " . mysqli_error($link));
                    
                    $login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));
                    $password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));
                    $repeated_password = htmlentities(mysqli_real_escape_string($link, $_POST['repeat_password']));
                    
                    if ($password == $repeated_password)
                    {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $query ="INSERT INTO users VALUES(NULL, '$login','$hashed_password', NULL)";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                        if($result)
                        {
                            header('Location: /index.html');
                        }
                    }
                    else
                    {
                        echo "Error";
                    }

                    mysqli_close($link);
                }
            } 
        }
    }
 

?>