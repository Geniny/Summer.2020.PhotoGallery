<?php
    require_once "config.php";

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
            or die("Ошибка " . mysqli_error($link));
     
    $query ="SELECT * FROM photos";
    
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if(isset($_POST['image_name']) && isset($_POST['image_description']) && $_FILES && $_FILES['image']['error']== UPLOAD_ERR_OK)
    {
        $name = htmlentities($_POST['image_name']);
        $description = htmlentities($_POST['image_description']);
        $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>';
        $query = "INSERT INTO photos (id, image, name, author, description) VALUES('','$image','$name', 'author', '$description')";  
        $qry = mysqli_query($db, $query);
    }
?>