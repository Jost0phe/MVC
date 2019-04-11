<?php
    class articleController{
            
        function publierAction(){
            $article = new article;
            $auteur = $_SESSION['login'];
            $nom = FILTER_INPUT(INPUT_POST, 'titre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//            var_dump($_POST); die();
            $contenu = FILTER_INPUT(INPUT_POST, 'contenu', FILTER_DEFAULT);
//            var_dump($_SESSION['login']); die();
            $datas = array(
                'nom'=>$nom,
                'auteur'=>$auteur,
                'contenu'=>$contenu,
            );
//            var_dump($datas); die();
            $oBdd = new dbController();
//            var_dump($oBdd->newRecord($article,$datas)); die();
            header('Location:?action=article-display');
        }
        
        function modifAction(){
            $article = new article();
            $oBdd = new dbController();
            
            $userPost = array(
                'nom'=> FILTER_SANITIZE_STRING,
                'contenu'=> FILTER_SANITIZE_STRING,
                'date'=> FILTER_SANITIZE_STRING,
                'auteur'=> FILTER_SANITIZE_SRING
            );
            
            $userTab = filter_input_array(INPUT_POST, $userPost);
            
        $article->setId($_SESSION['userid']);
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
        
        function supprimerAction(){
            $article = new article();
            $oBdd = new dbController();

            $article->getId($article);
            $nbDelete = $oBdd->deleteRecord($article);
            
            if($nbDelete === 0){
                $_SESSION['msgStyle'] = 'danger';
                $_SESSION['msgTxt'] = 'Erreur lors de la suppression';
                return 0;
            }
            $_SESSION['msgStyle'] = 'success';
            $_SESSION['msgTxt'] = 'Article supprimé';
        }
        
        function displayAction(){
            $article = new article();
            $oBdd = new dbController();
            
            $tabArt = $oBdd->findAll($article);
            
//            var_dump($tabArt); die();
            
            return array("view"=>"accueil","articles"=>$tabArt);
                        
        }
        
        function displaybyIdAction(){
            $article = new article();
            $oBdd = new dbController();
            $tab = array(
                'champs'=>array(
                    '*'
                ),
                'criteria'=>array(
                    'auteur'=>$_SESSION['login']
                )
            );
            
            $tabArt = $oBdd->findObjectbyAuteur($article, $tab);
            
            return array("view"=>"deleteArticle","articles"=>$tabArt);
                        
        }
    }

