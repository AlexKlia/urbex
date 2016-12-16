<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>

    <link rel="stylesheet" href="<?= $this->assetUrl('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
    <script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initialize&key=AIzaSyAzIhfO2Fr7beUdTpXogwie0L1YDMbP3hE" async defer></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="<?= $this->assetUrl('js/script.js') ?>"></script>
    <style>
        #map {
            width: 600px;
            height: 200px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header col col-sm-2">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= $this->url('default_home') ?>">Urbex</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Urbex Pics</a></li>
                        <li><a href="<?= $this->url('pictures_add') ?>">Partager</a></li>
                        <li><a href="<?= $this->url('default_about') ?>">A propos</a></li>default_about
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </header>

	<div class="container">

        <h1><?= $this->e($title) ?></h1><br>

		<section>
			<?= $this->section('main_content') ?>

		</section>

        <section>
            <?= $this->section('map') ?>

        </section>

		<footer>
		</footer>
	</div>
</body>
</html>