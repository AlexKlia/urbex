<?php $this->layout('layout', ['title' => 'Login']) ?>

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

<?php if (isset($_SESSION['flash'])) : ?>

    <?php foreach($_SESSION['flash'] as $key => $message) : ?>
        <div class="alert alert-<?= $key ?>">
            <?= $message ?>
        </div>
    <?php endforeach; ?>

<?php unset($_SESSION['flash']); endif; ?>

<form action="" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email"  <?php if (isset($confirm['email'])) {echo 'value="'.$confirm['email'].'"';} ?> id="email" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
    </div>

    <button type="submit" name="submit" class="btn btn-default">Connexion</button>
    <button class="btn btn-default"><a href="<?= $this->url('users_sign_in') ?>">Inscription</a></button>
</form><br>
<a href="<?= $this->url('user_password_recovery') ?>">Mot de passe oubliée ?</a>
<?php $this->stop('main_content') ?>
