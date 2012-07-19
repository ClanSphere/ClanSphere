UPDATE {pre}_options SET options_value = '2008.2' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2008-08-15' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '32' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('comments', 'show_avatar', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'abcode', '1,1,1,0,0');

ALTER TABLE {pre}_rules ADD rules_order2 varchar(5) NOT NULL default '';
UPDATE {pre}_rules SET rules_order2 = rules_order;
ALTER TABLE {pre}_rules DROP rules_order;
ALTER TABLE {pre}_rules ADD rules_order int(5) NOT NULL default '0';
UPDATE {pre}_rules SET rules_order = rules_order2;
ALTER TABLE {pre}_rules DROP rules_order2;

UPDATE {pre}_gbook SET gbook_lock = '1' WHERE gbook_lock = '0';

ALTER TABLE {pre}_access ADD access_templates INT( 2 ) NOT NULL;
UPDATE {pre}_access SET access_templates = '1' WHERE access_id = '1';
UPDATE {pre}_access SET access_templates = '2' WHERE access_id = '2';
UPDATE {pre}_access SET access_templates = '3' WHERE access_id = '3';
UPDATE {pre}_access SET access_templates = '4' WHERE access_id = '4';
UPDATE {pre}_access SET access_templates = '5' WHERE access_id = '5';

ALTER TABLE {pre}_users ADD users_tpl varchar(80) NOT NULL default '';
ALTER TABLE {pre}_users ADD users_invisible int(2) NOT NULL default '0';
ALTER TABLE {pre}_news ADD news_readmore text;
ALTER TABLE {pre}_news ADD news_readmore_active int(2) NOT NULL default '0';
ALTER TABLE {pre}_news ADD news_mirror text;
ALTER TABLE {pre}_news ADD news_mirror_name text;

