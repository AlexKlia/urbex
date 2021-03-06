<?php
    $data = [
            'title' => 'Derniers Partages',
            'script' => $this->assetUrl('js/scriptVote.js')
    ];
?>


<?php  $this->layout('layout',$data);?>

<?php $this->start('main_content')?>
    <?php foreach ($allPictures as $picture): ?>
    <div class="row" data-id="<?= $picture['id'] ?>">
        <input type="hidden" id="ajax_operation_route" value="<?=$this->url('pictures_ajax_operationVote')?>">
        <div class="col-md-1">
            <button type="button" name="vote" data-picture-id="<?= $picture['id'] ?>" class="vote btn btn-default" aria-label="Left Align">
                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
            </button>
            <br>
            <!--<p><?/*=$picture['nbVote']*/?></p>-->
            <p class="nbVote"><?= $picture['nbVote'] ?></p>
        </div>

        <div class="col-md-3">
                <img class="img-responsive" src="<?= $this->assetUrl('uploads/' . $picture['url_resize'] )?>" alt="<?= $picture['title']?>">
        </div>
        <div class="col-md-8">
                <h2><?= $picture['title']?></h2>

                <p><?= $picture['descr']?></p>
                <p>Posté par: <?= $picture['username']?></p>

            <?php if (isset($_SESSION['user'])) : ?>

                <?php if ($_SESSION['user']['role'] == 'Admin') : ?>
                    <form action="" method="POST">
                        <input type="text" name="pictureId" value="<?= $picture['id'] ?>" hidden>
                        <button type="submit" name="delete" class="btn btn-default">Supprimer</button>
                    </form>
                <?php endif; ?>

            <?php endif; ?>


        </div>

    </div>
    <hr/>
    <?php endforeach; ?>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <?php if($page>1): ?>
                <a href="/urbex/urbex/public/accueil/page/<?=$page-1?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
                <?php endif ?>
            </li>
        <?php for($i = 1; $i<=$nbPages; $i++):?>
            <li><a href="/urbex/urbex/public/accueil/page/<?=$i?>">Page <?=$i?></a></li>
        <?php endfor; ?>
            <li>
                <?php if($page < $nbPages): ?>
                <a href="/urbex/urbex/public/accueil/page/<?=$page+1?>"" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
                <?php endif ?>
            </li>
        </ul>
    </nav>
<?php $this->stop('main_content')?>





