UPDATE {pre}_options SET options_value = '2009.0_svn' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-03-26' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '37' WHERE options_mod = 'clansphere' AND options_name = 'version_id';
    
ALTER TABLE {pre}_users ADD users_age2 varchar(20) NOT NULL default '0';
UPDATE {pre}_users SET users_age2 = users_age;
ALTER TABLE {pre}_users DROP users_age;
ALTER TABLE {pre}_users ADD users_age varchar(20) NOT NULL default '0';
UPDATE {pre}_users SET users_age = users_age2;
ALTER TABLE {pre}_users DROP users_age2;

ALTER TABLE {pre}_joinus ADD joinus_age2 varchar(20) NOT NULL default '0';
UPDATE {pre}_joinus SET joinus_age2 = joinus_age;
ALTER TABLE {pre}_joinus DROP joinus_age;
ALTER TABLE {pre}_joinus ADD joinus_age varchar(20) NOT NULL default '0';
UPDATE {pre}_joinus SET joinus_age = joinus_age2;
ALTER TABLE {pre}_joinus DROP joinus_age2;