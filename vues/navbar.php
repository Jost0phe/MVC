<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Brand</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php">Accueil</a>
            <?php if(!isset($_SESSION['connected']) || $_SESSION['connected']!==true){
                echo '<a class="nav-item nav-link" href="?page=login">Login</a>';
            }else{
                echo '<a class="nav-item nav-link" href="?page=logout">Logout</a>';
            }?>
        </div>
    </div>
</nav>