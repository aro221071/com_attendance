CREATE TABLE IF NOT EXISTS `#__attendance_items` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`year` INT(4)  NOT NULL ,
`number` INT(6)  NOT NULL ,
`name` VARCHAR(50)  NOT NULL ,
`date` DATE NOT NULL DEFAULT '0000-00-00',
`type` INT NOT NULL ,
`mode` VARCHAR(50)  NOT NULL ,
`place` INT(2)  NOT NULL ,
`teams` INT(2)  NOT NULL ,
`driver` VARCHAR(50)  NOT NULL ,
`team` VARCHAR(150)  NOT NULL ,
`distance` REAL(5,2)  NOT NULL ,
`fee` REAL(5,2)  NOT NULL ,
`fare` REAL(5,2)  NOT NULL ,
`currency` VARCHAR(3)  NOT NULL ,
`sortkey` INT(6)  NOT NULL ,
`published` TINYINT(4)  NOT NULL ,
`comment` TEXT NOT NULL ,
`created` TIME NOT NULL ,
`creator` VARCHAR(50)  NOT NULL ,
`modified` TIME NOT NULL ,
`modifier` VARCHAR(50)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__attendance_type` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`shortname` VARCHAR(30)  NOT NULL ,
`longname` VARCHAR(150)  NOT NULL ,
`sortkey` INT(11)  NOT NULL ,
`published` INT(11)  NOT NULL ,
`created` TIME NOT NULL ,
`creator` VARCHAR(50)  NOT NULL ,
`modified` TIME NOT NULL ,
`modifier` VARCHAR(50)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;

