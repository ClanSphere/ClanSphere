UPDATE {pre}_options SET options_value = '2010.0 DEV 5' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-08-20' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 59 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'count_lastday', '0');

ALTER TABLE {pre}_maps ADD server_name varchar(100) NOT NULL default '';