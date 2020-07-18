<?php

    $btn = isset($_SESSION['user_id']) == true ? 
    '<a class = "btn btn-outline-primary" href = "/add" style = "margin-right:15px;"> Add </a>' .
    '<a class="btn btn-outline-success" href="/logout">Log out</a>':
    '<a class="btn btn-outline-success" href="/login">Sign up</a>' ;
    
    echo 
    '
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <a href = "/" class="my-0 mr-md-auto font-weight-normal">PhotoGallery</a>'.$btn .'
    </div>
    ';
?>