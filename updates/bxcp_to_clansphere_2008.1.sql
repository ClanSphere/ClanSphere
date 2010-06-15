-- BXCP 0.3.2.2 to ClanSphere rc1
ALTER TABLE {pre}_access ADD access_clansphere int(2) NOT NULL default '0';
UPDATE {pre}_access SET access_clansphere = access_bxcp;
ALTER TABLE {pre}_access DROP access_bxcp;
UPDATE {pre}_options SET options_mod = 'clansphere' WHERE options_mod = 'bxcp';
ALTER TABLE {pre}_users ADD users_country2 varchar(8) NOT NULL default '';
UPDATE {pre}_users SET users_country2 = users_country;
ALTER TABLE {pre}_users DROP users_country;
ALTER TABLE {pre}_users ADD users_country varchar(8) NOT NULL default '';
UPDATE {pre}_users SET users_country = users_country2;
ALTER TABLE {pre}_users DROP users_country2;
ALTER TABLE {pre}_clans ADD clans_country2 varchar(8) NOT NULL default '';
UPDATE {pre}_clans SET clans_country2 = clans_country;
ALTER TABLE {pre}_clans DROP clans_country;
ALTER TABLE {pre}_clans ADD clans_country varchar(8) NOT NULL default '';
UPDATE {pre}_clans SET clans_country = clans_country2;
ALTER TABLE {pre}_clans DROP clans_country2;
ALTER TABLE {pre}_fightus ADD fightus_country2 varchar(8) NOT NULL default '';
UPDATE {pre}_fightus SET fightus_country2 = fightus_country;
ALTER TABLE {pre}_fightus DROP fightus_country;
ALTER TABLE {pre}_fightus ADD fightus_country varchar(8) NOT NULL default '';
UPDATE {pre}_fightus SET fightus_country = fightus_country2;
ALTER TABLE {pre}_fightus DROP fightus_country2;
ALTER TABLE {pre}_joinus ADD joinus_country2 varchar(8) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_country2 = joinus_country;
ALTER TABLE {pre}_joinus DROP joinus_country;
ALTER TABLE {pre}_joinus ADD joinus_country varchar(8) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_country = joinus_country2;
ALTER TABLE {pre}_joinus DROP joinus_country2;
ALTER TABLE {pre}_users ADD users_hidden text;
ALTER TABLE {pre}_quotes ADD quotes_text text;
UPDATE {pre}_quotes SET quotes_text = quotes_quote;
ALTER TABLE {pre}_quotes DROP quotes_quote;
ALTER TABLE {pre}_quotes ADD quotes_headline varchar(80) NOT NULL default '';
UPDATE {pre}_users SET users_hidden = 'users_icq,users_msn' WHERE users_private = 1;
UPDATE {pre}_users SET users_hidden = 'users_phone,users_mobile' WHERE users_private = 2;
UPDATE {pre}_users SET users_hidden = 'users_icq,users_msn,users_phone,users_mobile' WHERE users_private = 3;
ALTER TABLE {pre}_users DROP users_private;
ALTER TABLE {pre}_clans ADD clans_picture varchar(80) NOT NULL default '';
ALTER TABLE {pre}_clans ADD clans_pwd varchar(40) NOT NULL default '';
ALTER TABLE {pre}_clans ADD users_id int(8) NOT NULL default '0';
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'image_width', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'image_height', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'max_width', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'max_height', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'last_archiv', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_files', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_folders', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'size2', '511488');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'def_public', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_theme', 'base');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox', 'max_text', '100');
ALTER TABLE {pre}_squads ADD squads_own int(2) NOT NULL default '0';
UPDATE {pre}_squads SET squads_own = '1' WHERE clans_id = '1';
ALTER TABLE {pre}_access ADD access_explorer int(2) NOT NULL default '0';
ALTER TABLE {pre}_wars ADD wars_players1 int(4) NOT NULL default '0';
ALTER TABLE {pre}_wars ADD wars_players2 int(4) NOT NULL default '0';
ALTER TABLE {pre}_wars ADD wars_opponents varchar(200) NOT NULL default '';
ALTER TABLE {pre}_access ADD access_cups int(8) NOT NULL default '0';
ALTER TABLE {pre}_board ADD board_order int(4) NOT NULL default '0';
CREATE TABLE {pre}_cups (
  cups_id {serial},
  games_id int(8) NOT NULL DEFAULT '0',
  cups_name varchar(80) NOT NULL DEFAULT '',
  cups_system varchar(20) NOT NULL DEFAULT '',
  cups_text text,
  cups_teams int(4) NOT NULL DEFAULT '0',
  cups_start int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (cups_id)
){engine};
CREATE TABLE {pre}_cupsquads (
  cupsquads_id {serial},
  cups_id int(8) NOT NULL DEFAULT '0',
  squads_id int(8) NOT NULL DEFAULT '0',
  cupsquads_time varchar(14) NOT NULL default '',
  PRIMARY KEY (cupsquads_id),
  UNIQUE (cups_id, squads_id)
){engine};
CREATE TABLE {pre}_cupmatches (
  cupmatches_id {serial},
  cups_id int(8) NOT NULL DEFAULT '0',
  squad1_id int(8) NOT NULL DEFAULT '0',
  squad2_id int(8) NOT NULL DEFAULT '0',
  cupmatches_score1 int(6) NOT NULL DEFAULT '0',
  cupmatches_score2 int(6) NOT NULL DEFAULT '0',
  cupmatches_winner int(8) NOT NULL DEFAULT '0',
  cupmatches_loserbracket int(2) NOT NULL DEFAULT '0',
  cupmatches_accepted1 int(2) NOT NULL DEFAULT '0',
  cupmatches_accepted2 int(2) NOT NULL DEFAULT '0',
  cupmatches_round int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (cupmatches_id),
  UNIQUE (cups_id, squad1_id, squad2_id, cupmatches_round)
){engine};
CREATE TABLE {pre}_count_archiv (
  count_id {serial},
  count_month varchar(10) NOT NULL DEFAULT '',
  count_num int(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (count_id)
){engine};
CREATE TABLE {pre}_folders (
  folders_id {serial},
  users_id int(8) NOT NULL default '0', 
  sub_id int(8) NOT NULL default '0', 
  folders_mod varchar(80) NOT NULL default '',
  folders_name varchar(80) NOT NULL default '',
  folders_picture varchar(80) NOT NULL default '',
  folders_url varchar(80) NOT NULL default '',
  folders_text text,
  folders_access int(2) NOT NULL default '0',
  folders_order int(4) NOT NULL default '0',
  folders_position int(8) NOT NULL default '0',
  PRIMARY KEY (folders_id),
  UNIQUE (folders_mod,folders_name,users_id)
){engine};
ALTER TABLE {pre}_servers ADD servers_name2 varchar(200) NOT NULL default '';
UPDATE {pre}_servers SET servers_name2 = servers_name;
ALTER TABLE {pre}_servers DROP servers_name;
ALTER TABLE {pre}_servers ADD servers_name varchar(200) NOT NULL default '';
UPDATE {pre}_servers SET servers_name = servers_name2;
ALTER TABLE {pre}_servers DROP servers_name2;
ALTER TABLE {pre}_servers DROP servers_pw;
ALTER TABLE {pre}_servers DROP servers_tools;
ALTER TABLE {pre}_servers DROP servers_gamestat;
ALTER TABLE {pre}_servers ADD servers_class varchar(80) NOT NULL default '';
ALTER TABLE {pre}_servers ADD servers_order int(3) NOT NULL default '0';
ALTER TABLE {pre}_servers ADD servers_type int(1) NOT NULL default '0';
ALTER TABLE {pre}_servers ADD servers_info text;
ALTER TABLE {pre}_servers ADD servers_slots int(4) NOT NULL default '0';
CREATE TABLE {pre}_usersgallery (
  usersgallery_id {serial},
  folders_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  usersgallery_name varchar(80) NOT NULL default '',
  usersgallery_titel varchar(40) NOT NULL default '',
  usersgallery_access int(8) NOT NULL default '0',
  usersgallery_status int(2) NOT NULL default '0',
  usersgallery_description text,
  usersgallery_time varchar(14) NOT NULL default '0',
  usersgallery_count int(8) NOT NULL default '0',
  usersgallery_count_downloads int(8) NOT NULL default '0',
  usersgallery_count_cards int(8) NOT NULL default '0',
  usersgallery_vote int(2) NOT NULL default '0',
  usersgallery_download varchar(20) NOT NULL default '0',
  usersgallery_close int(2) NOT NULL default '0',
  PRIMARY KEY (usersgallery_id)
){engine};
ALTER TABLE {pre}_access ADD access_usersgallery int(2) NOT NULL default '0';
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'size2', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_files', '15');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_folders', '3');
CREATE INDEX {pre}_clans_users_id_index ON {pre}_clans (users_id);
CREATE INDEX {pre}_cups_games_id_index ON {pre}_cups (games_id);
CREATE INDEX {pre}_cupsquads_cups_id_index ON {pre}_cupsquads (cups_id);
CREATE INDEX {pre}_cupsquads_squads_id_index ON {pre}_cupsquads (squads_id);
CREATE INDEX {pre}_cupmatches_cups_id_index ON {pre}_cupmatches (cups_id);
CREATE INDEX {pre}_cupmatches_squad1_id_index ON {pre}_cupmatches (squad1_id);
CREATE INDEX {pre}_cupmatches_squad2_id_index ON {pre}_cupmatches (squad2_id);
CREATE INDEX {pre}_folders_users_id_index ON {pre}_folders (users_id);
CREATE INDEX {pre}_folders_sub_id_index ON {pre}_folders (sub_id);
CREATE INDEX {pre}_usersgallery_users_id_index ON {pre}_usersgallery (users_id);
CREATE INDEX {pre}_usersgallery_folders_id_index ON {pre}_usersgallery (folders_id);

-- ClanSphere rc1 to rc2 

ALTER TABLE {pre}_access ADD access_modules int(2) NOT NULL default '0';
ALTER TABLE {pre}_rounds ADD rounds_order int(4) NOT NULL default '0';
ALTER TABLE {pre}_rounds ADD rounds_description2 varchar(80) NOT NULL default '';
UPDATE {pre}_rounds SET rounds_description2 = rounds_description;
ALTER TABLE {pre}_rounds DROP rounds_description;
ALTER TABLE {pre}_rounds ADD rounds_description text;
UPDATE {pre}_rounds SET rounds_description = rounds_description2;
ALTER TABLE {pre}_rounds DROP rounds_description2;
CREATE TABLE {pre}_metatags (
  metatags_id {serial},
  metatags_name varchar(20) NOT NULL default '',
  metatags_content varchar(200) NOT NULL default '',
  metatags_active int(2) NOT NULL default '1',
  PRIMARY KEY (metatags_id)
) {engine};
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('description', 'ClanSphere', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('keywords', 'ClanSphere', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('language', 'de,en', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('author', 'ClanSphere', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('publisher', 'ClanSphere', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('designer', 'ClanSphere', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('robots', 'index,follow', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('distribution', 'global', 1);
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'file_size', '10000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'file_type', 'wmv,avi');

-- ClanSphere rc2 to rc3

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox','order','ASC');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox','limit','10');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox','linebreak','28');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','def_parameters','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','def_abcode','0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board','doubleposts','-1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans','label','clan');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('squads','label','squad');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('members','label','members');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board','sort','ASC');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere','word_cut','40');
ALTER TABLE {pre}_cups ADD cups_brackets int(2) NOT NULL default '0';
ALTER TABLE {pre}_awards ADD awards_event_url text;
ALTER TABLE {pre}_awards DROP awards_info;
ALTER TABLE {pre}_access ADD access_mailbox int(2) NOT NULL default '0';
ALTER TABLE {pre}_access ADD access_static int(2) NOT NULL default '0';
CREATE TABLE {pre}_static (
  static_id {serial},
  static_title varchar(200) NOT NULL DEFAULT '',
  static_text TEXT,
  static_table INT(2) NOT NULL DEFAULT '0',
  static_comments INT(2) NOT NULL DEFAULT '0',
  static_admins INT(2) NOT NULL DEFAULT '0',
  static_access INT(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (static_id)
) {engine};

-- ClanSphere rc3 to final

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','def_width_listimg','180');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','def_height_listimg','70');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','max_size_listimg','512000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','def_width_navimg','88');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','def_height_navimg','31');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','max_size_navimg','512000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','def_width_rotimg','180');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','def_height_rotimg','70');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','max_size_rotimg','512000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner','method','rotation');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events','show_wars','0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board','safe_mode','');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'public','1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'min_letters','4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'welcome', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_lang', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_temp', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_opts', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_meta', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_setp', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_prfl', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_clan', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_cont', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_mods', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'done_logs', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'register', '1');
UPDATE {pre}_options SET options_mod = 'abcode' WHERE options_name = 'def_abcode' AND options_mod = 'clansphere';
UPDATE {pre}_options SET options_mod = 'abcode' WHERE options_name = 'word_cut' AND options_mod = 'clansphere';
ALTER TABLE {pre}_users ADD users_regkey varchar(50) NOT NULL DEFAULT '0';
ALTER TABLE {pre}_users ADD users_homelimit int(4) NOT NULL default '8';
ALTER TABLE {pre}_access ADD access_partner int(2) NOT NULL default '0';
ALTER TABLE {pre}_access ADD access_wizard int(2) NOT NULL default '0';
ALTER TABLE {pre}_board ADD squads_id int(8) NOT NULL default '0';
ALTER TABLE {pre}_boardfiles ADD boardfiles_downloaded int(9) NOT NULL default '0';
ALTER TABLE {pre}_gallery ADD folders_id int(9) NOT NULL DEFAULT '0';
UPDATE {pre}_gallery SET folders_id = categories_id;
ALTER TABLE {pre}_gallery DROP categories_id;
CREATE TABLE {pre}_partner (
  partner_id {serial},
  categories_id int(8) NOT NULL default '0',
  partner_name varchar(80) NOT NULL default '',
  partner_url varchar(200) NOT NULL default '',
  partner_alt varchar(200) NOT NULL default '',
  partner_text text,
  partner_limg varchar(200) NOT NULL default '',
  partner_nimg varchar(200) NOT NULL default '',
  partner_rimg varchar(200) NOT NULL default '',
  partner_priority int(2) NOT NULL default '0',
  PRIMARY KEY (partner_id )
){engine};
CREATE INDEX {pre}_partner_categories_id_index ON {pre}_partner (categories_id);
ALTER TABLE {pre}_rules ADD rules_order2 int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_rules SET rules_order2 = rules_order;
ALTER TABLE {pre}_rules DROP rules_order;
ALTER TABLE {pre}_rules ADD rules_order int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_rules SET rules_order = rules_order2;
ALTER TABLE {pre}_rules DROP rules_order2;
CREATE TABLE {pre}_boardreport (
  boardreport_id {serial},
  threads_id int(8) NOT NULL default '0',
  comments_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  boardreport_time int(14) NOT NULL default '0',
  boardreport_text text,
  boardreport_done int(2) NOT NULL default '0',
  PRIMARY KEY (boardreport_id)
){engine};
CREATE INDEX {pre}_boardreport_threads_id_index ON {pre}_boardreport (threads_id);
CREATE INDEX {pre}_boardreport_comments_id_index ON {pre}_boardreport (comments_id);
CREATE INDEX {pre}_boardreport_users_id_index ON {pre}_boardreport (users_id);

-- ClanSphere gallery rc3 to final

INSERT INTO {pre}_folders (folders_id, folders_mod, folders_name, folders_text, folders_access) SELECT categories_id AS folders_id, 'gallery' AS folders_mod, categories_name AS folders_name, categories_text AS folders_text, categories_access AS folders_access FROM {pre}_categories WHERE categories_mod = 'gallery';
DELETE FROM {pre}_categories WHERE categories_mod = 'gallery';

-- ClanSphere 2007.0 to 2007.1

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'def_register', '1');
ALTER TABLE {pre}_users DROP users_dstime;
ALTER TABLE {pre}_users ADD users_dstime varchar(10) NOT NULL DEFAULT '';
ALTER TABLE {pre}_users ADD users_readtime varchar(14) NOT NULL DEFAULT '1209600';

-- ClanSphere 2007.1 to 2007.2

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

-- ClanSphere 2007.2.1 to 2007.3

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners','last_id','0');
ALTER TABLE {pre}_banners ADD categories_id int(8) NOT NULL default '0';
ALTER TABLE {pre}_rules ADD rules_order2 int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_rules SET rules_order2 = rules_order;
ALTER TABLE {pre}_rules DROP rules_order;
ALTER TABLE {pre}_rules ADD rules_order int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_rules SET rules_order = rules_order2;
ALTER TABLE {pre}_rules DROP rules_order2;

-- ClanSphere 2007.3 to 2007.3.1

-- ClanSphere 2007.3.1 to 2007.4

ALTER TABLE {pre}_mail ADD mail_answered int(1) NOT NULL default '0';
ALTER TABLE {pre}_mail ADD mail_answertime int(14) NOT NULL default '0';
ALTER TABLE {pre}_mail ADD mail_answer text NOT NULL default '';
ALTER TABLE {pre}_mail ADD mail_answeruser int(8) NOT NULL default '0';

ALTER TABLE {pre}_boardfiles ADD boardfiles_downloaded int(9) NOT NULL default '0';

-- ClanSphere 2007.4 to 2007.4.1

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'mod_rewrite', '0');

-- ClanSphere 2007.4.1 to 2007.4.2

ALTER TABLE {pre}_files ADD files_size2 varchar(20) NOT NULL default '';
UPDATE {pre}_files SET files_size2 = files_size;
ALTER TABLE {pre}_files DROP files_size;
ALTER TABLE {pre}_files ADD files_size varchar(20) NOT NULL default '';
UPDATE {pre}_files SET files_size = files_size2;
ALTER TABLE {pre}_files DROP files_size2;

-- ClanSphere 2007.4.2 to 2007.4.3

ALTER TABLE {pre}_threads ADD threads_close2 int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_threads SET threads_close2 = '-1' WHERE threads_close = '1';
ALTER TABLE {pre}_threads DROP threads_close;
ALTER TABLE {pre}_threads ADD threads_close int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_threads SET threads_close = threads_close2;
ALTER TABLE {pre}_threads DROP threads_close2;

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'rss_title', 'News');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'rss_description', 'Recent informations');

ALTER TABLE {pre}_squads ADD squads_joinus int(1) NOT NULL default '0',
ADD squads_fightus int(1) NOT NULL default '0';

-- ClanSphere 2007.4.3 to 2007.4.4

ALTER TABLE {pre}_joinus ADD users_pwd varchar(40) NOT NULL default '';

ALTER TABLE {pre}_access ADD access_fckeditor int(2) NOT NULL default '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fckeditor', 'mode', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fckeditor', 'skin', 'default');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('fckeditor', 'height', '400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'lightbox', '1');

-- ClanSphere 2007.4.4 to 2008.0

ALTER TABLE {pre}_threads ADD threads_ghost int(2) NOT NULL default '0';
ALTER TABLE {pre}_threads ADD threads_ghost_board int(8) NOT NULL default '0';
ALTER TABLE {pre}_threads ADD threads_ghost_thread int(8) NOT NULL default '0';
ALTER TABLE {pre}_board ADD board_read int(2) NOT NULL default '0';

ALTER TABLE {pre}_access CHANGE access_updates access_database int(2) NOT NULL default '0';
ALTER TABLE {pre}_mail ADD mail_msn varchar(40) NOT NULL default '';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'width', '90');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'height', '400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'background', '000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'view', 'stats');

-- ClanSphere 2008.0 to 2008.1

UPDATE {pre}_options SET options_value = '2008.1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2008-05-02' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '30' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_votes ADD votes_several int(2) NOT NULL default '0';
ALTER TABLE {pre}_categories ADD categories_subid int(9) NOT NULL default '0';
ALTER TABLE {pre}_users ADD users_newsletter int(1) NOT NULL default '1';
ALTER TABLE {pre}_rules ADD rules_title varchar(80) NOT NULL default '';
ALTER TABLE {pre}_news ADD news_publishs_at int(11) NOT NULL default '0';
ALTER TABLE {pre}_rules CHANGE rules_order varchar(5) NOT NULL default '';

ALTER TABLE {pre}_users CHANGE users_register users_register int(11) default NULL,
 CHANGE users_laston users_laston int(11) default NULL,
 CHANGE users_readtime users_readtime int(11) NOT NULL default '1209600';
 
ALTER TABLE cs_board CHANGE users_id users_id INT( 11 ) NOT NULL DEFAULT '0',
 CHANGE board_time board_time INT( 11 ) NOT NULL DEFAULT '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textsize', '12');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textcolor', 'FFFFFF');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textballoncolor', '000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'axescolor', '0F4781');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'indicatorcolor', '3972AD');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'graphcolor1', '2BCB02');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'graphcolor2', 'FF0000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gbook', 'lock', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news','max_recent','8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news','max_navlist','4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars','max_navlist','4');

CREATE TABLE {pre}_notifications (
  notifications_id {serial},
  users_id int(11) NOT NULL,
  notifications_board int(1) NOT NULL default '1',
  notifications_pm int(1) NOT NULL default '1',
  notifications_clanwar int(1) NOT NULL default '1',
  PRIMARY KEY  (notifications_id),
  KEY users_id (users_id)
) {engine};

ALTER TABLE {pre}_gbook ADD gbook_lock int(1) NOT NULL default '0';