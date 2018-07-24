SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `climai`.`especialidades`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`especialidades` (
  `idespecialidades` INT NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idespecialidades`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`funcionarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`funcionarios` (
  `matricula` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `nr_conselho` INT NOT NULL ,
  `percentual` INT NOT NULL ,
  `especialidades_idespecialidades` INT NOT NULL ,
  PRIMARY KEY (`matricula`, `especialidades_idespecialidades`) ,
  INDEX `fk_funcionarios_especialidades` (`especialidades_idespecialidades` ASC) ,
  CONSTRAINT `fk_funcionarios_especialidades`
    FOREIGN KEY (`especialidades_idespecialidades` )
    REFERENCES `climai`.`especialidades` (`idespecialidades` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`usuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`usuarios` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(60) NOT NULL ,
  `login` VARCHAR(20) NOT NULL ,
  `senha` VARCHAR(8) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `funcionarios_matricula` INT NOT NULL ,
  `funcionarios_especialidades_idespecialidades` INT NOT NULL ,
  `perfil` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`idUsuario`, `funcionarios_matricula`, `funcionarios_especialidades_idespecialidades`) ,
  INDEX `fk_usuarios_funcionarios` (`funcionarios_matricula` ASC, `funcionarios_especialidades_idespecialidades` ASC) ,
  CONSTRAINT `fk_usuarios_funcionarios`
    FOREIGN KEY (`funcionarios_matricula` , `funcionarios_especialidades_idespecialidades` )
    REFERENCES `climai`.`funcionarios` (`matricula` , `especialidades_idespecialidades` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`planos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`planos` (
  `idplanos` INT NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idplanos`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`pacientes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`pacientes` (
  `idpaciente` INT(11) NOT NULL ,
  `cpf` VARCHAR(11) NULL ,
  `nome` VARCHAR(100) NOT NULL ,
  `rg` INT(14) NULL ,
  `endereco` VARCHAR(100) NULL ,
  `telefone_residencial` INT(8) NULL ,
  `telefone_celular` INT(8) NOT NULL ,
  `telefone_trabalho` INT(8) NULL ,
  `email` VARCHAR(50) NULL ,
  `profissao` VARCHAR(30) NULL ,
  `data_nascimento` DATE NULL ,
  `filiacao` VARCHAR(150) NULL ,
  `nr_plano` INT(20) NULL ,
  `planos_idplanos` INT NOT NULL ,
  PRIMARY KEY (`idpaciente`, `planos_idplanos`) ,
  INDEX `fk_paciente_planos` (`planos_idplanos` ASC) ,
  CONSTRAINT `fk_paciente_planos`
    FOREIGN KEY (`planos_idplanos` )
    REFERENCES `climai`.`planos` (`idplanos` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`agenda`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`agenda` (
  `idagenda` INT NOT NULL AUTO_INCREMENT ,
  `dia` INT(2) NOT NULL ,
  `mes` INT(2) NOT NULL ,
  `ano` INT(4) NOT NULL ,
  `hora` VARCHAR(5) NOT NULL ,
  `situacao` VARCHAR(20) NOT NULL DEFAULT 'Atendido ou Faltou' ,
  `funcionarios_matricula` INT NOT NULL ,
  `funcionarios_especialidades_idespecialidades` INT NOT NULL ,
  `nr_sessao` INT(2) NOT NULL ,
  `pacientes_idpaciente` INT(11) NOT NULL ,
  `pacientes_planos_idplanos` INT NOT NULL ,
  PRIMARY KEY (`idagenda`, `funcionarios_matricula`, `funcionarios_especialidades_idespecialidades`, `pacientes_idpaciente`, `pacientes_planos_idplanos`) ,
  INDEX `fk_agenda_funcionarios` (`funcionarios_matricula` ASC, `funcionarios_especialidades_idespecialidades` ASC) ,
  INDEX `fk_agenda_pacientes` (`pacientes_idpaciente` ASC, `pacientes_planos_idplanos` ASC) ,
  CONSTRAINT `fk_agenda_funcionarios`
    FOREIGN KEY (`funcionarios_matricula` , `funcionarios_especialidades_idespecialidades` )
    REFERENCES `climai`.`funcionarios` (`matricula` , `especialidades_idespecialidades` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_agenda_pacientes`
    FOREIGN KEY (`pacientes_idpaciente` , `pacientes_planos_idplanos` )
    REFERENCES `climai`.`pacientes` (`idpaciente` , `planos_idplanos` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`servicos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`servicos` (
  `idservicos` INT NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(100) NOT NULL ,
  `mes` INT(2) NOT NULL ,
  `ano` INT(4) NOT NULL ,
  `valor` FLOAT NOT NULL ,
  `planos_idplanos` INT NOT NULL ,
  `funcionarios_matricula` INT NOT NULL ,
  `funcionarios_especialidades_idespecialidades` INT NOT NULL ,
  PRIMARY KEY (`idservicos`, `planos_idplanos`, `funcionarios_matricula`, `funcionarios_especialidades_idespecialidades`) ,
  INDEX `fk_servicos_planos` (`planos_idplanos` ASC) ,
  INDEX `fk_servicos_funcionarios` (`funcionarios_matricula` ASC, `funcionarios_especialidades_idespecialidades` ASC) ,
  CONSTRAINT `fk_servicos_planos`
    FOREIGN KEY (`planos_idplanos` )
    REFERENCES `climai`.`planos` (`idplanos` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_servicos_funcionarios`
    FOREIGN KEY (`funcionarios_matricula` , `funcionarios_especialidades_idespecialidades` )
    REFERENCES `climai`.`funcionarios` (`matricula` , `especialidades_idespecialidades` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `climai`.`horario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `climai`.`horario` (
  `idhorario` INT NOT NULL AUTO_INCREMENT ,
  `descricao` VARCHAR(5) NOT NULL ,
  `diasemana` VARCHAR(8) NOT NULL ,
  `funcionarios_matricula` INT NOT NULL ,
  `funcionarios_especialidades_idespecialidades` INT NOT NULL ,
  PRIMARY KEY (`idhorario`, `funcionarios_matricula`, `funcionarios_especialidades_idespecialidades`) ,
  INDEX `fk_horario_funcionarios` (`funcionarios_matricula` ASC, `funcionarios_especialidades_idespecialidades` ASC) ,
  CONSTRAINT `fk_horario_funcionarios`
    FOREIGN KEY (`funcionarios_matricula` , `funcionarios_especialidades_idespecialidades` )
    REFERENCES `climai`.`funcionarios` (`matricula` , `especialidades_idespecialidades` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
