<?php
    session_start();
    define('PATHROOT',__DIR__);
    define('DS',DIRECTORY_SEPARATOR);
    define('PATHVIEWS', PATHROOT.DS.'vues'.DS);
    define('PATHCTRL', PATHROOT.DS.'controllers'.DS);
    define('PATHMDL', PATHROOT.DS.'models'.DS);
    
    //include PATHMDL.'user.php';
    //include PATHCTRL.'userController.php';
    //include PATHCTRL.'dbController.php';
    
   // $config = yaml_parse_file(PATHROOT.DS.'conf'.DS.'parameters.yml');
    
    function autoLoadModel($modelName){
        if(file_exists(PATHMDL.$modelName.'.php')){
            require_once PATHMDL.$modelName.'.php';
        }
    }
    function autoLoadController($controllerName){
        if(file_exists(PATHCTRL.$controllerName.'.php')){
            require_once PATHCTRL.$controllerName.'.php';
        }
    }
    
    spl_autoload_register('autoLoadModel');
    spl_autoload_register('autoLoadController');
    
    // $oBdd = new dbController($config['dbConfig']);
    
    $page = filter_input(INPUT_GET,'page', FILTER_SANITIZE_STRING);
    if(is_null($page) || !file_exists(PATHVIEWS.$page.'.php')){
        $page = 'accueil';
    }
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
    
    if(!is_null($action)){
        $tabAction = explode ('-', $action);
        $controller = $tabAction[0].'Controller';
        $method = $tabAction[1].'Action';
        $objet = new $controller();
        $resAction = $objet->$method();
       
        if($resAction){
            $page = $resAction;
        }
    }
    
    include PATHVIEWS.'page.php';