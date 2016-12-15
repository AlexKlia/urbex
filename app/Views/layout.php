<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title><?= $this->e($title) ?></title>

    <!--<link rel="stylesheet" href="<?/*= $this->assetUrl('css/bootstrap.min.css') */?>">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $this->assetUrl('css/style.css') ?>">
    <script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
</head>
<body>
	<div class="container">

		<header>
			<h1> <?= $this->e($title) ?></h1>
		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>

		<footer>
		</footer>
	</div>
</body>
</html>