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
            require_once 'views/components/header.php';       
        ?>

        <div class = "centered bordered-container vertical-centered">
            <form method="post" action="php/add_photo.php" enctype='multipart/form-data'>
                <div class="form-group" >
                        <label for="image_name">Image name</label>
                        <input type="text" class="form-control" name="image_name" >
                        <small id="passwordHelpInline" class="text-muted">
                            Must be 8-20 characters long.
                        </small>
                </div>
                <div class="form-group">
                    <label for="image_description">Short description</label>
                    <input type="password" class="form-control" name="image_description">
                </div>
                <div class="form-group">
                    <label for="image">Choose file...</label>      
                    <input type='file' name='image' />  
                </div>
                </div class='text-center'>
                    <input type="submit" class="btn btn-outline-secondary">Button</button>
                </div>
            </form>
        </div>
        <footer>
        </footer>
    </body>
</html>