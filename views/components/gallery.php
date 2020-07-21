<?php
require_once 'php/config.php';

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
or die("Ошибка " . mysqli_error($link));

$query ="SELECT * FROM photos";

$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));


echo '
<div class = "container">          
';


if($result)
{
    $rows = mysqli_num_rows($result);
    $counter = 1;
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);

        
        if ($counter == 1)
        {
         echo '<div class = "row row-cols-3" style = "margin-top: 30px;">';
        }

         echo 
         '
         <div class="col">
         <img id = "img-'.$row[0].'" src="data:image/jpeg;base64,'.base64_encode( $row[1] ).'" style = "width: 100%; max-height: 300px; height: 300px;" alt="'.$row[5].'">
         </div>
         <script type="text/javascript">
         img = document.getElementById("img-'.$row[0].'");
         img.onclick = function(){
            modal.style.display = "block";
            console.log(this.alt);
            modalContent.src = this.src;
            captionText.innerHTML = this.alt;
        }; 
        </script>
        ';

        if ($counter == 3 || $i == $rows -1 )
        {
            echo '</div>';
            $counter = 0;
        }
        $counter = $counter + 1;

    }
mysqli_free_result($result);
}

echo 
'
</div>

<div class="modal-img">
<div class = "f-e">
<span class="myclose">&times;</span>
</div>

<img class="modal-content">

<div id="caption"></div>
</div>

<script>

var span = document.getElementsByClassName("myclose")[0];

span.onclick = function() {
  modal.style.display = "none";
} 


var modal = document.getElementsByClassName("modal-img")[0];
var modalContent = document.getElementsByClassName("modal-content")[0];
var captionText = document.getElementById("caption");

</script>
';

mysqli_close($link);
?>

