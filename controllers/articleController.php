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
                'date'=>date('Y-m-d H:i:s')
            );
//            var_dump($datas); die();
            $oBdd = new dbController();
            $oBdd->newRecord($article,$datas);
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
        
        function displayArticle(){
            $article = new article();
            $oBdd = new dbController();
            
            $tabart = $oBdd->findAll($artcle);
        }
    }

