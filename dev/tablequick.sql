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
  `first_name` VARCHAR(32) NOT NULL ,
  `last_name` VARCHAR(32) NULL ,
  `phone` VARCHAR(14) NOT NULL ,
  `phone_text_capable` TINYINT NOT NULL DEFAULT 0 ,
  `confirm_code` VARCHAR(8) NULL ,
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


-- -----------------------------------------------------
-- Table `patron`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `patron` ;

CREATE  TABLE IF NOT EXISTS `patron` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `name` VARCHAR(64) NOT NULL ,
  `phone` VARCHAR(14) NOT NULL ,
  `table_number` VARCHAR(10) NULL ,
  `status` ENUM('Waiting','Notified','Seated','Cancelled/Left','Cancelled/At Bar') NOT NULL ,
  `response` ENUM('ok on our way','stay at bar','cancel table') NULL ,
  `time_in` DATETIME NOT NULL ,
  `time_seated` DATETIME NULL ,
  `removed` TINYINT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_patron_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_patron_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `user`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `phone`, `phone_text_capable`, `confirm_code`, `created_at`, `updated_at`, `last_login`) VALUES (1, 'nick@lifthousedesign.com', '4f1f8def85fc3bf2dc58f04a667c8273b37a8b4c', 'Nick', 'Niebaum', '(304) 871-6066', 1, NULL, '2013-08-01 16:35:34', NULL, NULL);

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
INSERT INTO `notification` (`id`, `key`, `name`, `description`, `vars`, `email_enabled`, `email_subject`, `email_message`, `sms_enabled`, `sms_message`, `updated_at`) VALUES (1, 'user_registered', 'User Registered', 'This notification is sent to new users that have just registered an account.', '{\"first_name\":\"User\'s first name\",\"last_name\":\"User\'s last name\",\"email\":\"User\'s e-mail address\",\"phone\":\"User\'s phone number\",\"confirm_url\":\"The URL to activate the account\"}', 1, 'New Account: Please Confirm', 'Hi {first_name},\n\nThank you for registering an account! To complete registration, please confirm your account by clicking the link below:\n\n{confirm_url}', 1, 'Hi {first_name}, please confirm your account by visiting: {confirm_url}', NULL);
INSERT INTO `notification` (`id`, `key`, `name`, `description`, `vars`, `email_enabled`, `email_subject`, `email_message`, `sms_enabled`, `sms_message`, `updated_at`) VALUES (2, 'user_confirmed', 'User Confirmed', 'This notification is sent to new users that have just confirmed their account by clicking on the confirmation link in the User Registered', '{\"first_name\":\"User\'s first name\",\"last_name\":\"User\'s last name\",\"email\":\"User\'s e-mail address\",\"phone\":\"User\'s phone number\",\"login_url\":\"The URL to log in with\"}', 1, 'Account Confirmed', 'Hi {first_name},\n\nThank you for confirming your account. You may log in now by visiting:\n\n{login_url}', 1, 'Hi {first_name}, your account has been verified and you may log in now', NULL);
INSERT INTO `notification` (`id`, `key`, `name`, `description`, `vars`, `email_enabled`, `email_subject`, `email_message`, `sms_enabled`, `sms_message`, `updated_at`) VALUES (3, 'user_forgot_password', 'User Forgot Password', 'This notification is sent to users who have requested a new password with the forgot password form.', '{\"first_name\":\"User\'s first name\",\"last_name\":\"User\'s last name\",\"email\":\"User\'s e-mail address\",\"phone\":\"User\'s phone number\",\"reset_url\":\"The URL to reset the password\"}', 1, 'Reset Your Password', 'Hi {first_name},\n\nClick the link below to reset your account password:\n\n{reset_url}', 1, 'Hi {first_name}, click here to reset your password: {reset_url}', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `patron`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `patron` (`id`, `user_id`, `name`, `phone`, `table_number`, `status`, `response`, `time_in`, `time_seated`, `removed`) VALUES (1, 1, 'Nick Niebaum', '(304) 871-6066', NULL, 'Waiting', NULL, '2013-08-19 21:49:26', NULL, 0);
INSERT INTO `patron` (`id`, `user_id`, `name`, `phone`, `table_number`, `status`, `response`, `time_in`, `time_seated`, `removed`) VALUES (2, 1, 'Somiyah Said', '(304) 871-6066', NULL, 'Notified', NULL, '2013-08-19 20:49:36', NULL, 0);
INSERT INTO `patron` (`id`, `user_id`, `name`, `phone`, `table_number`, `status`, `response`, `time_in`, `time_seated`, `removed`) VALUES (3, 1, 'Theresa Pauley', '(304) 871-6066', NULL, 'Seated', NULL, '2013-08-19 22:49:40', NULL, 0);
INSERT INTO `patron` (`id`, `user_id`, `name`, `phone`, `table_number`, `status`, `response`, `time_in`, `time_seated`, `removed`) VALUES (4, 1, 'Mike Pauley', '(304) 871-6066', NULL, 'Cancelled/Left', NULL, '2013-08-19 23:49:43', NULL, 0);

COMMIT;
