UPDATE {pre}_options SET options_value = '2011.3 Patch 1' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2012-03-31' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '81' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_clans ADD clans_country2 varchar(40) NOT NULL default '';
UPDATE {pre}_clans SET clans_country2 = clans_country;
ALTER TABLE {pre}_clans DROP clans_country;
ALTER TABLE {pre}_clans ADD clans_country varchar(40) NOT NULL default '';
UPDATE {pre}_clans SET clans_country = clans_country2;
ALTER TABLE {pre}_clans DROP clans_country2;

ALTER TABLE {pre}_fightus ADD fightus_country2 varchar(40) NOT NULL default '';
UPDATE {pre}_fightus SET fightus_country2 = fightus_country;
ALTER TABLE {pre}_fightus DROP fightus_country;
ALTER TABLE {pre}_fightus ADD fightus_country varchar(40) NOT NULL default '';
UPDATE {pre}_fightus SET fightus_country = fightus_country2;
ALTER TABLE {pre}_fightus DROP fightus_country2;

ALTER TABLE {pre}_joinus ADD joinus_country2 varchar(40) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_country2 = joinus_country;
ALTER TABLE {pre}_joinus DROP joinus_country;
ALTER TABLE {pre}_joinus ADD joinus_country varchar(40) NOT NULL default '';
UPDATE {pre}_joinus SET joinus_country = joinus_country2;
ALTER TABLE {pre}_joinus DROP joinus_country2;

ALTER TABLE {pre}_users ADD users_country2 varchar(40) NOT NULL default '';
UPDATE {pre}_users SET users_country2 = users_country;
ALTER TABLE {pre}_users DROP users_country;
ALTER TABLE {pre}_users ADD users_country varchar(40) NOT NULL default '';
UPDATE {pre}_users SET users_country = users_country2;
ALTER TABLE {pre}_users DROP users_country2;