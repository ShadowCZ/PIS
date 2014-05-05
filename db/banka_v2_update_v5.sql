ALTER TABLE `employee`
CHANGE `last_ip` `last_ip` varchar(50) COLLATE 'utf8_czech_ci' NULL AFTER `active`,
COMMENT='';