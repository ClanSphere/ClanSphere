CREATE TABLE {pre}_abcode (
  abcode_id {serial},
  abcode_order int(2) NOT NULL default '0',
  abcode_func varchar(8) NOT NULL default '',
  abcode_pattern varchar(40) NOT NULL default '',
  abcode_result varchar(40) NOT NULL default '',
  abcode_file varchar(80) NOT NULL default '',
  PRIMARY KEY (abcode_id)
){engine};

INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (1, 'img', ':)', '', 'smile.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (2, 'img', ';)', '', 'wink.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (3, 'img', ':D', '', 'biggrin.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (4, 'img', ':P', '', 'tongue.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (5, 'img', ':cool:', '', 'cool.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (6, 'img', ':lol:', '', 'lol.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (7, 'img', ';(', '', 'frown.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (8, 'img', ':mad:', '', 'mad.gif');
INSERT INTO {pre}_abcode (abcode_order, abcode_func, abcode_pattern, abcode_result, abcode_file) VALUES (9, 'img', ':rolleyes:', '', 'rolleyes.gif');

CREATE TABLE {pre}_abonements (
  abonements_id {serial},
  users_id int(8) NOT NULL default '0',
  threads_id int(8) NOT NULL default '0',
  PRIMARY KEY (abonements_id)
){engine};

CREATE TABLE {pre}_access (
  access_id {serial},
  access_name varchar(40) NOT NULL default '',
  access_access int(2) NOT NULL default '0',
  access_clansphere int(2) NOT NULL default '0',
  access_abcode int(2) NOT NULL default '0',
  access_ajax int(2) NOT NULL default '0',
  access_articles int(2) NOT NULL default '0',
  access_awards int(2) NOT NULL default '0',
  access_banners int(2) NOT NULL default '0',
  access_board int(2) NOT NULL default '0',
  access_boardmods int(2) NOT NULL default '0',
  access_boardranks int(2) NOT NULL default '0',
  access_buddys int(2) NOT NULL default '0',
  access_cash int(2) NOT NULL default '0',
  access_categories int(2) NOT NULL default '0',
  access_clans int(2) NOT NULL default '0',
  access_comments int(2) NOT NULL default '0',
  access_computers int(2) NOT NULL default '0',
  access_contact int(2) NOT NULL default '0',
  access_count int(2) NOT NULL default '0',
  access_database int(2) NOT NULL default '0',
  access_errors int(2) NOT NULL default '0',
  access_events int(2) NOT NULL default '0',
  access_explorer int(2) NOT NULL default '0',
  access_faq int(2) NOT NULL default '0',
  access_fightus int(2) NOT NULL default '0',
  access_files int(2) NOT NULL default '0',
  access_gallery int(2) NOT NULL default '0',
  access_games int(2) NOT NULL default '0',
  access_gbook int(2) NOT NULL default '0',
  access_history int(2) NOT NULL default '0',
  access_joinus int(2) NOT NULL default '0',
  access_lightbox int(2) NOT NULL default '0',
  access_links int(2) NOT NULL default '0',
  access_linkus int(2) NOT NULL default '0',
  access_logs int(2) NOT NULL default '0',
  access_maps int(2) NOT NULL default '0',
  access_medals int(2) NOT NULL default '0',
  access_members int(2) NOT NULL default '0',
  access_messages int(2) NOT NULL default '0',
  access_modules int(2) NOT NULL default '0',
  access_news int(2) NOT NULL default '0',
  access_newsletter int(2) NOT NULL default '0',
  access_notifymods int(2) NOT NULL default '0',
  access_options int(2) NOT NULL default '0',
  access_partner int(2) NOT NULL default '0',
  access_quotes int(2) NOT NULL default '0',
  access_ranks int(2) NOT NULL default '0',
  access_replays int(2) NOT NULL default '0',
  access_rules int(2) NOT NULL default '0',
  access_static int(2) NOT NULL default '0',
  access_search int(2) NOT NULL default '0',
  access_servers int(2) NOT NULL default '0',
  access_shoutbox int(2) NOT NULL default '0',
  access_squads int(2) NOT NULL default '0',
  access_templates int(2) NOT NULL default '0',
  access_users int(2) NOT NULL default '0',
  access_usersgallery int(2) NOT NULL default '0',
  access_votes int(2) NOT NULL default '0',
  access_wars int(2) NOT NULL default '0',
  access_wizard int(2) NOT NULL default '0',
  PRIMARY KEY (access_id),
  UNIQUE (access_name)
){engine};

INSERT INTO {pre}_access (access_name, access_access, access_clansphere, access_abcode, access_ajax, access_articles, access_awards, access_banners, access_board, access_boardmods, access_boardranks, access_buddys, access_cash, access_categories, access_clans, access_comments, access_computers, access_contact, access_count, access_database, access_explorer, access_errors, access_events, access_faq, access_fightus, access_files, access_gallery, access_games, access_gbook, access_history, access_joinus, access_lightbox, access_links, access_linkus, access_logs, access_maps, access_medals, access_members, access_messages, access_modules, access_news, access_newsletter, access_notifymods, access_options, access_partner, access_quotes, access_ranks, access_replays, access_rules, access_static, access_search, access_servers, access_shoutbox, access_squads, access_templates, access_users, access_usersgallery, access_votes, access_wars, access_wizard) VALUES ('{guest}', 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0);
INSERT INTO {pre}_access (access_name, access_access, access_clansphere, access_abcode, access_ajax, access_articles, access_awards, access_banners, access_board, access_boardmods, access_boardranks, access_buddys, access_cash, access_categories, access_clans, access_comments, access_computers, access_contact, access_count, access_database, access_explorer, access_errors, access_events, access_faq, access_fightus, access_files, access_gallery, access_games, access_gbook, access_history, access_joinus, access_lightbox, access_links, access_linkus, access_logs, access_maps, access_medals, access_members, access_messages, access_modules, access_news, access_newsletter, access_notifymods, access_options, access_partner, access_quotes, access_ranks, access_replays, access_rules, access_static, access_search, access_servers, access_shoutbox, access_squads, access_templates, access_users, access_usersgallery, access_votes, access_wars, access_wizard) VALUES ('{community}', 0, 0, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 0);
INSERT INTO {pre}_access (access_name, access_access, access_clansphere, access_abcode, access_ajax, access_articles, access_awards, access_banners, access_board, access_boardmods, access_boardranks, access_buddys, access_cash, access_categories, access_clans, access_comments, access_computers, access_contact, access_count, access_database, access_explorer, access_errors, access_events, access_faq, access_fightus, access_files, access_gallery, access_games, access_gbook, access_history, access_joinus, access_lightbox, access_links, access_linkus, access_logs, access_maps, access_medals, access_members, access_messages, access_modules, access_news, access_newsletter, access_notifymods, access_options, access_partner, access_quotes, access_ranks, access_replays, access_rules, access_static, access_search, access_servers, access_shoutbox, access_squads, access_templates, access_users, access_usersgallery, access_votes, access_wars, access_wizard) VALUES ('{member}', 0, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 0);
INSERT INTO {pre}_access (access_name, access_access, access_clansphere, access_abcode, access_ajax, access_articles, access_awards, access_banners, access_board, access_boardmods, access_boardranks, access_buddys, access_cash, access_categories, access_clans, access_comments, access_computers, access_contact, access_count, access_database, access_explorer, access_errors, access_events, access_faq, access_fightus, access_files, access_gallery, access_games, access_gbook, access_history, access_joinus, access_lightbox, access_links, access_linkus, access_logs, access_maps, access_medals, access_members, access_messages, access_modules, access_news, access_newsletter, access_notifymods, access_options, access_partner, access_quotes, access_ranks, access_replays, access_rules, access_static, access_search, access_servers, access_shoutbox, access_squads, access_templates, access_users, access_usersgallery, access_votes, access_wars, access_wizard) VALUES ('{orga}', 0, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 2, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 0);
INSERT INTO {pre}_access (access_name, access_access, access_clansphere, access_abcode, access_ajax, access_articles, access_awards, access_banners, access_board, access_boardmods, access_boardranks, access_buddys, access_cash, access_categories, access_clans, access_comments, access_computers, access_contact, access_count, access_database, access_explorer, access_errors, access_events, access_faq, access_fightus, access_files, access_gallery, access_games, access_gbook, access_history, access_joinus, access_lightbox, access_links, access_linkus, access_logs, access_maps, access_medals, access_members, access_messages, access_modules, access_news, access_newsletter, access_notifymods, access_options, access_partner, access_quotes, access_ranks, access_replays, access_rules, access_static, access_search, access_servers, access_shoutbox, access_squads, access_templates, access_users, access_usersgallery, access_votes, access_wars, access_wizard) VALUES ('{admin}', 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5);

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

CREATE TABLE {pre}_articles (
  articles_id {serial},
  users_id int(8) NOT NULL default '0',
  categories_id int(8) NOT NULL default '0',
  articles_time int(14) NOT NULL default '0',
  articles_text text,
  articles_headline varchar(200) NOT NULL default '',
  articles_navlist int(2) NOT NULL default '0',
  articles_views int(8) NOT NULL default '0',
  articles_com int(2) NOT NULL default '0',
  articles_fornext int(2) NOT NULL default '0',
  PRIMARY KEY (articles_id)
){engine};

CREATE TABLE {pre}_autoresponder (
  autoresponder_id {serial},
  users_id int(8) NOT NULL default '0',
  autoresponder_subject varchar(80) NOT NULL default '',
  autoresponder_text text,
  autoresponder_time int(14) NOT NULL default '0',
  autoresponder_close int(2) NOT NULL default '0',
  autoresponder_mail int(2) NOT NULL default '0',
  PRIMARY KEY (autoresponder_id)
){engine};

CREATE TABLE {pre}_awards (
  awards_id {serial},
  users_id int(8) NOT NULL default '0',
  awards_rank int(8) NOT NULL default '0',
  awards_time varchar(12) NOT NULL default '',
  games_id int(8) NOT NULL default '0',
  squads_id int(8) NOT NULL default '0',
  awards_event text,
  awards_event_url text,
  PRIMARY KEY (awards_id)
){engine};

CREATE TABLE {pre}_banners (
  banners_id {serial},
  categories_id int(8) NOT NULL default '0',
  banners_name varchar(40) NOT NULL default '',
  banners_url varchar(80) NOT NULL default '',
  banners_alt varchar(80) NOT NULL default '',
  banners_order int(4) NOT NULL default '0',
  banners_picture varchar(80) NOT NULL default '',
  PRIMARY KEY (banners_id)
){engine};

CREATE TABLE {pre}_board (
  board_id {serial},
  categories_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  squads_id int(8) NOT NULL default '0',
  board_access int(8) NOT NULL default '0',
  board_name varchar(80) NOT NULL default '',
  board_text varchar(200) NOT NULL default '',
  board_time int(11) NOT NULL default '0',
  board_pwd varchar(40) NOT NULL default '',
  board_threads int(8) NOT NULL default '0',
  board_comments int(8) NOT NULL default '0',
  board_order int(2) NOT NULL default '0',
  board_read int(2) NOT NULL default '0',
  board_last_time int(14) NOT NULL default '0',
  board_last_user varchar(40) NOT NULL default '',
  board_last_userid int(8) NOT NULL default '0',
  board_last_thread varchar(200) NOT NULL default '',
  board_last_threadid int(8) NOT NULL default '0',
  PRIMARY KEY (board_id)
){engine};

CREATE TABLE {pre}_boardfiles (
  boardfiles_id {serial},
  threads_id int(8) NOT NULL default '0',
  comments_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  boardfiles_time int(14) NOT NULL default '0',
  boardfiles_name varchar(80) NOT NULL default '',
  boardfiles_downloaded int(8) NOT NULL default '0',
  PRIMARY KEY (boardfiles_id)
){engine};

CREATE TABLE {pre}_boardmods (
  boardmods_id {serial},
  users_id int(8) NOT NULL default '0',
  categories_id int(8) NOT NULL default '0',
  boardmods_modpanel int(2) NOT NULL default '0',
  boardmods_edit int(2) NOT NULL default '0',
  boardmods_del int(2) NOT NULL default '0',
  PRIMARY KEY (boardmods_id)
){engine};

CREATE TABLE {pre}_boardpws (
  boardpws_id {serial},
  board_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  PRIMARY KEY (boardpws_id)
){engine};

CREATE TABLE {pre}_boardranks (
  boardranks_id {serial},
  boardranks_min int(8) NOT NULL default '0',
  boardranks_name varchar(200) NOT NULL default '',
  PRIMARY KEY (boardranks_id)
){engine};

INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (0, 'Beginner');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (20, 'Wannabe poster');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (40, 'Rock the board');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (100, 'Try to beat me');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (200, 'King for a day');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (400, 'Going for pro');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (600, 'Poststar');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (800, 'Just nerd');
INSERT INTO {pre}_boardranks (boardranks_min, boardranks_name) VALUES (1000, 'Geekboy');

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

CREATE TABLE {pre}_boardvotes (
  boardvotes_id {serial},
  threads_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  boardvotes_access int(2) NOT NULL default '0',
  boardvotes_time int(14) NOT NULL default '0',
  boardvotes_end int(14) NOT NULL default '0',
  boardvotes_several int(2) NOT NULL default '0',
  boardvotes_question varchar(50) NOT NULL default '',
  boardvotes_election text,
  PRIMARY KEY (boardvotes_id)
){engine};

CREATE TABLE {pre}_buddys (
  buddys_id {serial},
  users_id int(8) NOT NULL default '0',
  buddys_user int(8) NOT NULL default '0',
  buddys_time int(14) NOT NULL default '0',
  buddys_notice text,
  PRIMARY KEY (buddys_id),
  UNIQUE (buddys_user,users_id)
){engine};

CREATE TABLE {pre}_captcha (
  captcha_id {serial},
  captcha_time int(14) NOT NULL default '0',
  captcha_ip varchar(40) NOT NULL default '',
  captcha_string varchar(8) NOT NULL default '',
  PRIMARY KEY (captcha_id)
){engine};

CREATE TABLE {pre}_categories (
  categories_id {serial},
  categories_mod varchar(80) NOT NULL default '',
  categories_name varchar(80) NOT NULL default '',
  categories_picture varchar(80) NOT NULL default '',
  categories_url varchar(80) NOT NULL default '',
  categories_text text,
  categories_access int(2) NOT NULL default '0',
  categories_order int(4) NOT NULL default '0',
  categories_subid int(8) NOT NULL default '0',
  PRIMARY KEY (categories_id),
  UNIQUE (categories_mod,categories_name)
){engine};

INSERT INTO {pre}_categories (categories_mod, categories_name) VALUES ('contact', 'default');

CREATE TABLE {pre}_cash (
  cash_id {serial},
  users_id int(8) NOT NULL default '0',
  cash_time varchar(12) NOT NULL default '',
  cash_money varchar(8) NOT NULL default '',
  cash_text varchar(200) NOT NULL default '',
  cash_info text,
  cash_inout varchar(4) NOT NULL default '',
  PRIMARY KEY (cash_id)
){engine};

CREATE TABLE {pre}_clans (
  clans_id {serial},
  users_id int(8) NOT NULL default '0',
  clans_name varchar(200) NOT NULL default '',
  clans_short varchar(20) NOT NULL default '',
  clans_tag varchar(40) NOT NULL default '',
  clans_tagpos int(2) NOT NULL default '0',
  clans_country varchar(40) NOT NULL default '',
  clans_url varchar(80) NOT NULL default '',
  clans_since varchar(12) NOT NULL default '',
  clans_picture varchar(80) NOT NULL default '',
  clans_pwd varchar(40) NOT NULL default '',
  PRIMARY KEY (clans_id),
  UNIQUE (clans_name)
){engine};

CREATE TABLE {pre}_comments (
  comments_id {serial},
  users_id int(8) NOT NULL default '0',
  comments_fid int(8) NOT NULL default '0',
  comments_mod varchar(80) NOT NULL default '',
  comments_ip varchar(40) NOT NULL default '',
  comments_time int(14) NOT NULL default '0',
  comments_text text,
  comments_edit varchar(200) NOT NULL default '',
  comments_guestnick varchar(40) NOT NULL default '',
  PRIMARY KEY (comments_id)
){engine};

CREATE TABLE {pre}_computers (
  computers_id {serial},
  users_id int(8) NOT NULL default '0',
  computers_since int(14) NOT NULL default '0',
  computers_name varchar(40) NOT NULL default '',
  computers_software varchar(40) NOT NULL default '',
  computers_mainboard varchar(80) NOT NULL default '',
  computers_memory text,
  computers_processors text,
  computers_graphics text,
  computers_sounds text,
  computers_harddisks text,
  computers_drives text,
  computers_screens text,
  computers_interfaces text,
  computers_networks text,
  computers_more text,
  computers_pictures text,
  PRIMARY KEY (computers_id)
){engine};

CREATE TABLE {pre}_count (
  count_id {serial},
  count_time int(14) NOT NULL default '0',
  count_ip varchar(40) NOT NULL default '',
  count_data text,
  count_location varchar(80) NOT NULL default '',
  PRIMARY KEY (count_id)
){engine};

CREATE TABLE {pre}_count_archiv (
  count_id {serial},
  count_month varchar(10) NOT NULL default '',
  count_num int(30) NOT NULL default '0',
  count_mode int(2) NOT NULL default '0',
  PRIMARY KEY (count_id)
){engine};

CREATE TABLE {pre}_eventguests (
  eventguests_id {serial},
  events_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  eventguests_since int(14) NOT NULL default '0',
  eventguests_status int(2) NOT NULL default '0',
  eventguests_name varchar(80) NOT NULL default '',
  eventguests_surname varchar(80) NOT NULL default '',
  eventguests_age int(4) NOT NULL default '0',
  eventguests_phone varchar(40) NOT NULL default '0',
  eventguests_mobile varchar(40) NOT NULL default '0',
  eventguests_residence text,
  eventguests_notice text,
  PRIMARY KEY (eventguests_id)
){engine};

CREATE TABLE {pre}_events (
  events_id {serial},
  categories_id int(8) NOT NULL default '0',
  events_name varchar(40) NOT NULL default '',
  events_url varchar(80) NOT NULL default '',
  events_time int(14) NOT NULL default '0',
  events_venue varchar(40) NOT NULL default '',
  events_close int(2) NOT NULL default '0',
  events_cancel int(2) NOT NULL default '0',
  events_guestsmin int(8) NOT NULL default '0',
  events_guestsmax int(8) NOT NULL default '0',
  events_needage int(2) NOT NULL default '0',
  events_more text,
  events_pictures text,
  PRIMARY KEY (events_id)
){engine};

CREATE TABLE {pre}_faq (
  faq_id {serial},
  users_id int(8) NOT NULL default '0',
  categories_id int(8) NOT NULL default '0',
  faq_question text,
  faq_answer text,
  PRIMARY KEY (faq_id)
){engine};

CREATE TABLE {pre}_fightus (
  fightus_id {serial},
  categories_id int(8) NOT NULL default '0',
  games_id int(8) NOT NULL default '0',
  squads_id int(8) NOT NULL default '0',
  fightus_since int(14) NOT NULL default '0',
  fightus_nick varchar(40) NOT NULL default '',
  fightus_icq int(12) NOT NULL default '0',
  fightus_jabber varchar(40) NOT NULL default '',
  fightus_email varchar(40) NOT NULL default '',
  fightus_clan varchar(200) NOT NULL default '',
  fightus_short varchar(20) NOT NULL default '',
  fightus_country varchar(40) NOT NULL default '',
  fightus_url varchar(80) NOT NULL default '',
  fightus_date int(14) NOT NULL default '0',
  fightus_more text,
  PRIMARY KEY (fightus_id)
){engine};

CREATE TABLE {pre}_files (
  files_id {serial},
  users_id int(8) NOT NULL default '0',
  categories_id int(8) NOT NULL default '0',
  files_name varchar(80) NOT NULL default '',
  files_description text,
  files_time int(14) NOT NULL default '0',
  files_count int(12) NOT NULL default '0',
  files_vote int(2) NOT NULL default '0',
  files_close varchar(8) NOT NULL default '',
  files_access int(8) NOT NULL default '0',
  files_mirror text,
  files_size varchar(20) NOT NULL default '0',
  files_version varchar(20) NOT NULL default '',
  files_previews varchar(200) NOT NULL default '',
  files_error int(2) NOT NULL default '0',
  PRIMARY KEY (files_id)
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
  folders_advanced varchar(20) NOT NULL default '',
  PRIMARY KEY (folders_id),
  UNIQUE (folders_mod,folders_name)
){engine};

CREATE TABLE {pre}_gallery (
  gallery_id {serial},
  folders_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  gallery_name varchar(80) NOT NULL default '',
  gallery_titel varchar(40) NOT NULL default '',
  gallery_access int(8) NOT NULL default '0',
  gallery_status int(2) NOT NULL default '0',
  gallery_description text,
  gallery_time int(14) NOT NULL default '0',
  gallery_count int(8) NOT NULL default '0',
  gallery_count_downloads int(8) NOT NULL default '0',
  gallery_count_cards int(8) NOT NULL default '0',
  gallery_vote int(2) NOT NULL default '0',
  gallery_watermark varchar(20) NOT NULL default '',
  gallery_watermark_pos varchar(10) NOT NULL default '',
  PRIMARY KEY (gallery_id)
){engine};

CREATE TABLE {pre}_games (
  games_id {serial},
  categories_id int(8) NOT NULL default '0',
  games_name varchar(80) NOT NULL default '',
  games_version varchar(20) NOT NULL default '',
  games_released varchar(12) NOT NULL default '',
  games_creator varchar(80) NOT NULL default '',
  games_url varchar(80) NOT NULL default '',
  games_usk varchar(20) NOT NULL default '',
  PRIMARY KEY (games_id),
  UNIQUE (games_name)
){engine};

CREATE TABLE {pre}_gbook (
  gbook_id {serial},
  users_id int(8) NOT NULL default '0',
  gbook_users_id int(8) NOT NULL default '0',
  gbook_time int(14) NOT NULL default '0',
  gbook_nick varchar(20) NOT NULL default '',
  gbook_email varchar(40) NOT NULL default '',
  gbook_icq varchar(20) NOT NULL default '',
  gbook_jabber varchar(40) NOT NULL default '',
  gbook_skype varchar(40) NOT NULL default '',
  gbook_url varchar(40) NOT NULL default '',
  gbook_town varchar(20) NOT NULL default '',
  gbook_text text,
  gbook_ip varchar(40) NOT NULL default '',
  gbook_lock int(2) NOT NULL default '0',
  PRIMARY KEY (gbook_id)
){engine};

CREATE TABLE {pre}_history (
  history_id {serial},
  users_id int(8) NOT NULL default '0',
  history_text text,
  history_time int(14) NOT NULL default '0',
  PRIMARY KEY (history_id)
){engine};

CREATE TABLE {pre}_joinus (
  joinus_id {serial},
  games_id int(8) NOT NULL default '0',
  squads_id int(8) NOT NULL default '0',
  joinus_since int(14) NOT NULL default '0',
  joinus_nick varchar(40) NOT NULL default '',
  joinus_name varchar(80) NOT NULL default '',
  joinus_surname varchar(80) NOT NULL default '',
  joinus_age varchar(12) NOT NULL default '',
  joinus_country varchar(40) NOT NULL default '',
  joinus_place varchar(40) NOT NULL default '',
  joinus_icq int(12) NOT NULL default '0',
  joinus_jabber varchar(40) NOT NULL default '',
  joinus_email varchar(40) NOT NULL default '',
  joinus_webcon varchar(80) NOT NULL default '',
  joinus_lanact varchar(80) NOT NULL default '',
  joinus_date varchar(12) NOT NULL default '',
  joinus_more text,
  users_pwd varchar(40) NOT NULL default '',
  PRIMARY KEY (joinus_id)
){engine};

CREATE TABLE {pre}_links (
  links_id {serial},
  categories_id int(8) NOT NULL default '0',
  links_name varchar(200) NOT NULL default '',
  links_url varchar(200) NOT NULL default '',
  links_info text,
  links_stats varchar(4) NOT NULL default '0',
  links_sponsor int(2) NOT NULL default '0',
  links_banner varchar(40) NOT NULL default '',
  PRIMARY KEY (links_id)
){engine};

CREATE TABLE {pre}_linkus (
  linkus_id {serial},
  linkus_name varchar(200) NOT NULL default '',
  linkus_url varchar(200) NOT NULL default '',
  linkus_banner varchar(40) NOT NULL default '',
  PRIMARY KEY (linkus_id)
){engine};

CREATE TABLE {pre}_mail (
  mail_id {serial},
  categories_id int(8) NOT NULL default '0',    
  mail_name varchar(200) NOT NULL default '',
  mail_time int(14) NOT NULL default '0',
  mail_ip varchar(40) NOT NULL default '',
  mail_email varchar(80) NOT NULL default '',
  mail_icq int(12) NOT NULL default '0',
  mail_jabber varchar(40) NOT NULL default '',
  mail_firm varchar(200) NOT NULL default '',
  mail_subject varchar(200) NOT NULL default '',
  mail_message text,
  mail_answered int(2) NOT NULL default '0',
  mail_answertime int(14) NOT NULL default '0',
  mail_answer text,
  mail_answeruser int(8) NOT NULL default '0',
  PRIMARY KEY (mail_id)
){engine};

CREATE TABLE {pre}_maps (
  maps_id {serial},
  games_id int(8) NOT NULL default '0',
  maps_name varchar(100) NOT NULL default '',
  maps_text text,
  maps_picture varchar(80) NOT NULL default '',
  server_name varchar(100) NOT NULL default '',
  PRIMARY KEY (maps_id)
){engine};

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

CREATE TABLE {pre}_members (
  members_id {serial},
  squads_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  members_task varchar(80) NOT NULL default '',
  members_order int(4) NOT NULL default '0',
  members_since varchar(12) NOT NULL default '',
  members_admin int(2) NOT NULL default '0',
  PRIMARY KEY (members_id),
  UNIQUE (squads_id,users_id)
){engine};

CREATE TABLE {pre}_messages (
  messages_id {serial},
  users_id int(8) NOT NULL default '0',
  users_id_to int(8) NOT NULL default '0',
  messages_time int(14) NOT NULL default '0',
  messages_subject varchar(80) NOT NULL default '',
  messages_text text,
  messages_view int(2) NOT NULL default '0',
  messages_archiv_receiver int(2) NOT NULL default '0',
  messages_archiv_sender int(2) NOT NULL default '0',
  messages_show_receiver int(2) NOT NULL default '0',
  messages_show_sender int(2) NOT NULL default '0',
  PRIMARY KEY (messages_id)
){engine};

CREATE TABLE {pre}_metatags (
  metatags_id {serial},
  metatags_name varchar(20) NOT NULL default '',
  metatags_content varchar(200) NOT NULL default '',
  metatags_active int(2) NOT NULL default '1',
  PRIMARY KEY (metatags_id),
  UNIQUE (metatags_name)
){engine};

INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('description', '', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('keywords', '', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('language', 'en,de', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('author', '', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('publisher', '', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('designer', '', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('robots', 'index,follow', 1);
INSERT INTO {pre}_metatags (metatags_name, metatags_content, metatags_active) VALUES ('distribution', 'global', 1);

CREATE TABLE {pre}_news (
  news_id {serial},
  categories_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  news_time int(14) NOT NULL default '0',
  news_headline varchar(80) NOT NULL default '',
  news_readmore text,
  news_text text,
  news_readmore_active int(2) NOT NULL default '0',
  news_close int(2) NOT NULL default '0',
  news_public int(2) NOT NULL default '0',
  news_attached int(2) NOT NULL default '0',
  news_pictures text,
  news_publishs_at int(11) NOT NULL default '0',
  news_mirror text,
  news_mirror_name text,
  PRIMARY KEY (news_id)
){engine};

CREATE TABLE {pre}_newsletter (
  newsletter_id {serial},
  users_id int(8) NOT NULL default '0',
  newsletter_to varchar(200) NOT NULL default '',
  newsletter_subject varchar(200) NOT NULL default '',
  newsletter_text text,
  newsletter_time varchar(200) NOT NULL default '',
  PRIMARY KEY (newsletter_id)
){engine};

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

CREATE TABLE {pre}_options (
  options_id {serial},
  options_mod varchar(40) NOT NULL default '',
  options_name varchar(40) NOT NULL default '',
  options_value varchar(80) NOT NULL default '',
  PRIMARY KEY (options_id),
  UNIQUE (options_mod,options_name)
){engine};

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'def_abcode', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'word_cut', '40');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'max_width', '300');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'max_height', '300');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'def_func', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'image_width', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'image_height', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_html', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('abcode', 'rte_more', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('articles', 'max_navlist', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('articles', 'max_navtop', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_width', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_height', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'def_order', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'last_id', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_navlist', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('banners', 'max_navright', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'list_subforums', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_text', '1000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_signatur', '200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'avatar_height', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'avatar_width', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'avatar_size', '102400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'file_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'file_types', 'jpg,jpeg,gif,png,txt,pdf');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'doubleposts', '-1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'sort', 'ASC');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_navlist', '8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_headline', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_navtop', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('board', 'max_navtop2', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('buddys', 'max_navlist', '8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('cash', 'currency', 'Euro');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('cash', 'month_out', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('categories', 'max_width', '150');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('categories', 'max_height', '150');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('categories', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('categories', 'def_mod', 'news');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'max_width', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'max_height', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clans', 'label', 'clan');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'ajax', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'ajax_reload', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'cache_unicode', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'cellspacing', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'data_limit', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_lang', '{def_lang}');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_tpl', 'clansphere');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_theme', 'clansphere');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'mod_rewrite', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_width', '100%');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_title', 'ClanSphere');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_mod', 'news');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_action', 'recent');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_path', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_timezone', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_dstime', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_parameters', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_flood', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'img_path', 'crystal_project');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'img_ext', 'png');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'def_admin', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'developer', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'maintenance_access', '3');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'notfound_info', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'public', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_last', '583');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_news', '583');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_remote', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'sec_time', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'version_name', '2011.4.3');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'version_date', '2013-12-06');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('clansphere', 'version_id', '94');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('comments', 'allow_unreg', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('comments', 'show_avatar', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('computers', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('computers', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('computers', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'def_org', 'yourdomain.com');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'def_mail', 'noreply@yourdomain.com');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_host', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_port', '25');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_user', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('contact', 'smtp_pw', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'count_lastday', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'last_archiv_day', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'last_archiv', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'width', '90');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'height', '400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'background', '000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'view', 'stats');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textsize', '12');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textcolor', 'FFFFFF');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'textballoncolor', '000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'axescolor', '0F4781');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'indicatorcolor', '3972AD');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'graphcolor1', '2BCB02');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('count', 'graphcolor2', 'FF0000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'show_wars', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_fullname', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_fulladress', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_mobile', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('events', 'req_phone', '0');
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
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'cols', '3');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'rows', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'xpics', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'thumbs', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'quality', '80');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'width', '2000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'height', '2000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'size', '1022976');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_width', '400');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'top_5_votes', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'top_5_views', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'newest_5', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'list_sort', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_files', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_folders', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'size2', '511488');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'lightbox', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gallery', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_height', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_size', '15360');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('games', 'max_width', '30');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gbook', 'captcha_users', '');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('gbook', 'lock', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'vorname', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'surname', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'place', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'country', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'icq', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'jabber', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'game', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'squad', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'webcon', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'lanact', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'more', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'max_usershome', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('linkus', 'max_width', '470');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('linkus', 'max_height', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('linkus', 'max_size', '256000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('maps', 'max_width', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('maps', 'max_height', '500');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('maps', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('members', 'label', 'members');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('messages', 'max_space', '20');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('messages', 'del_time', '10');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_recent', '8');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_navlist', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'def_public', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'rss_title', 'News');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'rss_description', 'Recent information');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'abcode', '1,1,1,0,0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'max_headline', '15');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'def_width_listimg', '180');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'def_height_listimg', '70');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'max_size_listimg', '512000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'def_width_navimg', '88');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'def_height_navimg', '31');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'max_size_navimg', '512000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'def_width_rotimg', '180');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'def_height_rotimg', '70');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'max_size_rotimg', '512000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'method', 'rotation');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'last_id', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('partner', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('ranks', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'file_size', '10000000');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'file_type', 'wmv,avi');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'max_headline_team1', '9');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('replays', 'max_headline_team2', '9');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('servers', 'max_navlist', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox', 'max_text', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox', 'order', 'ASC');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox', 'limit', '10');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('shoutbox', 'linebreak', '28');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('squads', 'max_width', '250');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('squads', 'max_height', '100');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('squads', 'max_size', '76800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('squads', 'def_order', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('squads', 'label', 'squad');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('static', 'php_eval', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'login', 'nick');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'max_width', '140');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'max_height', '170');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'max_size', '51200');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'min_letters', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'def_picture', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'def_register', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'register', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'nextbirth_max_users', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'navbirth_max_users', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'nextbirth_time_interval', '1209600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_size', '204800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_navlist', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_navlist2', '5');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wars', 'max_navnext', '4');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('wizard', 'welcome', '1');
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
  PRIMARY KEY (partner_id)
){engine};

CREATE TABLE {pre}_pictures (
  pictures_id {serial},
  pictures_mod varchar(20) NOT NULL default '',
  pictures_fid int(8) NOT NULL default '0',
  pictures_file varchar(20) NOT NULL default '',
  PRIMARY KEY (pictures_id)
) {engine};

CREATE TABLE {pre}_players (
  players_id {serial},
  users_id int(8) NOT NULL default '0',
  wars_id int(8) NOT NULL default '0',
  players_status varchar(20) NOT NULL default '',
  players_played int(2) NOT NULL default '0',
  players_time int(14) NOT NULL default '0',
  PRIMARY KEY (players_id),
  UNIQUE (users_id, wars_id)
){engine};

CREATE TABLE {pre}_quotes (
  quotes_id {serial},
  categories_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  quotes_headline varchar(80) NOT NULL default '',
  quotes_text text,
  quotes_time int(14) NOT NULL default '0',
  PRIMARY KEY (quotes_id)
){engine};

CREATE TABLE {pre}_ranks (
  ranks_id {serial},
  ranks_name varchar(80) NOT NULL default '',
  ranks_url varchar(80) NOT NULL default '',
  squads_id int(8) NOT NULL default '0',
  ranks_img varchar(80) NOT NULL default '',
  ranks_code text,
  PRIMARY KEY (ranks_id)
){engine};

CREATE TABLE {pre}_read (
  read_id {serial},
  threads_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  read_since int(14) NOT NULL default '0',
  PRIMARY KEY (read_id),
  UNIQUE (threads_id,users_id)
){engine};

CREATE TABLE {pre}_replays (
  replays_id {serial},
  categories_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  games_id int(8) NOT NULL default '0',
  replays_version varchar(40) NOT NULL default '',
  replays_date varchar(12) NOT NULL default '',
  replays_since int(14) NOT NULL default '0',
  replays_team1 varchar(80) NOT NULL default '',
  replays_team2 varchar(80) NOT NULL default '',
  replays_map varchar(80) NOT NULL default '',
  replays_mirror_names text,
  replays_mirror_urls text,
  replays_info text,
  replays_close int(2) NOT NULL default '0',
  PRIMARY KEY (replays_id)
){engine};

CREATE TABLE {pre}_rounds (
  rounds_id {serial},
  wars_id int(8) NOT NULL default '0',
  maps_id int(8) NOT NULL default '0',
  rounds_score1 int(6) NOT NULL default '0',
  rounds_score2 int(6) NOT NULL default '0',
  rounds_description text,
  rounds_order int(4) NOT NULL default '0',
  PRIMARY KEY (rounds_id)
){engine};

CREATE TABLE {pre}_rules (
  rules_id {serial},
  categories_id int(8) NOT NULL default '0',
  rules_order int(4) NOT NULL default '0',
  rules_title varchar(80) NOT NULL default '',
  rules_rule text,
  PRIMARY KEY (rules_id)
){engine};

CREATE TABLE {pre}_static (
    static_id {serial},
    static_title varchar(200) NOT NULL default '',
    static_text TEXT,
    static_table INT(2) NOT NULL default '0',
    static_comments INT(2) NOT NULL default '0',
    static_admins INT(2) NOT NULL default '0',
    static_access INT(2) NOT NULL default '0',
    PRIMARY KEY (static_id)
) {engine};

CREATE TABLE {pre}_servers (
  servers_id {serial},
  servers_name varchar(200) NOT NULL default '',
  servers_ip varchar(40) NOT NULL default '',
  games_id int(8) NOT NULL default '0',
  servers_info text,
  servers_port int(20) NOT NULL default '0',
  servers_class varchar(80) NOT NULL default '',
  servers_query int(20) NOT NULL default '0',
  servers_stats int(2) NOT NULL default '0',
  servers_order int(4) NOT NULL default '0',
  servers_slots int(4) NOT NULL default '0',
  servers_type int(2) NOT NULL default '0',
  PRIMARY KEY (servers_id)
){engine};

CREATE TABLE {pre}_shoutbox (
  shoutbox_id {serial},
  shoutbox_name varchar(80) NOT NULL default '',
  shoutbox_text text,
  shoutbox_date int(14) NOT NULL default '0',
  shoutbox_ip varchar(40) NOT NULL default '',
  PRIMARY KEY (shoutbox_id)
){engine};

CREATE TABLE {pre}_squads (
  squads_id {serial},
  clans_id int(8) NOT NULL default '0',
  games_id int(8) NOT NULL default '0',
  squads_name varchar(80) NOT NULL default '',
  squads_picture varchar(80) NOT NULL default '',
  squads_order int(4) NOT NULL default '0',
  squads_pwd varchar(40) NOT NULL default '',
  squads_own int(2) NOT NULL default '0',
  squads_joinus int(2) NOT NULL default '0',
  squads_fightus int(2) NOT NULL default '0',
  squads_text text,
  PRIMARY KEY (squads_id),
  UNIQUE (squads_name)
){engine};

CREATE TABLE {pre}_threads (
  threads_id {serial},
  board_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  threads_headline varchar(200) NOT NULL default '',
  threads_text text,
  threads_time int(14) NOT NULL default '0',
  threads_view int(8) NOT NULL default '0',
  threads_important int(2) NOT NULL default '0',
  threads_close int(8) NOT NULL default '0',
  threads_edit varchar(200) NOT NULL default '',
  threads_last_user int(8) NOT NULL default '0',
  threads_last_time int(14) NOT NULL default '0',
  threads_comments int(8) NOT NULL default '0',
  threads_ghost int(2) NOT NULL default '0',
  threads_ghost_board int(8) NOT NULL default '0',
  threads_ghost_thread int(8) NOT NULL default '0',
  PRIMARY KEY (threads_id)
){engine};

CREATE TABLE {pre}_trashmail (
  trashmail_id {serial},
  trashmail_entry varchar(255) NOT NULL default '',
  PRIMARY KEY (trashmail_id),
  UNIQUE (trashmail_entry)
){engine};

CREATE TABLE {pre}_usernicks (
  usernicks_id {serial},
  users_id int(8) NOT NULL default '0',
  users_nick varchar(200) NOT NULL default '',
  users_changetime int(14) NOT NULL default '0',
  PRIMARY KEY (usernicks_id)
) {engine};

CREATE TABLE {pre}_users (
  users_id {serial},
  access_id int(4) NOT NULL default '0',
  users_nick varchar(40) NOT NULL default '',
  users_pwd varchar(40) NOT NULL default '',
  users_name varchar(80) NOT NULL default '',
  users_surname varchar(80) NOT NULL default '',
  users_sex varchar(8) NOT NULL default '',
  users_age varchar(12) NOT NULL default '',
  users_height int(4) NOT NULL default '0',
  users_lang varchar(40) NOT NULL default '',
  users_country varchar(40) NOT NULL default '',
  users_postalcode varchar(8) NOT NULL default '',
  users_place varchar(40) NOT NULL default '',
  users_adress varchar(80) NOT NULL default '',
  users_icq int(12) NOT NULL default '0',
  users_jabber varchar(40) NOT NULL default '',
  users_skype varchar(40) NOT NULL default '',
  users_email varchar(255) NOT NULL default '',
  users_emailregister varchar(255) NOT NULL default '',
  users_url varchar(80) NOT NULL default '',
  users_phone varchar(40) NOT NULL default '',
  users_mobile varchar(40) NOT NULL default '',
  users_active int(2) NOT NULL default '0',
  users_limit int(4) NOT NULL default '20',
  users_view varchar(20) NOT NULL default '',
  users_register int(14) NOT NULL default '0',
  users_laston int(14) NOT NULL default '0',
  users_picture varchar(80) NOT NULL default '',
  users_avatar varchar(80) NOT NULL default '',
  users_signature text,
  users_info text,
  users_timezone int(8) NOT NULL default '0',
  users_dstime varchar(10) NOT NULL default '',
  users_hidden text,
  users_regkey varchar(50) NOT NULL default '0',
  users_homelimit int(4) NOT NULL default '8',
  users_readtime int(14) NOT NULL default '1209600',
  users_newsletter int(2) NOT NULL default '0',
  users_tpl varchar(80) NOT NULL default '',
  users_theme varchar(80) NOT NULL default '',
  users_invisible int(2) NOT NULL default '0',
  users_ajax int(2) NOT NULL default '0',
  users_delete int(2) NOT NULL default '0',
  users_abomail int(2) NOT NULL default '1',
  users_cookiehash varchar(80) NOT NULL default '',
  users_cookietime int(14) NOT NULL default '0',
  PRIMARY KEY (users_id),
  UNIQUE (users_nick),
  UNIQUE (users_email)
){engine};

CREATE TABLE {pre}_usersgallery (
  usersgallery_id {serial},
  folders_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  usersgallery_name varchar(80) NOT NULL default '',
  usersgallery_titel varchar(40) NOT NULL default '',
  usersgallery_access int(8) NOT NULL default '0',
  usersgallery_status int(2) NOT NULL default '0',
  usersgallery_description text,
  usersgallery_time int(14) NOT NULL default '0',
  usersgallery_count int(8) NOT NULL default '0',
  usersgallery_count_downloads int(8) NOT NULL default '0',
  usersgallery_count_cards int(8) NOT NULL default '0',
  usersgallery_vote int(2) NOT NULL default '0',
  usersgallery_download varchar(20) NOT NULL default '0',
  usersgallery_close int(2) NOT NULL default '0',
  PRIMARY KEY (usersgallery_id)
){engine};

CREATE TABLE {pre}_voted (
  voted_id {serial},
  users_id int(8) NOT NULL default '0',
  voted_fid int(8) NOT NULL default '0',
  voted_time int(14) NOT NULL default '0',
  voted_ip varchar(40) NOT NULL default '',
  voted_answer int(8) NOT NULL default '0',
  voted_mod varchar(80) NOT NULL default '',
  PRIMARY KEY (voted_id),
  UNIQUE (users_id, voted_ip, voted_fid, voted_mod, voted_answer)
){engine};

CREATE TABLE {pre}_votes (
  votes_id {serial},
  users_id int(8) NOT NULL default '0',
  votes_access int(8) NOT NULL default '0',
  votes_time int(14) NOT NULL default '0',
  votes_start int(14) NOT NULL default '0',
  votes_end int(14) NOT NULL default '0',
  votes_question text,
  votes_election text,
  votes_several int(2) NOT NULL default '0',
  votes_close int(2) NOT NULL default '0',
  PRIMARY KEY (votes_id)
){engine};

CREATE TABLE {pre}_wars (
  wars_id {serial},
  games_id int(8) NOT NULL default '0',
  categories_id int(8) NOT NULL default '0',
  clans_id int(8) NOT NULL default '0',
  squads_id int(8) NOT NULL default '0',
  wars_date int(14) NOT NULL default '0',
  wars_status varchar(20) NOT NULL default '',
  wars_topmatch int(2) NOT NULL default '0',
  wars_score1 int(6) NOT NULL default '0',
  wars_score2 int(6) NOT NULL default '0',
  wars_url varchar(80) NOT NULL default '',
  wars_opponents varchar(200) NOT NULL default '',
  wars_players1 int(4) NOT NULL default '0',
  wars_players2 int(4) NOT NULL default '0',
  wars_report text,
  wars_report2 text,
  wars_close int(2) NOT NULL default '0',
  wars_pictures text,
  PRIMARY KEY (wars_id)
){engine};

CREATE INDEX {pre}_abcode_abcode_order_index ON {pre}_abcode (abcode_order);
CREATE INDEX {pre}_abonements_users_id_index ON {pre}_abonements (users_id);
CREATE INDEX {pre}_abonements_threads_id_index ON {pre}_abonements (threads_id);
CREATE INDEX {pre}_articles_users_id_index ON {pre}_articles (users_id);
CREATE INDEX {pre}_articles_categories_id_index ON {pre}_articles (categories_id);
CREATE INDEX {pre}_autoresponder_users_id_index ON {pre}_autoresponder (users_id);
CREATE INDEX {pre}_awards_users_id_index ON {pre}_awards (users_id);
CREATE INDEX {pre}_awards_games_id_index ON {pre}_awards (games_id);
CREATE INDEX {pre}_board_users_id_index ON {pre}_board (users_id);
CREATE INDEX {pre}_board_categories_id_index ON {pre}_board (categories_id);
CREATE INDEX {pre}_boardfiles_threads_id_index ON {pre}_boardfiles (threads_id);
CREATE INDEX {pre}_boardfiles_comments_id_index ON {pre}_boardfiles (comments_id);
CREATE INDEX {pre}_boardfiles_users_id_index ON {pre}_boardfiles (users_id);
CREATE INDEX {pre}_boardmods_categories_id_index ON {pre}_boardmods (categories_id);
CREATE INDEX {pre}_boardmods_users_id_index ON {pre}_boardmods (users_id);
CREATE INDEX {pre}_boardpws_board_id_index ON {pre}_boardpws (board_id);
CREATE INDEX {pre}_boardpws_users_id_index ON {pre}_boardpws (users_id);
CREATE INDEX {pre}_boardreport_threads_id_index ON {pre}_boardreport (threads_id);
CREATE INDEX {pre}_boardreport_comments_id_index ON {pre}_boardreport (comments_id);
CREATE INDEX {pre}_boardreport_users_id_index ON {pre}_boardreport (users_id);
CREATE INDEX {pre}_boardvotes_threads_id_index ON {pre}_boardvotes (threads_id);
CREATE INDEX {pre}_boardvotes_users_id_index ON {pre}_boardvotes (users_id);
CREATE INDEX {pre}_buddys_users_id_index ON {pre}_buddys (users_id);
CREATE INDEX {pre}_buddys_buddys_user_index ON {pre}_buddys (buddys_user);
CREATE INDEX {pre}_clans_users_id_index ON {pre}_clans (users_id);
CREATE INDEX {pre}_comments_users_id_index ON {pre}_comments (users_id);
CREATE INDEX {pre}_comments_comments_fid_index ON {pre}_comments (comments_fid);
CREATE INDEX {pre}_computers_users_id_index ON {pre}_computers (users_id);
CREATE INDEX {pre}_eventguests_events_id_index ON {pre}_eventguests (events_id);
CREATE INDEX {pre}_eventguests_users_id_index ON {pre}_eventguests (users_id);
CREATE INDEX {pre}_events_categories_id_index ON {pre}_events (categories_id);
CREATE INDEX {pre}_faq_users_id_index ON {pre}_faq (users_id);
CREATE INDEX {pre}_faq_categories_id_index ON {pre}_faq (categories_id);
CREATE INDEX {pre}_fightus_categories_id_index ON {pre}_fightus (categories_id);
CREATE INDEX {pre}_fightus_games_id_index ON {pre}_fightus (games_id);
CREATE INDEX {pre}_fightus_squads_id_index ON {pre}_fightus (squads_id);
CREATE INDEX {pre}_files_users_id_index ON {pre}_files (users_id);
CREATE INDEX {pre}_files_categories_id_index ON {pre}_files (categories_id);
CREATE INDEX {pre}_folders_sub_id_index ON {pre}_folders (sub_id);
CREATE INDEX {pre}_folders_users_id_index ON {pre}_folders (users_id);
CREATE INDEX {pre}_gallery_folders_id_index ON {pre}_gallery (folders_id);
CREATE INDEX {pre}_gallery_users_id_index ON {pre}_gallery (users_id);
CREATE INDEX {pre}_games_categories_id_index ON {pre}_games (categories_id);
CREATE INDEX {pre}_gbook_users_id_index ON {pre}_gbook (users_id);
CREATE INDEX {pre}_gbook_gbook_users_id_index ON {pre}_gbook (gbook_users_id);
CREATE INDEX {pre}_history_users_id_index ON {pre}_history (users_id);
CREATE INDEX {pre}_joinus_squads_id_index ON {pre}_joinus (squads_id);
CREATE INDEX {pre}_joinus_games_id_index ON {pre}_joinus (games_id);
CREATE INDEX {pre}_links_categories_id_index ON {pre}_links (categories_id);
CREATE INDEX {pre}_mail_categories_id_index ON {pre}_mail (categories_id);
CREATE INDEX {pre}_maps_games_id_index ON {pre}_maps (games_id);
CREATE INDEX {pre}_medalsuser_medals_id_index ON {pre}_medalsuser (medals_id);
CREATE INDEX {pre}_medalsuser_users_id_index ON {pre}_medalsuser (users_id);
CREATE INDEX {pre}_members_squads_id_index ON {pre}_members (squads_id);
CREATE INDEX {pre}_members_users_id_index ON {pre}_members (users_id);
CREATE INDEX {pre}_messages_users_id_index ON {pre}_messages (users_id);
CREATE INDEX {pre}_messages_users_id_to_index ON {pre}_messages (users_id_to);
CREATE INDEX {pre}_news_categories_id_index ON {pre}_news (categories_id);
CREATE INDEX {pre}_news_users_id_index ON {pre}_news (users_id);
CREATE INDEX {pre}_newsletter_users_id_index ON {pre}_newsletter (users_id);
CREATE INDEX {pre}_partner_categories_id_index ON {pre}_partner (categories_id);
CREATE INDEX {pre}_pictures_pictures_fid_index ON {pre}_pictures (pictures_fid);
CREATE INDEX {pre}_pictures_pictures_id_index ON {pre}_pictures (pictures_id);
CREATE INDEX {pre}_quotes_categories_id_index ON {pre}_quotes (categories_id);
CREATE INDEX {pre}_quotes_users_id_index ON {pre}_quotes (users_id);
CREATE INDEX {pre}_read_threads_id_index ON {pre}_read (threads_id);
CREATE INDEX {pre}_read_users_id_index ON {pre}_read (users_id);
CREATE INDEX {pre}_replays_categories_id_index ON {pre}_replays (categories_id);
CREATE INDEX {pre}_replays_games_id_index ON {pre}_replays (games_id);
CREATE INDEX {pre}_replays_users_id_index ON {pre}_replays (users_id);
CREATE INDEX {pre}_rounds_wars_id_index ON {pre}_rounds (wars_id);
CREATE INDEX {pre}_rounds_maps_id_index ON {pre}_rounds (maps_id);
CREATE INDEX {pre}_rules_categories_id_index ON {pre}_rules (categories_id);
CREATE INDEX {pre}_servers_games_id_index ON {pre}_servers (games_id);
CREATE INDEX {pre}_squads_clans_id_index ON {pre}_squads (clans_id);
CREATE INDEX {pre}_squads_games_id_index ON {pre}_squads (games_id);
CREATE INDEX {pre}_threads_board_id_index ON {pre}_threads (board_id);
CREATE INDEX {pre}_threads_users_id_index ON {pre}_threads (users_id);
CREATE INDEX {pre}_users_access_id_index ON {pre}_users (access_id);
CREATE INDEX {pre}_usersgallery_folders_id_index ON {pre}_usersgallery (folders_id);
CREATE INDEX {pre}_usersgallery_users_id_index ON {pre}_usersgallery (users_id);
CREATE INDEX {pre}_voted_users_id_index ON {pre}_voted (users_id);
CREATE INDEX {pre}_voted_voted_fid_index ON {pre}_voted (voted_fid);
CREATE INDEX {pre}_votes_users_id_index ON {pre}_votes (users_id);
CREATE INDEX {pre}_wars_games_id_index ON {pre}_wars (games_id);
CREATE INDEX {pre}_wars_categories_id_index ON {pre}_wars (categories_id);
CREATE INDEX {pre}_wars_squads_id_index ON {pre}_wars (squads_id);
CREATE INDEX {pre}_wars_clans_id_index ON {pre}_wars (clans_id);

CREATE INDEX {pre}_trashmail_entry_index ON {pre}_trashmail (trashmail_entry);
CREATE INDEX {pre}_captcha_speedup_index ON {pre}_captcha (captcha_id, captcha_ip, captcha_time);
CREATE INDEX {pre}_comments_speedup_index ON {pre}_comments (comments_fid, comments_id, comments_mod);
CREATE INDEX {pre}_count_speedup_index ON {pre}_count (count_id, count_ip, count_time);
CREATE INDEX {pre}_users_speedup_index ON {pre}_users (users_id, users_laston);