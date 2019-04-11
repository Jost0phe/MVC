<?php
class article {
    private $id;
    private $nom;
    private $auteur;
    private $contenu;
    private $date;
    
    function getId() {
        return $this->id;
    }

    function getArticlenom() {
        return $this->nom;
    }

    function getArticleauteur() {
        return $this->auteur;
    }

    function getArticlecontenu() {
        return $this->contenu;
    }

    function getArticledate() {
        return $this->date;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setArticlenom($articlenom) {
        $this->nom = $articlenom;
    }

    function setArticleauteur($articleauteur) {
        $this->auteur = $articleauteur;
    }

    function setArticlecontenu($articlecontenu) {
        $this->contenu = $articlecontenu;
    }

    function setArticledate($articledate) {
        $this->date = $articledate;
    }

}
