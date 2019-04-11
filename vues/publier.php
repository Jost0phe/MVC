<?php
    $action = "article-publier";
    $page = "publier"
?>
<h1><?=ucfirst($page)?></h1> 
    <form method="POST" action="?action=<?=$action?>" name="publier">
        <label for="titre" class="form-control">Titre</label>
            <input type="text" placeholder="Titre de l'article" name="titre" class="form-control">
        <label for="contenu" class="form-control">Contenu</label>   
        <textarea name="contenu" class="form-control" placeholder="Rédigez votre article...."></textarea>
        <button type="submit" value="Publier" class="form-control col-sm-5">Publier</button>
    </form>

