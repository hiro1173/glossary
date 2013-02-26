# --------------------------------------------------------
# Table structure for table {prefix}_{dirname}_category`
# --------------------------------------------------------
CREATE TABLE `{prefix}_{dirname}_category` (
  `categoryid` int(4) unsigned NOT NULL auto_increment,
  `parentid` int(4) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `weight` int(11) NOT NULL default '0',
  PRIMARY KEY  (`categoryid`),
  KEY `categoryid` (`categoryid`)
) ENGINE=MyISAM ;

# --------------------------------------------------------
# Table structure for table {prefix}_{dirname}_word`
# --------------------------------------------------------
CREATE TABLE `{prefix}_{dirname}_word` (
  `wordid` int(8) unsigned NOT NULL auto_increment,
  `categoryid` int(4) NOT NULL default '0',
  `term` varchar(255) NOT NULL default '0',
  `english` varchar(255) NOT NULL,
  `proc` varchar(255) NOT NULL default '0',
  `init` varchar(10) NOT NULL default '0',
  `description` text NOT NULL,
  `reference` varchar(255) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '0',
  `submitter` int(5) NOT NULL default '0',
  `submited` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `block` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`wordid`),
  KEY `wordid` (`wordid`),
  KEY `src_term` (`term`(10))
) ENGINE=MyISAM ;


# --------------------------------------------------------
# Table structure for table `glossary_tag`
# --------------------------------------------------------

CREATE TABLE {prefix}_{dirname}_tag (
  `tagid` int(11) unsigned NOT NULL auto_increment,
  `wordid` int(8) NOT NULL default '0',
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`tagid`),
  KEY `wordid_tag` (`wordid`,`tag`)
) ENGINE=MyISAM ;
