<?php $this->layout('layout',['title'=>'Derniers Partages'])?>

<?php $this->start('main_content')?>
    <?php foreach ($allPictures as $picture): ?>
    <div class="row">
        <div class="col-md-1">
            <button type="button" class="btn btn-default" aria-label="Left Align">
                <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
            </button>
        </div>

        <div class="col-md-3">
                <img class="img-responsive" src="<?= $this->assetUrl('img/' . $picture['url'] . '.jpg' )?>" alt="<?= $picture['title']?>">
        </div>
        <div class="col-md-8">
                <h2><?= $picture['title']?></h2>
                <p><?= $picture['descr']?></p>
                <p>Posté par: <?= $picture['username']?></p>

        </div>

    </div>
    <hr/>
    <?php endforeach; ?>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="page/<?=$i-1?>"" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php for($i = 1; $i<=$nbPages; $i++):?>
            <li><a href="page/<?=$i?>">Page <?=$i?></a></li>
        <?php endfor; ?>
            <li>
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
<?php $this->stop('main_content')?>





