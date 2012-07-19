UPDATE {pre}_options SET options_value = '2007.4.4' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2007-12-13' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '26' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_joinus ADD users_pwd varchar(40) NOT NULL default '';

ALTER TABLE {pre}_access ADD access_fckeditor int(2) NOT NULL default '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fckeditor', 'mode', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fckeditor', 'skin', 'default');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fckeditor', 'height', '400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'lightbox', '1');