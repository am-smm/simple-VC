<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= url()->to('home') ?>">
            <img src="<?= ASSETS_URL ?>imgs/logo.jpeg" alt="home">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= url()->classeIf('home') ?>"
                       href="<?= url()->to('home') ?>">Home</a>
                </li>
            </ul>
            <?php
            if (auth()->user($user)) : ?>
                <ul class="navbar-nav d-flex">
                    <li class="nav-item mx-2">
                        <a class="nav-link"
                           href="<?= url()->to('logout') ?>" title="Sair">
                            <img src="<?= ASSETS_URL ?>imgs/logout.png" alt="logout" width="30">
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link"
                           href="<?= url()->to('perfil') ?>" title="Perfil">
                            <img src="<?= ASSETS_URL ?>imgs/user.png" alt="perfil" width="30">
                        </a>
                    </li>
                </ul>
            <?php
            endif; ?>
        </div>
    </div>
</nav>