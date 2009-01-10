UPDATE {pre}_options SET options_value = '2007.4' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2007-08-22' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '18' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_mail ADD mail_answered int(2) NOT NULL default '0';
ALTER TABLE {pre}_mail ADD mail_answertime int(14) NOT NULL default '0';
ALTER TABLE {pre}_mail ADD mail_answer text;
ALTER TABLE {pre}_mail ADD mail_answeruser int(8) NOT NULL default '0';

ALTER TABLE {pre}_boardfiles ADD boardfiles_downloaded int(8) NOT NULL default '0';