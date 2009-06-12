UPDATE {pre}_options SET options_value = '2009.0' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-06-12' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '42' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

UPDATE {pre}_options SET options_mod = 'contact' WHERE options_mod = 'clansphere' AND options_name = 'def_org';
UPDATE {pre}_options SET options_mod = 'contact' WHERE options_mod = 'clansphere' AND options_name = 'def_mail';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_host', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_port', 25);