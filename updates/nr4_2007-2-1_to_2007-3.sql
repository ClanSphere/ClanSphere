UPDATE {pre}_options SET options_value = '2007.3' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2007-06-26' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '13' WHERE options_mod = 'clansphere' AND options_name = 'version_id';
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners','last_id','0');
ALTER TABLE {pre}_banners ADD categories_id int(8) NOT NULL default '0';


ALTER TABLE {pre}_rules ADD rules_order2 int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_rules SET rules_order2 = rules_order;
ALTER TABLE {pre}_rules DROP rules_order;
ALTER TABLE {pre}_rules ADD rules_order int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_rules SET rules_order = rules_order2;
ALTER TABLE {pre}_rules DROP rules_order2;
