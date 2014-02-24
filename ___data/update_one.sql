CREATE TABLE IF NOT EXISTS `language` (
  `language_id` INT NOT NULL AUTO_INCREMENT,
  `language_code` VARCHAR(3) NOT NULL COMMENT 'ISO 639-1',
  `language_status` ENUM('default','active','inactive') NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`language_id`),
  UNIQUE INDEX `language_code_UNIQUE` (`language_code` ASC))
ENGINE = InnoDB;

INSERT INTO `language` (`language_id`, `language_code`, `language_status`) VALUES (1, 'hu', 'default');

ALTER TABLE `article`
    ADD CONSTRAINT `fk_language_id` FOREIGN KEY
    (`article_language_id`)
    REFERENCES `language` (`language_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

UPDATE `article` SET `article_language_id`=1 WHERE 1;

ALTER TABLE `article` ADD `article_brother_id` INT NULL AFTER  `article_language_id`;

ALTER TABLE `article`
    ADD CONSTRAINT `fk_brother_id` FOREIGN KEY
    (`article_brother_id`)
    REFERENCES `article` (`article_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;