CREATE TABLE IF NOT EXISTS `users`(
`id` number(38) NOT NULL auto_increment,
`username` varchar(20) NOT NULL default '',
`password` varchar(20) NOT NULL default '',
`nume` varchar(50) NOT NULL default '',
`prenume` varchar(50) NOT NULL default '',
`email` varchar(50) NOT NULL default '',
`telefon` char(10) default '',
`descriere` varchar(100) '',
`no_q` int(40) default '0',
`no_a` int(40) default '0',
`moderator` boolean default false,
`badges` set('0','1','2','3','4','5','6','7') default '0',
PRIMARY KEY (`id`),
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `questions`(
`id` number(38) NOT NULL auto_increment,
`id_owner` number(38) default '',
`categorie` varchar(20) NOT NULL default 'diverse',
`continut` varchar(120) NOT NULL,
`answer_id` number(38),
PRIMARY KEY (`id`),
FOREIGN KEY (`id_owner`) REFERENCES users(`id`)

)ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;




