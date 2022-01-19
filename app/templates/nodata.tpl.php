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

    <h1>???</h1>
    <br>
    <br>
    <h4><?= $msg_erro ?></h4>
    <br>
    <br>
    <a href="<?= $link ?>"><?= $msg_link ?></a>
</div>
</body>
</html>
