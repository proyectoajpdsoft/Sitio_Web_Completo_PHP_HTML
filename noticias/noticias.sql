CREATE TABLE news (
  id int(11) NOT NULL auto_increment,
  newsdate varchar(50) NOT NULL default '',
  newstitle varchar(100) NOT NULL default '',
  news text NOT NULL,
  PRIMARY KEY  (id),
  FULLTEXT KEY news (news)
) TYPE=MyISAM COMMENT='bdajpdsoft Table';

