SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user` ;

CREATE  TABLE IF NOT EXISTS `user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(64) NOT NULL ,
  `password` VARCHAR(64) NOT NULL ,
  `first_name` VARCHAR(32) NULL ,
  `last_name` VARCHAR(32) NULL ,
  `phone` VARCHAR(14) NULL ,
  `phone_text_capable` TINYINT NULL DEFAULT 0 ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NULL ,
  `last_login` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role` ;

CREATE  TABLE IF NOT EXISTS `role` (
  `user_id` INT NOT NULL ,
  `role` VARCHAR(32) NOT NULL ,
  INDEX `fk_role_user_idx` (`user_id` ASC) ,
  PRIMARY KEY (`user_id`, `role`) ,
  CONSTRAINT `fk_role_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notification` ;

CREATE  TABLE IF NOT EXISTS `notification` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `key` VARCHAR(64) NOT NULL ,
  `name` VARCHAR(64) NOT NULL ,
  `description` TEXT NULL ,
  `vars` TEXT NOT NULL ,
  `email_enabled` TINYINT NOT NULL DEFAULT 0 ,
  `email_subject` TEXT NULL ,
  `email_message` TEXT NULL ,
  `sms_enabled` TINYINT NOT NULL DEFAULT 0 ,
  `sms_message` VARCHAR(160) NULL ,
  `updated_at` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `user`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `phone`, `phone_text_capable`, `created_at`, `updated_at`, `last_login`) VALUES (1, 'nick@lifthousedesign.com', '4f1f8def85fc3bf2dc58f04a667c8273b37a8b4c', 'Nick', 'Niebaum', '(304) 871-6066', 1, '2013-08-01 16:35:34', NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `role`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `role` (`user_id`, `role`) VALUES (1, 'administrator');

COMMIT;

-- -----------------------------------------------------
-- Data for table `notification`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `notification` (`id`, `key`, `name`, `description`, `vars`, `email_enabled`, `email_subject`, `email_message`, `sms_enabled`, `sms_message`, `updated_at`) VALUES (1, 'test_notification', 'Test Notification', 'This is the default notification upon installing the project template. An administrator should add these notifications.', '[]', 1, NULL, 'This is the e-mail message.', 1, 'This is the SMS message.', NULL);

COMMIT;
