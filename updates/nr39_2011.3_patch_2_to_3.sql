UPDATE {pre}_options SET options_value = '2011.3_Patch_3' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2013-01-17' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '84' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gbook', 'captcha_users', '');