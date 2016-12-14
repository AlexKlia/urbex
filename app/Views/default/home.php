<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>

<?php if (isset($_SESSION['user'])) : ?>
    <pre>
        <?php print_r($_SESSION['user']); ?>
    </pre>
<?php endif; ?>
	<h2>Let's code.</h2>
	<p>Vous avez atteint la page d'accueil. Bravo.</p>
	<p>Et maintenant, RTFM dans <strong><a href="../docs/tuto/" title="Documentation de W">docs/tuto</a></strong>.</p>
<?php $this->stop('main_content') ?>
