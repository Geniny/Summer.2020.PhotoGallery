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
    ?>

    <div class="centered bordered-container vertical-centered">
            <form method="post" action="php/login.php">
                    <div class="form-group" >
                            <label for="login">Email</label>
                            <input type="text" class="form-control" name="login" >
                    </div>
                    <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                            <label for="repeat_password">Repeat password</label>
                            <input type="password" class="form-control" name="repeat_password">
                    </div>
                    <div class = "text-center">
                        <button type="submit" class="btn btn-primary btn-block " style="margin-top: 5%;">Sign in</button>
                    </div>
            </form>
    </div>

    <footer>
    </footer>
</body>


</html>