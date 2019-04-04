<?php
    if ($page == "update"){
        $action = "user-update";
    }else{
          $action = "user-create";
    }
?>
<h1><?=ucfirst($page)?></h1>
<div class="col-xs-2">
    <form method="POST" action="?action=<?=$action?>">
        <label for="identifiant">Identifiant</label>
        <input type="email" placeholder="Entrez votre identifiant" name="login" class="form-control" 
            <?php if(isset($resAction)){ ?>
            value="<?=$resAction['user']->getLogin();?>"
            <?php } ?>
            >
        <label for="password">Mot de passe</label>   
            <input type="password" placeholder="Entrez votre mot de passe" name="password" class="form-control">
        <button type="submit" value="Création" class="form-control">S'inscrire</button>
    </form>
</div>