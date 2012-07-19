UPDATE {pre}_options SET options_value = '2007.4.1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2007-09-27' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '20' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'mod_rewrite', '0');