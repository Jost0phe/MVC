<?php
    session_start();
    define('PATHROOT',__DIR__);
    define('DS',DIRECTORY_SEPARATOR);
    define('PATHVIEWS', PATHROOT.DS.'vues'.DS);
    
    $content = '<p>hello projet</p>';
    
    include PATHVIEWS.'page.php';

