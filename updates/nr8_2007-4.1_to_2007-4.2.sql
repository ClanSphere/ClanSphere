UPDATE {pre}_options SET options_value = '2007.4.2' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2007-09-30' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '22' WHERE options_mod = 'clansphere' AND options_name = 'version_id';


ALTER TABLE {pre}_files ADD files_size2 varchar(20) NOT NULL default '';
UPDATE {pre}_files SET files_size2 = files_size;
ALTER TABLE {pre}_files DROP files_size;
ALTER TABLE {pre}_files ADD files_size varchar(20) NOT NULL default '';
UPDATE {pre}_files SET files_size = files_size2;
ALTER TABLE {pre}_files DROP files_size2;