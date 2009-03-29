UPDATE {pre}_options SET options_value = '2009.0_svn' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-03-26' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '37' WHERE options_mod = 'clansphere' AND options_name = 'version_id';
    
ALTER TABLE {pre}_joinus ADD joinus_age2 varchar(20) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_age2 = joinus_age;
ALTER TABLE {pre}_joinus DROP joinus_age;
ALTER TABLE {pre}_joinus ADD joinus_age varchar(20) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_age = joinus_age2;
ALTER TABLE {pre}_joinus DROP joinus_age2;

ALTER TABLE {pre}_joinus ADD joinus_date2 varchar(20) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_date2 = joinus_date;
ALTER TABLE {pre}_joinus DROP joinus_date;
ALTER TABLE {pre}_joinus ADD joinus_date varchar(20) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_date = joinus_date2;
ALTER TABLE {pre}_joinus DROP joinus_date2;

ALTER TABLE {pre}_replays ADD replays_date2 varchar(20) NOT NULL default '';
UPDATE {pre}_replays SET replays_date2 = replays_date;
ALTER TABLE {pre}_replays DROP replays_date;
ALTER TABLE {pre}_replays ADD replays_date varchar(20) NOT NULL default '';
UPDATE {pre}_replays SET replays_date = replays_date2;
ALTER TABLE {pre}_replays DROP replays_date2;

ALTER TABLE {pre}_users ADD users_age2 varchar(20) NOT NULL default '';
UPDATE {pre}_users SET users_age2 = users_age;
ALTER TABLE {pre}_users DROP users_age;
ALTER TABLE {pre}_users ADD users_age varchar(20) NOT NULL default '';
UPDATE {pre}_users SET users_age = users_age2;
ALTER TABLE {pre}_users DROP users_age2;

ALTER TABLE {pre}_games ADD games_released2 varchar(20) NOT NULL default '';
UPDATE {pre}_games SET games_released2 = games_released;
ALTER TABLE {pre}_games DROP games_released;
ALTER TABLE {pre}_games ADD games_released varchar(20) NOT NULL default '';
UPDATE {pre}_games SET games_released = games_released2;
ALTER TABLE {pre}_games DROP games_released2;