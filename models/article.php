<?php
class article {
    private $id;
    private $articlenom;
    private $articleauteur;
    private $articlecontenu;
    private $articledate;
    
    function getId() {
        return $this->id;
    }

    function getArticlenom() {
        return $this->articlenom;
    }

    function getArticleauteur() {
        return $this->articleauteur;
    }

    function getArticlecontenu() {
        return $this->articlecontenu;
    }

    function getArticledate() {
        return $this->articledate;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setArticlenom($articlenom) {
        $this->articlenom = $articlenom;
    }

    function setArticleauteur($articleauteur) {
        $this->articleauteur = $articleauteur;
    }

    function setArticlecontenu($articlecontenu) {
        $this->articlecontenu = $articlecontenu;
    }

    function setArticledate($articledate) {
        $this->articledate = $articledate;
    }

}
