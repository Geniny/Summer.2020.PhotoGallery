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

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        require_once "php/config.php";

        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if(isset($_POST['image_name']) && isset($_POST['image_description']) && $_FILES && $_FILES['image']['error']== UPLOAD_ERR_OK)
        {
            $name = htmlentities($_POST['image_name']);
            $description = htmlentities($_POST['image_description']);
            $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));   
            $query = "INSERT INTO photos (id, image, name, author, description) VALUES('','$image','$name', 'author', '$description')";  
            $qry = mysqli_query($db, $query);
            header("Location: http://".$_SERVER['HTTP_HOST']."/");
        }

    }       
    ?>

    <div class = "centered bordered-container vertical-centered">
        <form method="post" action="/add" enctype='multipart/form-data'>
            <div class="form-group" >
                <label for="image_name">Image name</label>
                <input type="text" class="form-control" name="image_name" >
            </div>
            <div class="form-group">
                <label for="image_description">Short description</label>
                <input type="text" class="form-control" name="image_description">
            </div>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name = "image" aria-describedby="inputGroupFileAddon04">
                    <label class="custom-file-label" for="image">Choose file</label>
                </div>
                <div class="input-group-append">
                    <button type = "submit" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Upload</button>
                </div>
            </div>
        </form>
    </div>
    <footer>
    </footer>
</body>
</html>