UPDATE {pre}_options SET options_value = '2007.4.3' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2007-10-19' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '24' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

ALTER TABLE {pre}_threads ADD threads_close2 int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_threads SET threads_close2 = '-1' WHERE threads_close = '1';
ALTER TABLE {pre}_threads DROP threads_close;
ALTER TABLE {pre}_threads ADD threads_close int(8) NOT NULL DEFAULT '0';
UPDATE {pre}_threads SET threads_close = threads_close2;
ALTER TABLE {pre}_threads DROP threads_close2;

INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'rss_title', 'News');
INSERT INTO {pre}_options (options_mod, options_name, options_value) VALUES ('news', 'rss_description', 'Recent information');

ALTER TABLE {pre}_squads ADD squads_joinus int(1) NOT NULL default '0',
ADD squads_fightus int(1) NOT NULL default '0';