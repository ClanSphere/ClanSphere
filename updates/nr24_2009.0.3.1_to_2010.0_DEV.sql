UPDATE {pre}_options SET options_value = '2010.0 beta 1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-06-19' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 54 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

CREATE TABLE {pre}_notifymods (
  notifymods_id {serial},
  notifymods_user int(8) NOT NULL default '0',
  notifymods_gbook int(2) NOT NULL default '0',
  notifymods_joinus int(2) NOT NULL default '0',
  notifymods_fightus int(2) NOT NULL default '0',
  notifymods_files int(2) NOT NULL default '0',
  notifymods_board int(2) NOT NULL default '0',
  PRIMARY KEY (notifymods_id)
) {engine};

CREATE TABLE {pre}_usernicks (
  usernicks_id {serial},
  users_id int(8) NOT NULL default '0',
  users_nick varchar(200) NOT NULL default '',
  users_changetime int(14) NOT NULL default '0',
  PRIMARY KEY (usernicks_id)
) {engine};

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('linkus','max_width','470');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('linkus','max_height','100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('linkus','max_size','256000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','maintenance_access','3');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_remote', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_user', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_pw', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','last_id','1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('static', 'php_eval', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'nextbirth_max_users', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'navbirth_max_users', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'nextbirth_time_interval', '1209600');

DELETE FROM {pre}_options WHERE options_mod = 'ajax' AND options_name = 'ajax_navlists';

UPDATE {pre}_options SET options_mod = 'ckeditor' WHERE options_mod = 'fckeditor';
UPDATE {pre}_options SET options_value = 'ckeditor' WHERE options_mod = 'abcode' AND options_value = 'fckeditor';
UPDATE {pre}_options SET options_value = 'kama' WHERE options_mod = 'ckeditor' AND options_name = 'skin';
ALTER TABLE {pre}_access ADD access_ckeditor int(2) NOT NULL default '0';
UPDATE {pre}_access SET access_ckeditor = access_fckeditor;
ALTER TABLE {pre}_access DROP access_fckeditor;

ALTER TABLE {pre}_replays ADD replays_mirror_names text;
ALTER TABLE {pre}_replays ADD replays_mirror_urls text;
UPDATE {pre}_replays SET replays_mirror_names = replays_mirrors;
UPDATE {pre}_replays SET replays_mirror_urls = replays_mirrors;
ALTER TABLE {pre}_replays DROP replays_mirrors;

ALTER TABLE {pre}_eventguests ADD eventguests_age int(4) NOT NULL default '0';
ALTER TABLE {pre}_eventguests ADD eventguests_status int(2) NOT NULL default '0';

ALTER TABLE {pre}_abcode ADD abcode_order int(2) NOT NULL default '0';
CREATE INDEX {pre}_abcode_abcode_order_index ON {pre}_abcode (abcode_order);

ALTER TABLE {pre}_users ADD users_cookiehash varchar(80) NOT NULL default '';
ALTER TABLE {pre}_users ADD users_cookietime int(14) NOT NULL default '0';
ALTER TABLE {pre}_users ADD users_theme varchar(80) NOT NULL default '';

ALTER TABLE {pre}_users ADD users_abomail int(2) NOT NULL default '1';
ALTER TABLE {pre}_access ADD access_notifymods int(2) NOT NULL default '0';

ALTER TABLE {pre}_cupmatches ADD cupmatches_tree_order int(6);

ALTER TABLE {pre}_wars ADD wars_report2 text;