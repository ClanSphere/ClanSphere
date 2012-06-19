CREATE TABLE {pre}_sessions (
  sessions_id int(100) NOT NULL AUTO_INCREMENT,
  users_id int(10) NOT NULL,
  sessions_cookiehash varchar(80) NOT NULL,
  sessions_cookietime int(14) NOT NULL,
  sessions_ip varchar(20) NOT NULL,
  PRIMARY KEY (`sessions_id`)
){engine};

ALTER TABLE {pre}_access ADD access_sessions int(2) NOT NULL DEFAULT '0';