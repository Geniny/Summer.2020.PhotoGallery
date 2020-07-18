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
        ?>

        <div class = "centered bordered-container vertical-centered">
            <form method="post" action="php/add_photo.php" enctype='multipart/form-data'>
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
                        <button type = "submit" class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Button</button>
                    </div>
                </div>
            </form>
        </div>
        <footer>
        </footer>
    </body>
</html>