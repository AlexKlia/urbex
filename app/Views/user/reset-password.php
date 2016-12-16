<?php $this->layout('layout', ['title' => 'Réinitialisation du mot de passe']) ?>

<?php $this->start('main_content') ?>

    <?php if (isset($errors)) : ?>
        <div class="alert alert-danger">
            <h3>Erreur:</h3>
            <ul>
                <?php foreach($errors as $key => $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
        </div>

        <div class="form-group">
            <label for="password">Confirmer mot de passe</label>
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
        </div>

        <button type="submit" name="update-password" class="btn btn-default">Modifier le mot de passe</button>
    </form>

<?php $this->stop('main_content') ?>