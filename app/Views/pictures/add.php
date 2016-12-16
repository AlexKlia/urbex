<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 14/12/2016
 * Time: 10:05
 */ ?>

<?php $this->layout('layout', ['title' => "Ajout d'image"]); ?>
<?php $this->start('main_content'); ?>


<form action="#" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" name="title" placeholder="Titre de l'image" class="form-control" id="title">
        <textarea name="description" id="descr" cols="30" rows="10" class="form-control"></textarea>
        <label>Image : </label><input type="file" name="url"  id="url">

        <div class="ui-widget">
            <input type="text" name="geo" id="geo" class="form-control" placeholder="Emplacement géographique">
            <label for="geo">Tags: </label>
        </div>
        <input type="submit" name="submit" value="Ajouter une image">
        <input type="hidden" id="path" value="<?= $this->url('pictures_ajax-operation'); ?> ">
    </div>



</form>

<?php $this->stop('main_content'); ?>

<?php $this-> start('map')?>
    <div id="map">

    </div>
<?php $this-> stop('map')?>
