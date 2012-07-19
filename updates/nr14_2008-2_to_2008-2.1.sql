UPDATE {pre}_options SET options_value = '2008.2.1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2008-09-20' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '34' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'ajax', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'ajax_reload', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_news','0');
ALTER TABLE {pre}_users ADD users_ajax int(1) NOT NULL default '0';