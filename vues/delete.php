<?php
    $action = "article-supprimer";
    $page = "delete"
?>
<h1><?=ucfirst($page)?></h1> 
    <form method="POST" action="?action=<?=$action?>" name="publier">
        <label for="titre">Titre</label>
            <input type="text" placeholder="Titre de l'article" name="titre" class="form-control">
        <label for="contenu">Contenu</label>   
            <textarea name="contenu" class="form-control">Rédigez votre article ici</textarea>
        <button type="submit" value="Publier" class="form-control">Publier</button>
    </form>
