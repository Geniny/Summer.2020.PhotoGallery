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
    $email = $password = "";
    $emailInputCheck = $passwordInputCheck = true; 

    $emailInputView = 
    '
    <div class="form-group" >
    <label for="email">Email</label>
    <input id = "email_field" type="text" class="form-control" name="email" value = "'.$email.'" > 
    </div>
    ';

    $passwordInputView =
    '
    <div class="form-group">
    <label for="password">Password</label>
    <input id = "password_field" type="password" class="form-control" name="password" value = "'.$password.'" >
    </div>
    '; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        require_once 'php/config.php';

        $link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($link->connect_errno) {
            printf("Соединение не удалось: %s\n", $link->connect_error);
            exit();
        }

        $email = isset($_POST['email']) ? htmlentities(mysqli_real_escape_string($link, $_POST['email'])) : "";
        $password = isset($_POST['password']) ? htmlentities(mysqli_real_escape_string($link, $_POST['password'])) : "";

        $query = "SELECT * FROM users WHERE login = '$email'";
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
                $emailInputView = 
                '
                <div class="form-group" >
                <label for="email">Email</label>
                <input id = "email_field" type="text" class="form-control is-valid" name="email" value = "'.$email.'" >
                </div>
                ';
                $passwordInputView =
                '
                <div class="form-group">
                <label for="password">Password</label>
                <input id = "password_field" type="password" class="form-control is-invalid" name="password" value = "'.$password.'" >
                <div class="invalid-feedback">
                Wrong password
                </div>
                </div>
                ';
            }

            $result->free();

        }
        else
        {
            $emailInputView = 
            '
            <div class="form-group" >
            <label for="email">Email</label>
            <input id = "email_field" type="text" class="form-control is-invalid" name="email" value = "'.$email.'" >
            <div class="invalid-feedback">
            No such user
            </div> 
            </div>
            ';
            $passwordInputView =
            '
            <div class="form-group">
            <label for="password">Password</label>
            <input id = "password_field" type="password" class="form-control" name="password" value = "'.$password.'" >
            </div>
            ';
        }


        $link->close();
        
    }

    echo 
    '
    <div class="centered bordered-container vertical-centered">
    <form method="post" action="/signin">
    '.$emailInputView.'
    '.$passwordInputView.'          
    <div class = "text-center">
    <button type="submit" class="btn btn-primary btn-block" id="signin_btn" style="margin-top: 5%;">Sign in</button>
    </div>
    </form>
    </div>
    <div class="centered bordered-container text-center">
    <a href="/signup">Create an account</a>
    </div>   
    '; 
    ?>

</body>


</html>