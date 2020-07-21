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

    $email = $password = $repeated_password = "";
    $emailInputCheck = $passwordInputCheck = $repeatedPasswordInputCheck = true; 

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

    $repeatedPasswordInputView =
    '
    <div class="form-group">
    <label for="repeat_password">Repeat password</label>
    <input id = "repeat_password_field" type="password" class="form-control" name="repeat_password" value = "'.$repeated_password.'" >
    </div>
    ';

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        require_once 'php/config.php';
        require_once 'php/validation.php';

        $link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $email = isset($_POST['email']) ? htmlentities(mysqli_real_escape_string($link, $_POST['email'])) : "";
        $password = isset($_POST['password']) ? htmlentities(mysqli_real_escape_string($link, $_POST['password'])) : "";
        $repeated_password = isset($_POST['repeat_password']) ? htmlentities(mysqli_real_escape_string($link, $_POST['repeat_password'])) : "";

        if(email_validation($email))
        {
            $emailInputView = 
            '
            <div class="form-group" >
            <label for="email">Email</label>
            <input id = "email_field" type="text" class="form-control is-valid" name="email" value = "'.$email.'" > 
            </div>
            ';
        }
        else
        {
            $emailInputCheck = false;
            $emailInputView = 
            '
            <div class="form-group" >
            <label for="email">Email</label>
            <input id = "email_field" type="text" class="form-control is-invalid" name="email" value = "'.$email.'" >
            <div class="invalid-feedback">
            Incorrect format of email
            </div> 
            </div>
            ';
        }

        if(password_validation($password))
        {
            $passwordInputView =
            '
            <div class="form-group">
            <label for="password">Password</label>
            <input id = "password_field" type="password" class="form-control is-valid" name="password" value = "'.$password.'" >
            </div>
            ';
        }
        else
        {
            $passwordInputCheck = false;
            $passwordInputView =
            '
            <div class="form-group">
            <label for="password">Password</label>
            <input id = "password_field" type="password" class="form-control is-invalid" name="password" value = "'.$password.'" >
            <div class="invalid-feedback">
            Password is too weak
            </div>
            </div>
            ';
        }

        if(repeatedPassword_validation($password, $repeated_password))
        {
            $repeatedPasswordInputView =
            '
            <div class="form-group">
            <label for="repeat_password">Repeat password</label>
            <input id = "repeat_password_field" type="password" class="form-control is-valid" name="repeat_password" value = "'.$repeated_password.'" >
            </div>
            ';
        }
        else
        {
            $repeatedPasswordInputCheck = false;
            $repeatedPasswordInputView =
            '
            <div class="form-group">
            <label for="repeat_password">Repeat password</label>
            <input id = "repeat_password_field" type="password" class="form-control is-invalid" name="repeat_password" value = "'.$repeated_password.'" >
            <div class="invalid-feedback">
            Passwords mismatch
            </div>
            </div>
            ';
        }


        if($emailInputCheck && $passwordInputCheck && $repeatedPasswordInputCheck)
        {  
            if ($link->connect_errno) {
                printf("Соединение не удалось: %s\n", $link->connect_error);
                exit();
            }

            $checkUserQuery = "SELECT * FROM users WHERE login = '$email'";


            if ($result = $link->query($checkUserQuery)) 
            {

                $row = $result->fetch_assoc();

                if(isset($row['login']) && $email == $row['login'])
                {
                   $emailInputView = 
                   '
                   <div class="form-group" >
                   <label for="email">Email</label>
                   <input id = "email_field" type="text" class="form-control is-invalid" name="email" value = "'.$email.'" > 
                   <div class="invalid-feedback">
                   User with this email already exists
                   </div>
                   </div>
                   ';                    
               }
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


echo 
'
<div class="centered bordered-container vertical-centered">
<form method="post" action="/signup">
'.$emailInputView.'
'.$passwordInputView.'
'.$repeatedPasswordInputView.'           
<div class = "text-center">
<button type="submit" class="btn btn-primary btn-block" id="signin_btn" style="margin-top: 5%;">Sign up</button>
</div>
</form>
</div>
';

?>    



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