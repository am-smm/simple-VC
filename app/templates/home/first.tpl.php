<?php
// tvars(get_defined_vars());

view()->load('base/header');

?>
<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>

<div class="container p404">
    <div class="row mb-3">
        <div class="flash-messages"><?= flash()->get() ?></div>
    </div>
    <div class="row">

        <div class="col"><h1> Root / </h1>

            <h4> DDL </h4>
            <pre class="prettyprint">
DROP SCHEMA IF EXISTS `smm_lap`;
CREATE DATABASE `smm_lap` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `smm_lap`;

CREATE TABLE `auth` (
    `id` bigint unsigned NOT NULL AUTO_INCREMENT,
    `username` varchar(255) DEFAULT NULL,
    `pass` varchar(255) DEFAULT NULL,
--   0 - registado (sem privilegios)
--   1 - Superuser
--  10 - Cliente
-- 100 - Colaborador
    `tipo` tinyint unsigned NOT NULL DEFAULT '0',
    `member_id` bigint unsigned DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_auth_credentials` (`username`, `pass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `cliente` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `tlm` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nif` varchar(255) DEFAULT NULL,
  `obs` text COLLATE utf8_unicode_ci,
  `dh_removido` timestamp NULL DEFAULT NULL,
  `dh_criado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_cliente_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `colaborador` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `ordenado_bruto` decimal(9,2) DEFAULT NULL,
  `tlm` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nif` varchar(255) DEFAULT NULL,
  `obs` text COLLATE utf8_unicode_ci,
  `dh_removido` timestamp NULL DEFAULT NULL,
  `dh_criado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_colaborador_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
CREATE TABLE `marcacao` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint unsigned NOT NULL,
  `colaborador_id` bigint unsigned NOT NULL,
  `dh` datetime DEFAULT NULL,
  `tempo_gasto` tinyint unsigned NOT NULL DEFAULT '0',
  `custo` decimal(6,2) DEFAULT NULL,
  `dh_desmarcada` timestamp NULL DEFAULT NULL,
  `dh_realizada` timestamp NULL DEFAULT NULL,
  `dh_criado` timestamp NULL DEFAULT NULL,
  `dh_paga` timestamp NULL DEFAULT NULL,
  `obs` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxu_marcacao_dh` (`cliente_id`,`colaborador_id`,`dh`),
  KEY `fk_marcacao_cliente_idx` (`cliente_id`),
  KEY `fk_marcacao_colaborador_idx` (`colaborador_id`),
  CONSTRAINT `fk_marcacao_cliente` FOREIGN KEY (`cliente_id`)
      REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_marcacao_colaborador` FOREIGN KEY (`colaborador_id`)
      REFERENCES `colaborador` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
        </pre>
        </div>
        <div class="col">
            <h4>Links</h4>
            <p><a href="https://getbootstrap.com/docs/5.1/getting-started/introduction/">Bootstrap</a></p>
            <p><a href="https://fontawesome.bootstrapcheatsheets.com/">FONT AWESOME</a></p>
            <p><a href="https://www.flaticon.com/">Icons</a></p>
            <p><a href="https://api.jquery.com/">jQuery</a></p>
            <p>Dados gerados com <a href="https://generatedata.com/">https://generatedata.com</a></p>
            <p><br></p>
            <img src="<?= PUBLIC_URL ?>lap-modelo-ER.png" class="img-fluid" alt="ER">
            <p><br></p>
            <a href="<?= ASSETS_URL ?>lap.sql" download >DDL + Dados (SQL create script)</a>
            <p><br></p>
            <h3><a href="<?= url()->to('home') ?>">Home...</a></h3>

        </div>
    </div>
</div>
<?php
// tvars(get_defined_vars());

view()->load('base/footer')
?>
