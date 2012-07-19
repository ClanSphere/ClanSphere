INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'version_name', '2007.2');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'version_date', '2007-06-25');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'version_id', 10);
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('cash', 'month_out', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'show_wars', '0');

UPDATE {pre}_options SET options_value = 'crystal_project' WHERE options_mod = 'clansphere' AND options_name = 'img_path';

CREATE TABLE {pre}_account (
  account_id {serial},
  account_owner varchar(40) NOT NULL default '',
  account_number varchar(15) NOT NULL default '',
  account_bcn varchar(15) NOT NULL default '',
  account_bank varchar(40) NOT NULL default '',
  account_iban varchar(25) NOT NULL default '',
  account_bic varchar(25) NOT NULL default '',
  PRIMARY KEY (account_id)
){engine};

ALTER TABLE {pre}_cash ADD users_id int(8) NOT NULL default '0';