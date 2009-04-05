UPDATE {pre}_options SET options_value = '2009.0 RC2' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-04-05' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '38' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_last', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_time', '0');