<?php

class userController {
    function loginAction(){
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_SPECIAL_CHARS);
        
        $objUser = new user();
        $objUser->setLogin($login);
        $objUser->setPassword($password);
        
        $resultCheck = $this->checkAction($objUser);
        
        if ($resultCheck){
            $_SESSION['msgStyle'] = 'success';
            $_SESSION['msgTxt'] = 'Vous etes connecté';
            $_SESSION['connected'] = true;
            return 'welcome';
        }
            $_SESSION['msgStyle'] = 'danger';
            $_SESSION['msgTxt'] = 'Erreur sur le login/mot de passe';
            
            return $resultCheck;
        }


    
    function checkAction(user $user){
        return($user->getPassword()=='toto')?TRUE:FALSE;
    }
    
    function logoutAction(){
        $_SESSION['connected']=false;
        session_destroy();
        return null;
    }
}
