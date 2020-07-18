<?php
    if(isset($_SESSION['user_id']))
    {
        session_destroy();
        header("Location: http://".$_SERVER['HTTP_HOST']."/");
    }

?>