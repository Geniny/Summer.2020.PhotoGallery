<?php
    require_once 'php/config.php';

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
            or die("Ошибка " . mysqli_error($link));
     
    $query ="SELECT * FROM photos";
    
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    
    echo '
    <div class = "container">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">           
    ';
      
    if($result)
    {
        $rows = mysqli_num_rows($result);
        $row = mysqli_fetch_row($result);

        echo '
        <div class="carousel-item active" x>
            <img src="data:image/jpeg;base64,'.base64_encode( $row[1] ).'" class="responsive" alt="...">
        </div>
        ';

        for ($i = 1 ; $i < $rows ; ++$i)
        {
            $row = mysqli_fetch_row($result);
            print_r($i);
            echo 
            '
            <div class="carousel-item">
                <img src="data:image/jpeg;base64,'.base64_encode( $row[1] ).'" class="responsive" alt="...">
            </div>
            ';
        }
        
        mysqli_free_result($result);
    }
    
    echo 
    '
    </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    ';

    mysqli_close($link);
?>