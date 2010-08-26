UPDATE {pre}_options SET options_value = '2010.0' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2010-08-27' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = 60 WHERE options_mod = 'clansphere' AND options_name = 'version_id';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('counter', 'count_lastday', '0');

ALTER TABLE {pre}_maps ADD server_name varchar(100) NOT NULL default '';

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'vorname', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'surname', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'place', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'country', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'icq', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'msn', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'game', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'squad', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'webcon', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'lanact', '0');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('joinus', 'more', '1');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'login', 'nick');