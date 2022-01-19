<?php
// tvars(get_defined_vars());
?>
<!doctype html>
<html lang="pt-pt">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;700&family=Rubik:wght@300;500&display=swap"
          rel="stylesheet">

    <!-- My CSS -->
    <link href="<?= ASSETS_URL ?>css/style.css?t=<?= time() ?>" rel="stylesheet">

    <title><?= PRJ_TITLE ?? '' ?></title>
</head>
<body>

<div class="container p404">

    <h1>404</h1>
    <br>
    <br>
    <h4>Página <strong><?= $page ?></strong> inexistente !</h4>

</div>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- My JS -->
<script src="<?= ASSETS_URL ?>js/script.js?t=<?= time() ?>"></script>
</body>
</html>
