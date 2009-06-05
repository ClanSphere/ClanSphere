UPDATE {pre}_options SET options_value = '2009.0_svn' WHERE options_mod = 'clansphere' AND options_name = 'version_name';
UPDATE {pre}_options SET options_value = '2009-06-04' WHERE options_mod = 'clansphere' AND options_name = 'version_date';
UPDATE {pre}_options SET options_value = '41' WHERE options_mod = 'clansphere' AND options_name = 'version_id';

UPDATE {pre}_options SET options_mod = 'contact' WHERE options_mod = 'clansphere' AND options_name = 'def_org';
UPDATE {pre}_options SET options_mod = 'contact' WHERE options_mod = 'clansphere' AND options_name = 'def_mail';