<!DOCTYPE html>
<html>
<head>
    <title>Add photo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/site.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>

<body>
    <?php
    require 'views/components/header.php';
    $name = $description = $image = null;
    $nameInputCheck = $descriptionInputCheck = $fileInputCheck = true;

    $nameInputView = 
    '
    <div class="form-group" >
    <label for="image_name">Image name</label>
    <input type="text" class="form-control" name="image_name" value = "'.$name.'">
    </div>
    ';

    $descriptionInputView =
    '
    <div class="form-group">
    <label for="image_description">Short description</label>
    <input type="text" class="form-control" name="image_description" value = "'.$description.'">
    </div>
    ';

    $fileInputView =
    '
    <div class="input-group">
    <div class="custom-file">
    <input type="file" class="custom-file-input" name = "image" aria-describedby="inputGroupFileAddon04">
    <label class="custom-file-label" for="image" value = "'.$image.'" >Choose file</label>
    </div>
    <div class="input-group-append">
    <button type = "submit" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload</button>
    </div>
    </div>
    ';

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        require_once "php/config.php";
        require_once "php/validation.php";

        $name = isset($_POST['image_name'])? htmlentities($_POST['image_name']) : "";
        $description = isset($_POST['image_description'])? htmlentities($_POST['image_description']) : "";
        $image = $_FILES['image']['error']== UPLOAD_ERR_OK? addslashes(file_get_contents($_FILES['image']['tmp_name'])): "";


        if(!image_name_validation($name))
        {
            $nameInputCheck = false;
            $nameInputView = 
            '
            <div class="form-group" >
            <label for="image_name">Image name</label>
            <input type="text" class="form-control is-invalid" name="image_name" value = "'.$name.'">
            <div class="invalid-feedback">
            Image name length must be greater then 3.
            </div>
            </div>
            ';

        }
        else
        {
            $nameInputView = 
            '
            <div class="form-group" >
            <label for="image_name">Image name</label>
            <input type="text" class="form-control is-valid" name="image_name" value = "'.$name.'">
            </div>
            ';
        }

        if(!image_description_validation($description))
        {
            $descriptionInputCheck = false;
            $descriptionInputView =
            '
            <div class="form-group">
            <label for="image_description">Short description</label>
            <input type="text" class="form-control is-invalid" name="image_description" value = "'.$description.'">
            <div class="invalid-feedback">
            Image description length must be greater then 10.
            </div>
            </div>
            ';
        }
        else
        {
            $descriptionInputView =
            '
            <div class="form-group">
            <label for="image_description">Short description</label>
            <input type="text" class="form-control is-valid" name="image_description" value = "'.$description.'">
            </div>
            ';
        }

        if($_FILES && $_FILES['image']['error'] == UPLOAD_ERR_OK)
        {
            $fileInputView = 
            '
            <div class="input-group">
            <div class="custom-file">
            <input type="file" class="custom-file-input is-valid" name = "image" aria-describedby="inputGroupFileAddon04">
            <label class="custom-file-label" for="image" value = "'.$image.'" >Choose file</label>
            </div>
            <div class="input-group-append">
            <button type = "submit" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload</button>
            </div>
            </div>
            ';
        }
        else
        {
            $fileInputCheck = false;
            $fileInputView = 
            '
            <div class="input-group">
            <div class="custom-file">
            <input type="file" class="custom-file-input is-invalid" name = "image" aria-describedby="inputGroupFileAddon04">
            <label class="custom-file-label" for="image" value = "'.$image.'" >Choose file</label>
            </div>
            <div class="input-group-append">
            <button type = "submit" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload</button>
            </div>
            </div>
            ';
        }

        if($fileInputCheck && $nameInputCheck && $descriptionInputCheck)
        {
            $link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if ($link->connect_errno) {
                printf("Соединение не удалось: %s\n", $link->connect_error);
                exit();
            }

            $id = $_SESSION['user_id'];
            $getCurrentUserQuery = "SELECT login FROM users WHERE id = '$id'";
            $result = $link->query($getCurrentUserQuery);
            $row = $result->fetch_assoc();
            $login = $row['login'];
            $result->close();

            $query = "INSERT INTO photos (id, image, name, author, description) VALUES('','$image','$name', '$login', '$description')";  
            $result = $link->query($query);
            $link->close();

            header("Location: http://".$_SERVER['HTTP_HOST']."/");
        }

    }
    
    echo 
    '
    <div class = "centered bordered-container vertical-centered">
    <form method="post" action="/add" enctype="multipart/form-data">
    '.$nameInputView.'
    '.$descriptionInputView.'
    '.$fileInputView.'
    </form>
    </div>
    ';      
    ?>

    
</body>
</html>