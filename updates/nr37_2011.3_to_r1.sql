UPDATE {pre}_options SET options_value = '2011.3 r1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2012-03-14' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '80' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_users ADD users_country2 varchar(40) NOT NULL default '';
UPDATE {pre}_users SET users_country2 = users_country;
ALTER TABLE {pre}_users DROP users_country;
ALTER TABLE {pre}_users ADD users_country varchar(40) NOT NULL default '';
UPDATE {pre}_users SET users_country = users_country2;
ALTER TABLE {pre}_users DROP users_country2;