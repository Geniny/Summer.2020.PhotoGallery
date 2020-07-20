<!DOCTYPE html>
<html>

<head>
    <title>PhotoGallery - Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/site.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>

<body>
    <?php
    require 'views/components/header.php';
    $login = $password = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        require_once 'php/config.php';
        require_once 'views/components/modal_message.php';

        if(isset($_POST['login']) && isset($_POST['password']))
        {  

            $link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));
            $password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));

            if ($link->connect_errno) {
                printf("Соединение не удалось: %s\n", $link->connect_error);
                exit();
            }
            
            $query = "SELECT * FROM users WHERE login = '$login'";
            $result = $link->query($query);
            $row = $result->fetch_assoc();
            if (isset($row['login'])) 
            {
                
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
                else
                {
                    show_modal_message("Incorrect password!");
                }
                
                $result->free();
                
            }
            else
            {
                show_modal_message("Can't find user with this email!");
            }

            
            $link->close();
        }
    } 

    ?>

    <div class="centered bordered-container vertical-centered">
        <form method="post" action="/signin">
            <div class="form-group" >
                <label for="login">Email</label>
                <input type="text" class="form-control" name="login" value = "<?php echo $login;?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" value = "<?php echo $password;?>">
            </div>
            <div class = "text-center">
                <button type="submit" class="btn btn-primary btn-block " style="margin-top: 5%;">Sign in</button>
            </div>
        </form>
    </div>
    
    <div class='centered bordered-container text-center'>
        <a href="/signup">Create an account</a>
    </div>

    <footer>
    </footer>
</body>


</html>