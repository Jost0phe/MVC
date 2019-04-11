<?php
    foreach($resAction['articles'] as $articles){ ?>
<div class="col-4 border border border-info rounded-sm">
    <article>
        <h2><?php echo $articles->getArticlenom(); ?> </h2>
        <?php echo substr($articles->getArticlecontenu(),0,30); ?>
        <?php $strtime = strtotime($articles->getArticledate()); ?>
        <?php echo ($articles->getArticleauteur())?>
    </article>
</div>
    <?php } ?>

