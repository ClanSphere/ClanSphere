UPDATE {pre}_options SET options_value = '2009.0 RC1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-03-25' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '36' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

CREATE TABLE {pre}_eventguests (
  eventguests_id {serial},
  events_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  eventguests_since int(14) NOT NULL default '0',
  PRIMARY KEY (eventguests_id),
  UNIQUE (events_id, users_id)
){engine};

CREATE TABLE {pre}_pictures (
  pictures_id {serial},
  pictures_mod varchar(20) NOT NULL default '',
  pictures_fid int(8) NOT NULL default '0',
  pictures_file varchar(20) NOT NULL default '',
  PRIMARY KEY (pictures_id)
) {engine};

CREATE TABLE {pre}_medals (
  medals_id {serial},
  medals_extension varchar(20) NOT NULL default '',
  medals_name varchar(200) NOT NULL default '',
  medals_text text,
  PRIMARY KEY (medals_id)
){engine};

CREATE TABLE {pre}_medalsuser (
  medalsuser_id {serial},
  medals_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  medalsuser_date int(14) NOT NULL default '0',
  PRIMARY KEY (medalsuser_id)
){engine};

ALTER TABLE {pre}_access ADD access_ajax int(2) NOT NULL default '0';
ALTER TABLE {pre}_access ADD access_medals int(2) NOT NULL default '0';
ALTER TABLE {pre}_awards ADD squads_id int(8) NOT NULL default '0';
ALTER TABLE {pre}_boardmods ADD categories_id int(8) NOT NULL default '0';
ALTER TABLE {pre}_comments ADD comments_guestnick varchar(40) NOT NULL default '';
ALTER TABLE {pre}_events ADD events_cancel int(2) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_close int(2) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_guestsmax int(8) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_guestsmin int(8) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_needage int(2) NOT NULL default '0';
ALTER TABLE {pre}_events ADD events_pictures text;
ALTER TABLE {pre}_events ADD events_venue varchar(40) NOT NULL default '';
ALTER TABLE {pre}_folders ADD folders_advanced varchar(20) NOT NULL default '';
ALTER TABLE {pre}_ranks ADD squads_id int(8) NOT NULL default '0';
ALTER TABLE {pre}_squads ADD squads_text text;
ALTER TABLE {pre}_users ADD users_delete int(2) NOT NULL default '0';

ALTER TABLE {pre}_threads ADD threads_close2 int(8) NOT NULL default '0';
UPDATE {pre}_threads SET threads_close2 = threads_close;
ALTER TABLE {pre}_threads DROP threads_close;
ALTER TABLE {pre}_threads ADD threads_close int(8) NOT NULL default '0';
UPDATE {pre}_threads SET threads_close = threads_close2;
ALTER TABLE {pre}_threads DROP threads_close2;

ALTER TABLE {pre}_faq DROP faq_time;
ALTER TABLE {pre}_gallery DROP gallery_close;
ALTER TABLE {pre}_gallery DROP gallery_download;

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('articles', 'max_navlist', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'list_subforums', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'ajax_navlists', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'cellspacing', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'developer', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('comments', 'allow_unreg', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_fulladress', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_fullname', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_mobile', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_phone', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_height', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_size', '15360');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_width', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'def_picture', '0');
UPDATE {pre}_options SET options_value = '350' WHERE options_mod = 'clansphere' AND options_name = 'sec_news';

CREATE INDEX {pre}_boardmods_categories_id_index ON {pre}_boardmods (categories_id);
CREATE INDEX {pre}_eventguests_events_id_index ON {pre}_eventguests (events_id);
CREATE INDEX {pre}_eventguests_users_id_index ON {pre}_eventguests (users_id);
CREATE INDEX {pre}_pictures_pictures_fid_index ON {pre}_pictures (pictures_fid);
CREATE INDEX {pre}_pictures_pictures_id_index ON {pre}_pictures (pictures_id);
CREATE INDEX {pre}_medalsuser_medals_id_index ON {pre}_medalsuser (medals_id);
CREATE INDEX {pre}_medalsuser_users_id_index ON {pre}_medalsuser (users_id);

CREATE INDEX {pre}_captcha_speedup_index ON {pre}_captcha (captcha_id, captcha_ip, captcha_time);
CREATE INDEX {pre}_comments_speedup_index ON {pre}_comments (comments_fid, comments_id, comments_mod);
CREATE INDEX {pre}_count_speedup_index ON {pre}_count (count_id, count_ip, count_time);
CREATE INDEX {pre}_users_speedup_index ON {pre}_users (users_id, users_laston);