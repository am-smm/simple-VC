
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema smm_tarefas
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `smm_tarefas` ;

-- -----------------------------------------------------
-- Schema smm_tarefas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `smm_tarefas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `smm_tarefas` ;


-- -----------------------------------------------------
-- Table `utilizador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `smm_tarefas`.`utilizador` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(30) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `psw` VARCHAR(64) NULL DEFAULT NULL,
  `grp` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `dh_last_login` TIMESTAMP NULL DEFAULT NULL,
  `is_logged` TINYINT UNSIGNED NOT NULL DEFAULT '0',
  `dh_registo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `projeto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `smm_tarefas`.`projeto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `dh_registo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `dh_terminado` TIMESTAMP NULL DEFAULT NULL,
  `dh_desativado` TIMESTAMP NULL DEFAULT NULL,
  `reg_utilizador_id` INT UNSIGNED NOT NULL,
  INDEX `fk_projeto_utilizador_idx` (`reg_utilizador_id` ASC) ,
  CONSTRAINT `fk_projeto_utilizador`
    FOREIGN KEY (`reg_utilizador_id`)
    REFERENCES `smm_tarefas`.`utilizador`  (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `tarefa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `smm_tarefas`.`tarefa` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NULL DEFAULT NULL,
  `dh_iniciada` TIMESTAMP NULL DEFAULT NULL,
  `dh_terminada` TIMESTAMP NULL DEFAULT NULL,
  `dur_mn` INT UNSIGNED NOT NULL DEFAULT '0',
  `dh_registo` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `reg_utilizador_id` INT UNSIGNED NOT NULL,
  `projeto_id` INT UNSIGNED DEFAULT NULL,
  INDEX `fk_tarefa_projeto_idx` (`projeto_id` ASC),
  CONSTRAINT `fk_tarefa_projeto`
    FOREIGN KEY (`projeto_id`)
    REFERENCES `smm_tarefas`.`projeto`  (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  INDEX `fk_tarefa_utilizador_idx` (`reg_utilizador_id` ASC),
  CONSTRAINT `fk_tarefa_utilizador`
    FOREIGN KEY (`reg_utilizador_id`)
    REFERENCES `smm_tarefas`.`utilizador`  (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
