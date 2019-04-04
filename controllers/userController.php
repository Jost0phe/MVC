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
        $oBdd = new dbController();
        
        $tabUser = $oBdd->findOneBy(
               $user,
                    array(
                        'champs'=>array(
                            'password',
                        ),
                        'criteria'=> array(
                            'login'=> $user->getLogin(),
                        )
                    ));
        if(empty($tabUser)){
            return false;
        }
        return (password_verify($user->getPassword(), $tabUser['password']))?true:false;
    }
    
function createAction(){
        $user = new user();
        $oBdd = new dbController();
        
        $userPost = array(
            'login'=>FILTER_SANITIZE_EMAIL,
            'password'=>FILTER_SANITIZE_ENCODED
            );
        
        $userTab = filter_input_array(INPUT_POST,$userPost);
        $userTab['password'] = password_hash($userTab['password'],PASSWORD_BCRYPT);
        
        $id = $oBdd->newRecord($user, $userTab);
        
        if($id === 0){
            $_SESSION['msgStyle'] = 'danger';
            $_SESSION['msgTxt'] = 'Compte correctement créé';
            return $id;
        }
}    
    
    
    function logoutAction(){
        $_SESSION['connected']=false;
        session_destroy();
        return null;
    }
}
