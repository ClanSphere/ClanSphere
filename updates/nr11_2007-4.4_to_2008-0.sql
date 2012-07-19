UPDATE {pre}_options SET options_value = '2008.0' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2008-02-08' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '28' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_threads ADD threads_ghost int(2) NOT NULL default '0';
ALTER TABLE {pre}_threads ADD threads_ghost_board int(8) NOT NULL default '0';
ALTER TABLE {pre}_threads ADD threads_ghost_thread int(8) NOT NULL default '0';
ALTER TABLE {pre}_board ADD board_read int(2) NOT NULL default '0';

ALTER TABLE {pre}_access CHANGE access_updates access_database int(2) NOT NULL default '0';
ALTER TABLE {pre}_mail ADD mail_msn varchar(40) NOT NULL default '';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'width', '90');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'height', '400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'background', '000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'view', 'stats');