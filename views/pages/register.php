<!DOCTYPE html>
<html>

<head>
    <title>PhotoGallery - Register your account</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/site.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>

<body>
    <?php

    require_once 'views/components/header.php';
    $email = $password = $repeated_password = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['repeat_password']))
        {  
            require_once 'php/config.php';
            require_once 'php/validation.php';
            require_once 'views/components/modal_message.php';

            $link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
            $password = htmlentities(mysqli_real_escape_string($link, $_POST['password']));
            $repeated_password = htmlentities(mysqli_real_escape_string($link, $_POST['repeat_password']));

            if ($link->connect_errno) {
                printf("Соединение не удалось: %s\n", $link->connect_error);
                exit();
            }
            
            if(!email_validation($email))
            {
                show_modal_message("Bad email format!");
            }
            else if(!password_validation($password))
            {
                show_modal_message("Password is to weak!");
            }
            else
            {

                $checkUserQuery = "SELECT * FROM users WHERE login = '$email'";


                if ($result = $link->query($checkUserQuery)) {

                    $row = $result->fetch_assoc();

                    if(isset($row['login']) && $email == $row['login'])
                    {
                        show_modal_message("User with this email already exists.");                    }
                    else
                    {
                        $result->free();
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $insertNewUserQuery = "INSERT INTO users (login, password) values ('$email','$hashed_password')";
                        $result = $link->query($insertNewUserQuery);
                        if ($result)
                        {
                            $getUserIdQuery = "SELECT id FROM users WHERE login = '$email'";
                            $result = $link->query($getUserIdQuery);
                            $row = $result->fetch_assoc();
                            $_SESSION['user_id'] = $row['id'];
                            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                        }
                        header("Location: http://".$_SERVER['HTTP_HOST']."/");
                    }               
                }
            }

            $link->close();
        }

    } 
    ?>

    <div class="centered bordered-container vertical-centered">
        <form method="post" action="/signup">
            <div class="form-group" >
                <label for="email">Email</label>
                <input id = "email_field" type="text" class="form-control" name="email" value = "<?php echo $email;?>" > 
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id = "password_field" type="password" class="form-control" name="password" value = "<?php echo $password;?>" >
            </div>
            <div class="form-group">
                <label for="repeat_password">Repeat password</label>
                <input id = "repeat_password_field" type="password" class="form-control" name="repeat_password" value = "<?php echo $repeated_password;?>" >
            </div>
            <div class = "text-center">
                <button type="submit" class="btn btn-primary btn-block" id="signin_btn" style="margin-top: 5%;">Sign up</button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        let email_field = document.getElementById("email_field");
        let password_field = document.getElementById("password_field");
        let repeat_password_field = document.getElementById("repeat_password_field");
        

        email_field.addEventListener("keyup", () => {
            if(validateEmail(email_field.value))
            {
                email_field.className = "form-control is-valid";
            }
            else
            {
                email_field.className = "form-control is-invalid";
            }

        });

        password_field.addEventListener("keyup", () => {
            if(validatePassword(password_field.value))
            {
                password_field.className = "form-control is-valid";
            }
            else
            {
                password_field.className = "form-control is-invalid";
            }

        });

        repeat_password_field.addEventListener("keyup", () => {
            if(validateRepeatedPassword(repeat_password_field.value, password_field.value))
            {
                repeat_password_field.className = "form-control is-valid";
            }
            else
            {
                repeat_password_field.className = "form-control is-invalid";
            }
            
        });

        function validatePassword(password)
        {
            return password.length < 5 ? false : true;
        }

        function validateRepeatedPassword(repeated_password, password)
        {
            if (repeated_password.length > 4 && repeated_password == password)
                return true;
            else
                return false;           
        }

        function validateEmail(email) 
        {
            var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
            return re.test(String(email).toLowerCase());
        }
    </script>
    </footer>
</body>


</html>