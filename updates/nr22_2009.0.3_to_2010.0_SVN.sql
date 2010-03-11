UPDATE {pre}_options SET options_value = '2010.0_SVN' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-01-31' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 49 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','maintenance_access','3');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','last_id','1');

UPDATE {pre}_options SET options_mod = 'ckeditor' WHERE options_mod = 'fckeditor';
UPDATE {pre}_options SET options_value = 'ckeditor' WHERE options_mod = 'abcode' AND options_value = 'fckeditor';
UPDATE {pre}_options SET options_value = 'kama' WHERE options_mod = 'ckeditor' AND options_name = 'skin';

ALTER TABLE {pre}_access ADD access_ckeditor int(2) NOT NULL default '0';

UPDATE {pre}_access SET access_ckeditor = access_fckeditor;

ALTER TABLE {pre}_access DROP access_fckeditor;

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'nextbirth_max_users', '5'),
('users', 'navbirth_max_users', '5'), ('users', 'nextbirth_time_interval', '1209600');
