ALTER TABLE {pre}_access ADD access_lanpartys int(2) NOT NULL default '0';

ALTER TABLE {pre}_access ADD access_languests int(2) NOT NULL default '0';

ALTER TABLE {pre}_access ADD access_lanrooms int(2) NOT NULL default '0';

ALTER TABLE {pre}_access ADD access_lanshop int(2) NOT NULL default '0';

ALTER TABLE {pre}_access ADD access_lanvotes int(2) NOT NULL default '0';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('lanpartys', 'max_width', '800');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('lanpartys', 'max_height', '600');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('lanpartys', 'max_size', '204800');

CREATE TABLE {pre}_lanpartys (
  lanpartys_id {serial},
  lanpartys_name varchar(80) NOT NULL default '',
  lanpartys_url varchar(80) NOT NULL default '',
  lanpartys_start int(14) NOT NULL default '0',
  lanpartys_end int(14) NOT NULL default '0',
  lanpartys_maxguests int(8) NOT NULL default '0',
  lanpartys_money varchar(40) NOT NULL default '',
  lanpartys_needage varchar(40) NOT NULL default '',
  lanpartys_location varchar(80) NOT NULL default '',
  lanpartys_adress varchar(80) NOT NULL default '',
  lanpartys_postalcode varchar(8) NOT NULL default '',
  lanpartys_place varchar(40) NOT NULL default '',
  lanpartys_bankaccount text,
  lanpartys_network text,
  lanpartys_tournaments text,
  lanpartys_features text,
  lanpartys_more text,
  lanpartys_pictures text,
  PRIMARY KEY (lanpartys_id),
  UNIQUE (lanpartys_name)
){engine};

CREATE TABLE {pre}_languests (
  languests_id {serial},
  lanpartys_id int(8) NOT NULL default '0',
  users_id int(8) NOT NULL default '0',
  languests_since int(14) NOT NULL default '0',
  languests_team varchar(20) NOT NULL default '',
  languests_status varchar(20) NOT NULL default '',
  languests_money varchar(20) NOT NULL default '',
  languests_paytime varchar(14) NOT NULL default '',
  languests_notice varchar(80) NOT NULL default '',
  lanroomd_id int(8) NOT NULL default '0',
  PRIMARY KEY (languests_id),
  UNIQUE (users_id, lanpartys_id)
){engine};

CREATE TABLE {pre}_lanrooms (
  lanrooms_id {serial},
  lanpartys_id int(8) NOT NULL default '0',
	lanrooms_name varchar(40) NOT NULL default '',
  PRIMARY KEY (lanrooms_id),
  UNIQUE (lanpartys_id, lanrooms_name)
){engine};

CREATE TABLE {pre}_lanroomd (
  lanroomd_id {serial},
  lanrooms_id int(8) NOT NULL default '0',
	lanroomd_number int(4) NOT NULL default '0',
	lanroomd_row int(4) NOT NULL default '0',
	lanroomd_col int(4) NOT NULL default '0',
  PRIMARY KEY (lanroomd_id),
  UNIQUE (lanrooms_id, lanroomd_row, lanroomd_col),
  UNIQUE (lanrooms_id, lanroomd_number)
){engine};

CREATE TABLE {pre}_lanvotes (
  lanvotes_id {serial},
  lanpartys_id int(8) NOT NULL default '0',
  lanvotes_status varchar(20) NOT NULL default '',
  lanvotes_since varchar(14) NOT NULL default '',
  lanvotes_start varchar(14) NOT NULL default '',
  lanvotes_end varchar(14) NOT NULL default '',
  lanvotes_question varchar(80) NOT NULL default '',
  lanvotes_election text,
  PRIMARY KEY (lanvotes_id),
  UNIQUE (lanpartys_id, lanvotes_question)
){engine};

CREATE TABLE {pre}_lanvoted (
  lanvoted_id {serial},
  lanvotes_id int(8) NOT NULL default '0',
	users_id int(8) NOT NULL default '0',
  lanvoted_since varchar(14) NOT NULL default '',
  lanvoted_answer int(8) NOT NULL default '0',
  PRIMARY KEY (lanvoted_id),
  UNIQUE (lanvotes_id, users_id)
){engine};

CREATE TABLE {pre}_lanshop_articles (
  lanshop_articles_id {serial},
  categories_id int(8) NOT NULL default '0',
  lanshop_articles_name varchar(80) NOT NULL default '',
  lanshop_articles_info text,
  lanshop_articles_price int(8) NOT NULL default '0',
  lanshop_articles_picture varchar(80) NOT NULL default '',
  PRIMARY KEY (lanshop_articles_id),
  UNIQUE (categories_id, lanshop_articles_name)
){engine};

CREATE TABLE {pre}_lanshop_orders (
  lanshop_orders_id {serial},
  users_id int(8) NOT NULL default '0',
  lanshop_articles_id int(8) NOT NULL default '0',
  lanshop_orders_since varchar(14) NOT NULL default '',
  lanshop_orders_value int(4) NOT NULL default '0',
  lanshop_orders_status varchar(20) NOT NULL default '',
  PRIMARY KEY (lanshop_orders_id)
){engine};

CREATE INDEX {pre}_languests_lanpartys_id_index ON {pre}_languests (lanpartys_id);
CREATE INDEX {pre}_languests_users_id_index ON {pre}_languests (users_id);
CREATE INDEX {pre}_lanrooms_lanpartys_id_index ON {pre}_lanrooms (lanpartys_id);
CREATE INDEX {pre}_lanroomd_lanrooms_id_index ON {pre}_lanroomd (lanrooms_id);
CREATE INDEX {pre}_lanvotes_lanpartys_id_index ON {pre}_lanvotes (lanpartys_id);
CREATE INDEX {pre}_lanvoted_lanvotes_id_index ON {pre}_lanvoted (lanvotes_id);
CREATE INDEX {pre}_lanvoted_users_id_index ON {pre}_lanvoted (users_id);
CREATE INDEX {pre}_lanshop_articles_categories_id_index ON {pre}_lanshop_articles (categories_id);
CREATE INDEX {pre}_lanshop_orders_users_id_index ON {pre}_lanshop_orders (users_id);
CREATE INDEX {pre}_lanshop_orders_lanshop_articles_id_index ON {pre}_lanshop_orders (lanshop_articles_id);