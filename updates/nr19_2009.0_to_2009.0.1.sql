UPDATE {pre}_options SET options_value = '2009.0.1 SVN' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-06-14' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 43 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

UPDATE {pre}_users SET users_view = '' WHERE users_view NOT IN ('float', 'list');

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'cache_unicode', '0');

ALTER TABLE {pre}_eventguests DROP INDEX 'events_id';

ALTER TABLE {pre}_eventguests ADD eventguests_name varchar(80) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_surname varchar(80) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_phone varchar(40) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_mobile varchar(40) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_residence text;
ALTER TABLE {pre}_eventguests ADD eventguests_notice text;