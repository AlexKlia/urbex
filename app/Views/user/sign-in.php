<?php $this->layout('layout', ['title' => 'Inscription']) ?>

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
        <label for="username">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="username" <?php if (isset($confirm['username'])) {echo 'value="'.$confirm['username'].'"';} ?> id="username" placeholder="John Doe">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email"  <?php if (isset($confirm['email'])) {echo 'value="'.$confirm['email'].'"';} ?> id="email" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
    </div>

    <div class="form-group">
        <label for="confirmPassword">Confirmation mot de passe</label>
        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
    </div>

    <div class="g-recaptcha" data-sitekey="6LeC1A4UAAAAAPFlNlpSzZWGg491ej3yTCxhVVJu"></div>
    <br>

    <button type="submit" name="submit" class="btn btn-default">Inscription</button>
</form>
<?php $this->stop('main_content') ?>

