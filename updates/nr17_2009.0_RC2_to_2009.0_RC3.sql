ALTER TABLE {pre}_count_archiv ADD count_mode int(2) NOT NULL default '0';
ALTER TABLE {pre}_board ADD board_last_time int(14) NOT NULL default '0';
ALTER TABLE {pre}_board ADD board_last_user varchar(40) NOT NULL default '';
ALTER TABLE {pre}_board ADD board_last_userid int(8) NOT NULL default '0';
ALTER TABLE {pre}_board ADD board_last_thread varchar(200) NOT NULL default '';
ALTER TABLE {pre}_board ADD board_last_threadid int(8) NOT NULL default '0';

DELETE FROM {pre}_options WHERE options_mod = 'fckeditor' AND options_name = 'mode';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_html', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_more', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'last_archiv_day', '1');

UPDATE {pre}_options SET options_value = '2009.0 RC 3' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-05-17' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '40' WHERE options_mod = 'clansphere' AND options_name = 'version_id';