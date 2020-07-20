<?php 

    $routes = array(
        '/'=>'views/pages/home.php',
        '/signin' => 'views/pages/login.php',
        '/signup' => 'views/pages/register.php'
    );

    $authorized_routes = array(
        '/add' => 'views/pages/add.php',
        '/signout' => 'php/exit.php'
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
                header("Location: http://".$_SERVER['HTTP_HOST']."/signin");
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