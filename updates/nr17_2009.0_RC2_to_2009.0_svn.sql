UPDATE {pre}_options SET options_value = '2009.0_svn' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-04-23' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '39' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

DELETE FROM {pre}_options WHERE options_mod = 'fckeditor' AND options_name = 'mode';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_html', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_more', '');

ALTER TABLE {pre}_board ADD board_last_time int(14) NOT NULL DEFAULT '0';
ALTER TABLE {pre}_board ADD board_last_user varchar(40) NOT NULL DEFAULT '';
ALTER TABLE {pre}_board ADD board_last_userid int(8) NOT NULL DEFAULT '0';
ALTER TABLE {pre}_board ADD board_last_thread varchar(200) NOT NULL default '';
ALTER TABLE {pre}_board ADD board_last_threadid int(8) NOT NULL DEFAULT '0';