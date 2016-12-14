<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 14/12/2016
 * Time: 11:35
 */ ?>

<?php $this->layout('layout', ['title' => "Pics"]); ?>
<?php $this->start('main_content'); ?>

<h1>Bienvenu</h1>
<?php print_r($error)?>
<?php $this->stop('main_content'); ?>