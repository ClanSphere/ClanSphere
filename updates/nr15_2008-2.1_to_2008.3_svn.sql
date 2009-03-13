UPDATE {pre}_options SET options_value = '2008.3_svn' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2008-09-20' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '35' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('articles','max_navlist','4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'list_subforums', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','ajax_navlists','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','cellspacing','1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('comments', 'allow_unreg', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'def_picture', '0');

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_width', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_height', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_size', '15360');

CREATE TABLE {pre}_updates (
  updates_id {serial},
  updates_packet int(5) NOT NULL default '0',
  updates_name text NOT NULL,
  updates_date int(22) NOT NULL default '0',
  updates_error text NOT NULL,
  PRIMARY KEY (updates_id)
) {engine};

CREATE TABLE {pre}_pictures (
  pictures_id {serial},
  pictures_mod varchar(20) NOT NULL DEFAULT '',
  pictures_fid int(9) NOT NULL DEFAULT '0',
  pictures_file varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (pictures_id)
) {engine};

ALTER TABLE {pre}_access ADD access_updates int(2) NOT NULL default '0';
ALTER TABLE {pre}_access ADD access_ajax int(2) NOT NULL default '0';

ALTER TABLE {pre}_comments ADD comments_guestnick varchar(40) NOT NULL default '';
ALTER TABLE {pre}_squads ADD squads_text text;

ALTER TABLE {pre}_boardmods ADD categories_id int(8) NOT NULL default '0';
CREATE INDEX {pre}_boardmods_categories_id_index ON {pre}_boardmods (categories_id);

ALTER TABLE {pre}_count ADD INDEX (count_ip,count_id,count_time);
ALTER TABLE {pre}_captcha ADD INDEX (captcha_ip,captcha_time,captcha_id);
ALTER TABLE {pre}_comments ADD INDEX (comments_mod,comments_fid,comments_id);

ALTER TABLE {pre}_awards ADD squads_id int(8) NOT NULL DEFAULT '0';
ALTER TABLE {pre}_ranks ADD squads_id int(8) NOT NULL DEFAULT '0';

ALTER TABLE {pre}_faq DROP faq_time;

ALTER TABLE {pre}_events ADD events_close int(2) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_venue varchar(40) NOT NULL default '';
ALTER TABLE {pre}_events ADD events_pictures text;
ALTER TABLE {pre}_events ADD events_cancel int(2) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_guestsmin int(8) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_guestsmax int(8) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_needage int(2) NOT NULL default '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_fullname', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_fulladress', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_mobile', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_phone', '0');

CREATE TABLE {pre}_eventguests (
  eventguests_id {serial},
  events_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  eventguests_since int(14) NOT NULL default '0',
  PRIMARY KEY (eventguests_id),
  UNIQUE (events_id, users_id)
){engine};

CREATE INDEX {pre}_eventguests_events_id_index ON {pre}_eventguests (events_id);
CREATE INDEX {pre}_eventguests_users_id_index ON {pre}_eventguests (users_id);

ALTER TABLE {pre}_users ADD users_delete int(1) NOT NULL default '0';

CREATE TABLE {pre}_medals (
  medals_id {serial},
  medals_extension varchar(10) NOT NULL DEFAULT '',
  medals_name varchar(150) NOT NULL DEFAULT '',
  medals_text text,
  PRIMARY KEY (medals_id)
){engine};

CREATE TABLE {pre}_medalsuser (
  medalsuser_id {serial},
  medals_id int(8) NOT NULL DEFAULT '0',
  users_id int(8) NOT NULL DEFAULT '0',
  medalsuser_date varchar(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (medalsuser_id)
){engine};

ALTER TABLE {pre}_access ADD access_medals int(2) NOT NULL DEFAULT '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','developer','0');

ALTER TABLE {pre}_folders ADD folders_advanced varchar(10) NOT NULL default '';