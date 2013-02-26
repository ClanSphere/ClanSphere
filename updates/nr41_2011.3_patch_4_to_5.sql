UPDATE {pre}_options SET options_value = '2011.3_Patch_5_GIT' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2013-02-26' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '87' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_fightus ADD fightus_jabber varchar(40) NOT NULL default '';
ALTER TABLE {pre}_fightus DROP fightus_msn;

ALTER TABLE {pre}_gbook ADD gbook_jabber varchar(40) NOT NULL default '';
ALTER TABLE {pre}_gbook DROP gbook_msn;

ALTER TABLE {pre}_joinus ADD joinus_jabber varchar(40) NOT NULL default '';
ALTER TABLE {pre}_joinus DROP joinus_msn;

ALTER TABLE {pre}_mail ADD mail_jabber varchar(40) NOT NULL default '';
ALTER TABLE {pre}_mail DROP mail_msn;

ALTER TABLE {pre}_users ADD users_jabber varchar(40) NOT NULL default '';
ALTER TABLE {pre}_users DROP users_msn;

UPDATE {pre}_options SET options_name = 'jabber' WHERE options_name = 'msn' AND options_mod = 'joinus';