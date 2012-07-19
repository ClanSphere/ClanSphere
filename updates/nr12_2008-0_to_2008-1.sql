UPDATE {pre}_options SET options_value = '2008.1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2008-05-02' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '30' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_votes ADD votes_several int(2) NOT NULL default '0';
ALTER TABLE {pre}_categories ADD categories_subid int(9) NOT NULL default '0';
ALTER TABLE {pre}_users ADD users_newsletter int(1) NOT NULL default '1';
ALTER TABLE {pre}_rules ADD rules_title varchar(80) NOT NULL default '';
ALTER TABLE {pre}_news ADD news_publishs_at int(11) NOT NULL default '0';
ALTER TABLE {pre}_rules CHANGE rules_order rules_order varchar(5) NOT NULL default '';

ALTER TABLE {pre}_users CHANGE users_register users_register int(11) default NULL,
 CHANGE users_laston users_laston int(11) default NULL,
 CHANGE users_readtime users_readtime int(11) NOT NULL default '1209600';
 
ALTER TABLE {pre}_board CHANGE users_id users_id INT( 11 ) NOT NULL DEFAULT '0',
 CHANGE board_time board_time INT( 11 ) NOT NULL DEFAULT '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textsize', '12');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textcolor', 'FFFFFF');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textballoncolor', '000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'axescolor', '0F4781');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'indicatorcolor', '3972AD');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'graphcolor1', '2BCB02');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'graphcolor2', 'FF0000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gbook', 'lock', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news','max_recent','8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news','max_navlist','4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars','max_navlist','4');

CREATE TABLE {pre}_notifications (
  notifications_id {serial},
  users_id int(11) NOT NULL,
  notifications_board int(1) NOT NULL default '1',
  notifications_pm int(1) NOT NULL default '1',
  notifications_clanwar int(1) NOT NULL default '1',
  PRIMARY KEY  (notifications_id),
  KEY users_id (users_id)
) {engine};

ALTER TABLE {pre}_gbook ADD gbook_lock int(1) NOT NULL default '0';
UPDATE {pre}_gbook SET gbook_lock = '1' WHERE gbook_lock = '0';