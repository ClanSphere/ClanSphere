UPDATE {pre}_options SET options_value = '2010.0 DEV 7' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-08-27' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 61 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_users ADD users_emailregister varchar(255) NOT NULL default '';
UPDATE {pre}_users SET users_emailregister = users_email;
ALTER TABLE {pre}_users DROP users_email;
ALTER TABLE {pre}_users ADD users_email varchar(255) NOT NULL default '';
UPDATE {pre}_users SET users_email = users_emailregister;

CREATE TABLE {pre}_trashmail (
	trashmail_id {serial},
	trashmail_entry varchar(255) NOT NULL default '',
	PRIMARY KEY (trashmail_id),
  UNIQUE (trashmail_entry)
){engine};

CREATE INDEX {pre}_trashmail_entry_index ON {pre}_trashmail (trashmail_entry);