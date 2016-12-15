<?php $this->layout('layout', ['title' => 'Mot de passe oublié']) ?>

<?php $this->start('main_content') ?>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger">
            <h3>Erreur:</h3>
            <?= $error ?>
        </div>
    <?php endif; ?>

    Pour réinitialiser votre mot de passe, entrez votre adresse mail :

    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>

        <button type="submit" name="send-email" class="btn btn-default">Envoyer un mail de réinitialisation</button>
    </form>

<?php $this->stop('main_content') ?>