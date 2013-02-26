# --------------------------------------------------------
# Table structure for table {prefix}_{dirname}_relation`
# --------------------------------------------------------

CREATE TABLE {prefix}_{dirname}_relation (
  `relationid` smallint(5) unsigned NOT NULL,
  `wordid` int(8) NOT NULL default '0',
  `relwordid` int(8) NOT NULL default '0',
  PRIMARY KEY  (`relationid`),
  KEY `wordid` (`wordid`)
) ENGINE=MyISAM;


