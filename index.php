 <?php
    require_once 'php/router.php'; 
    $action = $_SERVER['REQUEST_URI'];
    route($action);      
?>