UPDATE {pre}_options SET options_value = '2009.0.1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-07-05' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 44 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

UPDATE {pre}_users SET users_view = '' WHERE users_view NOT IN ('float', 'list');

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'cache_unicode', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'data_limit', 20);

ALTER TABLE {pre}_eventguests ADD eventguests_name varchar(80) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_surname varchar(80) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_phone varchar(40) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_mobile varchar(40) NOT NULL default '';
ALTER TABLE {pre}_eventguests ADD eventguests_residence text;
ALTER TABLE {pre}_eventguests ADD eventguests_notice text;

RENAME TABLE {pre}_eventguests TO {pre}_eventguests2;

CREATE TABLE {pre}_eventguests (
  eventguests_id {serial},
  events_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  eventguests_since int(14) NOT NULL default '0',
  eventguests_name varchar(80) NOT NULL default '',
  eventguests_surname varchar(80) NOT NULL default '',
  eventguests_phone varchar(40) NOT NULL default '0',
  eventguests_mobile varchar(40) NOT NULL default '0',
  eventguests_residence text,
  eventguests_notice text,
  PRIMARY KEY (eventguests_id)
){engine};

INSERT INTO {pre}_eventguests (eventguests_id, events_id, users_id, eventguests_since, eventguests_name, eventguests_surname, eventguests_phone, eventguests_mobile, eventguests_residence, eventguests_notice) SELECT eventguests_id, events_id, users_id, eventguests_since, eventguests_name, eventguests_surname, eventguests_phone, eventguests_mobile, eventguests_residence, eventguests_notice FROM {pre}_eventguests2;

DROP TABLE {pre}_eventguests2;