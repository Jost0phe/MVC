<?php

class userController {
    function loginAction() {
        // Récupère les informations qui proviennent du formulaire
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Instancie un nouvel objet user pour tester les paramètres
        $objUser = new user();
        $objUser->setLogin($login);
        $objUser->setPassword($password);
        
        // Test le mot de passe
        $resultCheck = $this->checkAction($objUser);
        
        // Vérifie le retour et affiche la vue correspondante
        if($resultCheck) {
            
            $oBdd = new dbController();
            $user = $oBdd->findOneBy(
            $objUser, 
                array(
                    'champs'=>array(
                        'id',
                        ),
                    'criteria'=> array(
                        'login' => $objUser->getLogin(),
                        )
                    ));
            
            $_SESSION['msgStyle'] = 'success';
            $_SESSION['msgTxt'] = 'Vous êtes connecté';
            $_SESSION['connected'] = true;
            $_SESSION['userid'] = $user['id'];
            return array('view'=>'welcome');
        }
        $_SESSION['msgStyle'] = 'danger';
        $_SESSION['msgTxt'] = 'Erreur de login/mot de passe';
        
        return $resultCheck;
    }

    
    function updateAction() {
        $user= new user();
        $oBdd = new dbController();
        $userPost = array(
                'login' => FILTER_SANITIZE_EMAIL,
                'password' => FILTER_SANITIZE_ENCODED
                );
        
        $userTab = filter_input_array(INPUT_POST,$userPost);
        
        if(!empty($userTab['password'])){
            $userTab['password'] = password_hash($userTab['password'], PASSWORD_BCRYPT);
        } else {
            unset($userTab['password']);
        }
        $user->setId($_SESSION['userid']);
        $nbUpdate = $oBdd->updateRecord($user, $userTab);
        if($nbUpdate === 0) {
            $_SESSION['msgStyle'] = 'danger';
            $_SESSION['msgTxt'] = 'Erreur lors de la modification de l\'utilisateur';
            return 0;
        }
        $_SESSION['msgStyle'] = 'success';
        $_SESSION['msgTxt'] = 'Compte correctement modifié';
        return $nbUpdate;
    }


        function checkAction(user $user) {
        $oBdd = new dbController();
//        $tabUser = $oBdd->findOneById($user, 10);
        $tabUser = $oBdd->findOneBy(
            $user, 
                array(
                    'champs'=>array(
                        'password',
//                        'login'
                        ),
                    'criteria'=> array(
                        'login' => $user->getLogin(),
//                        'password' => $user->getPassword(),
                        )
                    ));
        
        if(empty($tabUser)) {
            return false;  
        }
        return (password_verify($user->getPassword(), $tabUser['password']))?true:false;
    }

    function createAction() {
        
        $user= new user();
        $oBdd = new dbController();
        
        $userPost = array(
                'login' => FILTER_SANITIZE_EMAIL,
                'password' => FILTER_SANITIZE_ENCODED
                );
        
        $userTab = filter_input_array(INPUT_POST,$userPost);
        $userTab['password'] = password_hash($userTab['password'], PASSWORD_BCRYPT);
        
        $id = $oBdd->newRecord($user, $userTab);
        
        if($id === 0) {
            $_SESSION['msgStyle'] = 'danger';
            $_SESSION['msgTxt'] = 'Erreur lors de la création de l\'utilisateur';
            return 0;
        }
        $_SESSION['msgStyle'] = 'success';
        $_SESSION['msgTxt'] = 'Compte correctement créé';
        return $id;
    }

    function editAction(){
        $oBdd = new dbController;
        $user = new user();
        
        $tabEdit = $oBdd->findObjectById($user, $_SESSION['id']);
        //var_dump($tab); die();
        return array('view' => 'update', 'user' => $user);
    }
    
    function deleteAction(object $user){
        $user = new user();
        $oBdd = new dbController();
        
        $user->setId($_SESSION['userId']);
        $nbDelete = $oBdd->deleteRecord($user);
        
        if($nbDelete === 0){
            $_SESSION['msgStyle'] = 'danger';
            $_SESSION['msgTxt'] = 'Erreur lors de la suppression';
            return 0;
        }
        $_SESSION['msgStyle'] = 'success';
        $_SESSION['msgTxt'] = 'Compte supprimé';
    }
    function logoutAction(){
        $_SESSION['connected']=false;
        session_destroy();
        return null;
    }
}
