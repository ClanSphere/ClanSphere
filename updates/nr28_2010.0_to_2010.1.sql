UPDATE {pre}_options SET options_value = '2010.1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-11-15' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '62' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

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

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'notfound_info', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('articles', 'max_navtop', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_navlist', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_navright', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_navlist', '8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_headline', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_navtop', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_navtop2', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('buddys', 'max_navlist', '8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('cups', 'max_navlist', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_navbirthday', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_navnext', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fightus', 'max_usershome', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_headline', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_navtop', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_headline_navtop', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_width', '1280');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_height', '1024');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('files', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'max_usershome', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('maps', 'max_width', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('maps', 'max_height', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('maps', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_headline', '15');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('ranks', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'max_headline_team1', '9');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'max_headline_team2', '9');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('servers', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_navlist2', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_navnext', '4');