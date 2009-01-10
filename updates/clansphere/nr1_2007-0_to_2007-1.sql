INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('users', 'def_register', '1');

ALTER TABLE {pre}_users DROP users_dstime;
ALTER TABLE {pre}_users ADD users_dstime varchar(10) NOT NULL DEFAULT '';

ALTER TABLE {pre}_users ADD users_readtime varchar(14) NOT NULL DEFAULT '1209600';