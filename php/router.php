<?php 

    $routes = array(
        '/'=>'views/pages/home.php',
        '/login' => 'views/pages/login.php',
        '/register' => 'views/pages/register.php'
    );

    $authorized_routes = array(
        '/add' => 'views/pages/add.php',
        '/logout' => 'php/exit.php'
    );

    session_start();
    

    function route($uri)
    {
        $uri = strtolower($uri);
        global $routes;
        global $authorized_routes;

        if(array_key_exists($uri, $authorized_routes))
        {
            if(isset($_SESSION['user_id']))
            {
                require_once $authorized_routes[$uri];
            }
            else
            {               
                header("Location: http://".$_SERVER['HTTP_HOST']."/login");
            }
        }
        else if(array_key_exists($uri, $routes))
        {    
            require_once $routes[$uri];    
        } 
        else
        {
            echo "Error";
        }

        exit;
    }

?>