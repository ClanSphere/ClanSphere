UPDATE {pre}_options SET options_value = '2011.3' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2012-03-02' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '80' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_gbook ADD gbook_ip2 varchar(40) NOT NULL default '';
UPDATE {pre}_gbook SET gbook_ip2 = gbook_ip;
ALTER TABLE {pre}_gbook DROP gbook_ip;
ALTER TABLE {pre}_gbook ADD gbook_ip varchar(40) NOT NULL default '';
UPDATE {pre}_gbook SET gbook_ip = gbook_ip2;
ALTER TABLE {pre}_gbook DROP gbook_ip2;

ALTER TABLE {pre}_shoutbox ADD shoutbox_ip2 varchar(40) NOT NULL default '';
UPDATE {pre}_shoutbox SET shoutbox_ip2 = shoutbox_ip;
ALTER TABLE {pre}_shoutbox DROP shoutbox_ip;
ALTER TABLE {pre}_shoutbox ADD shoutbox_ip varchar(40) NOT NULL default '';
UPDATE {pre}_shoutbox SET shoutbox_ip = shoutbox_ip2;
ALTER TABLE {pre}_shoutbox DROP shoutbox_ip2;